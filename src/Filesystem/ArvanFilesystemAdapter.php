<?php

    namespace itsunn\Filemanager\Filesystem;

    use League\Flysystem\Config;
    use League\Flysystem\FileAttributes;
    use League\Flysystem\FilesystemAdapter;
    use itsunn\Filemanager\Services\ArvanService;

    class ArvanFilesystemAdapter implements FilesystemAdapter
    {
        protected ArvanService $service;
        protected ?array $response = null;

        public function __construct(ArvanService $service)
        {
            $this->service = $service;
        }

        public function write($path, $contents, Config $config): void
        {
            // not implemented
        }

        public function properties(): ?array
        {
            return $this->response;
        }

        public function writeStream($path, $resource, Config $config): void
        {

            $check_chunk_size = env('ARVAN_CHUNK_SIZE');

            if ($check_chunk_size) {
                $chunkSize = $check_chunk_size->value;
            } else {
                $chunkSize = 5242880;
            }

            $channelId = $config->get('channel_id');
            $title = $config->get('title');
            $convert_mode = $config->get('convert_mode','auto');

            if (!$channelId) {
                throw new \InvalidArgumentException("channel_id is required.");
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'arvan_');
            file_put_contents($tempFile, stream_get_contents($resource));

            $uploadRequest = $this->service->requestNewUploadFile($channelId, $tempFile);
            $uploadUrl = $uploadRequest['upload_url'] ?? null;
            $fileId = $uploadRequest['id'] ?? null;

            if (!$uploadUrl || !$fileId) {
                throw new \RuntimeException("Failed to request upload file.");
            }

            $fp = fopen($tempFile, 'rb');
            $offset = 0;

            while (!feof($fp)) {
                $data = fread($fp, $chunkSize);
                if (!$this->service->uploadChunk($uploadUrl, $data, $offset)) {
                    fclose($fp);
                    throw new \RuntimeException("Upload chunk failed at offset $offset");
                }
                $offset += strlen($data);
            }
            fclose($fp);

            unlink($tempFile); // clean up
            // create video (optional)
            $video = $this->service->createVideo($channelId, [
                'title' => $title,
                'file_id' => $fileId,
                'convert_mode' => $convert_mode,
            ]);

            if (!isset($video['data']['id'])) {
                throw new \RuntimeException("createVideo failed or no ID returned");
            }

            $this->response = $video['data'];

        }

        // Implement other methods as needed (delete, readStream, etc.)
        public function fileExists(string $path): bool {
            // TODO: Implement fileExists() method.
        }

        public function directoryExists(string $path): bool {
            // TODO: Implement directoryExists() method.
        }

        public function read(string $path): string {
            // TODO: Implement read() method.
        }

        public function readStream(string $path) {
            // TODO: Implement readStream() method.
        }

        public function delete(string $path): void {
            // TODO: Implement delete() method.
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
