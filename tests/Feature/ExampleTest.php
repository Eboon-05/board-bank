<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\BankMovementType;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_game(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('games.store'), [
                'code' => '123456',
                'initial_balance' => 1000
            ])
            ->assertFound();

        $this->assertDatabaseHas('games', [
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

        $this->assertDatabaseHas('players', [
            'user_id' => $user->id,
            'balance' => 1000
        ]);

        $this->assertDatabaseHas('players', [
            'user_id' => $user2->id,
            'balance' => 1000
        ]);
    }

    public function test_player_can_withdraw_from_bank(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('games.store'), [
                'code' => '123456',
                'initial_balance' => 1000
            ])
            ->assertFound();

        $this->actingAs($user)
            ->post(route('games.bank', ['game' => 1]), [
                'amount' => '500',
                'type' => BankMovementType::Withdraw->value,
            ])
            ->assertFound();

        $this->assertDatabaseHas('players', [
            'game_id' => 1,
            'user_id' => $user->id,
            'balance' => 1500
        ]);
    }

    public function test_player_can_pay_to_bank(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('games.store'), [
                'code' => '123456',
                'initial_balance' => 1000
            ])
            ->assertFound();

        $this->actingAs($user)
            ->post(route('games.bank', ['game' => 1]), [
                'amount' => '500',
                'type' => BankMovementType::Payment->value,
            ])
            ->assertFound();

        $this->assertDatabaseHas('players', [
            'game_id' => 1,
            'user_id' => $user->id,
            'balance' => 500
        ]);
    }
}
