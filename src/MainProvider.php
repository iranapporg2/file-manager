<?php

	//auto publish needing files
	namespace itsunn\Filemanager;

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\ServiceProvider;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				__DIR__.'/other/config' => config_path(),
			],'iranapp-config');

			$this->publishes([
				__DIR__.'/other/database/migrations'  => database_path('migrations'),
			],'file-manager');

			$this->publishes([
				__DIR__.'/other/public'  => public_path('assets'),
			],'file-manager');

			$this->loadRoutesFrom(__DIR__.'/other/routes/artisan.php');

		}

		public function register()
		{

		}

	}
