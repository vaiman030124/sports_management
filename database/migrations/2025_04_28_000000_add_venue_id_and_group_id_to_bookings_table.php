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
            $table->foreignId('trainer_id')->nullable()->constrained('trainers')->nullOnDelete()->after('court_id');
            $table->foreignId('venue_id')->nullable()->constrained('venues')->nullOnDelete()->after('trainer_id');
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete()->after('venue_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['trainer_id']);
            $table->dropColumn('trainer_id');
            $table->dropForeign(['venue_id']);
            $table->dropColumn('venue_id');
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
};
