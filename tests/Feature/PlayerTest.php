<?php

namespace Tests\Feature;

use App\BankMovementType;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Game;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_can_send_money()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user)
            ->post(route('games.store'), [
                'code' => '123456',
                'initial_balance' => 1000
            ])
            ->assertFound();

        $this->actingAs($user2)
            ->post(route('games.join'), [
                'code' => '123456'
            ])
            ->assertFound();

        $player2 = Player::where([
            'user_id' => $user2->id
        ])->first();

        $this->actingAs($user)
            ->post(route('games.send', ['game' => 1]), [
                'amount' => '500',
                'to' => $player2->id,
            ])
            ->assertFound();

        $this->assertDatabaseHas('players', [
            'game_id' => 1,
            'user_id' => $user->id,
            'balance' => 500
        ]);

        $this->assertDatabaseHas('players', [
            'game_id' => 1,
            'user_id' => $user2->id,
            'balance' => 1500
        ]);

        $this->assertDatabaseHas('player_transactions', [
            'game_id' => 1,
            'from_player_id' => $user->players->first()->id,
            'to_player_id' => $user2->players->first()->id,
            'amount' => 500
        ]);
    }

    public function test_get_player_bank_transactions() {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('games.store'), [
                'code' => '123456',
                'initial_balance' => 1000
            ])
            ->assertFound();

        $this->actingAs($user)
            ->post(route('games.bank', ['game' => 1]), [
                'amount' => '1000',
                'type' => BankMovementType::Withdraw->value,
            ])
            ->assertFound();

        $player = $user->players->first();
        $this->assertNotEmpty($player->bankTransactions);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $player->bankTransactions);
        $this->assertInstanceOf('App\Models\BankTransaction', $player->bankTransactions->first());
    }

    public function test_get_player_player_transactions() {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user)
            ->post(route('games.store'), [
                'code' => '123456',
                'initial_balance' => 1000
            ])
            ->assertFound();

        
        $this->actingAs($user2)
            ->post(route('games.join'), [
                'code' => '123456'
            ])
            ->assertFound();

        $this->actingAs($user)
            ->post(route('games.send', ['game' => 1]), [
                'amount' => '500',
                'to' => $user2->players->first()->id,
            ])
            ->assertFound();

        $player1 = $user->players->first();
        $this->assertInstanceOf('Illuminate\Support\Collection', $player1->getPlayerTransactions());
    }

    public function test_get_player_movements() {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user);

        Game::factory()->create([
            'code' => '123456',
            'initial_balance' => 1000
        ]);
        
        $this->actingAs($user2)
            ->post(route('games.join'), [
                'code' => '123456'
            ])
            ->assertFound();

        $this->actingAs($user)
            ->post(route('games.send', ['game' => 1]), [
                'amount' => '500',
                'to' => $user2->players->first()->id,
            ])
            ->assertFound();

        $this->actingAs($user)
            ->post(route('games.bank', ['game' => 1]), [
                'amount' => '1000',
                'type' => BankMovementType::Withdraw->value,
            ])
            ->assertFound();

        $this->actingAs($user2)
            ->post(route('games.send', ['game' => 1]), [
                'amount' => '500',
                'to' => $user->players->first()->id,
            ])
            ->assertFound();

        $player1 = $user->players->first();
        $movements = $player1->getMovements();
        $this->assertNotEmpty($movements);
        $this->assertInstanceOf('Illuminate\Support\Collection', $movements);
    }
}
