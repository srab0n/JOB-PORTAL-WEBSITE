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
        Schema::table('jobs', function (Blueprint $table) {
            $table->integer('status')->default(1)->after('company_website'); // 1 means active dropdown
            $table->integer('isFeatured')->default(0)->after('status'); // 1 means featured
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Check if the column exists before attempting to drop it
            if (Schema::hasColumn('jobs', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('jobs', 'isFeatured')) {
                $table->dropColumn('isFeatured');
            }
        });
    }
};
