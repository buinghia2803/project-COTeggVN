<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'email',
                'required',
                'unique:users,email,' . request()->route('user')->id,
                'string',
            ],
            'password' => [
                'required_if:change_password,==,' . 'on'
            ],
        ];
    }

    /**
     * Get the attributes that apply to the request.
     *
     * @return  array
     */
    public function attributes(): array
    {
        return [
            'm_type_id' => 'types',
        ];
    }
}
