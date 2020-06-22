<?php

namespace App\Providers;

use App\Payment\RepayManager;
use App\Payment\RepayManagerInterface;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->instance(RepayManagerInterface::class, new RepayManager());
    }
}
