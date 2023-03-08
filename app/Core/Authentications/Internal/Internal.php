<?php

namespace App\Core\Authentications\Internal;

use App\Core\Authentications\Internal\InternalInterface;
use App\Events\EmailRegisteredEvent;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotAcceptableException;
use App\Exceptions\UnauthorizedException;
use App\Models\EmailVerify;
use App\Repositories\Staff\StaffRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Internal implements InternalInterface
{
    protected $guard;
    protected $staff_repo;

    /**
     * 
     */
    public function __construct($guard = null)
    {
        $this->guard = $guard;
        $this->staff_repo = App::make(StaffRepositoryInterface::class);
    }

    /**
     * Default register with verify
     * 
     * @param  array $info
     * @return       $token
     * 
     * @throws \App\Exceptions\BadRequestException
     * @throws \App\Exceptions\UnauthorizedException
     */
    public function register($info)
    {
        try {
            DB::beginTransaction();
            $staff_by_email = $this->staff_repo->findByEmail($info['email']);
            $staff_by_code  = $this->staff_repo->findByCode($info['staff_cd']);
            $staff = null;
            if (!empty($staff_by_email) && !empty($staff_by_code) && ($staff_by_email->id == $staff_by_code->id)) {
                $staff = $staff_by_email;
                if (!empty($staff->email_verified_at)) {
                    throw new BadRequestException(__('messages.cus.email_exist'));
                }
                $staff->staff_cd    = $info['staff_cd'];
                $staff->name        = $info['name'];
                $staff->password    = $info['password'];
                $staff->save();
            } elseif (empty($staff_by_email) && empty($staff_by_code)) {
                $staff = $this->staff_repo->create([
                    'staff_cd'  => $info['staff_cd'],
                    'name'      => $info['name'] ?? null,
                    'email'     => $info['email'],
                    'password'  => $info['password'],
                    'role'      => $info['role']
                ]);
            } elseif (!empty($staff_by_email) && empty($staff_by_code)) {
                throw new BadRequestException(__('messages.cus.email_exist'));
            } else {
                throw new BadRequestException(__('messages.cus.code_exist'));
            }
            $token_verify = Str::random(70);
            EmailVerify::updateOrCreate(
                ['email' => $staff->email], //cdn
                ['token' => $token_verify] //attr
            );
            DB::commit();

            $token = auth($this->guard)->attempt([
                'staff_cd' => $info['staff_cd'], 
                'password' => $info['password']
            ]);
            if(!$token) {
                throw new UnauthorizedException();
            }
            $this->sendMailRegister($staff, $token_verify);
            return $token;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Default login
     * 
     * @param  array $info
     * @return       $token
     * 
     * @throws \App\Exceptions\UnauthorizedException
     */
    public function login($info)
    {
        $info['email_verified_at'] = function($q) {
            $q->where('email_verified_at', '<>', null);
        };
        if (! $token = auth($this->guard)->attempt($info)) {
            throw new UnauthorizedException();
        }
        return $token;
    }

    /**
     * @return Staff $staff
     */
    public function me()
    {
        return auth($this->guard)->user();
    }

    /**
     * Change password default
     * 
     * @param array $info
     * @return mixed
     * 
     * @throws \App\Exceptions\NotAcceptableException
     */
    public function changePassword($info)
    {
        try {
            DB::beginTransaction();
            $staff   = auth($this->guard)->user();
            $cur_pw = $staff->password;
            $old_pw = $info['old_password'] ?? null;
            $pw     = $info['password'] ?? null;
            if (!password_verify($old_pw, $cur_pw)) {
                throw new NotAcceptableException(__('messages.cus.old_pw_not_correct'));
            }
            $staff->password = $pw;
            $staff->save();
            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * 
     */
    protected function sendMailRegister($staff, $token_verify = null)
    {
        event(new EmailRegisteredEvent($staff, $token_verify));
    }
}