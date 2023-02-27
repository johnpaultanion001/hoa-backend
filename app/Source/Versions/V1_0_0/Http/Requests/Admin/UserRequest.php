<?php

namespace Api\V1_0_0\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $unique = [];


        if ($this->isMethod('post')) {

            $unique = [
                "email" => "required|email|unique:users,email",

            ];

        }

        if ($this->isMethod('put')) {
            $unique = [
                'email'                 => [
                    'required',
                    Rule::unique('users')->ignore($this->route()->parameter('user')),
                ],

            ];
        }

        return array_merge([
            "name"     => "required",
            "role"     => "required",
            "disabled" => "required",
            'phone_number' => 'nullable|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9',
        ], $unique);
    }
}
