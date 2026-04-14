<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository implements EventRepositoryInterface
{
    public function paginateUpcoming(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = Event::query();

        if (! empty($filters['location'])) {
            $query->where('location', 'like', '%'.$filters['location'].'%');
        }

        if (! empty($filters['date'])) {
            $query->whereDate('event_datetime', $filters['date']);
        }

        return $query
            ->orderBy('event_datetime')
            ->paginate($perPage);
    }

    public function findById(int $id): Event
    {
        return Event::query()
            ->findOrFail($id);
    }

    public function create(array $data): Event
    {
        return Event::query()->create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);

        return $event->refresh();
    }

    public function delete(Event $event): bool
    {
        return (bool) $event->delete();
    }
}
