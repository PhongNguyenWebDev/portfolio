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
        Schema::create('work_experience', function (Blueprint $table) {
            $table->id(); // primary id
            $table->string('title', 150); // Giới hạn độ dài cho tiêu đề
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Có thể null nếu chưa kết thúc
            $table->decimal('gpa', 3, 2)->nullable(); // Cho phép giá trị null
            $table->decimal('gpa_scale', 3, 1)->nullable(); // Có thể null
            $table->string('position', 100); // Giới hạn độ dài cho vị trí công việc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experience');
    }
};
