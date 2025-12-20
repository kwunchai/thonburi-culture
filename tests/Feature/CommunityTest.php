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

// New tests for Buddhist Era year and text population
test('admin can create community with buddhist era year', function () {
    $data = [
        'name' => 'Test Community with Buddhist Year',
        'description' => 'Test description',
        'established_year' => '2510', // Buddhist Era (1967 CE)
        'latitude' => 13.7563,
        'longitude' => 100.5018,
        'is_active' => true,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), $data);

    $response->assertRedirect(route('admin.communities.index'));
    $this->assertDatabaseHas('communities', [
        'name' => 'Test Community with Buddhist Year',
        'established_year' => '2510',
    ]);
});

test('admin can create community with text population', function () {
    $data = [
        'name' => 'Test Community with Text Population',
        'description' => 'Test description',
        'population' => '1,500-1,800', // Text range
        'is_active' => true,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), $data);

    $response->assertRedirect(route('admin.communities.index'));
    $this->assertDatabaseHas('communities', [
        'name' => 'Test Community with Text Population',
        'population' => '1,500-1,800',
    ]);
});

test('it validates buddhist era year range', function () {
    $data = [
        'name' => 'Test Community',
        'description' => 'Test',
        'established_year' => '1800', // Too old for Buddhist Era
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), $data);

    $response->assertSessionHasErrors(['established_year']);
});

test('population accepts thai text', function () {
    $data = [
        'name' => 'Test Community Thai Pop',
        'description' => 'Test',
        'population' => 'ประมาณ 2,000 คน',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), $data);

    $response->assertRedirect(route('admin.communities.index'));
    $this->assertDatabaseHas('communities', [
        'population' => 'ประมาณ 2,000 คน',
    ]);
});

test('year must be 4 digits', function () {
    $data = [
        'name' => 'Test Community',
        'description' => 'Test',
        'established_year' => '25', // Only 2 digits
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.communities.store'), $data);

    $response->assertSessionHasErrors(['established_year']);
});

// =======================
// Population Display Tests
// =======================

test('community show page displays numeric population correctly', function () {
    $community = Community::factory()->create([
        'name' => 'Test Community',
        'population' => '1500', // Numeric string
        'latitude' => null, // No coordinates to avoid nearby communities query
        'longitude' => null,
        'is_active' => true
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.communities.show', $community));

    $response->assertStatus(200);
    $response->assertSee('1,500 คน'); // Should format with thousand separator
});

test('community show page displays text population correctly', function () {
    $community = Community::factory()->create([
        'name' => 'Test Community',
        'population' => '1,500–1,800', // Text range with en-dash
        'latitude' => null, // No coordinates to avoid nearby communities query
        'longitude' => null,
        'is_active' => true
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.communities.show', $community));

    $response->assertStatus(200);
    $response->assertSee('1,500–1,800 คน', false); // Should display text as-is with คน appended
});

test('community show page displays null population as dash', function () {
    $community = Community::factory()->create([
        'name' => 'Test Community',
        'population' => null,
        'latitude' => null, // No coordinates to avoid nearby communities query
        'longitude' => null,
        'is_active' => true
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.communities.show', $community));

    $response->assertStatus(200);
    $response->assertSee('จำนวนประชากร', false);
    // The dash should appear in the table
    $this->assertStringContainsString('-', $response->content());
});

test('community show page handles thai text population', function () {
    $community = Community::factory()->create([
        'name' => 'Test Community',
        'population' => 'ประมาณ 2,000 คน', // Thai text already containing "คน"
        'latitude' => null, // No coordinates to avoid nearby communities query
        'longitude' => null,
        'is_active' => true
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.communities.show', $community));

    $response->assertStatus(200);
    $response->assertSee('ประมาณ 2,000 คน', false); // Should display exactly as stored
    // Should NOT show double คน
    $this->assertStringNotContainsString('ประมาณ 2,000 คน คน', $response->content());
});

test('population display accessor formats numeric values', function () {
    $community = Community::factory()->create(['population' => '2500']);
    expect($community->population_display)->toBe('2,500 คน');

    $community2 = Community::factory()->create(['population' => 1000]);
    expect($community2->population_display)->toBe('1,000 คน');
});

test('population display accessor handles text values', function () {
    $community = Community::factory()->create(['population' => '1,500-2,000']);
    expect($community->population_display)->toBe('1,500-2,000 คน');

    $community2 = Community::factory()->create(['population' => 'ไม่ทราบ']);
    expect($community2->population_display)->toBe('ไม่ทราบ คน');
});

test('population display accessor does not duplicate kun suffix', function () {
    $community = Community::factory()->create(['population' => 'ประมาณ 3,000 คน']);
    expect($community->population_display)->toBe('ประมาณ 3,000 คน');
    expect($community->population_display)->not->toContain('คน คน');
});

test('population display accessor returns dash for null', function () {
    $community = Community::factory()->create(['population' => null]);
    expect($community->population_display)->toBe('-');

    $community2 = Community::factory()->create(['population' => '']);
    expect($community2->population_display)->toBe('-');
});
