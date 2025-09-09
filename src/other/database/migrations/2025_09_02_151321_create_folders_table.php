<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void {
			Schema::create('folders', function (Blueprint $table) {
				$table->id();
				$table->foreignId('folder_id')->nullable();
				$table->string('name');
				$table->timestamps();
			});
		}

		public function down(): void {
			Schema::dropIfExists('folders');
		}

	};
