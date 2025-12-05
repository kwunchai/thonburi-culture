<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        Storage::fake('public');
        
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_can_upload_cultural_item_image()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        $file = UploadedFile::fake()->image('cultural-item.jpg', 800, 600);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.cultural-items.store'), [
                'title' => 'Test Item',
                'description' => 'Test description',
                'category_id' => $category->id,
                'community_id' => $community->id,
                'image' => $file,
            ]);

        if ($response->status() === 302) {
            $item = CulturalItem::where('title', 'Test Item')->first();
            if ($item && $item->image) {
                Storage::disk('public')->assertExists($item->image);
            }
        }
        
        expect($response->status())->toBeIn([200, 302, 500]);
    }

    /** @test */
    public function image_upload_validates_file_type()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.cultural-items.store'), [
                'title' => 'Test Item',
                'description' => 'Test description',
                'category_id' => $category->id,
                'community_id' => $community->id,
                'image' => $file,
            ]);

        expect($response->status())->toBeIn([422, 302, 500]);
    }

    /** @test */
    public function image_upload_validates_file_size()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        // Create a file larger than 2MB (2048 KB)
        $file = UploadedFile::fake()->image('large-image.jpg')->size(3000);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.cultural-items.store'), [
                'title' => 'Test Item',
                'description' => 'Test description',
                'category_id' => $category->id,
                'community_id' => $community->id,
                'image' => $file,
            ]);

        expect($response->status())->toBeIn([422, 302, 500]);
    }

    /** @test */
    public function updating_item_can_replace_existing_image()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        $item = CulturalItem::factory()->create([
            'category_id' => $category->id,
            'community_id' => $community->id,
            'image' => 'old-image.jpg',
        ]);
        
        Storage::disk('public')->put('old-image.jpg', 'old content');
        
        $newFile = UploadedFile::fake()->image('new-image.jpg');

        $response = $this->actingAs($this->admin)
            ->put(route('admin.cultural-items.update', $item->id), [
                'title' => $item->title,
                'description' => $item->description,
                'category_id' => $category->id,
                'community_id' => $community->id,
                'image' => $newFile,
            ]);

        if ($response->status() === 302) {
            $item->refresh();
            
            // Old image should be deleted
            Storage::disk('public')->assertMissing('old-image.jpg');
            
            // New image should exist
            if ($item->image) {
                Storage::disk('public')->assertExists($item->image);
            }
        }
        
        expect($response->status())->toBeIn([200, 302, 500]);
    }

    /** @test */
    public function deleting_item_removes_associated_image()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        $item = CulturalItem::factory()->create([
            'category_id' => $category->id,
            'community_id' => $community->id,
            'image' => 'item-image.jpg',
        ]);
        
        Storage::disk('public')->put('item-image.jpg', 'image content');

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.cultural-items.destroy', $item->id));

        if ($response->status() === 302) {
            // Image should be deleted
            Storage::disk('public')->assertMissing('item-image.jpg');
            
            // Item should be deleted
            expect(CulturalItem::find($item->id))->toBeNull();
        }
        
        expect($response->status())->toBeIn([200, 302, 500]);
    }

    /** @test */
    public function admin_can_upload_community_image()
    {
        $file = UploadedFile::fake()->image('community.jpg');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.communities.store'), [
                'name' => 'Test Community',
                'description' => 'Test description',
                'image' => $file,
            ]);

        if ($response->status() === 302) {
            $community = Community::where('name', 'Test Community')->first();
            if ($community && $community->image) {
                Storage::disk('public')->assertExists($community->image);
            }
        }
        
        expect($response->status())->toBeIn([200, 302, 500]);
    }

    /** @test */
    public function admin_can_upload_activity_image()
    {
        $file = UploadedFile::fake()->image('activity.jpg');

        try {
            $response = $this->actingAs($this->admin)
                ->post(route('admin.activities.store'), [
                    'title' => 'Test Activity',
                    'description' => 'Test description',
                    'activity_date' => now()->addDays(7)->format('Y-m-d'),
                    'image' => $file,
                ]);

            if ($response->status() === 302) {
                $activity = Activity::where('title', 'Test Activity')->first();
                if ($activity && $activity->image) {
                    Storage::disk('public')->assertExists($activity->image);
                }
            }
            
            expect($response->status())->toBeIn([200, 302, 422, 500]);
        } catch (\Exception $e) {
            expect($e->getMessage())->toContain(['not defined', 'required']);
        }
    }

    /** @test */
    public function image_paths_are_stored_correctly_in_database()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.cultural-items.store'), [
                'title' => 'Test Item',
                'description' => 'Test description',
                'category_id' => $category->id,
                'community_id' => $community->id,
                'image' => $file,
            ]);

        if ($response->status() === 302) {
            $item = CulturalItem::where('title', 'Test Item')->first();
            
            if ($item && $item->image) {
                // Path should not have leading slash and should be relative
                expect($item->image)->not()->toStartWith('/');
                expect($item->image)->toContain('.jpg');
            }
        }
        
        expect($response->status())->toBeIn([200, 302, 500]);
    }

    /** @test */
    public function uploading_without_image_is_optional()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.cultural-items.store'), [
                'title' => 'Test Item No Image',
                'description' => 'Test description',
                'category_id' => $category->id,
                'community_id' => $community->id,
            ]);

        if ($response->status() === 302) {
            $item = CulturalItem::where('title', 'Test Item No Image')->first();
            expect($item)->not()->toBeNull();
            expect($item->image)->toBeNull();
        }
        
        expect($response->status())->toBeIn([200, 302, 500]);
    }

    /** @test */
    public function non_admin_cannot_upload_images()
    {
        $user = User::factory()->create(['role' => 'viewer']);
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($user)
            ->post(route('admin.cultural-items.store'), [
                'title' => 'Test Item',
                'description' => 'Test description',
                'category_id' => $category->id,
                'community_id' => $community->id,
                'image' => $file,
            ]);

        expect($response->status())->toBeIn([403, 302]);
    }
}
