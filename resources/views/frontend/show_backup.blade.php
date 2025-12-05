@extends('layouts.frontend')

@section('title', $item->title)

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
<meta property="og:title" content="{{ $item->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
@if($item->image)
<meta property="og:image" content="{{ asset('storage/' . $item->image) }}">
@endif
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
    <!-- Modern Breadcrumb with Glassmorphism -->
    <nav class="bg-gradient-to-r from-slate-50 to-gray-50 backdrop-blur-sm border-b border-white/20 py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center space-x-3 text-sm">
                <a href="{{ route('home') }}" 
                   class="flex items-center space-x-2 px-3 py-2 rounded-full bg-white/60 backdrop-blur-sm text-gray-600 hover:text-orange-600 hover:bg-white/80 transition-all duration-300 shadow-sm">
                    <i class="fas fa-home text-xs"></i>
                    <span class="font-medium">หน้าแรก</span>
                </a>
                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-orange-400 to-red-400 opacity-60"></div>
                
                <a href="{{ route('cultural.explore') }}" 
                   class="flex items-center space-x-2 px-3 py-2 rounded-full bg-white/60 backdrop-blur-sm text-gray-600 hover:text-orange-600 hover:bg-white/80 transition-all duration-300 shadow-sm">
                    <i class="fas fa-compass text-xs"></i>
                    <span class="font-medium">สำรวจวัฒนธรรม</span>
                </a>
                
                @if($item->category)
                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-orange-400 to-red-400 opacity-60"></div>
                <a href="{{ route('category', $item->category->slug) }}" 
                   class="flex items-center space-x-2 px-3 py-2 rounded-full bg-gradient-to-r from-orange-100 to-red-100 text-orange-700 hover:from-orange-200 hover:to-red-200 transition-all duration-300 shadow-sm backdrop-blur-sm">
                    <i class="fas fa-tag text-xs"></i>
                    <span class="font-semibold">{{ $item->category->name }}</span>
                </a>
                @endif
                
                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-orange-400 to-red-400"></div>
                <span class="px-4 py-2 rounded-full bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold shadow-lg">
                    {{ Str::limit($item->title, 40) }}
                </span>
            </div>
        </div>
    </nav>

    <!-- Ultra-Modern Hero Section -->
    <div class="relative">
        <!-- Main Content Container -->
        <div class="max-w-7xl mx-auto">
            <!-- Hero Section with Advanced Design -->
            @if($item->image)
                <div class="relative h-[80vh] min-h-[600px] overflow-hidden rounded-b-3xl shadow-2xl">
                    <!-- Multi-layer Background -->
                    <div class="absolute inset-0">
                        <!-- Main Image with Parallax Effect -->
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->title }}" 
                             class="absolute inset-0 w-full h-full object-cover transform scale-110 group-hover:scale-115 transition-transform duration-[3000ms] ease-out parallax-image"
                             loading="lazy">
                        
                        <!-- Advanced Gradient Overlays -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-black/40"></div>
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-orange-900/20"></div>
                        
                        <!-- Animated Gradient Mesh -->
                        <div class="absolute inset-0 opacity-30">
                            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-orange-600/20 via-transparent to-red-600/20 animate-pulse"></div>
                        </div>
                    </div>

                    <!-- Floating Content Container -->
                    <div class="relative h-full flex items-end p-8 md:p-12 lg:p-16">
                        <div class="w-full max-w-5xl space-y-8">
                            
                            <!-- Floating Meta Badges with Glassmorphism -->
                            <div class="flex flex-wrap items-center gap-4 mb-8">
                                @if($item->category)
                                <div class="group cursor-pointer">
                                    <div class="px-6 py-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-red-500 flex items-center justify-center shadow-lg">
                                                <i class="fas fa-folder text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white/70 text-xs font-medium uppercase tracking-wider">หมวดหมู่</p>
                                                <p class="text-white font-bold text-sm">{{ $item->category->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($item->community)
                                <div class="group cursor-pointer">
                                    <div class="px-6 py-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center shadow-lg">
                                                <i class="fas fa-map-marker-alt text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white/70 text-xs font-medium uppercase tracking-wider">ชุมชน</p>
                                                <p class="text-white font-bold text-sm">{{ $item->community->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="group cursor-pointer">
                                    <div class="px-6 py-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center shadow-lg">
                                                <i class="fas fa-calendar-alt text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white/70 text-xs font-medium uppercase tracking-wider">วันที่</p>
                                                <p class="text-white font-bold text-sm">{{ $item->publish_date->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($item->creator)
                                <div class="group cursor-pointer">
                                    <div class="px-6 py-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl hover:bg-white/20 transition-all duration-500 transform hover:scale-105 hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-pink-500 flex items-center justify-center shadow-lg">
                                                <i class="fas fa-user text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white/70 text-xs font-medium uppercase tracking-wider">ผู้เผยแพร่</p>
                                                <p class="text-white font-bold text-sm">{{ $item->creator->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Hero Title with Advanced Typography -->
                            <div class="space-y-6">
                                <h1 class="text-4xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-[0.9] tracking-tight">
                                    <span class="block bg-gradient-to-r from-white via-white to-orange-200 bg-clip-text text-transparent drop-shadow-2xl">
                                        {{ $item->title }}
                                    </span>
                                </h1>
                                
                                <!-- Subtitle with Glassmorphism -->
                                <div class="max-w-4xl">
                                    <p class="text-lg md:text-xl lg:text-2xl text-white/90 leading-relaxed font-light backdrop-blur-sm bg-black/20 rounded-2xl p-6 border border-white/10">
                                        {{ Str::limit(strip_tags($item->description), 200) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Animated Scroll Indicator -->
                    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
                        <div class="flex flex-col items-center space-y-2 animate-bounce">
                            <div class="w-8 h-12 border-2 border-white/40 rounded-full flex justify-center">
                                <div class="w-1 h-3 bg-white rounded-full mt-2 animate-pulse"></div>
                            </div>
                            <p class="text-white/60 text-xs font-medium uppercase tracking-widest">เลื่อนลง</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Image Hero with Modern Design -->
                <div class="relative h-[70vh] min-h-[500px] overflow-hidden rounded-b-3xl shadow-2xl">
                    <!-- Animated Gradient Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-400 via-red-500 to-pink-600"></div>
                    <div class="absolute inset-0 bg-gradient-to-tl from-purple-600/40 via-transparent to-blue-600/40"></div>
                    
                    <!-- Animated Mesh Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <defs>
                                <pattern id="mesh" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <circle cx="10" cy="10" r="1" fill="white" opacity="0.3"/>
                                </pattern>
                            </defs>
                            <rect width="100" height="100" fill="url(#mesh)"/>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative h-full flex items-center justify-center p-8 md:p-12 lg:p-16">
                        <div class="text-center space-y-8 max-w-5xl">
                            <!-- Icon with Animation -->
                            <div class="relative">
                                <div class="w-32 h-32 mx-auto bg-white/20 backdrop-blur-xl rounded-3xl flex items-center justify-center shadow-2xl border border-white/30">
                                    <i class="fas fa-image text-white text-5xl opacity-80"></i>
                                </div>
                                <!-- Floating Particles -->
                                <div class="absolute -top-4 -right-4 w-6 h-6 bg-white/30 rounded-full animate-ping"></div>
                                <div class="absolute -bottom-4 -left-4 w-4 h-4 bg-white/40 rounded-full animate-bounce delay-300"></div>
                            </div>
                            
                            <!-- Title -->
                            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-[0.9] tracking-tight">
                                <span class="block bg-gradient-to-r from-white via-white to-orange-200 bg-clip-text text-transparent drop-shadow-2xl">
                                    {{ $item->title }}
                                </span>
                            </h1>
                            
                            <!-- Meta Badges -->
                            <div class="flex flex-wrap justify-center gap-4">
                                @if($item->category)
                                <div class="px-6 py-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-folder text-white"></i>
                                        <span class="text-white font-semibold">{{ $item->category->name }}</span>
                                    </div>
                                </div>
                                @endif
                                
                                @if($item->community)
                                <div class="px-6 py-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                        <span class="text-white font-semibold">{{ $item->community->name }}</span>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="px-6 py-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-xl">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar-alt text-white"></i>
                                        <span class="text-white font-semibold">{{ $item->publish_date->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="max-w-3xl mx-auto">
                                <p class="text-lg md:text-xl text-white/90 leading-relaxed font-light backdrop-blur-sm bg-black/20 rounded-2xl p-6 border border-white/10">
                                    {{ Str::limit(strip_tags($item->description), 200) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Spacer with Gradient -->
            <div class="h-20 bg-gradient-to-b from-transparent to-gray-50"></div>

            <!-- Main Content Section with Modern Layout -->
            <div class="px-4 md:px-6 lg:px-8 space-y-16">
                
                <!-- Modern Meta Data Dashboard -->
                <section class="max-w-6xl mx-auto">
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-100/50 overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-info-circle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">ข้อมูลรายละเอียด</h2>
                                    <p class="text-white/80 text-sm">รายละเอียดเพิ่มเติมเกี่ยวกับวัฒนธรรมนี้</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content Grid -->
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @if($item->category)
                                <div class="group hover:scale-105 transition-all duration-300 cursor-pointer">
                                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200/50 shadow-lg hover:shadow-xl">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-r from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas fa-folder text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-semibold text-orange-600 uppercase tracking-wider mb-1">หมวดหมู่</p>
                                                <a href="{{ route('category', $item->category->slug) }}" 
                                                   class="font-bold text-gray-800 text-lg hover:text-orange-600 transition-colors duration-300 leading-tight">
                                                    {{ $item->category->name }}
                                                </a>
                                                <div class="mt-2 flex items-center text-orange-600">
                                                    <span class="text-xs font-medium">ดูทั้งหมด</span>
                                                    <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($item->community)
                                <div class="group hover:scale-105 transition-all duration-300 cursor-pointer">
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200/50 shadow-lg hover:shadow-xl">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas fa-map-marker-alt text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">ชุมชน</p>
                                                <p class="font-bold text-gray-800 text-lg leading-tight">{{ $item->community->name }}</p>
                                                <div class="mt-2 flex items-center text-blue-600">
                                                    <span class="text-xs font-medium">ข้อมูลชุมชน</span>
                                                    <i class="fas fa-info-circle ml-1 text-xs"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="group hover:scale-105 transition-all duration-300 cursor-pointer">
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border border-green-200/50 shadow-lg hover:shadow-xl">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-r from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas fa-calendar-alt text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-1">วันที่เผยแพร่</p>
                                                <p class="font-bold text-gray-800 text-lg leading-tight">{{ $item->publish_date->format('d/m/Y') }}</p>
                                                <div class="mt-2 flex items-center text-green-600">
                                                    <span class="text-xs font-medium">{{ $item->publish_date->diffForHumans() }}</span>
                                                    <i class="fas fa-clock ml-1 text-xs"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($item->creator)
                                <div class="group hover:scale-105 transition-all duration-300 cursor-pointer">
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200/50 shadow-lg hover:shadow-xl">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas fa-user text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider mb-1">ผู้เผยแพร่</p>
                                                <p class="font-bold text-gray-800 text-lg leading-tight">{{ $item->creator->name }}</p>
                                                <div class="mt-2 flex items-center text-purple-600">
                                                    <span class="text-xs font-medium">ผู้สร้างสรรค์</span>
                                                    <i class="fas fa-star ml-1 text-xs"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($item->place)
                                <div class="group hover:scale-105 transition-all duration-300 cursor-pointer">
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200/50 shadow-lg hover:shadow-xl">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-r from-gray-400 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas fa-building text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">สถานที่</p>
                                                <p class="font-bold text-gray-800 text-lg leading-tight">{{ $item->place->name }}</p>
                                                <div class="mt-2 flex items-center text-gray-600">
                                                    <span class="text-xs font-medium">ตำแหน่งที่ตั้ง</span>
                                                    <i class="fas fa-map ml-1 text-xs"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Modern Article Content -->
                <article class="max-w-4xl mx-auto">
                    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-100/50 overflow-hidden">
                        <!-- Article Header -->
                        <div class="bg-gradient-to-r from-slate-50 to-gray-50 p-8 border-b border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-book-open text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-800 mb-2">เนื้อหาหลัก</h2>
                                    <p class="text-gray-600">รายละเอียดและข้อมูลครบถ้วนเกี่ยวกับวัฒนธรรมนี้</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Article Body with Modern Typography -->
                        <div class="p-8 md:p-12">
                            <div class="prose prose-xl max-w-none" id="article-content">
                                <div class="text-gray-800 leading-relaxed space-y-6">
                                    {!! nl2br(e($item->description)) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Social Share Section -->
                        <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-8 border-t border-gray-100">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                                <!-- Share Header -->
                                <div class="space-y-3">
                                    <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-share-alt text-white"></i>
                                        </div>
                                        แบ่งปันความรู้
                                    </h3>
                                    <p class="text-gray-600">ช่วยเผยแพร่วัฒนธรรมไทยให้คนรุ่นใหม่ได้รู้จัก</p>
                                </div>
                                
                                <!-- Social Buttons Grid -->
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                       target="_blank"
                                       class="group flex flex-col items-center p-4 bg-white rounded-2xl shadow-lg hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 hover:scale-105">
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fab fa-facebook-f text-white text-lg"></i>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Facebook</span>
                                    </a>
                                    
                                    <!-- Twitter -->
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($item->title) }}" 
                                       target="_blank"
                                       class="group flex flex-col items-center p-4 bg-white rounded-2xl shadow-lg hover:shadow-xl border border-gray-100 hover:border-sky-200 transition-all duration-300 hover:scale-105">
                                        <div class="w-12 h-12 bg-gradient-to-r from-sky-400 to-sky-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fab fa-twitter text-white text-lg"></i>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-sky-600 transition-colors">Twitter</span>
                                    </a>
                                    
                                    <!-- LINE -->
                                    <a href="https://line.me/R/msg/text/?{{ urlencode($item->title . ' ' . request()->url()) }}" 
                                       target="_blank"
                                       class="group flex flex-col items-center p-4 bg-white rounded-2xl shadow-lg hover:shadow-xl border border-gray-100 hover:border-green-200 transition-all duration-300 hover:scale-105">
                                        <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fab fa-line text-white text-lg"></i>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-green-600 transition-colors">LINE</span>
                                    </a>
                                    
                                    <!-- Native Share -->
                                    <button onclick="navigator.share({title: '{{ $item->title }}', url: '{{ request()->url() }}'})" 
                                            class="group flex flex-col items-center p-4 bg-white rounded-2xl shadow-lg hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-300 hover:scale-105">
                                        <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-share text-white text-lg"></i>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-orange-600 transition-colors">แชร์</span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Quick Navigation -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('cultural.explore') }}" 
                                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-2xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold transform hover:scale-105">
                                        <i class="fas fa-search mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                                        สำรวจเพิ่มเติม
                                    </a>
                                    
                                    @if($item->category)
                                    <a href="{{ route('category', $item->category->slug) }}" 
                                       class="group inline-flex items-center px-6 py-3 bg-white border-2 border-orange-200 text-orange-700 rounded-2xl hover:bg-orange-50 hover:border-orange-300 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold transform hover:scale-105">
                                        <i class="fas fa-layer-group mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                                        หมวด{{ $item->category->name }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Google Maps Section with Modern Design -->
                @if($item->latitude && $item->longitude)
                <section class="max-w-6xl mx-auto">
                    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-100/50 overflow-hidden">
                        <!-- Maps Header -->
                        <div class="bg-gradient-to-r from-red-500 to-pink-500 p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-map-marked-alt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-white">ตำแหน่งที่ตั้ง</h2>
                                        <p class="text-white/80 text-sm">พิกัดและแผนที่แบบ Interactive</p>
                                    </div>
                                </div>
                                
                                <!-- Coordinates Display -->
                                <div class="hidden md:flex space-x-4">
                                    <div class="bg-white/20 backdrop-blur-xl rounded-xl px-4 py-2">
                                        <p class="text-white/70 text-xs font-medium">ละติจูด</p>
                                        <p class="text-white font-bold">{{ number_format($item->latitude, 6) }}</p>
                                    </div>
                                    <div class="bg-white/20 backdrop-blur-xl rounded-xl px-4 py-2">
                                        <p class="text-white/70 text-xs font-medium">ลองจิจูด</p>
                                        <p class="text-white font-bold">{{ number_format($item->longitude, 6) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Interactive Map -->
                        <div class="relative">
                            <div id="map" class="h-96 bg-gray-100"></div>
                            <!-- Map Controls Overlay -->
                            <div class="absolute bottom-4 right-4 flex flex-col space-y-2">
                                <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                   target="_blank" 
                                   class="bg-white/90 backdrop-blur-xl rounded-xl px-4 py-3 shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-300 group">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-external-link-alt text-red-500 group-hover:scale-110 transition-transform duration-300"></i>
                                        <span class="text-sm font-semibold text-gray-700">เปิดใน Google Maps</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Modern Related Items Section -->
                @if($relatedItems->count() > 0)
                <section class="max-w-7xl mx-auto">
                    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-100/50 overflow-hidden">
                        <!-- Related Items Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-8">
                            <div class="text-center space-y-4">
                                <div class="w-20 h-20 bg-white/20 backdrop-blur-xl rounded-3xl flex items-center justify-center mx-auto">
                                    <i class="fas fa-heart text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">รายการที่เกี่ยวข้อง</h2>
                                    <p class="text-white/80 text-lg">สำรวจวัฒนธรรมอื่นๆ ที่น่าสนใจและเกี่ยวข้องกัน</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Related Items Grid -->
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($relatedItems as $related)
                                <div class="group hover:scale-105 transition-all duration-500">
                                    <a href="{{ route('cultural-item.show', $related->id) }}" 
                                       class="block bg-white rounded-3xl shadow-lg hover:shadow-2xl border border-gray-100 hover:border-purple-200 overflow-hidden transition-all duration-500">
                                        
                                        <!-- Card Image -->
                                        <div class="relative h-56 overflow-hidden">
                                            @if($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}" 
                                                 alt="{{ $related->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                                 loading="lazy">
                                            <!-- Gradient Overlay -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                            @else
                                            <div class="w-full h-full bg-gradient-to-br from-purple-100 to-indigo-200 flex items-center justify-center group-hover:from-purple-200 group-hover:to-indigo-300 transition-colors duration-500">
                                                <i class="fas fa-image text-purple-400 text-5xl opacity-60"></i>
                                            </div>
                                            @endif
                                            
                                            <!-- Category Badge -->
                                            @if($related->category)
                                            <div class="absolute top-4 left-4">
                                                <span class="px-3 py-2 bg-white/90 backdrop-blur-sm text-purple-700 text-xs font-bold rounded-full shadow-lg border border-purple-200">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $related->category->name }}
                                                </span>
                                            </div>
                                            @endif
                                            
                                            <!-- Read More Icon -->
                                            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                                <div class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-arrow-right text-purple-600 group-hover:translate-x-1 transition-transform duration-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Content -->
                                        <div class="p-6 space-y-4">
                                            <h3 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300 line-clamp-2 leading-tight">
                                                {{ $related->title }}
                                            </h3>
                                            
                                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                                                {{ Str::limit(strip_tags($related->description), 120) }}
                                            </p>
                                            
                                            <!-- Card Meta -->
                                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                                <div class="flex items-center space-x-3">
                                                    @if($related->community)
                                                    <div class="flex items-center space-x-1 text-xs text-gray-500">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span>{{ Str::limit($related->community->name, 15) }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                
                                                <div class="text-xs text-gray-500 flex items-center space-x-1">
                                                    <i class="fas fa-calendar"></i>
                                                    <span>{{ $related->publish_date->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Explore More Section -->
                            <div class="mt-12 text-center space-y-6">
                                <div class="w-16 h-1 bg-gradient-to-r from-purple-400 to-indigo-500 rounded-full mx-auto"></div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">สำรวจเพิ่มเติม</h3>
                                    <p class="text-gray-600 mb-6">ค้นพบวัฒนธรรมไทยที่ยังรออยู่</p>
                                    
                                    <a href="{{ route('cultural.explore') }}" 
                                       class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-2xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 shadow-xl hover:shadow-2xl font-bold text-lg transform hover:scale-105">
                                        <i class="fas fa-compass mr-3 group-hover:rotate-180 transition-transform duration-500"></i>
                                        <span>สำรวจวัฒนธรรมทั้งหมด</span>
                                        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform duration-300"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@if($item->latitude && $item->longitude)
<script>
let map;
let marker;

function initMap() {
    // Modern map styling
    const mapStyles = [
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry",
            "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#ffffff"}, {"lightness": 17}]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [{"color": "#ffffff"}, {"lightness": 18}]
        },
        {
            "featureType": "road.local",
            "elementType": "geometry",
            "stylers": [{"color": "#ffffff"}, {"lightness": 16}]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{"color": "#dedede"}, {"lightness": 21}]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]
        },
        {
            "elementType": "labels.icon",
            "stylers": [{"visibility": "off"}]
        },
        {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [{"color": "#f2f2f2"}, {"lightness": 19}]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#fefefe"}, {"lightness": 20}]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]
        }
    ];

    // Initialize map
    const mapCenter = {
        lat: {{ $item->latitude }},
        lng: {{ $item->longitude }}
    };

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: mapCenter,
        styles: mapStyles,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: true,
        rotateControl: false,
        fullscreenControl: true,
        gestureHandling: 'cooperative',
        backgroundColor: '#f8f9fa'
    });

    // Custom marker icon
    const customIcon = {
        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
            <svg width="40" height="50" viewBox="0 0 40 50" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="markerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#ef4444;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#dc2626;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M20 0C9 0 0 9 0 20c0 15 20 30 20 30s20-15 20-30C40 9 31 0 20 0z" fill="url(#markerGradient)" stroke="#ffffff" stroke-width="2"/>
                <circle cx="20" cy="20" r="8" fill="#ffffff"/>
                <circle cx="20" cy="20" r="4" fill="#ef4444"/>
            </svg>
        `),
        scaledSize: new google.maps.Size(40, 50),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(20, 50)
    };

    // Add marker
    marker = new google.maps.Marker({
        position: mapCenter,
        map: map,
        title: '{{ $item->title }}',
        icon: customIcon,
        animation: google.maps.Animation.DROP
    });

    // Info window with modern styling
    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div class="p-4 min-w-[250px]">
                <div class="text-center space-y-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-map-marker-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2 leading-tight">{{ $item->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->description, 80) }}</p>
                        
                        <div class="space-y-2 text-xs text-gray-500">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-location-dot"></i>
                                <span>{{ number_format($item->latitude, 6) }}, {{ number_format($item->longitude, 6) }}</span>
                            </div>
                            @if($item->community)
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span>{{ $item->community->name }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-gray-200">
                            <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                               target="_blank" 
                               class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg hover:from-red-600 hover:to-pink-600 transition-all duration-300 text-sm font-medium shadow-md">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                เปิดใน Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `,
        pixelOffset: new google.maps.Size(0, -10)
    });

    // Show info window on marker click
    marker.addListener('click', () => {
        infoWindow.open(map, marker);
    });

    // Auto-open info window after a delay
    setTimeout(() => {
        infoWindow.open(map, marker);
    }, 1000);

    // Smooth zoom animation on load
    let currentZoom = 10;
    const targetZoom = 15;
    const zoomInterval = setInterval(() => {
        if (currentZoom < targetZoom) {
            currentZoom++;
            map.setZoom(currentZoom);
        } else {
            clearInterval(zoomInterval);
        }
    }, 200);
}

// Load Google Maps API
window.initMap = initMap;
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.google_api_key') }}&callback=initMap&libraries=geometry"></script>
@endif

<!-- Enhanced Social Sharing -->
<script>
// Modern native sharing with fallback
function enhancedShare() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $item->title }}',
            text: '{{ Str::limit(strip_tags($item->description), 100) }}',
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300';
            toast.innerHTML = '<i class="fas fa-check mr-2"></i>ลิงก์ถูกคัดลอกแล้ว!';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 2000);
        });
    }
}

