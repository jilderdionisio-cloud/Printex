<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->unsignedInteger('quantity');
                $table->decimal('price', 10, 2);
                $table->timestamps();
            });

            return;
        }

        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'name')) {
                $table->string('name')->after('product_id');
            }

            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->unsignedInteger('quantity')->after('name');
            }

            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 10, 2)->after('quantity');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
