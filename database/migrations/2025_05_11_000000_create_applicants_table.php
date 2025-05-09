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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id('applicant_id'); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK to users table (aspirant)
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade'); // FK to jobs table
            $table->string('institute');
            $table->string('degree');
            $table->string('cgpa');
            $table->string('passing_year');
            $table->string('experience');
            $table->timestamp('applied_date')->useCurrent();
            $table->timestamps();

            // Add unique constraint to prevent duplicate applications
            $table->unique(['user_id', 'job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
}; 