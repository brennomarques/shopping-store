<?php

namespace Tests\App\Http\Controllers\Api;

use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Get user in route me.
     * php artisan test --filter=UserControllerTest
     * @return void
     */
    public function testShow(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('me.show'));
        $response->assertStatus(200);

        $response->assertJson(
            [
                'data' => [
                    'id' => $user->uuid,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]
        );
    }
}
