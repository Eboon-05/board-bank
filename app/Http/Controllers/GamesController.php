<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Game;
use App\Models\Player;
use App\Models\BankTransaction;
use App\Models\PlayerTransaction;

use App\BankMovementType;

class GamesController extends Controller
{
    public function show(Request $request, Game $game) {
        if ($request->user()->cannot('view', $game)) {
            return abort(403, 'You are not in this game.');
        }

        $links = [
            [
                'name' => 'Withdraw',
                'url' => route(
                    'games.movement',
                    [
                        'type' => BankMovementType::Withdraw,
                        'game' => $game->id
                    ]
                ),
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>',
            ],
            [
                'name' => 'Send',
                'url' => route(
                    'games.movement',
                    [
                        'game' => $game->id
                    ]
                ),
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>'
            ],
            [
                'name' => 'Pay',
                'url' => route(
                    'games.movement',
                    [
                        'type' => BankMovementType::Payment,
                        'game' => $game->id
                    ]
                ),
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>'
            ]
        ];

        $player_movements = $game->userPlayer->getMovements();

        return view('games.show', compact('game', 'links', 'player_movements'));
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

        PlayerTransaction::create([
            'game_id' => $game->id,
            'from_player_id' => $game->userPlayer->id,
            'to_player_id' => $to->id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('games.show', $game);
    }

    public function movement(Request $request) {
        return view('games.movement', ['type' => $request->type]);
    }

    public function index(Request $request) {
        $user_players = $request->user()->players;

        $game_list = $user_players->map(fn($player) => $player->game);

        return view('games.index', compact('game_list'));
    }
}
