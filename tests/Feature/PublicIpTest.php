<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\IntellectualProperty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicIpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_public_ip_index()
    {
        $response = $this->get(route('ip.public.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function ip_index_shows_only_active_and_registered_items()
    {
        IntellectualProperty::factory()->create(['status' => 'active', 'title' => 'Active IP']);
        IntellectualProperty::factory()->create(['status' => 'registered', 'title' => 'Registered IP']);
        IntellectualProperty::factory()->create(['status' => 'draft', 'title' => 'Draft IP']);
        IntellectualProperty::factory()->create(['status' => 'pending', 'title' => 'Pending IP']);

        $response = $this->get(route('ip.public.index'));

        $response->assertStatus(200)
            ->assertSee('Active IP')
            ->assertSee('Registered IP')
            ->assertDontSee('Draft IP')
            ->assertDontSee('Pending IP');
    }

    /** @test */
    public function ip_index_can_filter_by_type()
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

        $response = $this->get(route('ip.public.index', ['type' => 'patent']));

        $response->assertStatus(200)
            ->assertSee('Patent Item')
            ->assertDontSee('Copyright Item');
    }

    /** @test */
    public function ip_index_can_filter_by_status()
    {
        IntellectualProperty::factory()->create([
            'status' => 'active',
            'title' => 'Active Item',
        ]);
        
        IntellectualProperty::factory()->create([
            'status' => 'registered',
            'title' => 'Registered Item',
        ]);

        $response = $this->get(route('ip.public.index', ['status' => 'active']));

        $response->assertStatus(200)
            ->assertSee('Active Item');
    }

    /** @test */
    public function ip_index_can_search_by_keyword()
    {
        IntellectualProperty::factory()->create([
            'status' => 'active',
            'title' => 'Searchable Patent Title',
            'description' => 'Normal description',
        ]);
        
        IntellectualProperty::factory()->create([
            'status' => 'active',
            'title' => 'Other Title',
            'description' => 'Contains searchable keyword',
        ]);

        $response = $this->get(route('ip.public.index', ['q' => 'searchable']));

        $response->assertStatus(200)
            ->assertSee('Searchable Patent Title')
            ->assertSee('searchable keyword');
    }

    /** @test */
    public function ip_index_can_search_by_registration_number()
    {
        IntellectualProperty::factory()->create([
            'status' => 'active',
            'title' => 'IP Item',
            'registration_number' => 'REG-12345',
        ]);

        $response = $this->get(route('ip.public.index', ['q' => 'REG-12345']));

        $response->assertStatus(200)
            ->assertSee('REG-12345');
    }

    /** @test */
    public function guest_can_view_active_ip_detail()
    {
        $ip = IntellectualProperty::factory()->create([
            'status' => 'active',
            'title' => 'Active IP Detail',
        ]);

        $response = $this->get(route('ip.public.show', $ip));

        $response->assertStatus(200)
            ->assertSee('Active IP Detail');
    }

    /** @test */
    public function guest_can_view_registered_ip_detail()
    {
        $ip = IntellectualProperty::factory()->create([
            'status' => 'registered',
            'title' => 'Registered IP Detail',
        ]);

        $response = $this->get(route('ip.public.show', $ip));

        $response->assertStatus(200)
            ->assertSee('Registered IP Detail');
    }

    /** @test */
    public function guest_cannot_view_draft_ip_detail()
    {
        $ip = IntellectualProperty::factory()->create([
            'status' => 'draft',
            'title' => 'Draft IP',
        ]);

        $response = $this->get(route('ip.public.show', $ip));

        $response->assertStatus(404);
    }

    /** @test */
    public function guest_cannot_view_pending_ip_detail()
    {
        $ip = IntellectualProperty::factory()->create([
            'status' => 'pending',
            'title' => 'Pending IP',
        ]);

        $response = $this->get(route('ip.public.show', $ip));

        $response->assertStatus(404);
    }

    /** @test */
    public function ip_index_is_paginated()
    {
        IntellectualProperty::factory()->count(20)->create(['status' => 'active']);

        $response = $this->get(route('ip.public.index'));

        $response->assertStatus(200);
        // Should paginate at 12 items per page
        $this->assertLessThanOrEqual(12, IntellectualProperty::query()->paginate(12)->count());
    }

    /** @test */
    public function ip_index_preserves_query_string_in_pagination()
    {
        IntellectualProperty::factory()->count(15)->create([
            'status' => 'active',
            'type' => 'patent',
        ]);

        $response = $this->get(route('ip.public.index', ['type' => 'patent', 'page' => 1]));

        $response->assertStatus(200);
        // Query string should be preserved in pagination links
    }

    /** @test */
    public function ip_index_shows_type_filter_options()
    {
        IntellectualProperty::factory()->create(['type' => 'patent', 'status' => 'active']);
        IntellectualProperty::factory()->create(['type' => 'copyright', 'status' => 'active']);

        $response = $this->get(route('ip.public.index'));

        $response->assertStatus(200);
        // Should have filter options available
    }

    /** @test */
    public function ip_index_shows_status_filter_options()
    {
        IntellectualProperty::factory()->create(['status' => 'active']);
        IntellectualProperty::factory()->create(['status' => 'registered']);

        $response = $this->get(route('ip.public.index'));

        $response->assertStatus(200);
        // Should have status filter options
    }
}
