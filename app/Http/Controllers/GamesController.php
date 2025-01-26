<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Game;
use App\Models\Player;

class GamesController extends Controller
{
    public function show(Game $game) {
        return view('games.show', compact('game'));
    }

    public function store(Request $request) {
        $request->validate([
            'code' => 'required'
        ]);

        $game = Game::create([
            'code' => $request->code
        ]);

        Player::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'balance' => 0
        ]);

        return redirect()->route('games.show', $game);
    }
}
