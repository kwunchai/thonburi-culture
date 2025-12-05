<?php

// Test script to check authentication and access
// URL: /test-admin-access

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "<h1>Admin Access Test</h1>";

echo "<h2>1. Check if user exists</h2>";
$user = User::where('email', 'admin@test.com')->first();
if ($user) {
    echo "✅ User found: {$user->email} (Role: {$user->role})<br>";
} else {
    echo "❌ User not found<br>";
}

echo "<h2>2. Check authentication</h2>";
if (Auth::check()) {
    $currentUser = Auth::user();
    echo "✅ Logged in as: {$currentUser->email} (Role: {$currentUser->role})<br>";
    
    echo "<h2>3. Check permissions</h2>";
    if ($currentUser->hasRole(['admin', 'editor', 'ip_manager'])) {
        echo "✅ Has sufficient permissions<br>";
    } else {
        echo "❌ Insufficient permissions<br>";
    }
} else {
    echo "❌ Not logged in<br>";
    echo "<p><a href='/login'>Click here to login</a></p>";
}

echo "<h2>4. Direct Links</h2>";
echo "<ul>";
echo "<li><a href='/login'>Login Page</a></li>";
echo "<li><a href='/admin/dashboard'>Admin Dashboard</a></li>";
echo "<li><a href='/admin/activities'>Activities Management</a></li>";
echo "<li><a href='/admin/activity-categories'>Categories Management</a></li>";
echo "</ul>";

echo "<h2>5. Test Login</h2>";
echo "<form method='POST' action='/login'>";
echo csrf_field();
echo "<input type='email' name='email' value='admin@test.com' placeholder='Email' style='margin:5px;'><br>";
echo "<input type='password' name='password' placeholder='Password' style='margin:5px;'><br>";
echo "<button type='submit' style='margin:5px;'>Test Login</button>";
echo "</form>";
?>