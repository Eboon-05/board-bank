<?php

namespace App\Http\Controllers;

use App\BankMovementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Game;
use App\Models\Player;
use App\Models\BankTransaction;

class GamesController extends Controller
{
    public function show(Game $game) {
        return view('games.show', compact('game'));
    }

    public function create() {
        return view('games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:App\Models\Game,code',
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

    public function join(Request $request)
    {
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

    public function bank_movement(Request $request, Game $game)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|int'
        ]);

        BankTransaction::create([
            'game_id' => $game->id,
            'player_id' => $game->userPlayer->id,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);

        if ($request->type === BankMovementType::Withdraw->value) {
            $game->userPlayer->balance += $request->amount;
        } else {
            $game->userPlayer->balance -= $request->amount;
        }

        $game->userPlayer->save();

        return redirect()->route('games.show', $game);
    }

    public function send_money(Request $request, Game $game)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'to' => 'required|int',
        ]);

        $to = Player::find($request->to);
        $to->balance += $request->amount;
        $to->save();

        $game->userPlayer->balance -= $request->amount;
        $game->userPlayer->save();

        return redirect()->route('games.show', $game);
    }
}
