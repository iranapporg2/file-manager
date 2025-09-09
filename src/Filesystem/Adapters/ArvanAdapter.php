<?php

    namespace itsunn\Filemanager\Filesystem\Adapters;

    use Illuminate\Support\Facades\Storage;
    use League\Flysystem\FileAttributes;
    use League\Flysystem\FilesystemAdapter;
    use League\Flysystem\Config;

    class ArvanAdapter implements FilesystemAdapter
    {

        protected $root;
        protected $url;

        public function __construct($root, $url)
        {
            $this->root = $root;
            $this->url = $url;
        }

        public function fileExists(string $path): bool
        {

        }

        public function write(string $path, string $contents, Config $config): void
        {

        }

        public function read(string $path): string
        {

        }

        public function delete(string $path): void
        {

        }

        public function getUrl($path)
        {
            return config('filesystems.disks.arvan.url') . ltrim($path, '/');
        }

        // Implement other required methods from FilesystemAdapter interface
        // For simplicity, only a few methods are shown here.
        public function directoryExists(string $path): bool {
            // TODO: Implement directoryExists() method.
        }

        public function writeStream(string $path, $contents, Config $config): void {
            Storage::disk('media')->put($path, $contents);
        }

        public function readStream(string $path) {
            // TODO: Implement readStream() method.
        }

        public function deleteDirectory(string $path): void {
            // TODO: Implement deleteDirectory() method.
        }

        public function createDirectory(string $path, Config $config): void {
            // TODO: Implement createDirectory() method.
        }

        public function setVisibility(string $path, string $visibility): void {
            // TODO: Implement setVisibility() method.
        }

        public function visibility(string $path): FileAttributes {
            // TODO: Implement visibility() method.
        }

        public function mimeType(string $path): FileAttributes {
            // TODO: Implement mimeType() method.
        }

        public function lastModified(string $path): FileAttributes {
            // TODO: Implement lastModified() method.
        }

        public function fileSize(string $path): FileAttributes {
            // TODO: Implement fileSize() method.
        }

        public function listContents(string $path, bool $deep): iterable {
            // TODO: Implement listContents() method.
        }

        public function move(string $source, string $destination, Config $config): void {
            // TODO: Implement move() method.
        }

        public function copy(string $source, string $destination, Config $config): void {
            // TODO: Implement copy() method.
        }
    }
