<?php

namespace App\Interfaces;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookingRepositoryInterface
{
    public function paginateUserBookings(int $userId, int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id): Booking;

    public function findByIdForUpdate(int $id): Booking;

    public function findEventForUpdate(int $eventId): Event;

    public function create(array $data): Booking;

    public function update(Booking $booking, array $data): Booking;

    public function saveEvent(Event $event): Event;
}
