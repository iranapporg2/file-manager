<?php

    use itsunn\Filemanager\Enums\FileDriverEnum;
    use itsunn\Filemanager\Enums\FileTypeEnum;
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {

        /**
         * Run the migrations.
         */
        public function up(): void {
            Schema::create('files', function (Blueprint $table) {
                $table->id();
                $table->nullableMorphs('creator');
                $table->string('title');
                $table->string('description')->nullable();
                $table->string('path')->default('/');
                $table->string('filename')->nullable();
                $table->unsignedBigInteger('filesize')->nullable();
                $table->enum('driver',FileDriverEnum::values());
                $table->enum('type',FileTypeEnum::values())->nullable();
                $table->string('content_type')->nullable();
                $table->json('properties')->nullable();
                $table->unsignedInteger('views_count')->default(0);
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void {
            Schema::dropIfExists('files');
        }

    };
