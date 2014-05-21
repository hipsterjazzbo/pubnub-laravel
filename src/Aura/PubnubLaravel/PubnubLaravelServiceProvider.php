<?php namespace Aura\PubnubLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Pubnub\Pubnub;

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
			return new Pubnub(Config::get('pubnub-laravel::publish_key'), Config::get('pubnub-laravel::subscribe_key'), Config::get('pubnub-laravel::secret_key'), Config::get('pubnub-laravel::cipher_key'), Config::get('pubnub-laravel::ssl'), Config::get('pubnub-laravel::origin'), Config::get('pubnub-laravel::pem_path'));
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
