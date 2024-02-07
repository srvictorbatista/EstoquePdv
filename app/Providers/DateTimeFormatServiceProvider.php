<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Traits\DateTimeFormatTrait;


class DateTimeFormatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         // Model::addGlobalScope(new DateTimeFormatTrait);
    }
}
