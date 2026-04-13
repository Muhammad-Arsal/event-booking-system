<?php

namespace App\Services;

use App\Interfaces\EventRepositoryInterface;

class EventService
{
    public function __construct(
        protected EventRepositoryInterface $eventRepository
    ) {}

    public function getPaginatedEvents(int $perPage = 10)
    {
        return $this->eventRepository->paginateUpcoming($perPage);
    }

    public function getEventById(int $id)
    {
        return $this->eventRepository->findById($id);
    }

    public function createEvent(array $data)
    {
        return $this->eventRepository->create($data);
    }

    public function updateEvent(int $id, array $data)
    {
        return $this->eventRepository->update($id, $data);
    }

    public function deleteEvent(int $id)
    {
        return $this->eventRepository->delete($id);
    }
}
