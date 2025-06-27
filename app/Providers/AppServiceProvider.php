<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\StockItemRepositoryInterface;
use App\Repositories\Eloquent\StockItemRepository;
use App\Repositories\Eloquent\ProcurementRepository;
use App\Repositories\Interfaces\ProcurementRepositoryInterface;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StockItemRepositoryInterface::class, StockItemRepository::class);
        $this->app->bind(ProcurementRepositoryInterface::class, ProcurementRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Paginator::useBootstrapFive();
    }
}