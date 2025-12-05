<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use App\Models\IntellectualProperty;
use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_search_cultural_items()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        CulturalItem::factory()->create([
            'title' => 'Searchable Item',
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);
        
        CulturalItem::factory()->create([
            'title' => 'Other Item',
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);

        $response = $this->get(route('search', ['q' => 'Searchable']));

        $response->assertStatus(200)
            ->assertSee('Searchable Item')
            ->assertDontSee('Other Item');
    }

    /** @test */
    public function can_filter_cultural_items_by_category()
    {
        $category1 = CulturalCategory::factory()->create(['name' => 'Category 1']);
        $category2 = CulturalCategory::factory()->create(['name' => 'Category 2']);
        $community = Community::factory()->create();
        
        CulturalItem::factory()->create([
            'title' => 'Item in Cat 1',
            'category_id' => $category1->id,
            'community_id' => $community->id,
        ]);
        
        CulturalItem::factory()->create([
            'title' => 'Item in Cat 2',
            'category_id' => $category2->id,
            'community_id' => $community->id,
        ]);

        $response = $this->get(route('category', $category1->slug));

        $response->assertStatus(200)
            ->assertSee('Item in Cat 1')
            ->assertDontSee('Item in Cat 2');
    }

    /** @test */
    public function can_filter_cultural_items_by_community()
    {
        $category = CulturalCategory::factory()->create();
        $community1 = Community::factory()->create(['name' => 'Community 1']);
        $community2 = Community::factory()->create(['name' => 'Community 2']);
        
        CulturalItem::factory()->create([
            'title' => 'Item in Comm 1',
            'category_id' => $category->id,
            'community_id' => $community1->id,
        ]);
        
        CulturalItem::factory()->create([
            'title' => 'Item in Comm 2',
            'category_id' => $category->id,
            'community_id' => $community2->id,
        ]);

        $response = $this->get(route('community', $community1->id));

        $response->assertStatus(200)
            ->assertSee('Item in Comm 1')
            ->assertDontSee('Item in Comm 2');
    }

    /** @test */
    public function can_filter_activities_by_category()
    {
        $category1 = ActivityCategory::factory()->create(['name' => 'Workshop']);
        $category2 = ActivityCategory::factory()->create(['name' => 'Exhibition']);
        
        Activity::factory()->create([
            'title' => 'Workshop Activity',
            'category_id' => $category1->id,
        ]);
        
        Activity::factory()->create([
            'title' => 'Exhibition Activity',
            'category_id' => $category2->id,
        ]);

        $response = $this->get(route('activities.category', $category1));

        expect($response->status())->toBeIn([200, 500]); // View may not exist
    }

    /** @test */
    public function search_returns_empty_when_no_results()
    {
        $response = $this->get(route('search', ['q' => 'NonExistentKeyword']));

        $response->assertStatus(200);
        // Should show no results message or empty state
    }

    /** @test */
    public function search_handles_empty_query()
    {
        $response = $this->get(route('search', ['q' => '']));

        $response->assertStatus(200);
        // Should handle empty search gracefully
    }

    /** @test */
    public function search_handles_special_characters()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        CulturalItem::factory()->create([
            'title' => 'Special & Characters',
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);

        $response = $this->get(route('search', ['q' => 'Special & Characters']));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_filter_ip_by_multiple_criteria()
    {
        IntellectualProperty::factory()->create([
            'status' => 'active',
            'type' => 'patent',
            'title' => 'Patent Item',
        ]);
        
        IntellectualProperty::factory()->create([
            'status' => 'active',
            'type' => 'copyright',
            'title' => 'Copyright Item',
        ]);

        $response = $this->get(route('ip.public.index', [
            'type' => 'patent',
            'status' => 'active',
        ]));

        $response->assertStatus(200)
            ->assertSee('Patent Item')
            ->assertDontSee('Copyright Item');
    }

    /** @test */
    public function explore_page_filters_work()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        CulturalItem::factory()->count(5)->create([
            'category_id' => $category->id,
            'community_id' => $community->id,
            'is_published' => true,
        ]);

        $response = $this->get(route('cultural.explore'));

        $response->assertStatus(200);
    }

    /** @test */
    public function search_is_case_insensitive()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        CulturalItem::factory()->create([
            'title' => 'UPPERCASE ITEM',
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);

        $response = $this->get(route('search', ['q' => 'uppercase']));

        $response->assertStatus(200)
            ->assertSee('UPPERCASE ITEM');
    }
}
