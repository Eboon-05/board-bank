<?php

namespace Tests\Feature;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_game(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Game::factory()->create([
            'code' => '123456',
            'initial_balance' => 1000
        ]);

        $this->assertDatabaseHas('players', [
            'user_id' => $user->id,
            'balance' => 1000
        ]);
    }

    public function test_user_can_join_game(): void
    {
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

        $this->assertDatabaseHas('players', [
            'user_id' => $user->id,
            'balance' => 1000
        ]);

        $this->assertDatabaseHas('players', [
            'user_id' => $user2->id,
            'balance' => 1000
        ]);
    }

    public function test_only_players_in_the_game_can_access() {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user);

        $game = Game::factory()->create([
            'code' => '123456',
            'initial_balance' => 1000
        ]);

        $this->actingAs($user2)
            ->get(route('games.show', ['game' => $game->id]))
            ->assertForbidden();
    }
}
