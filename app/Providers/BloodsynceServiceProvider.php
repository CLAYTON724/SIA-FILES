<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BloodsynceServiceProvider extends ServiceProvider
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
        // Register view composers
        view()->composer('*', function ($view) {
            $view->with('bloodTypes', config('bloodsynce.blood_types'));
            $view->with('urgencyLevels', config('bloodsynce.urgency_levels'));
        });
    }
}
