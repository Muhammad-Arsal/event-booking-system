<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                    {{ __('Events') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Browse upcoming events</p>
            </div>

            @auth
                <a
                    href="{{ route('events.create') }}"
                    class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white dark:focus:ring-offset-gray-800"
                >
                    Create Event
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm dark:border-green-700/60 dark:bg-green-900/30 dark:text-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <form method="GET" action="{{ route('events.index') }}" class="grid gap-4 md:grid-cols-4 md:items-end">
                    <div class="md:col-span-2">
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input
                            id="location"
                            name="location"
                            type="text"
                            class="mt-1 block w-full"
                            :value="request('location')"
                            placeholder="e.g. Karachi"
                        />
                    </div>

                    <div>
                        <x-input-label for="date" :value="__('Event Date')" />
                        <x-text-input
                            id="date"
                            name="date"
                            type="date"
                            class="mt-1 block w-full"
                            :value="request('date')"
                        />
                    </div>

                    <div class="flex items-center gap-2">
                        <x-primary-button>
                            {{ __('Filter') }}
                        </x-primary-button>

                        @if (request()->filled('location') || request()->filled('date'))
                            <a
                                href="{{ route('events.index') }}"
                                class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                            >
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-700">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">Upcoming Events</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Seats</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Availability</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            @forelse ($events as $event)
                                @php
                                    $available = (int) $event->available_seats;
                                    $total = max((int) $event->total_seats, 1);
                                    $isLimited = $available > 0 && ($available / $total) <= 0.2;
                                @endphp

                                <tr class="align-top transition hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $event->title }}</p>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $event->location }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $event->event_datetime->format('M d, Y h:i A') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $event->available_seats }}</span>
                                        <span class="text-gray-400 dark:text-gray-500">/ {{ $event->total_seats }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($available < 1)
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/40 dark:text-red-200">Sold Out</span>
                                        @elseif ($isLimited)
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/40 dark:text-amber-200">Limited</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">Available</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a
                                            href="{{ route('events.show', $event->id) }}"
                                            class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-1.5 font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                                        >
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-14 text-center">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">No events published yet.</p>
                                        @auth
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create the first event to get started.</p>
                                        @else
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please check back soon.</p>
                                        @endauth
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-700">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
