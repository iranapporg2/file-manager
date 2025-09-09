<?php

	return [
		'disks' => [
			'private' => [
				'driver' => 'local',
				'root' => storage_path('app/private/files/'),
				'serve' => true,
				'throw' => true,
			],
			'public' => [
				'driver' => 'local',
				'root' => public_path(env('FILE_MANAGER_PUBLIC_ROOT')),
				'url' => env('APP_URL') . '/' . env('FILE_MANAGER_PUBLIC_ROOT'),
				'visibility' => 'public',
				'serve' => true,
				'throw' => false
			],
			'arvan' => [
				'driver' => 'arvan'
			],
			'arvans3' => [
				'driver' => 's3',
				'key' => env('ARVAN_ACCESS_KEY'),
				'secret' => env('ARVAN_SECRET_KEY'),
				'region' => 'default',
				'bucket' => env('ARVAN_BUCKET'),
				'url' => env('ARVAN_URL') . env('ARVAN_BUCKET'),
				'endpoint' => 'https://s3.ir-thr-at1.arvanstorage.ir',
				'use_path_style_endpoint' => true,
				'visibility' => 'public',
			],
			'ftp' => [
				'driver' => 'ftp',
				'host' => env('FTP_HOST'), // FTP server host
				'username' => env('FTP_USERNAME'),
				'password' => env('FTP_PASSWORD'),
				'url' => env('FTP_URL'),
				'port' => 21, // Default FTP port
				'root' => env('FTP_ROOT_FOLDER'), // Root directory on the FTP server
				'passive' => true, // Enable passive mode
				'ssl' => true, // Enable SSL/TLS (FTPS)
				'timeout' => 2500, // Connection timeout in seconds
			],
		],
	];