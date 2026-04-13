<?php

namespace App\Providers;

use App\Interfaces\BookingRepositoryInterface;
use App\Interfaces\EventRepositoryInterface;
use App\Repositories\BookingRepository;
use App\Repositories\EventRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
    }
}
