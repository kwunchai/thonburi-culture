@echo off
cd c:\laragon\www\thonburi-culture
echo Creating test login script...
php artisan tinker --execute="use Illuminate\Support\Facades\Auth; use App\Models\User; $user = User::where('email', 'admin@test.com')->first(); if($user && $user->role === 'admin') { echo 'Admin user exists and ready for login'; echo 'Email: ' . $user->email; echo 'Name: ' . $user->name; echo 'Role: ' . $user->role; } else { echo 'Admin user not properly configured'; }"