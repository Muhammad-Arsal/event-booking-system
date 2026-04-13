<?php

namespace App\Interfaces;

interface EventRepositoryInterface
{
    public function paginateUpcoming(int $perPage = 10);

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
