<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'purchase_count')) {
                $table->unsignedBigInteger('purchase_count')->default(0)->after('stock');
            }
        });

        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'enrollment_count')) {
                $table->unsignedBigInteger('enrollment_count')->default(0)->after('slots');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'purchase_count')) {
                $table->dropColumn('purchase_count');
            }
        });

        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'enrollment_count')) {
                $table->dropColumn('enrollment_count');
            }
        });
    }
};
