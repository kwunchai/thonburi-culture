<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'หน้าแรก') - วัฒนธรรมเขตธนบุรี</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Styles Stack --}}
    @stack('styles')
    
    <style>
        body { font-family: 'Sarabun', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-dharmachakra text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-orange-600">วัฒนธรรมเขตธนบุรี</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">หน้าแรก</a>
                    <a href="{{ route('cultural.explore') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">สำรวจวัฒนธรรม</a>
                    <a href="{{ route('activities') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">กิจกรรม</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">เกี่ยวกับเรา</a>
                    
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">
                            จัดการระบบ
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">
                                ออกจากระบบ
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-300">
                            เข้าสู่ระบบ
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-orange-600 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-3 space-y-3">
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 px-3 py-2 rounded-lg transition-colors">
                    <i class="fas fa-home mr-2"></i>หน้าแรก
                </a>
                <a href="{{ route('cultural.explore') }}" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 px-3 py-2 rounded-lg transition-colors">
                    <i class="fas fa-compass mr-2"></i>สำรวจวัฒนธรรม
                </a>
                <a href="{{ route('activities') }}" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 px-3 py-2 rounded-lg transition-colors">
                    <i class="fas fa-calendar-alt mr-2"></i>กิจกรรม
                </a>
                <a href="{{ route('about') }}" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 px-3 py-2 rounded-lg transition-colors">
                    <i class="fas fa-info-circle mr-2"></i>เกี่ยวกับเรา
                </a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 px-3 py-2 rounded-lg transition-colors">
                        <i class="fas fa-cog mr-2"></i>จัดการระบบ
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-orange-600 hover:bg-orange-50 px-3 py-2 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>ออกจากระบบ
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        เข้าสู่ระบบ
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Main Footer Content -->
            <div class="py-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Brand and Mission -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Brand and Mission</h4>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">
                        ระบบจัดการข้อมูลทางวัฒนธรรมเขตธนบุรี เพื่อการอนุรักษ์และส่งเสริมมรดกทางวัฒนธรรม นวัตกรรม งานวิจัย และทรัพย์สินทางปัญญาของท้องถิ่นให้คงอยู่สู่อนาคต
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold text-orange-400 mb-4 flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        ลิงก์ด่วน
                    </h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-300 hover:text-orange-400 transition-colors duration-300 flex items-center text-sm">
                                <i class="fas fa-home text-gray-400 mr-2 w-4"></i>
                                หน้าแรก
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cultural.explore') }}" class="text-gray-300 hover:text-orange-400 transition-colors duration-300 flex items-center text-sm">
                                <i class="fas fa-compass text-gray-400 mr-2 w-4"></i>
                                สำรวจวัฒนธรรม
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-gray-300 hover:text-orange-400 transition-colors duration-300 flex items-center text-sm">
                                <i class="fas fa-graduation-cap text-gray-400 mr-2 w-4"></i>
                                เกี่ยวกับเรา
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="text-gray-300 hover:text-orange-400 transition-colors duration-300 flex items-center text-sm">
                                <i class="fas fa-phone text-gray-400 mr-2 w-4"></i>
                                ติดต่อเรา
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold text-orange-400 mb-4 flex items-center">
                        <i class="fas fa-address-book mr-2"></i>
                        ติดต่อเรา
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start text-sm">
                            <i class="fas fa-map-marker-alt text-orange-400 mr-2 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-300">111 ถนนไอราวดี แขวงธนบุรี เขตธนบุรี กรุงเทพมหานคร 10600</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-phone text-orange-400 mr-2 flex-shrink-0"></i>
                            <span class="text-gray-300">02-422-2222</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-envelope text-orange-400 mr-2 flex-shrink-0"></i>
                            <span class="text-gray-300">info@thonburi.go.th</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-clock text-orange-400 mr-2 flex-shrink-0"></i>
                            <span class="text-gray-300">จันทร์ - ศุกร์ (08:30-16:30 น.)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-700 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Social Media Icons -->
                    <div class="flex space-x-4 mb-4 md:mb-0">
                        <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors duration-300">
                            <i class="fab fa-facebook-f text-white text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-blue-400 rounded-full flex items-center justify-center transition-colors duration-300">
                            <i class="fab fa-twitter text-white text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors duration-300">
                            <i class="fab fa-youtube text-white text-sm"></i>
                        </a>
                    </div>

                    <!-- Copyright -->
                    <div class="text-gray-400 text-sm text-center md:text-right">
                        <p>&copy; 2025 บ้านทามาเชอธนบุรี สงวนลิขสิทธิ์</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts Stack --}}
    @stack('scripts')
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    
                    // Toggle icon
                    const icon = this.querySelector('i');
                    if (mobileMenu.classList.contains('hidden')) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    } else {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    }
                });
            }
        });
    </script>
</body>
</html>