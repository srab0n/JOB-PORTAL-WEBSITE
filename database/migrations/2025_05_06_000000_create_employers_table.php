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
        Schema::create('employers', function (Blueprint $table) {
            $table->id('employer_id'); // Primary key for the employers table
            $table->unsignedBigInteger('user_id'); // Foreign key to users.id
            $table->string('company_name');
            $table->string('company_location')->nullable();
            $table->string('company_website')->nullable();
            $table->text('company_description')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_size')->nullable();
            $table->string('industry')->nullable();
            $table->string('founded_year')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
}; 