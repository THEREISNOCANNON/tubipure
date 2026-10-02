<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SaveDeliveryRequest extends FormRequest
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
            'customer_id' => [Rule::requiredIf(fn (): bool => ! $this->boolean('is_walk_in')), 'nullable', 'integer', 'exists:customers,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', 'regex:/^(?:8:00–10:00 AM|10:00 AM–12:00 PM|1:00–3:00 PM|3:00–5:00 PM|(?:[01][0-9]|2[0-3]):[0-5][0-9])$/u'],
            'gallons' => ['required', 'integer', 'min:1', 'max:1000'],
            'quantity' => [Rule::requiredIf(fn (): bool => $this->boolean('is_walk_in') && $this->input('water_type') !== 'both'), 'integer', 'min:1', 'max:1000'],
            'alkaline_quantity' => [Rule::requiredIf(fn (): bool => $this->boolean('is_walk_in') && $this->input('water_type') === 'both'), 'integer', 'min:1', 'max:1000'],
            'purified_quantity' => [Rule::requiredIf(fn (): bool => $this->boolean('is_walk_in') && $this->input('water_type') === 'both'), 'integer', 'min:1', 'max:1000'],
            'status' => ['sometimes', 'in:Pending,Confirmed,Out for Delivery,Delivered,Delayed,Cancelled'],
            'is_walk_in' => ['sometimes', 'boolean'],
            'water_type' => [Rule::requiredIf(fn (): bool => $this->boolean('is_walk_in')), 'in:alkaline,purified,both'],
        ];
    }

    /**
     * Add validation rules that depend on multiple request values.
     *
     * @return array<int, \Closure(Validator): void>
     */
    public function after(): array
    {
        return [function (Validator $validator): void {
            if (! $this->boolean('is_walk_in') || $this->input('water_type') !== 'both') {
                return;
            }

            if ($validator->errors()->hasAny(['alkaline_quantity', 'purified_quantity'])) {
                return;
            }

            if ((int) $this->input('alkaline_quantity') + (int) $this->input('purified_quantity') > 1000) {
                $validator->errors()->add('purified_quantity', 'The combined quantity cannot exceed 1000 gallons.');
            }
        }];
    }
}
