<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $defer = true;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(\App\Discounts\DiscountCollection::class , function() {
            return new \App\Discounts\DiscountCollection([
                new \App\Discounts\ToolsDiscount(),
                new \App\Discounts\SwitchesDiscount(),
                new \App\Discounts\VipDiscount()
            ]);
        });
    }
}
