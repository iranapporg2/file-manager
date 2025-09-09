<?php

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

		public function title(): string
		{
			return match ($this) {
				self::PUBLIC    => 'عمومی',
				self::PRIVATE    => 'خصوصی',
				self::ARVAN => 'آروان',
				self::S3    => 'S3',
				self::FTP    => 'اف تی پی',
				default => 'سایر'
			};
		}

	}
