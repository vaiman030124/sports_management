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
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('sport_name');
            $table->foreignId('venue_id')->constrained('venues')->onDelete('cascade');
            $table->unsignedInteger('court_count')->default(1);
            $table->json('shared_with')->nullable();
            $table->decimal('pricing_peak', 10, 2);
            $table->decimal('pricing_non_peak', 10, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
