<?php

namespace App\Services;

use App\Interfaces\BookingRepositoryInterface;

class BookingService
{
    public function __construct(
        protected BookingRepositoryInterface $bookingRepository
    ) {}

    public function getUserBookings(int $userId, int $perPage = 10)
    {
        return $this->bookingRepository->paginateUserBookings($userId, $perPage);
    }

    public function createBooking(array $data)
    {
        // Seat availability checks, duplicate-booking guards, etc. will go here
        return $this->bookingRepository->create($data);
    }

    public function cancelBooking(int $bookingId, int $userId)
    {
        $booking = $this->bookingRepository->findById($bookingId);

        // Ownership verification and cancellation rules will go here
        return $this->bookingRepository->update($bookingId, ['status' => 'cancelled']);
    }
}
