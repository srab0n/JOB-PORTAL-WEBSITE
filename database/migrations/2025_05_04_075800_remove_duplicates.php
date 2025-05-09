<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove duplicates from categories table
        DB::statement("
            DELETE c1 FROM categories c1
            INNER JOIN categories c2
            WHERE c1.id > c2.id
            AND c1.name = c2.name
        ");

        // Remove duplicates from job_types table
        DB::statement("
            DELETE jt1 FROM job_types jt1
            INNER JOIN job_types jt2
            WHERE jt1.id > jt2.id
            AND jt1.name = jt2.name
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot restore deleted duplicates
    }
}; 