<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingRepositoryInterface
{
    public function paginateUserBookings(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Booking::query()
            ->with('event:id,title,location,event_datetime')
            ->where('user_id', $userId)
            ->orderByDesc('booking_date')
            ->paginate($perPage);
    }

    public function findById(int $id): Booking
    {
        return Booking::query()
            ->with('event')
            ->findOrFail($id);
    }

    public function findByIdForUpdate(int $id): Booking
    {
        return Booking::query()
            ->whereKey($id)
            ->lockForUpdate()
            ->firstOrFail();
    }

    public function findEventForUpdate(int $eventId): Event
    {
        return Event::query()
            ->whereKey($eventId)
            ->lockForUpdate()
            ->firstOrFail();
    }

    public function create(array $data): Booking
    {
        return Booking::query()->create($data);
    }

    public function update(Booking $booking, array $data): Booking
    {
        $booking->update($data);

        return $booking->refresh();
    }

    public function saveEvent(Event $event): Event
    {
        $event->save();

        return $event->refresh();
    }
}
