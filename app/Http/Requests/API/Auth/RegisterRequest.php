<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
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
            'staff_cd ' => 'required',
            'email'     => 'required|email:rfc,dns|max:255',
            'password'  => 'required|min:'.config('constants.password_min')
        ];
    }
}
