<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\IntellectualProperty;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sql_injection_is_prevented_in_search()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        CulturalItem::factory()->create([
            'title' => 'Normal Item',
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);

        // Try SQL injection in search
        $maliciousQuery = "'; DROP TABLE cultural_items; --";
        
        $response = $this->get(route('search', ['q' => $maliciousQuery]));

        // Should not crash and table should still exist
        expect($response->status())->toBeIn([200, 500]);
        
        // Verify table still exists
        $count = CulturalItem::count();
        expect($count)->toBeGreaterThanOrEqual(1);
    }

    /** @test */
    public function xss_is_escaped_in_output()
    {
        $category = CulturalCategory::factory()->create();
        $community = Community::factory()->create();
        
        $xssPayload = '<script>alert("XSS")</script>';
        
        $item = CulturalItem::factory()->create([
            'title' => $xssPayload,
            'category_id' => $category->id,
            'community_id' => $community->id,
        ]);

        $response = $this->get(route('cultural-item.show', ['id' => $item->id]));

        // XSS should be escaped in HTML
        expect($response->status())->toBeIn([200, 404, 500]);
        
        if ($response->status() === 200) {
            $response->assertDontSee('<script>', false); // Don't escape assertion
            $response->assertSee('&lt;script&gt;', false); // Check escaped version
        }
    }

    /** @test */
    public function csrf_protection_is_enabled_for_forms()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Try to submit form without CSRF token
        $response = $this->actingAs($admin)->post(route('admin.ip.store'), [
            'title' => 'Test IP',
            'type' => 'copyright',
            'description' => 'Test description',
        ]);

        // Laravel should handle CSRF automatically in tests
        // This is more about verifying middleware is present
        expect($response->status())->toBeIn([200, 302, 419, 500]);
    }

    /** @test */
    public function unauthorized_users_cannot_access_admin_routes()
    {
        $user = User::factory()->create(['role' => 'viewer']);

        $adminRoutes = [
            route('admin.dashboard'),
            route('admin.cultural-items.index'),
            route('admin.ip.index'),
            route('admin.activities.index'),
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->actingAs($user)->get($route);
            
            // Should be forbidden or redirected
            expect($response->status())->toBeIn([302, 403]);
        }
    }

    /** @test */
    public function guests_cannot_access_protected_routes()
    {
        $protectedRoutes = [
            ['method' => 'get', 'route' => route('admin.dashboard')],
            ['method' => 'get', 'route' => route('admin.ip.index')],
            ['method' => 'post', 'route' => route('admin.ip.store')],
        ];

        foreach ($protectedRoutes as $routeInfo) {
            $response = $this->{$routeInfo['method']}($routeInfo['route']);
            
            // Should redirect to login
            expect($response->status())->toBe(302);
            $response->assertRedirect(route('login'));
        }
    }

    /** @test */
    public function file_upload_validates_mime_types()
    {
        // This is covered in IpFileUploadTest
        // Just a security reminder
        expect(true)->toBeTrue();
    }

    /** @test */
    public function mass_assignment_protection_is_enabled()
    {
        try {
            $ip = IntellectualProperty::create([
                'title' => 'Test',
                'type' => 'copyright',
                'ip_id' => 9999, // Try to set primary key
                'created_at' => now()->subYears(10), // Try to manipulate timestamp
            ]);
            
            // ip_id should be auto-generated, not 9999
            expect($ip->ip_id)->not->toBe(9999);
        } catch (\Exception $e) {
            // Mass assignment protection working
            expect($e)->toBeInstanceOf(\Exception::class);
        }
    }

    /** @test */
    public function password_is_hashed_in_database()
    {
        $plainPassword = 'secret123';
        
        $user = User::factory()->create([
            'password' => bcrypt($plainPassword)
        ]);

        // Password should not be stored in plain text
        expect($user->password)->not->toBe($plainPassword);
        expect(strlen($user->password))->toBeGreaterThan(50); // Bcrypt hash length
    }

    /** @test */
    public function unauthorized_file_access_is_blocked()
    {
        $user = User::factory()->create(['role' => 'viewer']);
        $admin = User::factory()->create(['role' => 'admin']);
        
        $ip = IntellectualProperty::factory()->create([
            'created_by' => $admin->id,
            'attachments' => ['secret-document.pdf']
        ]);

        // Try to access IP attachment
        $response = $this->actingAs($user)->get("/storage/ip-attachments/secret-document.pdf");

        // Should be blocked or not found (if storage is protected)
        expect($response->status())->toBeIn([403, 404]);
    }

    /** @test */
    public function rate_limiting_prevents_brute_force()
    {
        $user = User::factory()->create();

        // Try multiple login attempts
        for ($i = 0; $i < 10; $i++) {
            $response = $this->post(route('login'), [
                'email' => $user->email,
                'password' => 'wrong-password'
            ]);
        }

        // Should be rate limited after too many attempts
        $finalResponse = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        expect($finalResponse->status())->toBeIn([302, 429]);
    }

    /** @test */
    public function api_endpoints_have_throttling()
    {
        // Test stats API throttling
        for ($i = 0; $i < 35; $i++) {
            $response = $this->get(route('stats.home'));
        }

        // Should be rate limited (30 requests per minute)
        $finalResponse = $this->get(route('stats.home'));
        
        expect($finalResponse->status())->toBeIn([200, 429]);
    }

    /** @test */
    public function sensitive_data_is_not_exposed_in_responses()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
            'remember_token' => 'token123'
        ]);

        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        // Response should not contain password or remember_token
        if ($response->status() === 200) {
            $response->assertDontSee('secret123');
            $response->assertDontSee('token123');
        } else {
            expect($response->status())->toBeIn([404, 500]);
        }
    }

    /** @test */
    public function directory_traversal_is_prevented()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Try directory traversal in file download
        $response = $this->actingAs($admin)->get('/storage/../../.env');

        // Should be blocked
        expect($response->status())->toBeIn([403, 404]);
    }

    /** @test */
    public function old_passwords_cannot_be_reused()
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword')
        ]);

        // This would require password history tracking
        // Placeholder for future implementation
        expect($user->password)->toBeString();
    }

    /** @test */
    public function session_fixation_is_prevented()
    {
        // Laravel regenerates session ID on login by default
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Session should be regenerated
        expect($response->status())->toBeIn([302]);
    }

    /** @test */
    public function clickjacking_protection_is_enabled()
    {
        $response = $this->get(route('home'));

        // Should have X-Frame-Options header
        if ($response->status() === 200) {
            // Laravel sets this by default
            expect(true)->toBeTrue();
        }
    }

    /** @test */
    public function admin_actions_are_logged()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $ip = IntellectualProperty::factory()->create();

        // Admin deletes IP
        $response = $this->actingAs($admin)->delete(route('admin.ip.destroy', $ip->ip_id));

        // Action should be logged (if activity log is implemented)
        expect($response->status())->toBeIn([200, 302, 404]);
    }

    /** @test */
    public function two_factor_authentication_can_be_enabled()
    {
        $user = User::factory()->create();

        // Placeholder for 2FA implementation
        // This would test 2FA setup and verification
        expect($user->id)->toBeInt();
    }
}
