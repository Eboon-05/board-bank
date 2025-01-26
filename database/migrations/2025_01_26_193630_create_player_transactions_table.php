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
        Schema::create('player_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('game_id')->constrained();
            $table->foreignId('from_player_id')->constrained('players');
            $table->foreignId('to_player_id')->constrained('players');
            $table->float('amount')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_transactions');
    }
};
