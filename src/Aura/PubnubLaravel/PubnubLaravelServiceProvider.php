<?php namespace Aura\PubnubLaravel;

use Pubnub\Pubnub;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class PubnubLaravelServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('aura/pubnub-laravel');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['pubnub'] = $this->app->share(function ($app)
		{
			return new PubnubLaravel();
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
