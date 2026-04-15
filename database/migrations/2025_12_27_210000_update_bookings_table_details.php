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
        Schema::table('bookings', function (Blueprint $table) {
            // Make user_id nullable for guest bookings
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Add contact details
            $table->string('name')->after('user_id');
            $table->string('email')->after('name');
            $table->string('phone')->after('email');
            
            // Add details
            $table->text('notes')->nullable()->after('status');
            $table->decimal('estimated_price', 10, 2)->nullable()->after('notes');
            
            // Rename or use service_details. Since service_type exists, let's just add service_details and we can drop service_type or use it. 
            // Model uses service_details. Let's try to rename if supported, or just add.
            // SQLite/some drivers has trouble with rename. Let's just add service_details.
            $table->string('service_details')->after('booking_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->dropColumn(['name', 'email', 'phone', 'notes', 'estimated_price', 'service_details']);
        });
    }
};