// Social sharing tracking
function trackSocialShare(platform) {
    if (typeof gtag !== 'undefined') {
        gtag('event', 'share', {
            'method': platform,
            'content_type': 'cultural_item',
            'item_id': '{{ $item->id }}'
        });
    }
}

// Smooth scroll for anchored links
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe sections for animation
    document.querySelectorAll('.bg-white\\/90, .bg-white').forEach(section => {
        observer.observe(section);
    });
});
</script>

<!-- Custom CSS for animations -->
<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

/* Smooth transitions for all interactive elements */
* {
    scroll-behavior: smooth;
}

/* Enhanced backdrop blur support */
@supports (backdrop-filter: blur(20px)) {
    .backdrop-blur-xl {
        backdrop-filter: blur(20px);
    }
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
}

/* Custom scrollbar styling */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #ef4444, #dc2626);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #dc2626, #b91c1c);
}

/* Print styles */
@media print {
    .bg-gradient-to-r,
    .bg-gradient-to-br,
    .backdrop-blur-xl,
    .shadow-2xl {
        background: white !important;
        box-shadow: none !important;
        backdrop-filter: none !important;
    }
    
    .text-white {
        color: black !important;
    }
}

.hero-zoom {
    transition: transform 0.7s ease-in-out;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.prose {
    color: #374151;
    line-height: 1.75;
}

.prose p {
    margin-bottom: 1.25em;
}

.prose h1, .prose h2, .prose h3 {
    color: #111827;
    font-weight: 700;
    margin-top: 1.5em;
    margin-bottom: 0.5em;
}

.prose ul, .prose ol {
    margin: 1.25em 0;
    padding-left: 1.625em;
}

.prose blockquote {
    border-left: 4px solid #f97316;
    padding-left: 1rem;
    font-style: italic;
    color: #6b7280;
    margin: 1.5em 0;
}
</style>
@endpush