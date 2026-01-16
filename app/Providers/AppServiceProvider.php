<?php

namespace App\Providers;

use App\Models\Appointment;
use Illuminate\Support\ServiceProvider;
use App\Observers\AppointmentObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            Paginator::useBootstrapFive(); // for Bootstrap 5

            Schema::defaultStringLength(191);
        Appointment::observe(AppointmentObserver::class);
    }
}
