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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->constrained('sports')->onDelete('cascade');
            $table->foreignId('court_id')->constrained('courts')->onDelete('cascade');
            $table->date('slot_date');
            $table->time('slot_time');
            $table->time('slot_end_time');
            $table->boolean('is_member_slot')->default(false);
            $table->unsignedInteger('max_players')->default(4);
            $table->unsignedInteger('available_slots');
            $table->boolean('is_peak_hour')->default(false);
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
