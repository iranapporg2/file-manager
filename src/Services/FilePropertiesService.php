<?php

    namespace itsunn\Filemanager\Services;

    use getID3;
    use Smalot\PdfParser\Parser;

    class FilePropertiesService {

        public static function getImage($file_path) {

            $imageDetails = getimagesize($file_path);

            return [
                'width' => $imageDetails[0],
                'height' => $imageDetails[1],
            ];

        }

        public static function getVideo($file_path) {

            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($file_path);

            if (isset($fileInfo['video'])) {
                return [
                    'width' => $fileInfo['video']['resolution_x'],
                    'height' => $fileInfo['video']['resolution_y'],
                    'duration' => $fileInfo['playtime_seconds'],
                    'codec' => isset($fileInfo['video']['codec']) ? $fileInfo['video']['codec'] : '',
                ];
            }

        }

        public static function getDocument($file_path) {

            $parser = new Parser();
            $pdf = $parser->parseFile($file_path);
            $details = $pdf->getDetails();

            return [
                'title' => isset($details['Title']) ? $details['Title'] : 'ناشناخته',
                'author' => isset($details['Author']) ? $details['Author'] : 'ناشناخته',
                'subject' => isset($details['Subject']) ? $details['Subject'] : 'ناشناخته',
                'producer' => isset($details['Producer']) ? $details['Producer'] : 'ناشناخته',
                'creator' => isset($details['Creator']) ? $details['Creator'] : 'ناشناخته',
                'created' => isset($details['CreationDate']) ? $details['CreationDate'] : 'ناشناخته',
                'pages' => count($pdf->getPages()),
            ];

        }

        public static function getAudio($file_path) {

            $getID3 = new getID3();
            $fileInfo = $getID3->analyze($file_path);

            return [
                'format' => isset($fileInfo['fileformat']) ? $fileInfo['fileformat'] : 'ناشناخته',
                'duration' => isset($fileInfo['playtime_seconds']) ? $fileInfo['playtime_seconds'] : 'ناشناخته',
                'bitrate' => isset($fileInfo['audio']['bitrate']) ? $fileInfo['audio']['bitrate'] : 'ناشناخته',
                'sample_rate' => isset($fileInfo['audio']['sample_rate']) ? $fileInfo['audio']['sample_rate'] : 'ناشناخته',
                'channels' => isset($fileInfo['audio']['channels']) ? $fileInfo['audio']['channels'] : 'ناشناخته',
                'mime' => isset($fileInfo['mime_type']) ? $fileInfo['mime_type'] : 'ناشناخته',
            ];

        }

    }
