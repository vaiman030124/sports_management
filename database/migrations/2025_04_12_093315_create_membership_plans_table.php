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
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['monthly', 'session']);
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('sessions')->nullable();
            $table->json('sports_allowed')->nullable();
            $table->unsignedInteger('duration_days')->nullable();
            $table->foreignId('trainer_id')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
