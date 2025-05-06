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
            // Add status and isFeatured columns if they don't exist
            if (!Schema::hasColumn('jobs', 'status')) {
                $table->integer('status')->default(1)->after('company_website');
            }
            if (!Schema::hasColumn('jobs', 'isFeatured')) {
                $table->integer('isFeatured')->default(0)->after('status');
            }
            // Add user_id foreign key if it doesn't exist
            if (!Schema::hasColumn('jobs', 'user_id')) {
                $table->foreignId('user_id')->after('job_type_id')->constrained('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (Schema::hasColumn('jobs', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('jobs', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('jobs', 'isFeatured')) {
                $table->dropColumn('isFeatured');
            }
        });
    }
};