<?php

    namespace itsunn\Filemanager\Services;

    use itsunn\Filemanager\Enums\FileTypeEnum;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Http\UploadedFile;
    use ZipArchive;

    class FileService {

        //get max upload file size
        //for change it, you have to enter to cpanel
        public static function getMaxUploadSize() {

            $uploadMax = ini_get('upload_max_filesize');
            $postMax   = ini_get('post_max_size');
            $memory    = ini_get('memory_limit');

            return min(self::convertToBytes($uploadMax), self::convertToBytes($postMax), self::convertToBytes($memory));

        }

        public static function getFileType(string $ext): FileTypeEnum
        {

            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
            $videoExtensions = ['mp4', 'avi', 'mov', 'mkv', 'webm'];
            $documentExtensions = ['pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'ppt', 'pptx'];
            $audioExtensions = ['mp3', 'wav', 'aac', 'ogg'];

            if (in_array($ext, $imageExtensions)) {
                return FileTypeEnum::IMAGE;
            } elseif (in_array($ext, $videoExtensions)) {
                return FileTypeEnum::VIDEO;
            } elseif (in_array($ext, $documentExtensions)) {
                return FileTypeEnum::DOCUMENT;
            } elseif (in_array($ext, $audioExtensions)) {
                return FileTypeEnum::AUDIO;
            }

            return FileTypeEnum::OTHER;

        }

        //download file from link and inject it into request class
        public static function getUrlAsUploadedFile($url) {

            try {
                $response = Http::get($url);

                if ($response->successful()) {
                    $parsedUrl = parse_url($url);
                    $fileName = basename($parsedUrl['path']);
                    $tempPath = sys_get_temp_dir() . '/' . $fileName;
                    file_put_contents($tempPath, $response->body());

                    return new UploadedFile($tempPath, $fileName);

                } else {
                    return false;
                }
            } catch (\Exception $e) {
                return false;
            }

        }

        public static function getFileProperties($file_type,$file_path) {

            return match ($file_type) {
                FileTypeEnum::IMAGE => FilePropertiesService::getImage($file_path),
                FileTypeEnum::VIDEO => FilePropertiesService::getVideo($file_path),
                FileTypeEnum::DOCUMENT => FilePropertiesService::getDocument($file_path),
                FileTypeEnum::AUDIO => FilePropertiesService::getAudio($file_path),
                default => []
            };

        }

        public static function extractZipFile($zipFilePath)
        {
            if (!file_exists($zipFilePath)) {
                return false;
            }

            $extractTo = sys_get_temp_dir() . '\unzip';

            $zip = new ZipArchive();

            if ($zip->open($zipFilePath) === TRUE) {
                if ($zip->extractTo($extractTo)) {
                    $zip->close();
                    return self::makeUploadedFileFromFolders($extractTo);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        private function convertToBytes(string $value): int
        {
            $value = trim($value);
            $unit  = strtolower(substr($value, -1));
            $bytes = (int)$value;

            switch ($unit) {
                case 'g':
                    $bytes *= 1024 * 1024 * 1024;
                    break;
                case 'm':
                    $bytes *= 1024 * 1024;
                    break;
                case 'k':
                    $bytes *= 1024;
                    break;
            }

            return $bytes;
        }

        private static function makeUploadedFileFromFolders($folder_path) {

            $list_files = scandir($folder_path);
            $files = [];

            foreach ($list_files as $file) {
                if ($file != '.' && $file != '..') {
                    $files[] = new UploadedFile("{$folder_path}/$file", $file);
                }
            }

            return $files;

        }

    }
