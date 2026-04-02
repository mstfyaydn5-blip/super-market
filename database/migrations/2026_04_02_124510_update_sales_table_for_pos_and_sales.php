<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'invoice_number')) {
                $table->string('invoice_number')->nullable()->after('id');
            }

            if (!Schema::hasColumn('sales', 'sale_date')) {
                $table->date('sale_date')->nullable()->after('customer_id');
            }

            if (!Schema::hasColumn('sales', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('sale_date');
            }

            if (!Schema::hasColumn('sales', 'discount')) {
                $table->decimal('discount', 12, 2)->default(0)->after('subtotal');
            }

            if (!Schema::hasColumn('sales', 'paid_amount')) {
                $table->decimal('paid_amount', 12, 2)->default(0)->after('total');
            }

            if (!Schema::hasColumn('sales', 'remaining_amount')) {
                $table->decimal('remaining_amount', 12, 2)->default(0)->after('paid_amount');
            }

            if (!Schema::hasColumn('sales', 'payment_status')) {
                $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid')->after('remaining_amount');
            }

            if (!Schema::hasColumn('sales', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'credit'])->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('sales', 'notes')) {
                $table->text('notes')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('sales', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $columns = [
                'invoice_number',
                'sale_date',
                'subtotal',
                'discount',
                'paid_amount',
                'remaining_amount',
                'payment_status',
                'payment_method',
                'notes',
                'user_id',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('sales', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
