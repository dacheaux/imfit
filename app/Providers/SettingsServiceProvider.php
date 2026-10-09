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
                $row = $settings->find(1);

                return $row ? $this->settingsArray($row) : null;
            });
        } catch (\Throwable $e) {
            $settings = null;
        }

        config()->set('settings', $this->settingsArray($settings));
    }

    /**
     * @param  mixed  $settings
     * @return array{time_book: mixed, time_delay: mixed, time_pause: mixed}
     */
    protected function settingsArray($settings): array
    {
        if ($settings instanceof GlobalConf) {
            return $settings->only(['time_book', 'time_delay', 'time_pause']);
        }

        if (is_array($settings)) {
            return [
                'time_book' => $settings['time_book'] ?? 3,
                'time_delay' => $settings['time_delay'] ?? 6,
                'time_pause' => $settings['time_pause'] ?? 7,
            ];
        }

        return [
            'time_book' => 3,
            'time_delay' => 6,
            'time_pause' => 7,
        ];
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
