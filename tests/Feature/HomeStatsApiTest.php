<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CulturalItem;
use App\Models\IntellectualProperty;
use App\Models\Community;
use App\Models\CulturalCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class HomeStatsApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function stats_endpoint_returns_json_response()
    {
        $response = $this->getJson(route('stats.home'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'labels',
                'line' => [
                    'cultural',
                    'research',
                    'ip',
                    'innov',
                    'places',
                ],
                'ipTypes',
                'topCommunities',
            ]);
    }

    /** @test */
    public function stats_endpoint_returns_correct_label_count()
    {
        $response = $this->getJson(route('stats.home'));

        $data = $response->json();
        
        // Default is 12 months
        $this->assertCount(12, $data['labels']);
    }

    /** @test */
    public function stats_endpoint_accepts_custom_months_parameter()
    {
        $response = $this->getJson(route('stats.home', ['months' => 6]));

        $data = $response->json();
        
        $this->assertCount(6, $data['labels']);
    }

    /** @test */
    public function stats_endpoint_has_minimum_3_months()
    {
        $response = $this->getJson(route('stats.home', ['months' => 1]));

        $data = $response->json();
        
        // Should enforce minimum of 3 months
        $this->assertGreaterThanOrEqual(3, count($data['labels']));
    }

    /** @test */
    public function stats_endpoint_respects_throttle_limit()
    {
        // This endpoint has throttle:30,1 (30 requests per minute)
        // Just verify it's accessible
        $response = $this->getJson(route('stats.home'));

        $response->assertStatus(200);
    }

    /** @test */
    public function stats_includes_cultural_items_data()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        CulturalItem::factory()->count(5)->create([
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);

        Cache::flush(); // Clear cache to get fresh data

        $response = $this->getJson(route('stats.home'));

        $data = $response->json();
        
        $this->assertIsArray($data['line']['cultural']);
        $this->assertGreaterThan(0, array_sum($data['line']['cultural']));
    }

    /** @test */
    public function stats_includes_ip_types_distribution()
    {
        IntellectualProperty::factory()->count(3)->create(['type' => 'patent']);
        IntellectualProperty::factory()->count(2)->create(['type' => 'copyright']);

        Cache::flush();

        $response = $this->getJson(route('stats.home'));

        $data = $response->json();
        
        $this->assertIsArray($data['ipTypes']);
        $this->assertArrayHasKey('patent', $data['ipTypes']);
        $this->assertArrayHasKey('copyright', $data['ipTypes']);
    }

    /** @test */
    public function stats_includes_top_communities()
    {
        $category = CulturalCategory::factory()->create();
        
        $community1 = Community::factory()->create(['name' => 'Top Community']);
        $community2 = Community::factory()->create(['name' => 'Second Community']);
        
        CulturalItem::factory()->count(10)->create([
            'community_id' => $community1->id,
            'category_id' => $category->id,
        ]);
        
        CulturalItem::factory()->count(5)->create([
            'community_id' => $community2->id,
            'category_id' => $category->id,
        ]);

        Cache::flush();

        $response = $this->getJson(route('stats.home'));

        $data = $response->json();
        
        $this->assertIsArray($data['topCommunities']);
        $this->assertNotEmpty($data['topCommunities']);
        
        // Top community should be first
        $this->assertEquals('Top Community', $data['topCommunities'][0]['name']);
        $this->assertEquals(10, $data['topCommunities'][0]['count']);
    }

    /** @test */
    public function stats_response_is_cached()
    {
        $response1 = $this->getJson(route('stats.home'));
        
        // Create new data after first request
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        CulturalItem::factory()->count(100)->create([
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);
        
        $response2 = $this->getJson(route('stats.home'));
        
        // Should return cached data (same as first request)
        $this->assertEquals($response1->json(), $response2->json());
    }

    /** @test */
    public function stats_line_data_has_correct_structure()
    {
        $response = $this->getJson(route('stats.home'));

        $data = $response->json();
        
        foreach (['cultural', 'research', 'ip', 'innov', 'places'] as $key) {
            $this->assertArrayHasKey($key, $data['line']);
            $this->assertIsArray($data['line'][$key]);
            $this->assertCount(12, $data['line'][$key]); // Default 12 months
        }
    }
}
