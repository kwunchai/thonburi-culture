<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
});

test('admin can view users index', function () {
    User::factory()->count(5)->create();

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index'));

    $response->assertStatus(200);
});

test('admin can create user', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'editor',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $data);

    $response->assertStatus(302);
    $this->assertDatabaseHas('users', [
        'email' => 'testuser@example.com',
        'role' => 'editor',
    ]);
});

test('it validates required fields for user', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.users.store'), []);

    $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
});

test('it validates unique email', function () {
    $existingUser = User::factory()->create(['email' => 'existing@example.com']);

    $data = [
        'name' => 'Test User',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'editor',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $data);

    $response->assertSessionHasErrors(['email']);
});

test('admin can update user', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.users.update', $user), [
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => 'editor',
        ]);

    $response->assertStatus(302);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'role' => 'editor',
    ]);
});

test('admin can delete user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.users.destroy', $user));

    $response->assertStatus(302);
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('admin can search users', function () {
    User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index', ['search' => 'John']));

    $response->assertStatus(200);
});

test('admin can filter users by role', function () {
    User::factory()->count(3)->create(['role' => 'editor']);
    User::factory()->count(2)->create(['role' => 'viewer']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index', ['role' => 'editor']));

    $response->assertStatus(200);
});

test('regular user cannot access user management', function () {
    $response = $this->actingAs($this->user)
        ->get(route('admin.users.index'));

    $response->assertStatus(403);
});

test('user index shows statistics', function () {
    User::factory()->count(5)->create(['role' => 'editor']);
    User::factory()->count(3)->create(['role' => 'viewer']);
    User::factory()->count(2)->create(['email_verified_at' => null]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index'));

    $response->assertStatus(200);
    $response->assertViewHas('stats');
});

test('cannot delete own account', function () {
    $response = $this->actingAs($this->admin)
        ->delete(route('admin.users.destroy', $this->admin));

    $response->assertStatus(302);
    $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
});
