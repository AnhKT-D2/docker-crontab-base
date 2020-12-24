<?php

namespace App\Http\Requests;

use App\Enums\Constant;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $id = $this->id;
        return [
            'name' => 'required|string|max:50|regex:/^[A-Za-z][A-Za-z0-9]*$/',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:8|max:20',
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $id,
            'level' => 'required|level:Constant::LEVEL_DEFAULT'
        ];
    }
}
