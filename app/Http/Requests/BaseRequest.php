<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\MessageBag;

class BaseRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if (Request::is('api/*') || Request::ajax()) {
            $messages = $this->getMessages($validator->errors());
            Log::error('Request ip:'.Request::ip().' Trace id:'.(request()->trace_id ?? 0).' Validation exception:', $messages);
            throw new ValidationException($messages);
        }
    }

    /**
     * 
     */
    protected function getMessages(MessageBag $errors)
    {
        return $errors->messages();
    }

    /**
     * The combine message of fields is one-dimensional array
     */
    protected function combineMessages(array $arr_mess, $fields_combine = [])
    {
        if (!empty($fields_combine)) {
            foreach ($fields_combine as $field) {
                foreach ($arr_mess as $k => $v) {
                    if (preg_match("/$field.\w/", $k)) {
                        if (isset($arr_mess[$field])) {
                            if (count($v) > 1) {
                                foreach ($v as $mess) {
                                    array_push($arr_mess[$field], $mess);
                                }
                            } else {
                                array_push($arr_mess[$field], $v[0]);
                            }
                        } else {
                            $arr_mess[$field] = $v;
                        }
                        unset($arr_mess[$k]);
                    }
                }
            }
        }
        return $arr_mess;
    }
}