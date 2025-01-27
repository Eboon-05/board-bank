<?php

namespace Tests\Feature;

use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

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
    }
}
