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
            'code' => 'required',
            'initial_balance' => 'required',
        ]);

        $game = Game::create([
            'code' => $request->code,
            'initial_balance' => $request->initial_balance,
        ]);

        Player::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'balance' => $request->initial_balance,
        ]);

        return redirect()->route('games.show', $game);
    }

    public function join(Request $request) {
        $request->validate([
            'code' => 'required'
        ]);

        $game = Game::where('code', $request->code)->first();

        Player::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'balance' => $game->initial_balance,
        ]);

        return redirect()->route('games.show', $game);
    }
}
