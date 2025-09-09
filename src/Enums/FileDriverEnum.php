<?php

    // app/Enums/FileType.php
    namespace itsunn\Filemanager\Enums;

    enum FileDriverEnum: string
    {
        case PUBLIC = 'public';
        case PRIVATE = 'private';
        case ARVAN = 'arvan';
        case S3 = 's3';
        case FTP = 'ftp';

        public static function values() {
            return array_map(fn ($enum) => $enum->value, self::cases());
        }

    }
