<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdatePricingSettingsRequest extends FormRequest
{
    private const WEEKDAYS = 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === 'staff';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'alkaline_price_per_gallon' => ['required', 'numeric', 'gt:0', 'max:999999.99'],
            'purified_price_per_gallon' => ['required', 'numeric', 'gt:0', 'max:999999.99'],
            'delivery_price_per_km' => ['required', 'numeric', 'gt:0', 'max:999999.99'],
            'opening_time' => ['sometimes', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
            'closing_time' => ['sometimes', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
            'delivery_start_time' => ['sometimes', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
            'delivery_end_time' => ['sometimes', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
            'station_schedule' => ['sometimes', 'array:'.self::WEEKDAYS, 'required_array_keys:'.self::WEEKDAYS],
            'station_schedule.*' => ['required', 'array:open,opens,closes', 'required_array_keys:open,opens,closes'],
            'station_schedule.*.open' => ['required', 'boolean'],
            'station_schedule.*.opens' => ['nullable', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
            'station_schedule.*.closes' => ['nullable', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
            'delivery_schedule' => ['sometimes', 'array:'.self::WEEKDAYS, 'required_array_keys:'.self::WEEKDAYS],
            'delivery_schedule.*' => ['required', 'array:open,opens,closes', 'required_array_keys:open,opens,closes'],
            'delivery_schedule.*.open' => ['required', 'boolean'],
            'delivery_schedule.*.opens' => ['nullable', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
            'delivery_schedule.*.closes' => ['nullable', 'date_format:H:i', 'regex:/^(?:[01]\d|2[0-3]):[0-5][05]$/'],
        ];
    }

    /**
     * Validate that each schedule ends after it starts on the same day.
     *
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [function (Validator $validator): void {
            if ($this->filled('opening_time') && $this->filled('closing_time')
                && ! $validator->errors()->hasAny(['opening_time', 'closing_time'])
                && $this->input('closing_time') <= $this->input('opening_time')) {
                $validator->errors()->add('closing_time', 'Closing time must be later than opening time.');
            }

            if ($this->filled('delivery_start_time') && $this->filled('delivery_end_time')
                && ! $validator->errors()->hasAny(['delivery_start_time', 'delivery_end_time'])
                && $this->input('delivery_end_time') <= $this->input('delivery_start_time')) {
                $validator->errors()->add('delivery_end_time', 'Delivery must end later than it starts.');
            }

            foreach (['station_schedule' => 'Station', 'delivery_schedule' => 'Delivery'] as $scheduleKey => $label) {
                foreach ($this->input($scheduleKey, []) as $day => $hours) {
                    if (! is_array($hours) || ! filter_var($hours['open'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                        continue;
                    }

                    $opens = $hours['opens'] ?? null;
                    $closes = $hours['closes'] ?? null;
                    $opensKey = "{$scheduleKey}.{$day}.opens";
                    $closesKey = "{$scheduleKey}.{$day}.closes";

                    if (! $opens) {
                        $validator->errors()->add($opensKey, "Set the {$label} opening time for {$day}.");
                    }

                    if (! $closes) {
                        $validator->errors()->add($closesKey, "Set the {$label} closing time for {$day}.");
                    }

                    if ($opens && $closes && ! $validator->errors()->hasAny([$opensKey, $closesKey]) && $closes <= $opens) {
                        $validator->errors()->add($closesKey, "{$label} closing time must be later than opening time on {$day}.");
                    }
                }
            }
        }];
    }
}
