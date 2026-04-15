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
        Schema::table('products', function (Blueprint $table) {
            // Check if column exists before adding/modifying to be safe, though not strictly required if we know state.
            // But this is a simple add/change.
            if (!Schema::hasColumn('products', 'slug')) {
                 $table->string('slug')->after('name')->nullable();
            }
            // Modify category_id
            $table->foreignId('category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
            // Reverting logic depends on data state, typically we don't strict it back easily if nulls exist.
            // Leaving as nullable in down is sometimes safer, or we revert if we are sure.
            // $table->foreignId('category_id')->nullable(false)->change(); 
        });
    }
};
