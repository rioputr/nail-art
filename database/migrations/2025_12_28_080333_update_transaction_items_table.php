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
        Schema::table('transaction_items', function (Blueprint $table) {
            if (!Schema::hasColumn('transaction_items', 'transaction_id')) {
                $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('transaction_items', 'product_id')) {
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('transaction_items', 'quantity')) {
                $table->integer('quantity');
            }
            if (!Schema::hasColumn('transaction_items', 'price')) {
                $table->integer('price');
            }
            if (!Schema::hasColumn('transaction_items', 'subtotal')) {
                $table->integer('subtotal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['transaction_id', 'product_id', 'quantity', 'price', 'subtotal']);
        });
    }
};
