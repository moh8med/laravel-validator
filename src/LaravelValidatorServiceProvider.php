<?php namespace Moh8med\LaravelValidator;

use Illuminate\Support\ServiceProvider;

class LaravelValidatorServiceProvider extends ServiceProvider {

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
		// Validator::resolver(function($translator, $data, $rules, $messages)
		$this->app->validator->resolver(function($translator, $data, $rules, $messages, $attributes)
		{
			return new LaravelValidator($translator, $data, $rules, $messages, $attributes);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('laravelvalidator');
	}

}
