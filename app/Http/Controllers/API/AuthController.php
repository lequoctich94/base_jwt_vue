<?php

namespace App\Http\Controllers\API;

use App\Events\EmailForgotPasswordEvent;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotAcceptableException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
//use App\Http\Controllers\SwaggerUI\AuthInterface;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use App\Http\Requests\API\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\RegisterVerifyRequest;
use App\Http\Requests\API\Auth\ResetPasswordRequest;
use App\Http\Resources\API\Auth\MeResource;
use App\Models\EmailVerify;
use App\Models\PasswordReset;
use App\Repositories\Staff\StaffRepositoryInterface;
use Exception;
use Authenticate;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller //implements AuthInterface
{
    protected $staff_repo;

    public function __construct()
    {
        $this->staff_repo = App::make(StaffRepositoryInterface::class);    
    }

    /**
     * Disable api
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        try {
            $token = Authenticate::register(['info' => $validated]);
            return response()->jsonToken($token);
        } catch (Exception $e) {
            throwErr($e);
        }
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        try {
            $token = Authenticate::login(['info' => $validated]);
        
            return response()->jsonToken($token);
        } catch (Exception $e) {
            throwErr($e);
        }
    }

    public function me()
    {
        try {
            $staff = Authenticate::me();
            $resource = new MeResource($staff);
            return response()->jsonSuccess($resource);
        } catch (Exception $e) {
            throwErr($e);
        }
    }

    public function logout()
    {
        try {
            Authenticate::logout();
            return response()->jsonSuccess();
        } catch (Exception $e) {
            throwErr($e);
        }
    }

    public function refresh()
    {
        try {
            $token = auth()->refresh();
            return response()->jsonToken($token, 'refresh_success');
        } catch (Exception $e) {
            throwErr($e); //500
        }
    }

    /**
     * Change password
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        try {
            Authenticate::changePassword(['info' => $validated]);
            return response()->jsonSuccess();
        } catch (Exception $e) {
            throwErr($e);
        }
    }

    /**
     * Forgot password
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $staff = $this->staff_repo->findByEmail($validated['email']);
            if (!$staff) {
                throw new NotFoundException(__('messages.cus.email_not_registerd'));
            }
            $token = Str::random(70);
            PasswordReset::updateOrCreate(
                ['email' => $staff->email], //cdn
                ['token' => $token] //data
            );
            DB::commit();
            event(new EmailForgotPasswordEvent($staff, $token));
            return response()->jsonSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            throwErr($e);
        }
    }

    /**
     * Reset password
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $reset = PasswordReset::where('token', $validated['token_verify'])->first();
            if (!$reset) {
                throw new BadRequestException(__('messages.cus.token_reset_not_available'));
            }

            // check time valid
            $start  = new Carbon($reset->updated_at);
            $end    = now();
            if ($start->diffInMinutes($end) >= config('constants.time_life_reset_link')) {
                throw new BadRequestException(__('messages.cus.time_life_reset_not_available'));
            }

            $staff = $this->staff_repo->findByEmail($reset['email']);
            if (!$staff) {
                throw new NotAcceptableException(__('messages.cus.user_reset_not_available'));
            }
            $staff->password = $validated['password'];
            $staff->save();
            $reset->delete();
            DB::commit();
            return response()->jsonSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            throwErr($e);
        }
    }

    /**
     * Disable api
     * Verify account internal
     */
    public function registerVerify(RegisterVerifyRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $verify = EmailVerify::firstWhere('token', $validated['token_verify']);
            if (!$verify) {
                throw new BadRequestException(__('messages.cus.token_verify_not_available'));
            }
            $staff = $this->staff_repo->findByEmail($verify['email']);
            if (!$staff) {
                throw new NotAcceptableException(__('messages.cus.user_verify_not_available'));
            }
            $staff->email_verified_at = now();
            $staff->save();
            $verify->delete();
            DB::commit();
            return response()->jsonSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            throwErr($e);
        }
    }
}
