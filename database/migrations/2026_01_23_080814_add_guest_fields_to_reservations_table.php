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
        Schema::table('reservations', function (Blueprint $table) {
            // Make user_id nullable for guest reservations
            $table->foreignId('user_id')->nullable()->change();
            
            // Add guest user fields
            $table->string('guest_name')->nullable()->after('user_id');
            $table->string('guest_contact')->nullable()->after('guest_name');
            
            // Remove time-based fields, make description required
            $table->dropColumn(['start_time', 'end_time', 'hours_used']);
            $table->text('description')->after('facility_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Restore original structure
            $table->foreignId('user_id')->nullable(false)->change();
            $table->dropColumn(['guest_name', 'guest_contact', 'description']);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('hours_used')->default(1);
        });
    }
};
