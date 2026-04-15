<?php

namespace App\Http\Requests\Event;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateEventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_datetime' => ['required', 'date'],
            'total_seats' => ['required', 'integer', 'min:1'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->has('event_datetime')) {
                return;
            }

            $event = Event::query()->find((int) $this->route('event'));

            if (! $event) {
                return;
            }

            $submittedDateTime = Carbon::parse((string) $this->input('event_datetime'))->seconds(0);
            $currentDateTime = $event->event_datetime->copy()->seconds(0);

            // Allow editing old events as long as the event date itself was not changed.
            if ($submittedDateTime->equalTo($currentDateTime)) {
                return;
            }

            if ($submittedDateTime->lt(now())) {
                $validator->errors()->add(
                    'event_datetime',
                    'The event date and time must be in the future.'
                );
            }
        });
    }
}
