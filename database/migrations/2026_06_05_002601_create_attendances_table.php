<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->date('attendance_date');
            $table->enum('label', ['good', 'spoof', 'abnormal'])->nullable();
            $table->foreignId('labeled_by')->nullable()->constrained('users');
            $table->timestamp('labeled_at')->nullable();
            $table->timestamps();
        });
    }
};