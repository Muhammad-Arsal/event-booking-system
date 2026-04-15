<?php

namespace App\Http\Requests\Booking;

use App\Models\Event;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreBookingRequest extends FormRequest
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
            'event_id' => ['required', 'exists:events,id'],
            'seats_booked' => ['required', 'integer', 'min:1'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->has('event_id') || $validator->errors()->has('seats_booked')) {
                return;
            }

            $event = Event::query()->find((int) $this->input('event_id'));

            if (! $event) {
                return;
            }

            if ($event->event_datetime->lte(now())) {
                $validator->errors()->add(
                    'event_id',
                    'This event has already ended. Booking is closed.'
                );

                return;
            }

            $seatsRequested = (int) $this->input('seats_booked');

            if ($seatsRequested > $event->available_seats) {
                $validator->errors()->add(
                    'seats_booked',
                    'Only '.$event->available_seats.' seat(s) are currently available.'
                );
            }
        });
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('event_id')) {
            return;
        }

        // The booking route carries the event in the URL.
        $this->merge([
            'event_id' => $this->route('event'),
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'event_id.exists' => 'The selected event could not be found.',
        ];
    }
}
