<?php

use App\Models\PC;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\get;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

it('can fetch all PCs', function () {
    $user = User::factory()->create();
    $PCs = PC::factory()->count(3)->create([
        'user_id' => $user->id,
    ]);
    actingAs($user);
    get(route('pcs.index'))
        ->assertOk()
        ->assertJson($PCs->toArray());
});

it('can store a PC', function () {
    $user = User::factory()->create();
    $data = PC::factory()->make();

    postJson(route('pcs.store', $data))->assertUnauthorized();  // Ensure guests cannot add a PC.

    actingAs($user);

    postJson(route('pcs.store', $data->toArray()))
        ->assertCreated()
        ->assertJsonStructure([
            'id',
            'name',
            'user_id',
            'created_at',
            'updated_at',
        ]);

    assertDatabaseHas('pcs', [
        'name' => $data->name,
        'url' => $data->url,
        'user_id' => $user->id,
    ]);
});

it('can display a PC', function () {
    $user = User::factory()->create();
    $PC = PC::factory()->create([
        'user_id' => $user->id,
    ]);
    actingAs($user);

    get(route('pcs.show', $PC))
        ->assertOk()
        ->assertJsonStructure([
            'id',
            'name',
            'user_id',
            'created_at',
            'updated_at',
        ]);
});

it('can update a PC', function () {
    $user = User::factory()->create();
    $PC = PC::factory()->create([
        'user_id' => $user->id,
    ]);
    $data = PC::factory()->make([
        'user_id' => $user->id,
    ]);
    actingAs($user);

    putJson(route('pcs.update', $PC), $data->toArray())
        ->assertOk()
        ->assertJsonStructure([
            'id',
            'name',
            'user_id',
            'created_at',
            'updated_at',
        ]);

    assertDatabaseHas('pcs', [
        'name' => $data->name,
        'url' => $data->url,
        'user_id' => $user->id,
    ]);
});

it('can delete a PC', function () {
    $user = User::factory()->create();
    $pc = PC::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user);

    deleteJson(route('pcs.destroy', $pc))
        ->assertNoContent();

    assertSoftDeleted($pc);
});
