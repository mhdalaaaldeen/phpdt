<?php

namespace Phpdt\Ldt;

use Illuminate\Support\ServiceProvider;

class LdtServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {

		$this->loadRoutesFrom( __DIR__ . '/routes.php' );
		$this->loadViewsFrom( __DIR__ . '/views', 'phpdt' );
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {

	}
}