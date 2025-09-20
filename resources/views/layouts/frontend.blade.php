<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'หน้าแรก') - วัฒนธรรมเขตธนบุรี</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600">หน้าแรก</a>
                    <a href="#" class="text-gray-700 hover:text-orange-600">แผนที่วัฒนธรรม</a>
                    <a href="#" class="text-gray-700 hover:text-orange-600">บทความ</a>
                    <a href="#" class="text-gray-700 hover:text-orange-600">กิจกรรม</a>
                    <a href="#" class="text-gray-700 hover:text-orange-600">เกี่ยวกับ</a>
                    <a href="#" class="text-gray-700 hover:text-orange-600">ค้นหา</a>
                    
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-orange-600">
                            จัดการระบบ
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-orange-600">
                                ออกจากระบบ
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                            เข้าสู่ระบบ
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} วัฒนธรรมเขตธนบุรี. สงวนลิขสิทธิ์.</p>
        </div>
    </footer>
</body>
</html>