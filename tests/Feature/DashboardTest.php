<?php

use App\Models\User;
use App\Models\CulturalItem;
use App\Models\Community;
use App\Models\IntellectualProperty;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
});

test('admin can access dashboard', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
});

test('regular user cannot access dashboard', function () {
    $response = $this->actingAs($this->user)
        ->get(route('admin.dashboard'));

    $response->assertStatus(403);
});

test('guest user is redirected to login', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});

test('dashboard shows correct statistics', function () {
    // Create test data
    CulturalItem::factory()->count(5)->create();
    Community::factory()->count(3)->create();
    IntellectualProperty::factory()->count(2)->create();

    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('generalStats');
    $response->assertViewHas('culturalStats');
    $response->assertViewHas('communityStats');
});

test('dashboard shows cultural items statistics', function () {
    CulturalItem::factory()->count(5)->create(['is_published' => true]);
    CulturalItem::factory()->count(3)->create(['is_published' => false]);
    CulturalItem::factory()->count(2)->create(['is_featured' => true]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
});

test('dashboard shows community statistics', function () {
    Community::factory()->count(3)->create([
        'latitude' => 13.7563,
        'longitude' => 100.5018
    ]);
    Community::factory()->count(2)->create([
        'latitude' => null,
        'longitude' => null
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
});

test('dashboard shows IP statistics', function () {
    IntellectualProperty::factory()->count(5)->create();

    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertViewHas('ipStats');
});
