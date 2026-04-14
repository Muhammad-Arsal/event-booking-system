<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">{{ __('Event Details') }}</h2>
            <a href="{{ route('events.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100">Back to Events</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm dark:border-green-700/60 dark:bg-green-900/30 dark:text-green-200">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->has('seats_booked') || $errors->has('booking'))
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm dark:border-red-700/60 dark:bg-red-900/30 dark:text-red-200">
                    {{ $errors->first('seats_booked') ?: $errors->first('booking') }}
                </div>
            @endif

            @php
                $available = (int) $event->available_seats;
                $total = max((int) $event->total_seats, 1);
                $isLimited = $available > 0 && ($available / $total) <= 0.2;
            @endphp

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="space-y-6 lg:col-span-2">
                    <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 sm:text-3xl">{{ $event->title }}</h1>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $event->location }}</p>
                            </div>

                            @can('update', $event)
                                <a
                                    href="{{ route('events.edit', $event->id) }}"
                                    class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                                >
                                    Edit Event
                                </a>
                            @endcan
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-600 dark:bg-gray-700">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Date & Time</p>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $event->event_datetime->format('M d, Y h:i A') }}</p>
                            </div>

                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-600 dark:bg-gray-700">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Seat Availability</p>
                                <div class="mt-1 flex items-center gap-2">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $event->available_seats }} / {{ $event->total_seats }}</p>

                                    @if ($available < 1)
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-900/40 dark:text-red-200">Sold Out</span>
                                    @elseif ($isLimited)
                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-900/40 dark:text-amber-200">Limited</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">Available</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-7">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Description</h3>
                            <p class="mt-2 whitespace-pre-line text-sm leading-7 text-gray-700 dark:text-gray-300">{{ $event->description ?: 'No description provided for this event yet.' }}</p>
                        </div>
                    </section>
                </div>

                <aside class="lg:col-span-1">
                    <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Book This Event</h3>

                        @if ($available < 1)
                            <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700 dark:border-amber-700/60 dark:bg-amber-900/30 dark:text-amber-200">
                                This event is currently sold out.
                            </div>
                        @elseif (auth()->check() && auth()->user()->hasVerifiedEmail())
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Choose your seats and confirm your booking.</p>

                            <form action="{{ route('bookings.store', $event->id) }}" method="POST" class="mt-5 space-y-4">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">

                                <div>
                                    <x-input-label for="seats_booked" :value="__('Number of Seats')" />
                                    <x-text-input
                                        id="seats_booked"
                                        name="seats_booked"
                                        type="number"
                                        min="1"
                                        max="{{ $event->available_seats }}"
                                        class="mt-1 block w-full"
                                        :value="old('seats_booked', 1)"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('seats_booked')" class="mt-2" />
                                </div>

                                <x-primary-button class="w-full justify-center">
                                    {{ __('Confirm Booking') }}
                                </x-primary-button>
                            </form>
                        @elseif (auth()->check())
                            <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700 dark:border-amber-700/60 dark:bg-amber-900/30 dark:text-amber-200">
                                Please verify your email before making a booking.
                                <a href="{{ route('verification.notice') }}" class="font-semibold underline hover:no-underline">Verify email</a>
                            </div>
                        @else
                            <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-600 dark:bg-gray-700">
                                <p class="text-sm text-gray-700 dark:text-gray-200">
                                    Please
                                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">log in</a>
                                    to book seats for this event.
                                </p>
                            </div>
                        @endif
                    </section>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
