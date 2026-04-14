<?php

namespace App\Interfaces;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EventRepositoryInterface
{
    public function paginateUpcoming(int $perPage = 10, array $filters = []): LengthAwarePaginator;

    public function findById(int $id): Event;

    public function create(array $data): Event;

    public function update(Event $event, array $data): Event;

    public function delete(Event $event): bool;
}
