<?php

use App\Models\User;
use App\Models\Community;
use App\Models\CulturalItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
});

test('admin can view communities index', function () {
    Community::factory()->count(5)->create();

    $response = $this->actingAs($this->admin)
        ->get(route('admin.communities.index'));

    $response->assertStatus(200);
});

test('admin can create community', function () {
    $data = [
        'name' => 'Test Community',
        'description' => 'Test description',
        'address' => '123 Test St',
        'latitude' => 13.7563,
        'longitude' => 100.5018,
        'is_active' => true,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), $data);

    $response->assertRedirect(route('admin.communities.index'));
    $this->assertDatabaseHas('communities', [
        'name' => 'Test Community',
    ]);
});

test('it validates required fields for community', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), []);

    $response->assertSessionHasErrors(['name']);
});

test('it validates coordinates range for community', function () {
    $data = [
        'name' => 'Test Community',
        'description' => 'Test',
        'latitude' => 999,
        'longitude' => 999,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), $data);

    $response->assertSessionHasErrors(['latitude', 'longitude']);
});

test('admin can update community', function () {
    $community = Community::factory()->create();

    $response = $this->actingAs($this->admin)
        ->put(route('admin.communities.update', $community), [
            'name' => 'Updated Community',
            'description' => 'Updated description',
        ]);

    $response->assertStatus(302);
    $this->assertDatabaseHas('communities', [
        'id' => $community->id,
        'name' => 'Updated Community',
    ]);
});

test('admin can delete community without items', function () {
    $community = Community::factory()->create();

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.communities.destroy', $community));

    $response->assertRedirect(route('admin.communities.index'));
    $this->assertDatabaseMissing('communities', ['id' => $community->id]);
});

test('community has cultural items relationship', function () {
    $community = Community::factory()->create();
    CulturalItem::factory()->count(3)->create(['community_id' => $community->id]);

    expect($community->culturalItems)->toHaveCount(3);
});

test('it filters active communities', function () {
    Community::factory()->create(['is_active' => true]);
    Community::factory()->create(['is_active' => false]);

    $active = Community::active()->get();

    expect($active)->toHaveCount(1);
});

test('it filters communities with location', function () {
    Community::factory()->create(['latitude' => 13.7563, 'longitude' => 100.5018]);
    Community::factory()->create(['latitude' => null, 'longitude' => null]);

    $withLocation = Community::withLocation()->get();

    expect($withLocation)->toHaveCount(1);
});

test('community has location check method', function () {
    $withLocation = Community::factory()->create([
        'latitude' => 13.7563,
        'longitude' => 100.5018
    ]);
    $withoutLocation = Community::factory()->create([
        'latitude' => null,
        'longitude' => null
    ]);

    expect($withLocation->hasLocation())->toBeTrue();
    expect($withoutLocation->hasLocation())->toBeFalse();
});

test('regular user cannot access admin communities', function () {
    $response = $this->actingAs($this->user)
        ->get(route('admin.communities.index'));

    $response->assertStatus(403);
});
