<?php

namespace App\Services;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventService
{
    public function __construct(
        protected EventRepositoryInterface $eventRepository
    ) {}

    public function getPaginatedEvents(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->eventRepository->paginateUpcoming($perPage, $filters);
    }

    public function getEventById(int $id): Event
    {
        return $this->eventRepository->findById($id);
    }

    public function createEvent(array $data, int $creatorId): Event
    {
        $data['created_by'] = $creatorId;
        $data['available_seats'] = (int) $data['total_seats'];

        return $this->eventRepository->create($data);
    }

    public function updateEvent(Event $event, array $data): Event
    {
        $currentBookedSeats = max($event->total_seats - $event->available_seats, 0);
        $newTotalSeats = (int) $data['total_seats'];

        $data['available_seats'] = max($newTotalSeats - $currentBookedSeats, 0);

        return $this->eventRepository->update($event, $data);
    }

    public function deleteEvent(Event $event): bool
    {
        return $this->eventRepository->delete($event);
    }
}
