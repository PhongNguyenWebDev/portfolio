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
        Schema::create('skills', function (Blueprint $table) {
            $table->id(); // primary id
            $table->string('title', 150); // Giới hạn độ dài cho tiêu đề
            $table->unsignedTinyInteger('process'); // Dùng unsignedTinyInteger vì giá trị từ 0 - 255
            $table->enum('level', ['basic', 'medium', 'advanced'])->default('basic'); // Enum với giá trị mặc định là 'basic'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
