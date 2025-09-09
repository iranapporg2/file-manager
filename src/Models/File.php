<?php

    namespace itsunn\Filemanager\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use itsunn\Filemanager\Enums\FileDriverEnum;
    use itsunn\Filemanager\Enums\FileTypeEnum;

    class File extends Model
    {
        use HasFactory;

        protected $fillable = [
            'creator_id',
            'creator_type',
            'title',
            'description',
            'path',
            'filename',
            'filesize',
            'driver',
            'type',
            'content_type',
            'properties',
            'views_count',
            'active',
        ];

        protected $casts = [
            'properties' => 'array',
            'active'     => 'boolean',
            'original_name'     => 'boolean',
            'driver'     => FileDriverEnum::class,
            'type'       => FileTypeEnum::class,
        ];

        public function creator()
        {
            return $this->morphTo();
        }

        public function incrementViews()
        {
            $this->increment('views_count');
        }

        public function toggleActive()
        {
            $this->active = !$this->active;
            $this->save();
        }

        public function getFullPathAttribute()
        {
            return $this->path . '/' . $this->filename;
        }

    }
