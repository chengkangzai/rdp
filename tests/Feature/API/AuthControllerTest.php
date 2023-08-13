<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('registers a user and returns a token', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret123',
    ];

    post(route('auth.register'), $userData)
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

    post(route('auth.login'), $credentials)
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

    post(route('auth.login'), $credentials)
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

    post(route('auth.me'), [], ['Authorization' => 'Bearer '.$token])
        ->assertSuccessful()
        ->assertJson([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
});
