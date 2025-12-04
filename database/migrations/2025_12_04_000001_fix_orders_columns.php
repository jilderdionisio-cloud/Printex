<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->decimal('subtotal', 10, 2)->default(0);
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('total', 10, 2)->default(0);
                $table->string('payment_method', 50)->nullable();
                $table->string('status', 50)->default('Pendiente');
                $table->string('shipping_address')->nullable();
                $table->timestamps();
            });
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('user_id');
            }
            if (! Schema::hasColumn('orders', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
            }
            if (! Schema::hasColumn('orders', 'total')) {
                $table->decimal('total', 10, 2)->default(0)->after('discount');
            }
            if (! Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method', 50)->nullable()->after('total');
            }
            if (! Schema::hasColumn('orders', 'status')) {
                $table->string('status', 50)->default('Pendiente')->after('payment_method');
            }
            if (! Schema::hasColumn('orders', 'shipping_address')) {
                $table->string('shipping_address')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        // No revert to avoid data loss; drop columns only if desired.
    }
};
