<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">{{ __('My Bookings') }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track your reservations and cancellations.</p>
            </div>
            <a href="{{ route('events.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Browse Events</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm dark:border-green-700/60 dark:bg-green-900/30 dark:text-green-200">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->has('booking'))
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm dark:border-red-700/60 dark:bg-red-900/30 dark:text-red-200">
                    {{ $errors->first('booking') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-700">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">Booking History</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Event Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Seats</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Booked On</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            @forelse ($bookings as $booking)
                                <tr class="align-top transition hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('events.show', $booking->event_id) }}" class="text-sm font-semibold text-gray-900 hover:text-indigo-600 dark:text-gray-100 dark:hover:text-indigo-300">
                                            {{ $booking->event?->title ?? 'Event not available' }}
                                        </a>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $booking->event?->location ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $booking->event?->event_datetime?->format('M d, Y h:i A') ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $booking->seats_booked }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $booking->booking_date->format('M d, Y h:i A') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($booking->status === 'booked')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">Booked</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-700 dark:text-gray-200">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        @can('cancel', $booking)
                                            @if ($booking->status === 'booked')
                                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this booking?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center rounded-md border border-red-200 bg-red-50 px-3 py-1.5 font-medium text-red-700 transition hover:bg-red-100 dark:border-red-700/60 dark:bg-red-900/30 dark:text-red-200 dark:hover:bg-red-900/50"
                                                    >
                                                        Cancel
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">You haven't booked any events yet.</p>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Explore available events and reserve your seats in a few clicks.</p>
                                        <a
                                            href="{{ route('events.index') }}"
                                            class="mt-4 inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                                        >
                                            View Events
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-700">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
