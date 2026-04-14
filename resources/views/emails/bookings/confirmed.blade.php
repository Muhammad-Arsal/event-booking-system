<div style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2 style="margin-bottom: 8px;">Booking Confirmed</h2>

    <p style="margin-top: 0;">
        Your booking has been confirmed successfully.
    </p>

    <div style="margin-top: 16px; padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px;">
        <p style="margin: 0 0 8px;"><strong>Event:</strong> {{ $booking->event->title }}</p>
        <p style="margin: 0 0 8px;"><strong>Date & Time:</strong> {{ $booking->event->event_datetime->format('M d, Y h:i A') }}</p>
        <p style="margin: 0 0 8px;"><strong>Location:</strong> {{ $booking->event->location }}</p>
        <p style="margin: 0 0 8px;"><strong>Seats Booked:</strong> {{ $booking->seats_booked }}</p>
        <p style="margin: 0;"><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    </div>

    <p style="margin-top: 16px;">
        Thank you for booking with us.
    </p>
</div>
