<?php

	//auto publish needing files
	namespace itsunn\Filemanager;

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\ServiceProvider;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				__DIR__.'/other/config' => config_path(),
			],'file-manager');

			$this->publishes([
				__DIR__.'/other/database/migrations'  => database_path('migrations'),
			],'file-manager');

			$this->publishes([
				__DIR__.'/other/public/assets'  => public_path('/assets'),
			],'file-manager');

			$this->publishes([
				__DIR__.'\other\resources' => base_path('resources'),
			], 'file-manager');

			$this->publishes([
				__DIR__.'/other/config/filemanager.php' => config_path(),
			], 'file-manager');

			$existing = config('filesystems.disks', []);
			$package  = config('filemanager.disks', []);

			config()->set('filesystems.disks', array_replace_recursive($existing, $package));

		}

		public function register()
		{
			$this->mergeConfigFrom(__DIR__.'/other/config/filemanager.php', 'filemanager');
		}

	}
