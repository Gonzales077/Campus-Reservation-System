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
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn('hourly_rate');
            $table->integer('available_hours')->default(0);
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('total_cost');
            $table->integer('hours_used')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn('available_hours');
            $table->decimal('hourly_rate', 8, 2)->default(0);
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('hours_used');
            $table->decimal('total_cost', 8, 2)->nullable();
        });
    }
};
