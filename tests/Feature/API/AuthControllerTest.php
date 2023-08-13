<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('fetches the authenticated user details', function () {
    $user = User::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    postJson(route('auth.me'), [], ['Authorization' => 'Bearer '.$token])
        ->assertSuccessful()
        ->assertJson([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
});
