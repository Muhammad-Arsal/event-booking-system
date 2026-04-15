<?php

namespace App\Services;

use App\Interfaces\BookingRepositoryInterface;
use App\Mail\BookingConfirmedMail;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Throwable;

class BookingService
{
    public function __construct(
        protected BookingRepositoryInterface $bookingRepository
    ) {}

    public function getUserBookings(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->bookingRepository->paginateUserBookings($userId, $perPage);
    }

    public function createBooking(int $userId, array $data): Booking
    {
        $booking = DB::transaction(function () use ($userId, $data) {
            $seatsBooked = (int) $data['seats_booked'];
            $event = $this->bookingRepository->findEventForUpdate((int) $data['event_id']);

            if ($seatsBooked < 1) {
                throw ValidationException::withMessages([
                    'seats_booked' => 'Please select at least one seat.',
                ]);
            }

            if ($event->event_datetime->lte(now())) {
                throw ValidationException::withMessages([
                    'event_id' => 'This event has already ended. Booking is closed.',
                ]);
            }

            if ($event->available_seats < $seatsBooked) {
                throw ValidationException::withMessages([
                    'seats_booked' => 'Only '.$event->available_seats.' seat(s) are currently available.',
                ]);
            }

            $event->available_seats -= $seatsBooked;
            $this->bookingRepository->saveEvent($event);

            return $this->bookingRepository->create([
                'user_id' => $userId,
                'event_id' => $event->id,
                'seats_booked' => $seatsBooked,
                'status' => 'booked',
                'booking_date' => now(),
            ]);
        });

        $booking->load('event');

        $user = User::query()->find($userId);

        if ($user !== null) {
            try {
                Mail::to($user->email)->send(new BookingConfirmedMail($booking));
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return $booking;
    }

    public function cancelBooking(int $bookingId): Booking
    {
        return DB::transaction(function () use ($bookingId) {
            $booking = $this->bookingRepository->findByIdForUpdate($bookingId);

            if ($booking->status === 'cancelled') {
                throw ValidationException::withMessages([
                    'booking' => 'This booking has already been cancelled.',
                ]);
            }

            $event = $this->bookingRepository->findEventForUpdate($booking->event_id);
            $event->available_seats = min(
                $event->total_seats,
                $event->available_seats + $booking->seats_booked
            );

            $this->bookingRepository->saveEvent($event);

            return $this->bookingRepository->update($booking, [
                'status' => 'cancelled',
            ]);
        });
    }
}
