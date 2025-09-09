<?php

	namespace itsunn\Filemanager\Models;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;

	class Folder extends Model {

		protected $fillable = [
			'name',
			'folder_id'
		];

		public function parent(): BelongsTo
		{
			return $this->belongsTo(self::class, 'folder_id');
		}

		public function children(): HasMany
		{
			return $this->hasMany(self::class, 'folder_id');
		}

		public function ancestors(): \Illuminate\Support\Collection
		{
			$nodes = [];
			$node = $this;
			$guard = 0;
			while ($node && $guard < 500) {
				$nodes[] = $node;
				$node = $node->parent;
				$guard++;
			}
			return collect($nodes)->reverse()->values();
		}

	}
