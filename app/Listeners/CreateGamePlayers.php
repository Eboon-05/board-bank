<?php

namespace App\Listeners;

use App\Events\GameCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

use App\Models\Player;

class CreateGamePlayers
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GameCreated $event): void
    {
        Player::create([
            'game_id' => $event->game->id,
            'user_id' => Auth::id(),
            'balance' => $event->game->initial_balance,
        ]);
    }
}
