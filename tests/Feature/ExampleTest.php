<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_game(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('games.store'), [
                'code' => '123456'
            ])
            ->assertFound();

        $this->assertDatabaseHas('games', [
            'code' => '123456'
        ]);

        $this->assertDatabaseHas('players', [
            'user_id' => $user->id,
            'balance' => 0
        ]);
    }
}
