<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm dark:border-green-700/60 dark:bg-green-900/30 dark:text-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
                <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Update Event</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Edit the details below. Seat availability is adjusted automatically.</p>
                    </div>

                    <p class="rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        Available Seats: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $event->available_seats }}</span>
                    </p>
                </div>

                <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $event->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                        >{{ old('description', $event->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $event->location)" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="event_datetime" :value="__('Event Date & Time')" />
                            <x-text-input id="event_datetime" name="event_datetime" type="datetime-local" class="mt-1 block w-full" :value="old('event_datetime', $event->event_datetime->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('event_datetime')" class="mt-2" />
                        </div>
                    </div>

                    <div class="sm:w-1/2">
                        <x-input-label for="total_seats" :value="__('Total Seats')" />
                        <x-text-input id="total_seats" name="total_seats" type="number" min="1" class="mt-1 block w-full" :value="old('total_seats', $event->total_seats)" required />
                        <x-input-error :messages="$errors->get('total_seats')" class="mt-2" />
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4 border-t border-gray-200 pt-6 dark:border-gray-700">
                        <button
                            type="submit"
                            form="delete-event-form"
                            class="inline-flex items-center rounded-md border border-red-200 bg-red-50 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-red-700 transition hover:bg-red-100 dark:border-red-800 dark:bg-red-900/30 dark:text-red-200 dark:hover:bg-red-900/50"
                            onclick="return confirm('Delete this event?');"
                        >
                            Delete Event
                        </button>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('events.show', $event->id) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Event') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <form id="delete-event-form" action="{{ route('events.destroy', $event->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</x-app-layout>
