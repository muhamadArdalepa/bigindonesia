<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class FolioServiceProvider extends ServiceProvider
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
        auth()->loginUsingId(3);
        Folio::path(resource_path('views/pages/g'))
            ->middleware(['guest']);
        Folio::path(resource_path('views/pages'))
            ->middleware(['auth']);
    }
}
