<?php

namespace Jollystrix\RemnawaveApi;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

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
	}

	/**
	 * Register the config for publishing
	 *
	 */
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([$this->configPath() => config_path('remnawave.php')], 'remnawave');
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
