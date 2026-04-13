<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use LogicException;

class BookingRepository implements BookingRepositoryInterface
{
    public function paginateUserBookings(int $userId, int $perPage = 10)
    {
        throw new LogicException('BookingRepository::paginateUserBookings() is not implemented yet.');
    }

    public function findById(int $id)
    {
        throw new LogicException('BookingRepository::findById() is not implemented yet.');
    }

    public function create(array $data)
    {
        throw new LogicException('BookingRepository::create() is not implemented yet.');
    }

    public function update(int $id, array $data)
    {
        throw new LogicException('BookingRepository::update() is not implemented yet.');
    }
}
