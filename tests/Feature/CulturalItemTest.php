<?php

use App\Models\User;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
    $this->category = CulturalCategory::factory()->create();
    $this->community = Community::factory()->create();
});

test('it can list cultural items', function () {
    CulturalItem::factory()->count(3)->create([
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get('/explore');

    $response->assertStatus(200);
});

test('admin can view cultural items index', function () {
    CulturalItem::factory()->count(5)->create();

    $response = $this->actingAs($this->admin)
        ->get(route('admin.cultural-items.index'));

    $response->assertStatus(200);
});

test('admin can create cultural item', function () {
    $data = [
        'title' => 'Test Cultural Item',
        'category_id' => $this->category->id,
        'community_id' => $this->community->id,
        'description' => 'Test description',
        'publish_date' => now()->format('Y-m-d'),
        'is_published' => true,
        'latitude' => 13.7563,
        'longitude' => 100.5018,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.cultural-items.store'), $data);

    $response->assertRedirect(route('admin.cultural-items.index'));
    $this->assertDatabaseHas('cultural_items', [
        'title' => 'Test Cultural Item',
        'category_id' => $this->category->id,
    ]);
});

test('it validates required fields for cultural item', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.cultural-items.store'), []);

    $response->assertSessionHasErrors(['title', 'category_id', 'community_id', 'description', 'publish_date']);
});

test('it validates coordinates range', function () {
    $data = [
        'title' => 'Test Item',
        'category_id' => $this->category->id,
        'community_id' => $this->community->id,
        'description' => 'Test',
        'publish_date' => now()->format('Y-m-d'),
        'latitude' => 999, // Invalid
        'longitude' => 999, // Invalid
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.cultural-items.store'), $data);

    $response->assertSessionHasErrors(['latitude', 'longitude']);
});

test('it can show cultural item detail', function () {
    $item = CulturalItem::factory()->create([
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get(route('cultural-item.show', $item->id));

    $response->assertStatus(200);
});

test('admin can update cultural item', function () {
    $item = CulturalItem::factory()->create([
        'created_by' => $this->admin->id
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.cultural-items.update', $item), [
            'title' => 'Updated Title',
            'category_id' => $this->category->id,
            'community_id' => $this->community->id,
            'description' => 'Updated description',
            'publish_date' => now()->format('Y-m-d'),
        ]);

    $response->assertRedirect(route('admin.cultural-items.index'));
    $this->assertDatabaseHas('cultural_items', [
        'id' => $item->id,
        'title' => 'Updated Title',
    ]);
});

test('admin can delete cultural item', function () {
    $item = CulturalItem::factory()->create();

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.cultural-items.destroy', $item));

    $response->assertRedirect(route('admin.cultural-items.index'));
    $this->assertDatabaseMissing('cultural_items', ['id' => $item->id]);
});

test('regular user cannot access admin cultural items', function () {
    $response = $this->actingAs($this->user)
        ->get(route('admin.cultural-items.index'));

    $response->assertStatus(403);
});

test('it filters featured items', function () {
    CulturalItem::factory()->create(['is_featured' => true]);
    CulturalItem::factory()->create(['is_featured' => false]);

    $featuredItems = CulturalItem::where('is_featured', true)->get();

    expect($featuredItems)->toHaveCount(1);
});

test('it filters published items', function () {
    CulturalItem::factory()->create([
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);
    CulturalItem::factory()->create([
        'is_published' => false,
        'publish_date' => now()->subDay()
    ]);

    $published = CulturalItem::published()->get();

    expect($published)->toHaveCount(1);
});

test('it has correct relationships', function () {
    $item = CulturalItem::factory()->create([
        'category_id' => $this->category->id,
        'community_id' => $this->community->id,
        'created_by' => $this->admin->id
    ]);

    expect($item->category)->toBeInstanceOf(CulturalCategory::class);
    expect($item->community)->toBeInstanceOf(Community::class);
    expect($item->creator)->toBeInstanceOf(User::class);
});

test('admin can upload image for cultural item', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test.jpg');

    $data = [
        'title' => 'Test Item',
        'category_id' => $this->category->id,
        'community_id' => $this->community->id,
        'description' => 'Test',
        'publish_date' => now()->format('Y-m-d'),
        'image' => $file,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.cultural-items.store'), $data);

    $response->assertStatus(302);
});
