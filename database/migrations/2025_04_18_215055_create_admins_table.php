<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('admin_id'); // Primary key for the admins table
            $table->unsignedBigInteger('user_id'); // Foreign key to users.id
            $table->string('role')->default('admin'); // Optional: role field (can be extended later)
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
