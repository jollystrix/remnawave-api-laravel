<?php

namespace Jollystrix\RemnawaveApi;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Jollystrix\RemnawaveApi\RemnawaveClient;
use Laravel\Lumen\Application as LumenApplication;

class RemnawaveServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->configPath(), 'remnawave');

        $this->app->singleton(RemnawaveClient::class, function ($app) {
            $config = $this->app['config']->get('remnawave');
            return new RemnawaveClient($config);
        });
    }

    /**
     * Register the config for publishing
     *
     */
    public function boot()
    {
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$this->configPath() => config_path('remnawave.php')], 'remnawave');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('remnawave');
        }
    }

    /**
     * Set the config path
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__ . '/../config/remnawave.php';
    }

}
