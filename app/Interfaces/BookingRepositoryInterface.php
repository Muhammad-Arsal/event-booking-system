<?php

namespace App\Interfaces;

interface BookingRepositoryInterface
{
    public function paginateUserBookings(int $userId, int $perPage = 10);

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);
}
