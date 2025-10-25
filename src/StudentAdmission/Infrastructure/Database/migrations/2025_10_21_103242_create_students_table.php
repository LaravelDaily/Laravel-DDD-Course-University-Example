<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('application_id')
                ->constrained('student_applications')
                ->onDelete('cascade');
            $table->timestamps();

            // Ensure one student per application
            $table->unique('application_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};


