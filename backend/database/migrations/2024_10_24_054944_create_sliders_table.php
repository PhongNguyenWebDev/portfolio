<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id(); // primary id
            $table->string('name', 100); // Giới hạn độ dài
            $table->string('position', 100); // Giới hạn độ dài
            $table->text('description')->nullable(); // Có thể null
            $table->string('url_cv')->nullable(); // URL có thể null
            $table->string('image')->nullable(); // Ảnh có thể null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
