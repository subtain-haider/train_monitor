<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\TrainServiceContract;
use App\Contracts\TrainRepositoryContract;
use App\Services\TrainService;
use App\Repositories\TrainRepository;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TrainRepositoryContract::class, TrainRepository::class);
        $this->app->bind(TrainServiceContract::class, TrainService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
