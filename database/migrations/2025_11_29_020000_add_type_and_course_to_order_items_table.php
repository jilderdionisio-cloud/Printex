<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (! Schema::hasColumn('order_items', 'item_type')) {
                $table->string('item_type')->default('product')->after('product_id');
            }

            if (! Schema::hasColumn('order_items', 'course_id')) {
                $table->foreignId('course_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            }
        });

        // Aseguramos que product_id pueda ser nulo cuando es un curso (sin requerir DBAL)
        if (Schema::hasColumn('order_items', 'product_id')) {
            $connection = Schema::getConnection()->getDriverName();
            if ($connection === 'mysql') {
                DB::statement('ALTER TABLE order_items MODIFY product_id BIGINT UNSIGNED NULL');
            }
        }
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'course_id')) {
                $table->dropConstrainedForeignId('course_id');
            }

            if (Schema::hasColumn('order_items', 'item_type')) {
                $table->dropColumn('item_type');
            }

        });
    }
};
