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
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'instructor_id')) {
                $table->unsignedBigInteger('instructor_id')->nullable()->after('status');
            }

            if (!Schema::hasColumn('coupons', 'course_id')) {
                $table->unsignedBigInteger('course_id')->nullable()->after('instructor_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (Schema::hasColumn('coupons', 'course_id')) {
                $table->dropColumn('course_id');
            }

            if (Schema::hasColumn('coupons', 'instructor_id')) {
                $table->dropColumn('instructor_id');
            }
        });
    }
};
