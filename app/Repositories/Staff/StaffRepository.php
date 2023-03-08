<?php
namespace App\Repositories\Staff;

use App\Exceptions\ForbiddenException;
use App\Exceptions\NotAcceptableException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Models\Center;
use App\Models\Staff;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class StaffRepository extends BaseRepository implements StaffRepositoryInterface
{
    public function model()
    {
        return \App\Models\Staff::class;
    }

    /**
     * Get list staff id of center
     * 
     * @param option $center_id
     * @return array $ids
     */
    private function caseStaffOfCenter($center_id = 'all')
    {
        $staff_ids = [];
        if ($auth = auth()->user()) {
            if ($center_id == config('constants.option_all_center')) {
                // $is_belong_center_main = $auth->centers()->where('is_main', true)->exists();
                // if ($is_belong_center_main) {
                //     $centers = Center::all();
                //     $centers->each(function($center) use(&$staff_ids) {
                //         $staff_ids = array_merge($staff_ids, $center->staffs()->pluck('id')->toArray());
                //     });
                // }
                $centers = Center::all();
                $centers->each(function($center) use(&$staff_ids) {
                    $staff_ids = array_merge($staff_ids, $center->staffs()->pluck('id')->toArray());
                });
            } elseif ($center = $auth->centers()->find($center_id)) {
                $staff_ids = $center->staffs()->pluck('id')->toArray();
            }
        }
        return array_unique($staff_ids);
    }

    /**
     * Find data by email
     *
     * @param       $email
     * @param array $columns
     * @return mixed
     */
    public function findByEmail($email, $columns = ['*'])
    {
        return $this->findByField('email', $email, $columns);
    }

    /**
     * Find data by email
     *
     * @param       $code
     * @param array $columns
     * @return mixed
     */
    public function findByCode($code, $columns = ['*'])
    {
        return $this->findByField('code', $code, $columns);
    }

    /**
     * Find data by email
     *
     * @param       $id
     * @param array $columns
     * @return mixed
     */
    public function detail($id, $data, $columns = ['*'])
    {
        $query = $this->model->query();

        //$staff_ids_of_center = $this->caseStaffOfCenter($data['center_id']);
        // $query->whereIn('id', $staff_ids_of_center);
        // update logic
        if ($data['center_id'] == config('constants.option_all_center')) {
            $staff_ids_of_center = $this->caseStaffOfCenter($data['center_id']);
        } else {
            $center = Center::find($data['center_id']);
            $staff_ids_of_center = $center->staffs()->pluck('id')->toArray();
        }
        $query->whereIn('id', $staff_ids_of_center);

        return $query
            ->with(['centers'])
            ->select($columns)
            ->where('id', $id)
            ->first();
    }

    /**
     * Search
     * 
     * @param $req_data
     * @param $columns
     * @return mixed paginator
     */
    public function search($data, $columns = ['*'])
    {
        $term = $data['q'] ?? '';

        $query = $this->model->query();

        // $staff_ids_of_center = $this->caseStaffOfCenter($data['center_id']);
        // $query->whereIn('id', $staff_ids_of_center);
        // update logic
        if ($data['center_id'] != config('constants.option_all_center')) {
            $center = Center::find($data['center_id']);
            $staff_ids_of_center = $center->staffs()->pluck('id')->toArray();
            $query->whereIn('id', $staff_ids_of_center);
        }
        
        return $query
            ->with(['centers'])
            ->search($term)
            ->select($columns)
            ->orderBy('staff_cd', 'asc')
            ->paginate(perPage())
            ->withQueryString();
    }

    /**
     * Create special
     * 
     * @param $data
     * @return mixed
     * 
     * @throws \App\Exceptions\NotAcceptableException
     * @throws Throwable
     * 
     */
    public function createSpecial($data)
    {
        $auth = auth()->user();
        $admin_role = config('constants.authenticate.roles.admin');
        if ($auth->role != $admin_role) {
            throw new ForbiddenException();
        }

        try {
            DB::beginTransaction();
            $staff = $this->create($data);
            $sub_center_ids = $data['sub_center_ids'] ?? [];
            $combine_data = $this->defineCentersForStaff($data['main_center_id'], $sub_center_ids);
            $staff->centers()->attach($combine_data);
            DB::commit();
            return $staff;
            
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Update special
     * 
     * @param $id
     * @param $data
     * @return mixed
     * 
     * @throws \App\Exceptions\NotAcceptableException
     * @throws \App\Exceptions\NotFoundException
     * @throws Throwable
     * 
     */
    public function updateSpecial($id, $data)
    {
        $auth = auth()->user();
        $admin_role = config('constants.authenticate.roles.admin');

        if (!$staff = $this->find($id)) {
            throw new NotFoundException();
        }

        $data_update = [];

        if ($auth->role == $admin_role) {
            /**
             * Unique staff_cd
             */
            if (!empty($data['staff_cd']) && $data['staff_cd'] == $staff->staff_cd) {
                unset($data['staff_cd']);
            }
            /**
             * Not update role master admin
             */
            if ($staff->id == config('constants.authenticate.master_admin_id')) {
                unset($data['role']);
            }
            $data_update = $data;
        }
        elseif ($auth->role != $admin_role && $auth->id == $staff->id) {
            if (!empty($data['password'])) {
                $data_update['password'] = $data['password'];
            }
        } 
        else {
            throw new ForbiddenException();
        }

        try {
            DB::beginTransaction();
            if (!empty($data_update)) {
                $staff->update($data_update);
                if ($auth->role == $admin_role) {
                    $sub_center_ids = $data_update['sub_center_ids'] ?? [];
                    $combine_data = $this->defineCentersForStaff($data_update['main_center_id'], $sub_center_ids);
                    $staff->centers()->sync($combine_data);
                }
            }
            DB::commit();
            return $staff;
            
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * @param $id
     * @param App\Http\Requests\API\Staff\DeleteRequest $data
     * @return boolean
     * 
     * @throws Throwable
     */
    public function deleteSpecial($id)
    {
        $auth = auth()->user();
        $admin_role = config('constants.authenticate.roles.admin');
        if ($auth->role != $admin_role) {
            throw new ForbiddenException();
        }

        if (!$staff = $this->find($id)) {
            throw new NotFoundException();
        }

        //bonus by dev
        if ($staff->role == $admin_role) {
            if ($staff->id == config('constants.authenticate.master_admin_id')) {
                throw new NotAcceptableException();
            }
            $num_of_admins = $this->model
                ->where('role', $admin_role)
                ->count();
            if ($num_of_admins <= config('constants.authenticate.minimum_num_admins')) {
                throw new NotAcceptableException();
            }
        }

        if ($this->isBelongToProjectsWithDeadlines($staff)) {
            throw new NotAcceptableException(__('messages.cus.delete_data_linked'));
        }

        $is_del = false;
        try {
            DB::beginTransaction();
            $is_del = $staff->delete();
            DB::commit();
            return $is_del;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Define the center for employees
     * 
     * @param integer $default_center_id
     * @param array $sub_center_ids
     * @return array
     */
    public function defineCentersForStaff($default_center_id, $sub_center_ids = [])
    {
        $center_head = Center::where('is_main', true)->first(); // head center 
        $combine_ids = [];
        if (!empty($sub_center_ids)) {
            foreach ($sub_center_ids as $id) {
                if ($center_head->id == $id) { // sub center not is head center
                    throw new NotAcceptableException(__('messages.cus.regist.staff.center_overlap'));
                }
                $combine_ids[$id] = ['is_default' => false];
            }
        }
        $combine_ids[$default_center_id] = ['is_default' => true];
        return $combine_ids;
    }

    /**
     * List staff dropdown
     * 
     * @param App\Http\Requests\API\Common\ListPersonInChargeRequest $req_data
     * @return mixed
     */
    public function listPic($req_data)
    {
        $auth = auth()->user();
        if ($center = $auth->centers->find($req_data['center_id'])) {
            return $center->staffs()->select('id', 'name')->get();
        }
        return [];
    }

    /**
     * 
     */
    private function isBelongToProjectsWithDeadlines(Staff $staff)
    {
        $is_belong_shipping_projects = $staff->shippingProjects()
            ->where(function($q) {
                $q->whereDate('end_date', '>=', date('Y-m-d'))
                  ->orWhere('is_period', true);
            })
            ->exists();

        $is_belong_warehouse_projects = $staff->warehouseProjects()
            ->where(function($q) {
                $q->whereDate('end_date', '>=', date('Y-m-d'))
                ->orWhere('is_period', true);
            })
            ->exists();

        return $is_belong_shipping_projects || $is_belong_warehouse_projects;
    }
}

