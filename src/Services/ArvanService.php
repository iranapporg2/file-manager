<?php

    namespace itsunn\Filemanager\Services;

    use Illuminate\Http\Client\ConnectionException;
    use Illuminate\Support\Facades\Http;

    /**
     * سرویس کامل مدیریت فایل و ویدیو در VOD آروان مطابق با مستندات رسمی
     */
    class ArvanService
    {
        protected string $apiKey;
        protected string $baseUrl;

        public function __construct()
        {
            $this->apiKey = config('arvan.api_key');
            $this->baseUrl = rtrim(config('arvan.vod_url'), '/');
        }

        /**
         * ایجاد یک کانال جدید در VOD آروان
         *
         * @param  string  $title
         * @param  string  $access  [public|private]
         *
         * @return array|null
         */
        public function createChannel(string $title, string $access = 'private'): ?array
        {
            $options = [];
            if (config('app.env') == 'local') {
                $options = [
                    'verify' => false,
                ];
            }
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->withOptions($options)->post("{$this->baseUrl}/channels", [
                'title' => $title,
                'access' => $access,
            ]);
            return $response->successful() ? $response->json() : null;
        }

        /**
         * دریافت همه فایل‌های Draft یک کانال
         *
         * @param  string  $channelId
         *
         * @return array|null
         */
        public function getDraftFiles(string $channelId): ?array
        {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/channels/{$channelId}/files");
            return $response->successful() ? $response->json() : null;
        }

        /**
         * شروع آپلود فایل جدید (TUS API - مرحله ۱)
         *
         * @param  string  $channelId
         * @param  array  $params  // مثل name, size, type و ...
         *
         * @return array|null
         */
        public function requestNewUploadFile(string $channelId, string $filePath): ?array
        {
            $options = [];
            if (config('app.env') === 'local') {
                $options += ['verify' => false];
            }
            $fileName = basename($filePath);
            $fileType = mime_content_type($filePath);
            $fileSize = filesize($filePath);

            $metadata = 'filename ' . base64_encode($fileName) . ',filetype ' . base64_encode($fileType);

            $response = Http::withHeaders([
                'Authorization'    => $this->apiKey,
                'Tus-Resumable'    => '1.0.0',
                'Upload-Length'    => $fileSize,
                'Upload-Metadata'  => $metadata,
            ])->withOptions($options)
                ->post("{$this->baseUrl}/channels/{$channelId}/files");

            // مقدار upload_url را از هدر Location بگیر
            $uploadUrl = $response->header('Location');

            // سایر اطلاعات را دستی بساز (مثل آیدی از url)
            $fileId = basename(parse_url($uploadUrl, PHP_URL_PATH));

            return [
                'upload_url' => $uploadUrl,
                'id' => $fileId,
            ];
        }



        /**
         * دریافت اطلاعات یک فایل خاص
         *
         * @param  string  $channelId
         * @param  string  $fileId
         *
         * @return array|null
         */
        public function getFile(string $channelId, string $fileId): ?array
        {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/channels/{$channelId}/files/{$fileId}");
            return $response->successful() ? $response->json() : null;
        }

        /**
         * دریافت Offset فعلی آپلود (برای ادامه آپلود - TUS)
         *
         * @param  string  $uploadUrl
         *
         * @return int|null
         */
        public function getUploadOffset(string $uploadUrl): ?int
        {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->head($uploadUrl);

            return $response->header('Upload-Offset') ? (int) $response->header('Upload-Offset') : null;
        }

        /**
         * بارگذاری Chunk جدید برای فایل (TUS)
         *
         * @param  string  $uploadUrl
         * @param  string  $data  // Raw bytes
         * @param  int  $offset
         *
         * @return bool
         * @throws ConnectionException
         */
        public function uploadChunk(string $uploadUrl,  $data, int $offset): bool
        {
            $options = [];
            if (config('app.env') == 'local') {
                $options = [
                    'verify' => false,
                ];
            }
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Tus-Resumable'    => '1.0.0',
                'Upload-Offset' => $offset,
                'Content-Type' => 'application/offset+octet-stream',
            ])->withOptions($options)->send('PATCH', $uploadUrl, ['body' => $data]);

            return $response->successful();
        }

        /**
         * حذف فایل مشخص از کانال
         *
         * @param  string  $channelId
         * @param  string  $fileId
         *
         * @return bool
         */
        public function deleteFile(string $channelId, string $fileId): bool
        {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->delete("{$this->baseUrl}/channels/{$channelId}/files/{$fileId}");
            return $response->successful();
        }

        // ======== Video APIs ========

        /**
         * دریافت همه ویدیوهای یک کانال (لیست کامل)
         *
         * @param  string  $channelId
         *
         * @return array|null
         */
        public function getChannelVideos(string $channelId): ?array
        {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->get("{$this->baseUrl}/channels/{$channelId}/videos");
            return $response->successful() ? $response->json() : null;
        }

        /**
         * ثبت و ذخیره یک ویدیوی جدید (پس از اتمام آپلود)
         *
         * @param  string  $channelId
         * @param  array  $params  // اطلاعات ویدیو مثل title, description, file_id و ...
         *
         * @return array|null
         */
        public function createVideo(string $channelId, array $params): ?array
        {
            $options = [];
            if (config('app.env') == 'local') {
                $options = [
                    'verify' => false,
                ];
            }
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->withOptions($options)->post("{$this->baseUrl}/channels/{$channelId}/videos", $params);
            return $response->successful() ? $response->json() : null;
        }

        /**
         * دریافت اطلاعات یک ویدیو خاص
         *
         * @param  string  $channelId
         * @param  string  $videoId
         *
         * @return array|null
         */
        public function getVideo(string $videoId): ?array
        {
            $options = [];
            if (config('app.env') == 'local') {
                $options = [
                    'verify' => false,
                ];
            }
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->withOptions($options)->get("{$this->baseUrl}/videos/{$videoId}");

            return $response->successful() ? $response->json() : null;
        }

        /**
         * حذف یک ویدیو از کانال
         *
         * @param  string  $channelId
         * @param  string  $videoId
         *
         * @return bool
         */
        public function deleteVideo(string $channelId, string $videoId): bool
        {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->delete("{$this->baseUrl}/channels/{$channelId}/videos/{$videoId}");
            return $response->successful();
        }

	    public function getChanelList()
	    {
		    try {
			    $response = Http::withHeaders([
				    'Authorization' => $this->apiKey,
			    ])->timeout(3)
				    ->get($this->baseUrl.'/channels', [
					    'per_page' => 1000,
				    ]);

			    if ($response->successful() && isset($response['data'])) {
				    return $response['data'];
			    }

			    // مدیریت خطا یا خروجی غیرمنتظره
			    // مثلاً ثبت لاگ:
			    \Log::error('Arvan channel list error', [
				    'status' => $response->status(),
				    'body' => $response->body(),
			    ]);

			    return [];
		    } catch (\Exception $e) {
			    // مدیریت خطاهای ارتباطی
			    \Log::error('Arvan channel list exception', [
				    'message' => $e->getMessage(),
			    ]);
			    return [];
		    }
	    }

        /**
         * بروزرسانی متادیتا و مشخصات ویدیو
         *
         * @param  string  $channelId
         * @param  string  $videoId
         * @param  array  $params
         *
         * @return array|null
         */
        public function updateVideo(string $channelId, string $videoId, array $params): ?array
        {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->patch("{$this->baseUrl}/channels/{$channelId}/videos/{$videoId}", $params);
            return $response->successful() ? $response->json() : null;
        }
    }
