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
        Schema::table('games', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable()->constrained('transactions')->nullOnDelete();
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->foreignId('refund_id')->nullable()->constrained('refunds')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropForeign(['refund_id']);
            $table->dropColumn('payment_id');
            $table->dropColumn('refund_id');
        });
    }
};
