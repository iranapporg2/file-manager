<?php

    // app/Enums/FileType.php
    namespace itsunn\Filemanager\Enums;

    enum FileTypeEnum: string
    {
        case IMAGE = 'image';
        case VIDEO = 'video';
        case DOCUMENT = 'document';
        case AUDIO = 'audio';
        case OTHER = 'other';

        public static function values() {
            return array_map(fn ($enum) => $enum->value, self::cases());
        }

    }
