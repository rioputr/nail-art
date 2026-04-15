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
        Schema::table('transactions', function (Blueprint $table) {
            // Rename columns if they exist with old names
            if (Schema::hasColumn('transactions', 'invoice_number')) {
                $table->renameColumn('invoice_number', 'transaction_code');
            }
            if (Schema::hasColumn('transactions', 'amount')) {
                $table->renameColumn('amount', 'total_amount');
            }
            
            // Add new columns
            if (!Schema::hasColumn('transactions', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('status');
            }

            // Ensure status has enough values or is string
            // Current migration had string default pending
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'transaction_code')) {
                $table->renameColumn('transaction_code', 'invoice_number');
            }
            if (Schema::hasColumn('transactions', 'total_amount')) {
                $table->renameColumn('total_amount', 'amount');
            }
            if (Schema::hasColumn('transactions', 'shipping_address')) {
                $table->dropColumn('shipping_address');
            }
        });
    }
};
