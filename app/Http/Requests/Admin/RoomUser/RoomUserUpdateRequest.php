<?php

namespace App\Http\Requests\Admin\RoomUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomUserUpdateRequest extends FormRequest
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
            'checkin_date' => [
                'required',
                'date',
            ],
            'checkout_date' => [
                'required',
                'date',
                'after_or_equal:checkin_date'
            ],
            'status' => [
                Rule::in(STATUS_APPROVE, STATUS_REJECT),
                'required',
                'integer',
            ],
        ];
    }
}
