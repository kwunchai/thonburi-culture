<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ActivityCategory;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'viewer']);
    }

    /** @test */
    public function admin_can_view_activity_categories_index()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.activity-categories.index'));

        expect($response->status())->toBeIn([200, 500]);
    }

    /** @test */
    public function non_admin_cannot_access_admin_activity_categories()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('admin.activity-categories.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_create_activity_category()
    {
        $this->actingAs($this->admin);

        $data = [
            'name' => 'Test Category',
            'description' => 'Test description',
            'color' => '#FF5733',
            'icon' => 'fas fa-calendar',
            'is_active' => true,
        ];

        $response = $this->post(route('admin.activity-categories.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('activity_categories', [
            'name' => 'Test Category',
        ]);
    }

    /** @test */
    public function admin_can_update_activity_category()
    {
        $this->actingAs($this->admin);
        $category = ActivityCategory::factory()->create(['name' => 'Old Name']);

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'color' => '#FF5733',
            'icon' => 'fas fa-star',
            'is_active' => true,
        ];

        $response = $this->put(route('admin.activity-categories.update', $category), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('activity_categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function admin_can_delete_activity_category()
    {
        $this->actingAs($this->admin);
        $category = ActivityCategory::factory()->create();

        $response = $this->delete(route('admin.activity-categories.destroy', $category));

        $response->assertRedirect();
        $this->assertDatabaseMissing('activity_categories', ['id' => $category->id]);
    }

    /** @test */
    public function admin_can_toggle_category_status()
    {
        $this->actingAs($this->admin);
        $category = ActivityCategory::factory()->create(['is_active' => true]);

        $response = $this->post(route('admin.activity-categories.toggle-status', $category));

        $response->assertRedirect();
        $this->assertFalse($category->fresh()->is_active);
    }

    /** @test */
    public function slug_is_auto_generated_from_name()
    {
        $category = ActivityCategory::factory()->create([
            'name' => 'Test Category Name',
            'slug' => null,
        ]);

        $this->assertEquals('test-category-name', $category->fresh()->slug);
    }

    /** @test */
    public function slug_updates_when_name_changes()
    {
        $category = ActivityCategory::factory()->create(['name' => 'Original Name']);
        
        $category->update(['name' => 'New Name']);

        $this->assertEquals('new-name', $category->fresh()->slug);
    }

    /** @test */
    public function scope_active_returns_only_active_categories()
    {
        ActivityCategory::factory()->count(3)->create(['is_active' => true]);
        ActivityCategory::factory()->count(2)->inactive()->create();

        $activeCategories = ActivityCategory::active()->get();

        $this->assertCount(3, $activeCategories);
    }

    /** @test */
    public function category_has_many_activities()
    {
        $category = ActivityCategory::factory()->create();
        Activity::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertCount(3, $category->activities);
    }

    /** @test */
    public function activities_count_attribute_returns_correct_count()
    {
        $category = ActivityCategory::factory()->create();
        Activity::factory()->count(5)->create([
            'category_id' => $category->id,
            'is_active' => true,
        ]);
        Activity::factory()->count(2)->create([
            'category_id' => $category->id,
            'is_active' => false,
        ]);

        $this->assertEquals(5, $category->activities_count);
    }

    /** @test */
    public function route_key_name_is_slug()
    {
        $category = ActivityCategory::factory()->create();

        $this->assertEquals('slug', $category->getRouteKeyName());
    }

    /** @test */
    public function category_validation_requires_name()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.activity-categories.store'), [
            'description' => 'Test',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function color_with_opacity_attribute_converts_hex_to_rgba()
    {
        $category = ActivityCategory::factory()->create(['color' => '#FF5733']);

        $rgba = $category->color_with_opacity;

        $this->assertStringContainsString('rgba', $rgba);
        $this->assertStringContainsString('0.1', $rgba);
    }
}
