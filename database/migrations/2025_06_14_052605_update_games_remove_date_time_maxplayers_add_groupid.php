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
            if (Schema::hasColumn('games', 'game_date')) {
                $table->dropColumn('game_date');
            }
            if (Schema::hasColumn('games', 'game_time')) {
                $table->dropColumn('game_time');
            }
            if (Schema::hasColumn('games', 'game_end_time')) {
                $table->dropColumn('game_end_time');
            }
            if (Schema::hasColumn('games', 'max_players')) {
                $table->dropColumn('max_players');
            }
            if (!Schema::hasColumn('games', 'group_id')) {
                $table->foreignId('group_id')->nullable()->constrained()->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            if (!Schema::hasColumn('games', 'game_date')) {
                $table->date('game_date')->nullable();
            }
            if (!Schema::hasColumn('games', 'game_time')) {
                $table->time('game_time')->nullable();
            }
            if (!Schema::hasColumn('games', 'game_end_time')) {
                $table->time('game_end_time')->nullable();
            }
            if (!Schema::hasColumn('games', 'max_players')) {
                $table->unsignedInteger('max_players')->default(4);
            }
            if (Schema::hasColumn('games', 'group_id')) {
                $table->dropForeign(['group_id']);
                $table->dropColumn('group_id');
            }
        });
    }
};
