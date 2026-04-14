<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\CancelBookingRequest;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Booking::class);

        $bookings = $this->bookingService->getUserBookings((int) auth()->id(), 10);

        return view('bookings.index', compact('bookings'));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $this->authorize('create', Booking::class);

        $booking = $this->bookingService->createBooking(
            (int) $request->user()->id,
            $request->validated()
        );

        return redirect()
            ->route('events.show', $booking->event_id)
            ->with('status', 'Your booking has been confirmed.');
    }

    public function cancel(CancelBookingRequest $request, Booking $booking): RedirectResponse
    {
        $request->validated();

        $this->bookingService->cancelBooking($booking->id);

        return redirect()
            ->route('bookings.index')
            ->with('status', 'Booking cancelled successfully.');
    }
}
