<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('bookings.index');
    }

    public function store(Request $request, string $event)
    {
        // Placeholder: handle event booking logic here
        return redirect()->route('bookings.index')->with('status', 'Event booked successfully (placeholder).');
    }

    public function cancel(string $booking)
    {
        // Placeholder: handle booking cancellation logic here
        return redirect()->route('bookings.index')->with('status', 'Booking cancelled successfully (placeholder).');
    }
}
