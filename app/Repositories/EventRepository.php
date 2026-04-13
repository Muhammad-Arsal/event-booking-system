<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use LogicException;

class EventRepository implements EventRepositoryInterface
{
    public function paginateUpcoming(int $perPage = 10)
    {
        // Will query the Event model once it's created
        throw new LogicException('EventRepository::paginateUpcoming() is not implemented yet.');
    }

    public function findById(int $id)
    {
        throw new LogicException('EventRepository::findById() is not implemented yet.');
    }

    public function create(array $data)
    {
        throw new LogicException('EventRepository::create() is not implemented yet.');
    }

    public function update(int $id, array $data)
    {
        throw new LogicException('EventRepository::update() is not implemented yet.');
    }

    public function delete(int $id)
    {
        throw new LogicException('EventRepository::delete() is not implemented yet.');
    }
}
