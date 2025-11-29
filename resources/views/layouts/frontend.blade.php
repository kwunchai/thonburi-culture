<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'วัฒนธรรมเขตธนบุรี') - ฐานข้อมูลวัฒนธรรมเขตธนบุรี</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    
    <meta name="description" content="@yield('meta_description', 'ฐานข้อมูลมรดกทางวัฒนธรรมเขตธนบุรี - สำรวจเรื่องราว ประเพณี และภูมิปัญญาท้องถิ่น')">
    <meta name="keywords" content="วัฒนธรรมธนบุรี, มรดกทางวัฒนธรรม, ประเพณีไทย, ชุมชนธนบุรี">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700;800&family=Prompt:wght@400;500;600;700&family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
    @stack('meta')
</head>
<body class="font-thai antialiased bg-neutral-bg text-neutral-text-primary" x-data="{ 
    mobileMenuOpen: false, 
    searchOpen: false,
    scrolled: false 
}" @scroll.window="scrolled = window.pageYOffset > 20">
    
    <!-- Sticky Header -->
    <header 
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="scrolled ? 'bg-white shadow-heritage' : 'bg-white border-b border-neutral-border-light'"
    >
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                
                <!-- Logo & Site Name -->
                <div class="flex items-center space-x-2 md:space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 md:space-x-3 group">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 via-orange-600 to-red-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-all duration-200 p-2">
                                <svg viewBox="0 0 48 48" fill="none" class="w-full h-full">
                                    <!-- Base -->
                                    <rect x="4" y="42" width="40" height="3" fill="white" rx="1"/>
                                    <!-- Foundation -->
                                    <path d="M6 42V38h36v4" fill="white" opacity="0.9"/>
                                    <!-- Columns -->
                                    <rect x="10" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <rect x="18" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <rect x="26" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <rect x="34" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <!-- Top beam -->
                                    <rect x="6" y="16" width="36" height="3" fill="white" rx="1"/>
                                    <!-- Pediment (triangle roof) -->
                                    <path d="M24 4L44 16H4L24 4Z" fill="white"/>
                                </svg>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-lg md:text-xl font-display font-bold text-thonburi-river-900 whitespace-nowrap">
                                วัฒนธรรมเขตธนบุรี
                            </h1>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1 xl:space-x-2">
                    <a href="{{ route('home') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'text-thonburi-river-500 bg-thonburi-river-50 border-b-2 border-thonburi-gold-500' : 'text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50' }}">
                        <i class="fas fa-home mr-2"></i>หน้าหลัก
                    </a>
                    <a href="{{ route('cultural.explore') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('cultural.explore') ? 'text-thonburi-river-500 bg-thonburi-river-50 border-b-2 border-thonburi-gold-500' : 'text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50' }}">
                        <i class="fas fa-compass mr-2"></i>สำรวจวัฒนธรรม
                    </a>
                    <a href="{{ route('ip.public.index') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('ip.*') ? 'text-thonburi-river-500 bg-thonburi-river-50 border-b-2 border-thonburi-gold-500' : 'text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50' }}">
                        <i class="fas fa-shield-alt mr-2"></i>ทรัพย์สินทางปัญญา
                    </a>
                    <a href="{{ route('activities') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('activities*') || request()->routeIs('activity.*') ? 'text-thonburi-river-500 bg-thonburi-river-50 border-b-2 border-thonburi-gold-500' : 'text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50' }}">
                        <i class="fas fa-calendar-alt mr-2"></i>กิจกรรม
                    </a>
                    <a href="{{ route('about') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('about') ? 'text-thonburi-river-500 bg-thonburi-river-50 border-b-2 border-thonburi-gold-500' : 'text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50' }}">
                        <i class="fas fa-info-circle mr-2"></i>เกี่ยวกับ
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-2 md:space-x-3">
                    <!-- Search Button -->
                    <button 
                        @click="searchOpen = true"
                        class="p-2 md:p-2.5 text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50 rounded-lg transition-all duration-200"
                        aria-label="Search">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <!-- User Menu (if authenticated) -->
                    @auth
                        <div class="hidden lg:block relative" x-data="{ userMenuOpen: false }">
                            <button 
                                @click="userMenuOpen = !userMenuOpen"
                                @click.away="userMenuOpen = false"
                                class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm font-medium text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50 transition-all duration-200">
                                <div class="w-8 h-8 bg-thonburi-river-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden xl:inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div 
                                x-show="userMenuOpen"
                                x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-river border border-neutral-border-light py-1"
                                style="display: none;">
                                
                                @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500">
                                        <i class="fas fa-tachometer-alt w-5"></i>
                                        <span>Admin Dashboard</span>
                                    </a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500">
                                        <i class="fas fa-chart-line w-5"></i>
                                        <span>แดชบอร์ด</span>
                                    </a>
                                @endif
                                
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500">
                                    <i class="fas fa-user w-5"></i>
                                    <span>โปรไฟล์</span>
                                </a>
                                
                                <div class="border-t border-neutral-border-light my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-thonburi-terra-600 hover:bg-thonburi-terra-50">
                                        <i class="fas fa-sign-out-alt w-5"></i>
                                        <span>ออกจากระบบ</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-4 py-2 text-sm font-medium text-thonburi-river-500 hover:text-thonburi-river-600 transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ
                        </a>
                        <a href="{{ route('register') }}" class="hidden md:inline-flex items-center px-4 py-2 bg-thonburi-gold-500 hover:bg-thonburi-gold-600 text-white text-sm font-medium rounded-lg shadow-gold transition-all duration-200 hover:shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>สมัครสมาชิก
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button 
                        @click="mobileMenuOpen = true"
                        class="lg:hidden p-2 text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50 rounded-lg transition-all duration-200"
                        aria-label="Open menu">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Menu Overlay -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        @click="mobileMenuOpen = false"
        class="fixed inset-0 bg-thonburi-river-900/50 backdrop-blur-sm z-50 lg:hidden"
        style="display: none;">
    </div>

    <!-- Mobile Menu Sidebar -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        class="fixed top-0 right-0 bottom-0 w-80 max-w-full bg-white shadow-2xl z-50 lg:hidden overflow-y-auto"
        style="display: none;">
        
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-display font-bold text-thonburi-river-900">เมนู</h2>
                <button 
                    @click="mobileMenuOpen = false"
                    class="p-2 text-neutral-text-secondary hover:text-thonburi-river-500 hover:bg-thonburi-sand-50 rounded-lg">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="space-y-1 mb-8">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('home') ? 'bg-thonburi-river-50 text-thonburi-river-500 font-semibold' : 'text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500' }}">
                    <i class="fas fa-home w-6"></i>หน้าหลัก
                </a>
                <a href="{{ route('cultural.explore') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('cultural.explore') ? 'bg-thonburi-river-50 text-thonburi-river-500 font-semibold' : 'text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500' }}">
                    <i class="fas fa-compass w-6"></i>สำรวจวัฒนธรรม
                </a>
                <a href="{{ route('ip.public.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('ip.*') ? 'bg-thonburi-river-50 text-thonburi-river-500 font-semibold' : 'text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500' }}">
                    <i class="fas fa-shield-alt w-6"></i>ทรัพย์สินทางปัญญา
                </a>
                <a href="{{ route('activities') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('activities*') ? 'bg-thonburi-river-50 text-thonburi-river-500 font-semibold' : 'text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500' }}">
                    <i class="fas fa-calendar-alt w-6"></i>กิจกรรม
                </a>
                <a href="{{ route('about') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('about') ? 'bg-thonburi-river-50 text-thonburi-river-500 font-semibold' : 'text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500' }}">
                    <i class="fas fa-info-circle w-6"></i>เกี่ยวกับ
                </a>
                <a href="{{ route('contact') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('contact') ? 'bg-thonburi-river-50 text-thonburi-river-500 font-semibold' : 'text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500' }}">
                    <i class="fas fa-envelope w-6"></i>ติดต่อเรา
                </a>
            </nav>

            @auth
                <div class="border-t border-neutral-border-light pt-6">
                    <div class="px-4 py-3 bg-thonburi-sand-50 rounded-lg mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-thonburi-river-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-neutral-text-primary">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-neutral-text-tertiary">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500">
                            <i class="fas fa-tachometer-alt w-6"></i>Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500">
                            <i class="fas fa-chart-line w-6"></i>แดชบอร์ด
                        </a>
                    @endif
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-lg text-neutral-text-secondary hover:bg-thonburi-sand-50 hover:text-thonburi-river-500">
                        <i class="fas fa-user w-6"></i>โปรไฟล์
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 rounded-lg text-thonburi-terra-600 hover:bg-thonburi-terra-50">
                            <i class="fas fa-sign-out-alt w-6"></i>ออกจากระบบ
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-neutral-border-light pt-6 space-y-3">
                    <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-3 border-2 border-thonburi-river-500 text-thonburi-river-500 hover:bg-thonburi-river-50 rounded-lg font-medium">
                        <i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-3 bg-thonburi-gold-500 hover:bg-thonburi-gold-600 text-white rounded-lg font-medium shadow-gold">
                        <i class="fas fa-user-plus mr-2"></i>สมัครสมาชิก
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Search Overlay -->
    <div 
        x-show="searchOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        @click="searchOpen = false"
        class="fixed inset-0 bg-thonburi-river-900/80 backdrop-blur-sm z-50 flex items-start justify-center pt-20 px-4"
        style="display: none;">
        
        <div 
            @click.stop
            class="w-full max-w-2xl bg-white rounded-xl shadow-2xl"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <form action="{{ route('search') }}" method="GET" class="p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-neutral-text-tertiary"></i>
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="ค้นหามรดกวัฒนธรรม, ชุมชน, กิจกรรม..." 
                            class="w-full pl-12 pr-4 py-3 border-2 border-neutral-border-light focus:border-thonburi-river-500 focus:ring-2 focus:ring-thonburi-river-200 rounded-lg transition-all duration-200 outline-none"
                            autofocus>
                    </div>
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-thonburi-gold-500 hover:bg-thonburi-gold-600 text-white font-medium rounded-lg shadow-gold transition-all duration-200 hover:shadow-lg">
                        ค้นหา
                    </button>
                </div>
                
                <div class="flex items-center justify-between text-sm text-neutral-text-tertiary">
                    <p><i class="fas fa-lightbulb mr-2"></i>เคล็ดลับ: ใช้คำสำคัญเช่น "อาหาร", "วัด", "ชุมชน"</p>
                    <button 
                        type="button"
                        @click="searchOpen = false"
                        class="text-neutral-text-secondary hover:text-thonburi-river-500">
                        <kbd class="px-2 py-1 bg-neutral-bg-secondary rounded text-xs">ESC</kbd>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Main Content Wrapper -->
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-1 mt-16 md:mt-20">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-br from-thonburi-wood-900 via-thonburi-sand-900 to-thonburi-wood-800 text-white mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                    
                    <!-- About Column -->
                    <div class="lg:col-span-1">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 via-orange-600 to-red-600 rounded-xl flex items-center justify-center shadow-lg p-2.5">
                                <svg viewBox="0 0 48 48" fill="none" class="w-full h-full">
                                    <rect x="4" y="42" width="40" height="3" fill="white" rx="1"/>
                                    <path d="M6 42V38h36v4" fill="white" opacity="0.9"/>
                                    <rect x="10" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <rect x="18" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <rect x="26" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <rect x="34" y="18" width="4" height="20" fill="white" rx="1"/>
                                    <rect x="6" y="16" width="36" height="3" fill="white" rx="1"/>
                                    <path d="M24 4L44 16H4L24 4Z" fill="white"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-display font-bold text-white">วัฒนธรรมเขตธนบุรี</h3>
                        </div>
                        <p class="text-thonburi-sand-200 text-sm leading-relaxed mb-4">
                            ฐานข้อมูลออนไลน์เพื่อการอนุรักษ์ เรียนรู้ และเผยแพร่มรดกทางวัฒนธรรมของเขตธนบุรี กรุงเทพมหานคร
                        </p>
                        <div class="flex items-center space-x-3">
                            <a href="#" class="w-9 h-9 bg-thonburi-wood-700 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 shadow-md hover:shadow-lg hover:scale-110">
                                <i class="fab fa-facebook-f text-white"></i>
                            </a>
                            <a href="#" class="w-9 h-9 bg-thonburi-wood-700 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 shadow-md hover:shadow-lg hover:scale-110">
                                <i class="fab fa-line text-white"></i>
                            </a>
                            <a href="#" class="w-9 h-9 bg-thonburi-wood-700 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 shadow-md hover:shadow-lg hover:scale-110">
                                <i class="fab fa-instagram text-white"></i>
                            </a>
                            <a href="#" class="w-9 h-9 bg-thonburi-wood-700 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 shadow-md hover:shadow-lg hover:scale-110">
                                <i class="fab fa-youtube text-white"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-white font-display font-semibold mb-4 flex items-center">
                            <i class="fas fa-link text-thonburi-gold-500 mr-2"></i>ลิงก์ด่วน
                        </h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>หน้าหลัก</a></li>
                            <li><a href="{{ route('cultural.explore') }}" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>สำรวจวัฒนธรรม</a></li>
                            <li><a href="{{ route('ip.public.index') }}" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>ทรัพย์สินทางปัญญา</a></li>
                            <li><a href="{{ route('activities') }}" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>กิจกรรม</a></li>
                            <li><a href="{{ route('about') }}" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>เกี่ยวกับเรา</a></li>
                        </ul>
                    </div>

                    <!-- Resources -->
                    <div>
                        <h4 class="text-white font-display font-semibold mb-4 flex items-center">
                            <i class="fas fa-book text-thonburi-gold-500 mr-2"></i>ทรัพยากร
                        </h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('about') }}" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>เกี่ยวกับเรา</a></li>
                            <li><a href="{{ route('contact') }}" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>ติดต่อเรา</a></li>
                            <li><a href="#" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>นโยบายความเป็นส่วนตัว</a></li>
                            <li><a href="#" class="text-thonburi-sand-200 hover:text-thonburi-gold-400 transition-all duration-300 text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-thonburi-gold-500 group-hover:translate-x-1 transition-transform"></i>เงื่อนไขการใช้งาน</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-white font-display font-semibold mb-4 flex items-center">
                            <i class="fas fa-envelope text-thonburi-gold-500 mr-2"></i>ติดต่อเรา
                        </h4>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start text-thonburi-sand-200 hover:text-thonburi-sand-100 transition-colors duration-300">
                                <i class="fas fa-map-marker-alt text-thonburi-gold-400 mr-3 mt-1 flex-shrink-0"></i>
                                <span>เขตธนบุรี<br>กรุงเทพมหานคร 10600</span>
                            </li>
                            <li class="flex items-center text-thonburi-sand-200 hover:text-thonburi-sand-100 transition-colors duration-300">
                                <i class="fas fa-phone text-thonburi-gold-400 mr-3 flex-shrink-0"></i>
                                <span>02-XXX-XXXX</span>
                            </li>
                            <li class="flex items-center text-thonburi-sand-200 hover:text-thonburi-sand-100 transition-colors duration-300">
                                <i class="fas fa-envelope text-thonburi-gold-400 mr-3 flex-shrink-0"></i>
                                <span>info@thonburi-culture.or.th</span>
                            </li>
                            <li class="flex items-center text-thonburi-sand-200 hover:text-thonburi-sand-100 transition-colors duration-300">
                                <i class="fas fa-clock text-thonburi-gold-400 mr-3 flex-shrink-0"></i>
                                <span>จันทร์-ศุกร์ 9:00-17:00 น.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-thonburi-wood-700/30 mt-12 pt-8">
                    <p class="text-thonburi-sand-300 text-sm text-center">
                        © {{ date('Y') }} Thonburi Cultural Heritage Database. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scroll to Top Button -->
    <button 
        x-show="scrolled"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        x-transition
        class="fixed bottom-6 right-6 z-40 w-12 h-12 bg-thonburi-gold-500 hover:bg-thonburi-gold-600 text-white rounded-full shadow-gold hover:shadow-lg flex items-center justify-center transition-all duration-200"
        style="display: none;">
        <i class="fas fa-chevron-up text-lg"></i>
    </button>

    @stack('scripts')
</body>
</html>