<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token_verify'          => 'required|string',
            'password'              => 'required|min:'.config('constants.password_min'),
            'password_confirmation' => 'same:password',
        ];
    }
}
