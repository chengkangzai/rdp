<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('registers a user and returns a token', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret123',
    ];

    postJson(route('auth.register'), $userData)
        ->assertSuccessful()
        ->assertJsonStructure([
            'access_token',
            'token_type',
        ]);

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('denies login for invalid user credentials', function () {
    $credentials = [
        'email' => 'nonexistent@example.com',
        'password' => 'wrongpassword',
    ];

    postJson(route('auth.login'), $credentials)
        ->assertStatus(401)
        ->assertJson(['message' => 'Invalid login details']);
});

it('allows login for valid user credentials and returns a token', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $credentials = [
        'email' => 'jane@example.com',
        'password' => 'secret123',
    ];

    postJson(route('auth.login'), $credentials)
        ->assertSuccessful()
        ->assertJsonStructure([
            'access_token',
            'token_type',
        ]);
});

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

it('issues a token for an authenticated user', function () {
    $user = User::factory()->create();
    actingAs($user);

    $requestData = ['device_name' => 'test-device'];

    postJson(route('auth.issue-token'), $requestData)
        ->assertSuccessful()
        ->assertJsonStructure([
            'access_token',
            'token_type',
        ]);

    assertDatabaseHas('personal_access_tokens', [
        'name' => 'test-device',
    ]);
});

it('fails to issue a token without device name', function () {
    $user = User::factory()->create();
    actingAs($user);

    postJson(route('auth.issue-token'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['device_name']);
});
