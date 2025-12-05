@extends('layouts.app')

@section('title', 'โปรไฟล์')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">โปรไฟล์ของฉัน</h1>
                    <p class="text-gray-600">จัดการข้อมูลส่วนตัวและความปลอดภัยของบัญชี</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('status') === 'profile-updated')
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">บันทึกข้อมูลเรียบร้อยแล้ว</p>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user-circle mr-3"></i>
                        ข้อมูลส่วนตัว
                    </h2>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-key mr-3"></i>
                        เปลี่ยนรหัสผ่าน
                    </h2>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
