<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_items', 'cost_price')) {
                $table->decimal('cost_price', 12, 2)->default(0)->after('price');
            }

            if (!Schema::hasColumn('sale_items', 'profit')) {
                $table->decimal('profit', 12, 2)->default(0)->after('cost_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            if (Schema::hasColumn('sale_items', 'profit')) {
                $table->dropColumn('profit');
            }

            if (Schema::hasColumn('sale_items', 'cost_price')) {
                $table->dropColumn('cost_price');
            }
        });
    }
};
