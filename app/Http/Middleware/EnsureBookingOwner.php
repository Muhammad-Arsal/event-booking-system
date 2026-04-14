<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBookingOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $bookingParam = $request->route('booking');

        $booking = $bookingParam instanceof Booking
            ? $bookingParam
            : Booking::query()->find($bookingParam);

        if (! $booking) {
            abort(404);
        }

        if ((int) $booking->user_id !== (int) $request->user()->id) {
            abort(403, 'You are not allowed to manage this booking.');
        }

        // Reuse the loaded model for route model binding downstream.
        $request->route()->setParameter('booking', $booking);

        return $next($request);
    }
}
