<?php

namespace App\Http\Requests\Admin\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomStoreRequest extends FormRequest
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
                'unique:rooms,name',
                'string',
            ],
            'status' => [
                Rule::in(STATUS_AVAILABLE, STATUS_NOT_AVAILABLE),
                'required',
                'integer',
            ],
            'm_type_id' => [
                'required',
                'integer',
            ],
            'price' => [
                'required',
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
