<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('jsonError', function ($err_messages, $err_data, $err_code, $trace_id = 0, $http_code = 400) {
            return	Response::json( [
				'error' => [
					'messages' => $err_messages,
					'code' => $err_code,
                    'trace_id' => $trace_id
				]
			], $http_code);
		});

        Response::macro('jsonSuccess', function ($data = null, $message = null, $http_code = 200) {
            return	Response::json( [
				'success' => [
					'message' => $message ?? __('messages.http.success'),
					'code' => config('exceptions.http.success.code'),
                    'trace_id' => request()->trace_id ?? 0
                ],
                'body' => $data
			], $http_code);
		});

        Response::macro('jsonFail', function ($data = null, $message = null, $http_code = 400) {
            return	Response::json( [
				'error' => [
					'messages' => [
                        'system_mess' => [
                            $message ?? __('messages.http.fail'),
                        ]
                    ],
					'code' => config('exceptions.http.bad_request.code'),
                    'trace_id' => request()->trace_id ?? 0
                ],
                'body' => $data
			], $http_code);
		});

        /**
         * $code: [auth_success, refresh_success]
         */
        Response::macro('jsonToken', function ($token, $code = 'auth_success', $http_code = 200) {
			return	Response::json([
                'success' => [
					'message' => $message ?? __("messages.http.$code"),
					'code' => config("exceptions.http.$code.code"),
                ],
				'body' => [
					'access_token' => $token,
					'token_type' => config('constants.authenticate.token_type'),
					'expires_in' => auth()->factory()->getTTL() * 60
				]
			], $http_code);
		});
    }
}