<?php

use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('homepage loads successfully', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('homepage shows featured items', function () {
    CulturalItem::factory()->count(3)->create([
        'is_featured' => true,
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
});

test('explore page loads', function () {
    $response = $this->get('/explore');

    $response->assertStatus(200);
});

test('cultural item detail page loads', function () {
    $item = CulturalItem::factory()->create([
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get(route('cultural-item.show', $item->id));

    $response->assertStatus(200);
});

test('returns 404 for non-existent item', function () {
    $response = $this->get(route('cultural-item.show', 99999));

    $response->assertStatus(404);
});

test('explore page shows published items only', function () {
    CulturalItem::factory()->create([
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);
    CulturalItem::factory()->create([
        'is_published' => false,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get('/explore');

    $response->assertStatus(200);
});

test('about page loads', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
});

test('contact page loads', function () {
    $response = $this->get('/contact');

    $response->assertStatus(200);
});

test('explore page can filter by category', function () {
    $category = CulturalCategory::factory()->create();
    CulturalItem::factory()->count(3)->create([
        'category_id' => $category->id,
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get('/explore?category=' . $category->id);

    $response->assertStatus(200);
});

test('explore page can filter by community', function () {
    $community = Community::factory()->create();
    CulturalItem::factory()->count(3)->create([
        'community_id' => $community->id,
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get('/explore?community=' . $community->id);

    $response->assertStatus(200);
});

test('explore page has pagination', function () {
    CulturalItem::factory()->count(20)->create([
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get('/explore');

    $response->assertStatus(200);
});

test('search works on explore page', function () {
    CulturalItem::factory()->create([
        'title' => 'Traditional Dance',
        'is_published' => true,
        'publish_date' => now()->subDay()
    ]);

    $response = $this->get('/explore?search=Traditional');

    $response->assertStatus(200);
});
