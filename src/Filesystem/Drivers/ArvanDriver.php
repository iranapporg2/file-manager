<?php

    namespace itsunn\Filemanager\Filesystem\Drivers;

    use Illuminate\Filesystem\FilesystemAdapter;
    use Illuminate\Support\Facades\Storage;
    use League\Flysystem\Filesystem;
    use itsunn\Filemanager\Filesystem\Adapters\ArvanAdapter;

    class ArvanDriver
    {
        public static function create($config)
        {
            $adapter = new ArvanAdapter($config['root'], $config['url']);
            $filesystem = new Filesystem($adapter);

            return new FilesystemAdapter($filesystem, $adapter, $config);
        }
    }
