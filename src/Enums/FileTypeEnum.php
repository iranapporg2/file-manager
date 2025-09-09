<?php

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

		public function title(): string
		{
			return match ($this) {
				self::IMAGE    => 'تصویر',
				self::VIDEO    => 'ویدئو',
				self::DOCUMENT => 'سند',
				self::AUDIO    => 'صوت',
				self::OTHER    => 'سایر',
				default => 'سایر'
			};
		}

	}
