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
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // primary id
            $table->string('title', 200); // Giới hạn tiêu đề tối đa 200 ký tự
            $table->string('image_project')->nullable(); // Có thể để null nếu chưa có ảnh
            $table->text('description')->nullable(); // Không bắt buộc
            $table->string('image_tech')->nullable(); // Có thể null nếu chưa có ảnh kỹ thuật
            $table->string('url')->nullable(); // URL có thể null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
