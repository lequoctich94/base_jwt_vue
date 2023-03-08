<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
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
            'staff_cd' => 'required',
            'password' => 'required|min:'.config('constants.password_min')
        ];
    }

    /**
     * Define field name JP follow UI
     * 
     * @return string
     */
    private function fieldLocaleJP($name)
    {
        $fields = [
            'staff_cd' => 'ユーザーID',
            'password' => 'パスワード'
        ];
        return $fields[$name] ?? '';
    }

    /**
     * Get the validation messages that apply to the request.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'staff_cd.required' => $this->fieldLocaleJP('staff_cd').__('messages.validation.required'),
            'password.required' => $this->fieldLocaleJP('password').__('messages.validation.required'),
            'password.min' => __('messages.validation.min', ['num' => config('constants.password_min')]),
        ];
    }
}
