<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|string|max:50|regex:/^[A-Za-z][A-Za-z0-9]*$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:20',
            'phone' => 'required|numeric|digits:10|unique:users',
            'level' => 'required|level:Constant::LEVEL_DEFAULT'
        ];
    }
}
