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
        try {
            $settings = $cache->remember('settings', now()->addMinutes(60), function () use ($settings) {
                return $settings->find(1);
            });
        } catch (\Throwable $e) {
            $settings = null;
        }

        if (! $settings) {
            $settings = [
                'time_book' => 3,
                'time_delay' => 6,
                'time_pause' => 7,
            ];
        }

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
