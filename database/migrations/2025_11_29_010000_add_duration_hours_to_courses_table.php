<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'duration_hours')) {
                $table->unsignedInteger('duration_hours')->default(0)->after('price');
            }
        });

        // Intentar migrar datos básicos desde la columna antigua si existe y es numérica.
        if (Schema::hasColumn('courses', 'duration_hours') && Schema::hasColumn('courses', 'duration')) {
            DB::table('courses')->whereNull('duration_hours')->update([
                'duration_hours' => DB::raw('CAST(duration AS UNSIGNED)'),
            ]);

            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('duration');
            });
        }
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'duration')) {
                $table->string('duration')->nullable()->after('price');
            }

            if (Schema::hasColumn('courses', 'duration_hours')) {
                $table->dropColumn('duration_hours');
            }
        });
    }
};
