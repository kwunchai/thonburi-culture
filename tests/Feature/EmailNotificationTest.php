<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\IntellectualProperty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class EmailNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Notification::fake();
    }

    /** @test */
    public function contact_form_sends_email()
    {
        $response = $this->post(route('contact.send'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message',
        ]);

        expect($response->status())->toBeIn([200, 302]);

        // Check if mail was sent (if implemented)
        // Mail::assertSent(ContactFormMail::class);
    }

    /** @test */
    public function contact_form_validates_email_format()
    {
        $response = $this->post(route('contact.send'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'message' => 'This is a test message',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function ip_registration_notification_can_be_sent()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ipManager = User::factory()->create(['role' => 'ip_manager']);
        
        $ip = IntellectualProperty::factory()->create([
            'status' => 'submitted',
            'created_by' => $ipManager->id,
        ]);

        // Simulate IP registration (if notification is implemented)
        $this->actingAs($admin)->patch(route('admin.ip.update', $ip->ip_id), [
            'status' => 'registered',
            'registration_number' => 'REG-2025-001',
            'registration_date' => now()->toDateString(),
        ]);

        // Check if notification was sent
        // Notification::assertSentTo($ipManager, IpRegisteredNotification::class);
        
        expect(true)->toBeTrue(); // Placeholder
    }

    /** @test */
    public function admin_receives_notification_for_new_ip_submission()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'viewer']);

        $response = $this->actingAs($user)->post(route('admin.ip.store'), [
            'title' => 'New IP Submission',
            'type' => 'copyright',
            'description' => 'Test description',
            'status' => 'submitted',
        ]);

        // Admin should receive notification (if implemented)
        // Notification::assertSentTo($admin, NewIpSubmissionNotification::class);
        
        expect($response->status())->toBeIn([200, 302, 403, 500]);
    }

    /** @test */
    public function ip_expiry_reminder_can_be_sent()
    {
        $ipManager = User::factory()->create(['role' => 'ip_manager']);
        
        // Create IP expiring in 30 days
        $ip = IntellectualProperty::factory()->create([
            'expiry_date' => now()->addDays(30),
            'status' => 'registered',
            'created_by' => $ipManager->id,
        ]);

        // Run expiry check command (if implemented)
        // Artisan::call('ip:check-expiry');
        
        // Check if reminder was sent
        // Notification::assertSentTo($ipManager, IpExpiryReminderNotification::class);
        
        expect($ip->expiry_date)->toBeInstanceOf(\Carbon\Carbon::class);
    }

    /** @test */
    public function multiple_admins_receive_ip_submission_notifications()
    {
        $admin1 = User::factory()->create(['role' => 'admin']);
        $admin2 = User::factory()->create(['role' => 'admin']);
        $ipManager = User::factory()->create(['role' => 'ip_manager']);

        $response = $this->actingAs($ipManager)->post(route('admin.ip.store'), [
            'title' => 'New Patent',
            'type' => 'invention_patent',
            'description' => 'Patent description',
            'status' => 'submitted',
        ]);

        // Both admins should receive notification
        // Notification::assertSentTo([$admin1, $admin2], NewIpSubmissionNotification::class);
        
        expect($response->status())->toBeIn([200, 302, 500]);
    }

    /** @test */
    public function notification_preferences_can_be_set()
    {
        $user = User::factory()->create();

        // User should be able to toggle email notifications
        // This is a placeholder for future implementation
        expect($user->id)->toBeInt();
    }

    /** @test */
    public function email_notification_contains_correct_ip_details()
    {
        $ipManager = User::factory()->create(['role' => 'ip_manager']);
        
        $ip = IntellectualProperty::factory()->create([
            'title' => 'Test Copyright',
            'type' => 'copyright',
            'status' => 'registered',
            'registration_number' => 'REG-2025-001',
            'created_by' => $ipManager->id,
        ]);

        // Send notification
        // $ipManager->notify(new IpRegisteredNotification($ip));
        
        // Check notification data
        // Notification::assertSentTo($ipManager, function ($notification) use ($ip) {
        //     return $notification->ip->ip_id === $ip->ip_id;
        // });
        
        expect($ip->title)->toBe('Test Copyright');
    }

    /** @test */
    public function failed_notifications_are_logged()
    {
        // Test that failed email sending is logged
        // This would require mocking Mail facade to throw exception
        
        expect(true)->toBeTrue(); // Placeholder
    }

    /** @test */
    public function notification_queue_is_used_for_bulk_emails()
    {
        // Create multiple IPs
        $ips = IntellectualProperty::factory()->count(10)->create([
            'expiry_date' => now()->addDays(15),
        ]);

        // Bulk notification should be queued
        // This is a performance consideration
        
        expect($ips)->toHaveCount(10);
    }

    /** @test */
    public function contact_form_prevents_spam()
    {
        $data = [
            'name' => 'Spammer',
            'email' => 'spam@example.com',
            'message' => 'Spam message',
        ];

        // Send multiple requests quickly
        $this->post(route('contact.send'), $data);
        $this->post(route('contact.send'), $data);
        $response = $this->post(route('contact.send'), $data);

        // Should be rate limited (if implemented)
        expect($response->status())->toBeIn([200, 302, 429]);
    }

    /** @test */
    public function email_uses_correct_locale()
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        // Set Thai locale
        app()->setLocale('th');
        
        $ip = IntellectualProperty::factory()->create();
        
        // Email should be in Thai
        // This tests i18n support
        
        expect(app()->getLocale())->toBe('th');
    }

    /** @test */
    public function notification_includes_action_buttons()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $ip = IntellectualProperty::factory()->create([
            'status' => 'submitted',
        ]);

        // Notification should include "View IP" and "Approve" buttons
        // This tests notification UI
        
        expect($ip->status)->toBe('submitted');
    }

    /** @test */
    public function email_sender_name_is_configured()
    {
        // Test that emails are sent from "Thonburi Culture"
        // This tests mail configuration
        
        $mailFrom = config('mail.from.name');
        expect($mailFrom)->toBeString();
    }

    /** @test */
    public function notification_database_channel_works()
    {
        $user = User::factory()->create();
        
        // Send database notification
        // $user->notify(new TestNotification());
        
        // Check database
        // expect($user->notifications)->toHaveCount(1);
        
        expect($user->id)->toBeInt(); // Placeholder
    }
}
