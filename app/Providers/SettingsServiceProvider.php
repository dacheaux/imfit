<?php

namespace App\Providers;

use App\GlobalConf;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Factory $cache, GlobalConf $settings)
    {
        $settings = $cache->remember('settings', now()->addMinutes(60), function() use ($settings)
        {
            return $settings->find(1);
        });

        config()->set('settings', $settings);

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
