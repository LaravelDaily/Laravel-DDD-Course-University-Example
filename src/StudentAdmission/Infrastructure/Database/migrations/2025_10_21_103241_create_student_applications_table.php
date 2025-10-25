<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->timestamp('submitted_at');
            $table->timestamp('expires_at')->nullable();
            $table->decimal('entry_exam_score', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            // Add index for status queries
            $table->index(['accepted_at', 'rejected_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};


