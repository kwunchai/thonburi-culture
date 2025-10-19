<?php

use App\Models\User;
use App\Models\IntellectualProperty;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authorized users can access IP index', function () {
    $user = User::factory()->create(['role' => 'admin']);
    
    $response = $this->actingAs($user)->get(route('admin.ip.index'));
    
    $response->assertStatus(200);
    $response->assertSee('ทรัพย์สินทางปัญญา');
});

test('IP index displays applicant name column', function () {
    $user = User::factory()->create(['role' => 'admin']);
    
    $ip = IntellectualProperty::create([
        'title' => 'Test IP',
        'type' => 'สิทธิบัตรการประดิษฐ์',
        'applicant_name' => 'Dr. Test Applicant',
        'slug' => 'test-ip-slug'
    ]);
    
    $response = $this->actingAs($user)->get(route('admin.ip.index'));
    
    $response->assertStatus(200);
    $response->assertSee('ผู้ขอ'); // Header
    $response->assertSee('Dr. Test Applicant'); // Data
});

test('IP search includes applicant name', function () {
    $user = User::factory()->create(['role' => 'admin']);
    
    IntellectualProperty::create([
        'title' => 'Innovation A',
        'type' => 'สิทธิบัตรการประดิษฐ์',
        'applicant_name' => 'John Doe',
        'slug' => 'innovation-a'
    ]);
    
    IntellectualProperty::create([
        'title' => 'Innovation B',
        'type' => 'ลิขสิทธิ์',
        'applicant_name' => 'Jane Smith',
        'slug' => 'innovation-b'
    ]);
    
    $response = $this->actingAs($user)->get(route('admin.ip.index', ['q' => 'John']));
    
    $response->assertStatus(200);
    $response->assertSee('John Doe');
    $response->assertDontSee('Jane Smith');
});

test('IP can be created with validation', function () {
    $user = User::factory()->create(['role' => 'admin']);
    
    $data = [
        'title' => 'New IP Creation',
        'type' => 'สิทธิบัตรการประดิษฐ์',
        'status' => 'ร่าง',
        'applicant_name' => 'Test Creator',
    ];
    
    $response = $this->actingAs($user)->post(route('admin.ip.store'), $data);
    
    $response->assertRedirect(route('admin.ip.index'));
    $this->assertDatabaseHas('intellectual_properties', [
        'title' => 'New IP Creation',
        'applicant_name' => 'Test Creator'
    ]);
});

test('IP can be updated with proper authorization', function () {
    $user = User::factory()->create(['role' => 'admin']);
    
    $ip = IntellectualProperty::create([
        'title' => 'Original Title',
        'type' => 'สิทธิบัตรการประดิษฐ์',
        'applicant_name' => 'Original Applicant',
        'slug' => 'original-title'
    ]);
    
    $data = [
        'title' => 'Updated Title',
        'type' => 'ลิขสิทธิ์',
        'applicant_name' => 'Updated Applicant',
    ];
    
    $response = $this->actingAs($user)->put(route('admin.ip.update', $ip), $data);
    
    $response->assertRedirect(route('admin.ip.index'));
    $this->assertDatabaseHas('intellectual_properties', [
        'id' => $ip->id,
        'title' => 'Updated Title',
        'applicant_name' => 'Updated Applicant'
    ]);
});

test('edit view is accessible', function () {
    $user = User::factory()->create(['role' => 'admin']);
    
    $ip = IntellectualProperty::create([
        'title' => 'Test IP',
        'type' => 'สิทธิบัตรการประดิษฐ์',
        'slug' => 'test-ip'
    ]);
    
    $response = $this->actingAs($user)->get(route('admin.ip.edit', $ip));
    
    $response->assertStatus(200);
    $response->assertSee('แก้ไขข้อมูลทรัพย์สินทางปัญญา');
    $response->assertSee($ip->title);
});
