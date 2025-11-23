@echo off
cd c:\laragon\www\thonburi-culture
echo Running authentication test...
php artisan tinker --execute="echo 'Testing authentication system...'; $user = App\Models\User::where('email', 'admin@test.com')->first(); if($user) { echo 'User found: ' . $user->email . ' (Role: ' . $user->role . ')'; } else { echo 'User not found'; } echo 'Total users: ' . App\Models\User::count();"