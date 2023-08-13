<?php

use App\Models\Pc;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a new PC if not already present for the user', function () {
    $user = User::factory()->create();

    $requestData = [
        'name' => 'My Custom PC',
        'url' => 'https://example.com',
    ];

    $this->actingAs($user)
        ->post(route('ping'), $requestData)
        ->assertSuccessful();

    $this->assertDatabaseHas('pcs', [
        'name' => 'My Custom PC',
        'user_id' => $user->id,
    ]);
});

it('updates the PC if one with the same name is already present for the user', function () {
    $user = User::factory()->create();
    $existingPc = Pc::factory()->create([
        'name' => 'My Custom PC',
        'user_id' => $user->id,
        'url' => 'https://example.com',
    ]);

    $requestData = [
        'name' => 'My Custom PC',
        'url' => 'https://example.com',
    ];

    $this->actingAs($user)
        ->post(route('ping'), $requestData)
        ->assertSuccessful();

    expect(Pc::where('user_id', $user->id)->count())->toBe(1);
});
