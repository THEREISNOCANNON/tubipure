<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryStatusRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'in:Pending,Confirmed,Out for Delivery,Delivered'],
            'date' => ['sometimes', 'date'],
            'time_slot' => ['sometimes', 'date_format:H:i'],
            'gallons' => ['sometimes', 'integer', 'min:1', 'max:1000'],
            'status_note' => ['sometimes', 'nullable', 'string', 'max:200'],
        ];
    }
}
