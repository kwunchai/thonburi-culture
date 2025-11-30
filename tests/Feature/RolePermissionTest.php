<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->editor = User::factory()->create(['role' => 'editor']);
    $this->ipManager = User::factory()->create(['role' => 'ip_manager']);
    $this->viewer = User::factory()->create(['role' => 'viewer']);
    $this->user = User::factory()->create(['role' => 'user']);
});

test('admin role has full access', function () {
    expect($this->admin->isAdmin())->toBeTrue();
    expect($this->admin->canManageIp())->toBeTrue();
});

test('editor role identification works', function () {
    expect($this->editor->isEditor())->toBeTrue();
    expect($this->editor->isAdmin())->toBeFalse();
});

test('ip manager can manage IP', function () {
    expect($this->ipManager->isIpManager())->toBeTrue();
    expect($this->ipManager->canManageIp())->toBeTrue();
});

test('viewer role is read-only', function () {
    expect($this->viewer->isViewer())->toBeTrue();
    expect($this->viewer->canManageIp())->toBeFalse();
});

test('hasRole method works with string', function () {
    expect($this->admin->hasRole('admin'))->toBeTrue();
    expect($this->admin->hasRole('editor'))->toBeFalse();
});

test('hasRole method works with array', function () {
    expect($this->admin->hasRole(['admin', 'editor']))->toBeTrue();
    expect($this->viewer->hasRole(['admin', 'editor']))->toBeFalse();
});

test('admin can access admin dashboard', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
});

test('editor cannot access admin dashboard', function () {
    $response = $this->actingAs($this->editor)
        ->get(route('admin.dashboard'));

    $response->assertStatus(403);
});

test('ip manager can access IP routes', function () {
    $response = $this->actingAs($this->ipManager)
        ->get(route('admin.ip.index'));

    $response->assertStatus(200);
});

test('viewer cannot access IP management', function () {
    $response = $this->actingAs($this->viewer)
        ->get(route('admin.ip.index'));

    $response->assertStatus(403);
});

test('admin can manage cultural items', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.cultural-items.index'));

    $response->assertStatus(200);
});

test('regular user cannot access admin routes', function () {
    $response = $this->actingAs($this->user)
        ->get(route('admin.cultural-items.index'));

    $response->assertStatus(403);
});
