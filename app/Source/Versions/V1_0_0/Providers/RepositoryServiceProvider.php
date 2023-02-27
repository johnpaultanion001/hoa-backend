<?php

namespace Api\V1_0_0\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
	protected $version = 'V1_0_0';

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind(
			'Api' . '\\' . $this->version . '\\' . 'Repositories\Rest\RestRepository'
		);
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		//
	}
}
