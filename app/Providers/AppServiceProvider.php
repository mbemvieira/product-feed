<?php

namespace App\Providers;

use App\Services\ProductProviders\EBay;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EBay::class, function() {
            return new EBay();
        });
    }
}
