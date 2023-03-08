<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StaffFactory extends Factory
{
    protected $model = Staff::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'staff_cd' => $this->generateUniqueCode(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ];
    }

    protected static $title_codes = null;

    /**
     * @return array
     */
    // protected static function getTitlesCode()
    // {
    //     if (self::$title_codes == null) {
    //         self::$title_codes = array_flip(config('constants.authenticate.titles'));
    //     }
    //     return self::$title_codes;

    // }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function admin() // quản trị hệ thống
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => '00001',
                // 'title' => $this->getTitleCode('admin'),
                'title' => __('auth.title.admin'),
                'role'  => config('constants.authenticate.roles.admin')
            ];
        });
    }

    public function adminTest() // quản trị hệ thống
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('admin'),
                'title' => __('auth.title.admin'),
                'role'  => config('constants.authenticate.roles.admin')
            ];
        });
    }

    public function dev($code, $password = 'devpassword') // quản trị hệ thống
    {
        return $this->state(function (array $attributes) use($code, $password) {
            return [
                'staff_cd' => $code,
                // 'title' => $this->getTitleCode('admin'),
                'title' => __('auth.title.admin'),
                'password' => $password,
                'role'  => config('constants.authenticate.roles.admin')
            ];
        });
    }


    public function boardMember() // người trong ban lãnh đạo
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => '00002',
                // 'title' => $this->getTitleCode('board_member'),
                'title' => __('auth.title.board_member'),
                'role'  => config('constants.authenticate.roles.board_member')
            ];
        });
    }

    public function boardMemberTest() // người trong ban lãnh đạo
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('board_member'),
                'title' => __('auth.title.board_member'),
                'role'  => config('constants.authenticate.roles.board_member')
            ];
        });
    }

    public function director() // giám đốc
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => '00003',
                // 'title' => $this->getTitleCode('director'),
                'title' => __('auth.title.director'),
                'role'  => config('constants.authenticate.roles.director')
            ];
        });
    }

    public function directorTest() // giám đốc
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('director'),
                'title' => __('auth.title.director'),
                'role'  => config('constants.authenticate.roles.director')
            ];
        });
    }

    public function deputyDirector() // phó giám đốc
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => '00004',
                // 'title' => $this->getTitleCode('deputy_director'),
                'title' => __('auth.title.deputy_director'),
                'role'  => config('constants.authenticate.roles.deputy_director')
            ];
        });
    }

    public function deputyDirectorTest() // phó giám đốc
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('deputy_director'),
                'title' => __('auth.title.deputy_director'),
                'role'  => config('constants.authenticate.roles.deputy_director')
            ];
        });
    }

    public function generalManager() // tổng vụ
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => '00005',
                // 'title' => $this->getTitleCode('general_manager'),
                'title' => __('auth.title.general_manager'),
                'role'  => config('constants.authenticate.roles.general_manager')
            ];
        });
    }

    public function generalManagerTest() // tổng vụ
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('general_manager'),
                'title' => __('auth.title.general_manager'),
                'role'  => config('constants.authenticate.roles.general_manager')
            ];
        });
    }

    public function headOffice() // trụ sở chính
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => '00006',
                // 'title' => $this->getTitleCode('head_office'),
                'title' => __('auth.title.head_office'),
                'role'  => config('constants.authenticate.roles.head_office')
            ];
        });
    }

    public function headOfCenter() // trưởng trung tâm
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('center_manager'),
                'title' => __('auth.title.center_manager'),
                'role'  => config('constants.authenticate.roles.center_manager')
            ];
        });
    }

    public function staff() // nhân viên
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('staff'),
                'title' => __('auth.title.staff'),
                'role'  => config('constants.authenticate.roles.staff')
            ];
        });
    }

    public function saler() // nhân viên sales
    {
        return $this->state(function (array $attributes) {
            return [
                'staff_cd' => $this->generateUniqueCode(),
                // 'title' => $this->getTitleCode('sale'),
                'title' => __('auth.title.sale'),
                'role'  => config('constants.authenticate.roles.sale')
            ];
        });
    }

    private function generateUniqueCode()
    {
        do {
            $code = random_int(10000, 99999);
        } while (Staff::where("staff_cd", "=", $code)->first());
  
        return $code;
    }

    // private function getTitleCode($title_string)
    // {
    //     $title_codes = self::getTitlesCode();
    //     return $title_codes[$title_string] ?? 0;
    // }
}
