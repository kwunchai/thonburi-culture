<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'วัฒนธรรมเขตธนบุรี') - Thonburi Cultural Heritage</title>
    
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
    
    @stack('styles')
</head>
<body class="font-thai antialiased bg-thonburi-sand-50 text-gray-800">
    
    <!-- ============================================
         NAVIGATION BAR
    ============================================= -->
    <nav class="bg-white shadow-md sticky top-0 z-50 border-b-4 border-thonburi-gold-400">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <!-- Logo Icon -->
                        <div class="w-12 h-12 bg-gradient-to-br from-thonburi-gold-400 to-thonburi-gold-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-dharmachakra text-white text-2xl"></i>
                        </div>
                        <!-- Brand Text -->
                        <div class="ml-3 hidden sm:block">
                            <div class="text-xl md:text-2xl font-bold font-display bg-gradient-to-r from-thonburi-gold-600 to-thonburi-terra-600 bg-clip-text text-transparent">
                                วัฒนธรรมธนบุรี
                            </div>
                            <div class="text-xs text-gray-500 font-light">Thonburi Heritage</div>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-thonburi-gold-600 font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-thonburi-gold-600 font-semibold' : '' }}">
                        <i class="fas fa-home mr-2"></i>
                        หน้าแรก
                    </a>
                    <a href="{{ route('cultural.explore') }}" 
                       class="text-gray-700 hover:text-thonburi-gold-600 font-medium transition-colors duration-200 {{ request()->routeIs('cultural.*') ? 'text-thonburi-gold-600 font-semibold' : '' }}">
                        <i class="fas fa-compass mr-2"></i>
                        สำรวจวัฒนธรรม
                    </a>
                    <a href="{{ route('communities.index') }}" 
                       class="text-gray-700 hover:text-thonburi-gold-600 font-medium transition-colors duration-200 {{ request()->routeIs('communities.*') ? 'text-thonburi-gold-600 font-semibold' : '' }}">
                        <i class="fas fa-users mr-2"></i>
                        ชุมชน
                    </a>
                    <a href="{{ route('about') }}" 
                       class="text-gray-700 hover:text-thonburi-gold-600 font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-thonburi-gold-600 font-semibold' : '' }}">
                        <i class="fas fa-info-circle mr-2"></i>
                        เกี่ยวกับเรา
                    </a>
                </div>
                
                <!-- Search & Mobile Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Search Button -->
                    <button onclick="toggleSearch()" 
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-thonburi-sand-100 hover:bg-thonburi-gold-100 text-gray-600 hover:text-thonburi-gold-600 transition-all duration-200">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                    
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" 
                            class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg bg-thonburi-sand-100 hover:bg-thonburi-gold-100 text-gray-600 hover:text-thonburi-gold-600 transition-all duration-200">
                        <i class="fas fa-bars text-lg" id="mobile-menu-icon"></i>
                    </button>
                </div>
                
            </div>
        </div>
        
        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-200">
            <div class="container mx-auto px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-thonburi-sand-100 hover:text-thonburi-gold-600 font-medium transition-colors {{ request()->routeIs('home') ? 'bg-thonburi-gold-50 text-thonburi-gold-600' : '' }}">
                    <i class="fas fa-home mr-3 w-5"></i>
                    หน้าแรก
                </a>
                <a href="{{ route('cultural.explore') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-thonburi-sand-100 hover:text-thonburi-gold-600 font-medium transition-colors {{ request()->routeIs('cultural.*') ? 'bg-thonburi-gold-50 text-thonburi-gold-600' : '' }}">
                    <i class="fas fa-compass mr-3 w-5"></i>
                    สำรวจวัฒนธรรม
                </a>
                <a href="{{ route('communities.index') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-thonburi-sand-100 hover:text-thonburi-gold-600 font-medium transition-colors {{ request()->routeIs('communities.*') ? 'bg-thonburi-gold-50 text-thonburi-gold-600' : '' }}">
                    <i class="fas fa-users mr-3 w-5"></i>
                    ชุมชน
                </a>
                <a href="{{ route('about') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-thonburi-sand-100 hover:text-thonburi-gold-600 font-medium transition-colors {{ request()->routeIs('about') ? 'bg-thonburi-gold-50 text-thonburi-gold-600' : '' }}">
                    <i class="fas fa-info-circle mr-3 w-5"></i>
                    เกี่ยวกับเรา
                </a>
            </div>
        </div>
        
        <!-- Search Overlay -->
        <div id="search-overlay" class="hidden absolute top-full left-0 right-0 bg-white shadow-xl border-t-2 border-thonburi-gold-400">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl py-6">
                <form action="{{ route('cultural.explore') }}" method="GET" class="relative">
                    <input type="text" 
                           name="search"
                           placeholder="ค้นหาวัฒนธรรม ประเพณี สถานที่ หรือชุมชน..."
                           class="w-full px-6 py-4 pr-32 text-lg border-2 border-thonburi-sand-300 rounded-xl focus:border-thonburi-gold-500 focus:ring-4 focus:ring-thonburi-gold-100 outline-none transition-all"
                           autofocus>
                    <button type="submit" 
                            class="absolute right-2 top-2 bottom-2 px-8 bg-gradient-to-r from-thonburi-gold-500 to-thonburi-gold-600 text-white rounded-lg font-medium hover:shadow-lg transition-all">
                        <i class="fas fa-search mr-2"></i>
                        ค้นหา
                    </button>
                </form>
                
                <!-- Popular searches -->
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="text-sm text-gray-500">ยอดนิยม:</span>
                    <a href="{{ route('cultural.explore', ['search' => 'วัดอรุณ']) }}" 
                       class="px-3 py-1 bg-thonburi-sand-100 text-thonburi-gold-700 rounded-full text-sm hover:bg-thonburi-gold-100 transition-colors">
                        วัดอรุณ
                    </a>
                    <a href="{{ route('cultural.explore', ['search' => 'ขนมไทย']) }}" 
                       class="px-3 py-1 bg-thonburi-sand-100 text-thonburi-gold-700 rounded-full text-sm hover:bg-thonburi-gold-100 transition-colors">
                        ขนมไทย
                    </a>
                    <a href="{{ route('cultural.explore', ['search' => 'ตลาดน้ำ']) }}" 
                       class="px-3 py-1 bg-thonburi-sand-100 text-thonburi-gold-700 rounded-full text-sm hover:bg-thonburi-gold-100 transition-colors">
                        ตลาดน้ำ
                    </a>
                    <a href="{{ route('cultural.explore', ['search' => 'หัตถกรรม']) }}" 
                       class="px-3 py-1 bg-thonburi-sand-100 text-thonburi-gold-700 rounded-full text-sm hover:bg-thonburi-gold-100 transition-colors">
                        หัตถกรรม
                    </a>
                </div>
            </div>
        </div>
        
    </nav>
    
    <!-- ============================================
         BREADCRUMBS (if provided)
    ============================================= -->
    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
    <div class="bg-white border-b border-thonburi-sand-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-3">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-thonburi-gold-600 transition-colors">
                    <i class="fas fa-home"></i>
                </a>
                @foreach($breadcrumbs as $breadcrumb)
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    @if($loop->last)
                        <span class="text-gray-700 font-medium">{{ $breadcrumb['name'] }}</span>
                    @else
                        <a href="{{ $breadcrumb['url'] }}" class="text-gray-500 hover:text-thonburi-gold-600 transition-colors">
                            {{ $breadcrumb['name'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>
    @endif
    
    <!-- ============================================
         MAIN CONTENT
    ============================================= -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- ============================================
         FOOTER
    ============================================= -->
    <footer class="bg-thonburi-navy-900 text-white relative overflow-hidden">
        
        <!-- Decorative top border -->
        <div class="h-2 bg-gradient-to-r from-thonburi-gold-500 via-thonburi-terra-500 to-thonburi-navy-500"></div>
        
        <!-- Thai pattern overlay -->
        <div class="absolute inset-0 opacity-5 bg-thai-pattern"></div>
        
        <div class="relative z-10">
            <!-- Main footer content -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-12 lg:py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    
                    <!-- Brand Column -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-thonburi-gold-400 to-thonburi-gold-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-dharmachakra text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-2xl font-bold font-display">วัฒนธรรมธนบุรี</div>
                                <div class="text-sm text-gray-400">Thonburi Cultural Heritage</div>
                            </div>
                        </div>
                        <p class="text-gray-300 leading-relaxed mb-6 max-w-md">
                            ฐานข้อมูลมรดกทางวัฒนธรรมเขตธนบุรี เพื่อการอนุรักษ์และสืบสานภูมิปัญญาท้องถิ่น 
                            ประเพณี และเรื่องราวทางวัฒนธรรมสู่ชนรุ่นหลัง
                        </p>
                        
                        <!-- Social media -->
                        <div class="flex items-center space-x-3">
                            <a href="#" class="w-10 h-10 bg-white/10 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-facebook text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/10 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-line text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/10 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-youtube text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/10 hover:bg-thonburi-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-bold mb-4 text-thonburi-gold-400">เมนูหลัก</h4>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('home') }}" class="text-gray-300 hover:text-thonburi-gold-400 transition-colors flex items-center">
                                    <i class="fas fa-chevron-right text-xs mr-2"></i>
                                    หน้าแรก
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cultural.explore') }}" class="text-gray-300 hover:text-thonburi-gold-400 transition-colors flex items-center">
                                    <i class="fas fa-chevron-right text-xs mr-2"></i>
                                    สำรวจวัฒนธรรม
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('communities.index') }}" class="text-gray-300 hover:text-thonburi-gold-400 transition-colors flex items-center">
                                    <i class="fas fa-chevron-right text-xs mr-2"></i>
                                    ชุมชน
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}" class="text-gray-300 hover:text-thonburi-gold-400 transition-colors flex items-center">
                                    <i class="fas fa-chevron-right text-xs mr-2"></i>
                                    เกี่ยวกับเรา
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-thonburi-gold-400 transition-colors flex items-center">
                                    <i class="fas fa-chevron-right text-xs mr-2"></i>
                                    ติดต่อเรา
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-lg font-bold mb-4 text-thonburi-gold-400">ติดต่อเรา</h4>
                        <ul class="space-y-3 text-gray-300 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt text-thonburi-gold-400 mt-1 mr-3"></i>
                                <span>เขตธนบุรี<br>กรุงเทพมหานคร 10600</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone text-thonburi-gold-400 mr-3"></i>
                                <span>02-XXX-XXXX</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope text-thonburi-gold-400 mr-3"></i>
                                <span>info@thonburi-culture.go.th</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-clock text-thonburi-gold-400 mr-3"></i>
                                <span>จันทร์-ศุกร์ 08:30-16:30 น.</span>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <!-- Bottom bar -->
            <div class="border-t border-thonburi-navy-800">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-6">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="text-gray-400 text-sm text-center md:text-left">
                            &copy; {{ date('Y') }} Thonburi Cultural Heritage Database. All rights reserved.
                        </div>
                        <div class="flex items-center space-x-6 text-sm">
                            <a href="#" class="text-gray-400 hover:text-thonburi-gold-400 transition-colors">
                                นโยบายความเป็นส่วนตัว
                            </a>
                            <a href="#" class="text-gray-400 hover:text-thonburi-gold-400 transition-colors">
                                เงื่อนไขการใช้งาน
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </footer>
    
    <!-- ============================================
         SCROLL TO TOP BUTTON
    ============================================= -->
    <button id="scroll-to-top" 
            onclick="scrollToTop()"
            class="fixed bottom-8 right-8 w-12 h-12 bg-thonburi-gold-500 hover:bg-thonburi-gold-600 text-white rounded-full shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 opacity-0 pointer-events-none z-40">
        <i class="fas fa-arrow-up text-lg"></i>
    </button>
    
    <!-- ============================================
         JAVASCRIPT
    ============================================= -->
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
        
        // Search overlay toggle
        function toggleSearch() {
            const overlay = document.getElementById('search-overlay');
            overlay.classList.toggle('hidden');
            
            if (!overlay.classList.contains('hidden')) {
                const input = overlay.querySelector('input');
                setTimeout(() => input.focus(), 100);
            }
        }
        
        // Close search on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.getElementById('search-overlay').classList.add('hidden');
            }
        });
        
        // Scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Show/hide scroll to top button
        window.addEventListener('scroll', () => {
            const scrollBtn = document.getElementById('scroll-to-top');
            if (window.pageYOffset > 300) {
                scrollBtn.classList.remove('opacity-0', 'pointer-events-none');
                scrollBtn.classList.add('opacity-100');
            } else {
                scrollBtn.classList.add('opacity-0', 'pointer-events-none');
                scrollBtn.classList.remove('opacity-100');
            }
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            const menu = document.getElementById('mobile-menu');
            const menuBtn = e.target.closest('[onclick="toggleMobileMenu()"]');
            
            if (!menu.contains(e.target) && !menuBtn && !menu.classList.contains('hidden')) {
                toggleMobileMenu();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
