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
    <!-- Full-Screen Hero Section with Cinematic Layout -->
    <div class="relative min-h-screen overflow-hidden">
        <!-- Dynamic Background with Parallax -->
        <div class="absolute inset-0 z-0">
            @if($item->image)
            <div class="relative h-full w-full">
                <img src="{{ asset('storage/' . $item->image) }}" 
                     alt="{{ $item->title }}" 
                     class="w-full h-full object-cover scale-110 transition-transform duration-[20s] ease-out"
                     id="hero-bg">
                <!-- Cinematic Overlays -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-red-900/30 via-transparent to-orange-900/30"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/70"></div>
                <!-- Noise Texture for Film Effect -->
                <div class="absolute inset-0 opacity-10 bg-noise"></div>
            </div>
            @else
            <div class="h-full w-full bg-gradient-to-br from-slate-900 via-red-900 to-orange-900 relative">
                <div class="absolute inset-0 bg-noise opacity-20"></div>
            </div>
            @endif
        </div>

        <!-- Floating Navigation Bar -->
        <nav class="absolute top-0 left-0 right-0 z-50 pt-6">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex items-center justify-between">
                    <!-- Left Navigation -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('home') }}" 
                           class="group flex items-center space-x-2 px-5 py-3 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 text-white hover:bg-white/20 transition-all duration-500 shadow-lg">
                            <i class="fas fa-home text-sm group-hover:scale-125 transition-transform duration-300"></i>
                            <span class="font-semibold hidden sm:block">หน้าแรก</span>
                        </a>
                        
                        <div class="w-2 h-2 rounded-full bg-gradient-to-r from-orange-400 to-red-400 animate-pulse"></div>
                        
                        <a href="{{ route('cultural.explore') }}" 
                           class="group flex items-center space-x-2 px-5 py-3 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 text-white hover:bg-white/20 transition-all duration-500 shadow-lg">
                            <i class="fas fa-compass text-sm group-hover:rotate-180 transition-transform duration-700"></i>
                            <span class="font-semibold hidden sm:block">สำรวจ</span>
                        </a>
                        
                        @if($item->category)
                        <div class="w-2 h-2 rounded-full bg-gradient-to-r from-orange-400 to-red-400 animate-pulse"></div>
                        <a href="{{ route('category', $item->category->slug) }}" 
                           class="group flex items-center space-x-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-orange-500/80 to-red-500/80 backdrop-blur-xl border border-orange-300/40 text-white hover:from-orange-400/90 hover:to-red-400/90 transition-all duration-500 shadow-xl">
                            <i class="fas fa-tag text-sm group-hover:scale-125 transition-transform duration-300"></i>
                            <span class="font-bold">{{ $item->category->name }}</span>
                        </a>
                        @endif
                    </div>

                    <!-- Right Actions -->
                    <div class="flex items-center space-x-3">
                        <button onclick="window.history.back()" 
                                class="group p-4 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 text-white hover:bg-white/20 transition-all duration-500 shadow-lg">
                            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-2 transition-transform duration-300"></i>
                        </button>
                        
                        <button onclick="enhancedShare()" 
                                class="group p-4 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 text-white hover:bg-white/20 transition-all duration-500 shadow-lg">
                            <i class="fas fa-share-alt text-sm group-hover:scale-125 transition-transform duration-300"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Hero Content -->
        <div class="relative z-40 flex items-center justify-center min-h-screen px-6">
            <div class="max-w-6xl mx-auto text-center space-y-12">
                <!-- Category Badge with Premium Design -->
                @if($item->category)
                <div class="inline-flex items-center px-8 py-4 rounded-full bg-gradient-to-r from-orange-500/90 to-red-500/90 backdrop-blur-xl border border-orange-300/60 shadow-2xl animate-fade-in-up">
                    <div class="w-3 h-3 rounded-full bg-white/80 mr-4 animate-pulse"></div>
                    <span class="text-white font-bold text-xl tracking-wide">{{ $item->category->name }}</span>
                    <div class="w-3 h-3 rounded-full bg-white/80 ml-4 animate-pulse"></div>
                </div>
                @endif

                <!-- Spectacular Title Section -->
                <div class="space-y-8 animate-fade-in-up animation-delay-300">
                    <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-[0.9] tracking-tighter">
                        <span class="block bg-gradient-to-r from-white via-orange-200 to-white bg-clip-text text-transparent drop-shadow-[0_10px_30px_rgba(0,0,0,0.8)]">
                            {{ $item->title }}
                        </span>
                    </h1>
                    
                    <!-- Elegant Subtitle -->
                    <div class="max-w-4xl mx-auto">
                        <p class="text-2xl md:text-3xl text-white/95 leading-relaxed font-light tracking-wide">
                            {{ Str::limit(strip_tags($item->description), 180) }}
                        </p>
                    </div>
                </div>

                <!-- Premium Meta Information -->
                <div class="flex flex-wrap justify-center gap-6 mt-16 animate-fade-in-up animation-delay-600">
                    @if($item->community)
                    <div class="group flex items-center space-x-4 px-8 py-6 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl hover:bg-white/15 transition-all duration-500 transform hover:scale-105">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-map-marker-alt text-white text-lg"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-white/70 text-sm font-semibold uppercase tracking-wide">ชุมชน</p>
                            <p class="text-white font-bold text-xl">{{ $item->community->name }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="group flex items-center space-x-4 px-8 py-6 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl hover:bg-white/15 transition-all duration-500 transform hover:scale-105">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar text-white text-lg"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-white/70 text-sm font-semibold uppercase tracking-wide">วันที่เผยแพร่</p>
                            <p class="text-white font-bold text-xl">{{ $item->publish_date->format('d M Y') }}</p>
                        </div>
                    </div>

                    @if($item->place)
                    <div class="group flex items-center space-x-4 px-8 py-6 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl hover:bg-white/15 transition-all duration-500 transform hover:scale-105">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-location-dot text-white text-lg"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-white/70 text-sm font-semibold uppercase tracking-wide">สถานที่</p>
                            <p class="text-white font-bold text-xl">{{ $item->place->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Dynamic Call-to-Action -->
                <div class="mt-20 animate-fade-in-up animation-delay-900">
                    <button onclick="document.getElementById('content-section').scrollIntoView({behavior: 'smooth'})" 
                            class="group relative inline-flex items-center px-12 py-6 rounded-full bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold text-xl shadow-2xl hover:from-orange-400 hover:to-red-400 transition-all duration-500 transform hover:scale-110 hover:shadow-orange-500/50">
                        <span class="relative z-10">เริ่มสำรวจ</span>
                        <i class="fas fa-arrow-down ml-4 group-hover:translate-y-2 transition-transform duration-500 relative z-10"></i>
                        
                        <!-- Animated Ring -->
                        <div class="absolute inset-0 rounded-full bg-gradient-to-r from-orange-400 to-red-400 opacity-0 group-hover:opacity-30 group-hover:scale-150 transition-all duration-700"></div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Animated Scroll Indicator -->
        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 z-40">
            <div class="flex flex-col items-center space-y-4 animate-bounce">
                <div class="w-8 h-12 rounded-full border-2 border-white/60 flex justify-center relative">
                    <div class="w-2 h-4 bg-white/80 rounded-full mt-2 animate-pulse"></div>
                </div>
                <p class="text-white/80 text-sm font-medium tracking-wide">เลื่อนลงเพื่อดูเพิ่มเติม</p>
            </div>
        </div>

        <!-- Floating Particles Effect -->
        <div class="absolute inset-0 z-20 pointer-events-none">
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
            <div class="particle particle-5"></div>
        </div>
    </div>

    <!-- Magazine-Style Content Section -->
    <div id="content-section" class="relative bg-white">
        <!-- Section Transition -->
        <div class="absolute -top-20 left-0 right-0 h-40 bg-gradient-to-b from-transparent to-white z-10"></div>
        
        <!-- Main Content Grid -->
        <div class="relative z-20 max-w-7xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Main Article Column -->
                <div class="lg:col-span-8 space-y-16">
                    <!-- Article Header -->
                    <div class="space-y-8">
                        <div class="flex items-center space-x-4">
                            <div class="w-2 h-16 bg-gradient-to-b from-orange-500 to-red-500 rounded-full"></div>
                            <div>
                                <h2 class="text-5xl font-black text-gray-900 leading-tight">เรื่องราว</h2>
                                <p class="text-xl text-gray-600 mt-2">ความงามของวัฒนธรรมไทย</p>
                            </div>
                        </div>
                    </div>

                    <!-- Article Content with Premium Typography -->
                    <article class="space-y-8">
                        <div class="prose prose-2xl prose-gray max-w-none">
                            <div class="text-2xl leading-relaxed text-gray-800 font-light">
                                {!! $item->description !!}
                            </div>
                        </div>
                    </article>

                    <!-- Social Sharing Section -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-3xl p-8 space-y-6">
                        <div class="text-center space-y-4">
                            <h3 class="text-3xl font-bold text-gray-900">แชร์เรื่องราวนี้</h3>
                            <p class="text-gray-600 text-lg">ช่วยเผยแพร่วัฒนธรรมไทยให้คนอื่นได้รู้จัก</p>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               onclick="trackSocialShare('facebook')"
                               class="group flex flex-col items-center p-6 bg-[#1877F2] rounded-2xl hover:bg-[#166FE5] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="fab fa-facebook-f text-white text-2xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-white font-semibold">Facebook</span>
                            </a>

                            <!-- Twitter -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($item->title) }}" 
                               target="_blank"
                               onclick="trackSocialShare('twitter')"
                               class="group flex flex-col items-center p-6 bg-[#1DA1F2] rounded-2xl hover:bg-[#1A91DA] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="fab fa-twitter text-white text-2xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-white font-semibold">Twitter</span>
                            </a>

                            <!-- LINE -->
                            <a href="https://social-plugins.line.me/lineit/share?url={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               onclick="trackSocialShare('line')"
                               class="group flex flex-col items-center p-6 bg-[#00B900] rounded-2xl hover:bg-[#00A500] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="fab fa-line text-white text-2xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-white font-semibold">LINE</span>
                            </a>

                            <!-- Native Share -->
                            <button onclick="enhancedShare()" 
                                    class="group flex flex-col items-center p-6 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="fas fa-share-alt text-white text-2xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="text-white font-semibold">แชร์</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Quick Info Card -->
                    <div class="sticky top-8 space-y-8">
                        <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-3xl p-8 border border-orange-100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">ข้อมูลสรุป</h3>
                            
                            <div class="space-y-6">
                                @if($item->category)
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 flex items-center justify-center">
                                        <i class="fas fa-tag text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">หมวดหมู่</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $item->category->name }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($item->community)
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">ชุมชน</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $item->community->name }}</p>
                                    </div>
                                </div>
                                @endif

                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                                        <i class="fas fa-calendar text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">วันที่เผยแพร่</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $item->publish_date->format('d F Y') }}</p>
                                    </div>
                                </div>

                                @if($item->place)
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center">
                                        <i class="fas fa-location-dot text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">สถานที่</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $item->place->name }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Navigation Card -->
                        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">เนวิเกชัน</h3>
                            
                            <div class="space-y-4">
                                <a href="{{ route('cultural.explore') }}" 
                                   class="flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-orange-50 to-red-50 hover:from-orange-100 hover:to-red-100 transition-all duration-300 group">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-compass text-orange-500 group-hover:rotate-180 transition-transform duration-500"></i>
                                        <span class="font-semibold text-gray-800">สำรวจทั้งหมด</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-gray-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                                
                                @if($item->category)
                                <a href="{{ route('category', $item->category->slug) }}" 
                                   class="flex items-center justify-between p-4 rounded-2xl bg-gradient-to-r from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 transition-all duration-300 group">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-layer-group text-blue-500 group-hover:scale-110 transition-transform duration-300"></i>
                                        <span class="font-semibold text-gray-800">หมวดหมู่นี้</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-gray-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Map Section -->
    @if($item->latitude && $item->longitude)
    <section class="relative bg-gradient-to-br from-slate-900 to-gray-900 py-20">
        <div class="absolute inset-0 bg-noise opacity-10"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black text-white mb-6">ตำแหน่งที่ตั้ง</h2>
                <p class="text-xl text-white/80">ค้นหาพิกัดและสำรวจพื้นที่โดยรอบ</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 overflow-hidden shadow-2xl">
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-red-500 to-pink-500 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-location-dot text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">พิกัด</h3>
                            <p class="text-white/80">{{ number_format($item->latitude, 6) }}, {{ number_format($item->longitude, 6) }}</p>
                        </div>
                        
                        @if($item->community)
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-home text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">ชุมชน</h3>
                            <p class="text-white/80">{{ $item->community->name }}</p>
                        </div>
                        @endif
                        
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-map text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">แผนที่</h3>
                            <p class="text-white/80">Google Maps Interactive</p>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div id="map" class="h-96 bg-gray-100"></div>
                    <div class="absolute bottom-6 right-6">
                        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                           target="_blank" 
                           class="inline-flex items-center px-6 py-3 bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg hover:bg-white transition-all duration-300 group">
                            <i class="fas fa-external-link-alt text-gray-700 mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="text-gray-700 font-semibold">เปิดใน Google Maps</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Related Items with Magazine Layout -->
    @if($relatedItems->count() > 0)
    <section class="bg-gradient-to-br from-gray-50 to-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-orange-100 to-red-100 border border-orange-200 mb-6">
                    <i class="fas fa-heart text-orange-500 mr-2"></i>
                    <span class="text-orange-700 font-semibold">เนื้อหาที่เกี่ยวข้อง</span>
                </div>
                <h2 class="text-5xl font-black text-gray-900 mb-6">สำรวจเพิ่มเติม</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">ค้นพบวัฒนธรรมไทยอื่นๆ ที่น่าสนใจและเชื่อมโยงกัน</p>
            </div>
            
            <!-- Related Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @foreach($relatedItems as $related)
                <article class="group">
                    <a href="{{ route('cultural-item.show', $related->id) }}" 
                       class="block bg-white rounded-3xl shadow-lg hover:shadow-2xl border border-gray-100 hover:border-orange-200 overflow-hidden transition-all duration-500 transform hover:scale-105">
                        
                        <!-- Image -->
                        <div class="relative h-64 overflow-hidden">
                            @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" 
                                 alt="{{ $related->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                 loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-orange-100 to-red-200 flex items-center justify-center group-hover:from-orange-200 group-hover:to-red-300 transition-colors duration-500">
                                <i class="fas fa-image text-orange-400 text-5xl opacity-60"></i>
                            </div>
                            @endif
                            
                            <!-- Category Badge -->
                            @if($related->category)
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-2 bg-white/90 backdrop-blur-sm text-orange-700 text-xs font-bold rounded-full shadow-lg border border-orange-200">
                                    {{ $related->category->name }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6 space-y-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300 line-clamp-2 leading-tight">
                                {{ $related->title }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($related->description), 120) }}
                            </p>
                            
                            <!-- Meta -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                @if($related->community)
                                <div class="flex items-center space-x-2 text-xs text-gray-500">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ Str::limit($related->community->name, 15) }}</span>
                                </div>
                                @endif
                                
                                <div class="text-xs text-gray-500 flex items-center space-x-1">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $related->publish_date->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
            
            <!-- Explore More Button -->
            <div class="text-center">
                <a href="{{ route('cultural.explore') }}" 
                   class="group inline-flex items-center px-12 py-6 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-2xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-2xl hover:shadow-orange-500/25 font-bold text-xl transform hover:scale-105">
                    <i class="fas fa-compass mr-4 group-hover:rotate-180 transition-transform duration-500"></i>
                    <span>สำรวจวัฒนธรรมทั้งหมด</span>
                    <i class="fas fa-arrow-right ml-4 group-hover:translate-x-2 transition-transform duration-300"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Back to Top Button -->
    <button id="back-to-top" 
            class="fixed bottom-8 right-8 w-14 h-14 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full shadow-2xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 transform hover:scale-110 opacity-0 pointer-events-none z-50"
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="fas fa-arrow-up"></i>
    </button>

@endsection

@push('scripts')
@if($item->latitude && $item->longitude)
<script>
let map;
let marker;

function initMap() {
    // Sophisticated map styling
    const mapStyles = [
        {
            "featureType": "all",
            "elementType": "geometry",
            "stylers": [{"color": "#f5f5f5"}]
        },
        {
            "featureType": "all",
            "elementType": "labels.icon",
            "stylers": [{"visibility": "off"}]
        },
        {
            "featureType": "all",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#616161"}]
        },
        {
            "featureType": "all",
            "elementType": "labels.text.stroke",
            "stylers": [{"color": "#f5f5f5"}]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#bdbdbd"}]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{"color": "#eeeeee"}]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#757575"}]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{"color": "#e5e5e5"}]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#9e9e9e"}]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{"color": "#ffffff"}]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#757575"}]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{"color": "#dadada"}]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#616161"}]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#9e9e9e"}]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{"color": "#e5e5e5"}]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [{"color": "#eeeeee"}]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{"color": "#c9c9c9"}]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#9e9e9e"}]
        }
    ];

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
        gestureHandling: 'cooperative'
    });

    // Premium custom marker
    const customIcon = {
        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
            <svg width="48" height="58" viewBox="0 0 48 58" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="markerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#f97316;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#ea580c;stop-opacity:1" />
                    </linearGradient>
                    <filter id="shadow">
                        <feDropShadow dx="0" dy="4" stdDeviation="4" flood-color="#000000" flood-opacity="0.3"/>
                    </filter>
                </defs>
                <path d="M24 2C13.5 2 5 10.5 5 21c0 16.5 19 35 19 35s19-18.5 19-35C43 10.5 34.5 2 24 2z" 
                      fill="url(#markerGradient)" 
                      stroke="#ffffff" 
                      stroke-width="3" 
                      filter="url(#shadow)"/>
                <circle cx="24" cy="21" r="8" fill="#ffffff"/>
                <circle cx="24" cy="21" r="4" fill="#ea580c"/>
            </svg>
        `),
        scaledSize: new google.maps.Size(48, 58),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(24, 58)
    };

    marker = new google.maps.Marker({
        position: mapCenter,
        map: map,
        title: '{{ $item->title }}',
        icon: customIcon,
        animation: google.maps.Animation.DROP
    });

    // Premium info window
    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div class="p-6 min-w-[300px] max-w-[400px]">
                <div class="text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-xl mb-3 leading-tight">{{ $item->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ Str::limit($item->description, 100) }}</p>
                        
                        <div class="space-y-3 text-sm text-gray-500 bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-location-dot text-orange-500"></i>
                                <span class="font-medium">{{ number_format($item->latitude, 6) }}, {{ number_format($item->longitude, 6) }}</span>
                            </div>
                            @if($item->community)
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home text-blue-500"></i>
                                <span class="font-medium">{{ $item->community->name }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                               target="_blank" 
                               class="inline-flex items-center justify-center w-full px-4 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300 text-sm font-semibold shadow-md">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                เปิดใน Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `,
        pixelOffset: new google.maps.Size(0, -15)
    });

    marker.addListener('click', () => {
        infoWindow.open(map, marker);
    });

    // Auto-open info window
    setTimeout(() => {
        infoWindow.open(map, marker);
    }, 1500);
}

window.initMap = initMap;
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.google_api_key') }}&callback=initMap&libraries=geometry"></script>
@endif

<!-- Enhanced Interactions -->
<script>
// Enhanced sharing function
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
            showToast('ลิงก์ถูกคัดลอกแล้ว!', 'success');
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

// Toast notification system
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };
    
    toast.className = `fixed bottom-6 right-6 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl z-50 transition-all duration-300 transform translate-y-2 opacity-0`;
    toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas fa-check-circle"></i>
            <span class="font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
    }, 100);
    
    // Animate out
    setTimeout(() => {
        toast.classList.add('translate-y-2', 'opacity-0');
        setTimeout(() => document.body.removeChild(toast), 300);
    }, 3000);
}

// Back to top button
window.addEventListener('scroll', () => {
    const backToTop = document.getElementById('back-to-top');
    if (window.scrollY > 500) {
        backToTop.classList.remove('opacity-0', 'pointer-events-none');
        backToTop.classList.add('opacity-100');
    } else {
        backToTop.classList.add('opacity-0', 'pointer-events-none');
        backToTop.classList.remove('opacity-100');
    }
});

// Parallax effect for hero background
window.addEventListener('scroll', () => {
    const heroBackground = document.getElementById('hero-bg');
    if (heroBackground) {
        const scrolled = window.scrollY;
        const rate = scrolled * -0.5;
        heroBackground.style.transform = `translate3d(0, ${rate}px, 0) scale(1.1)`;
    }
});

// Intersection Observer for animations
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Observe elements
    document.querySelectorAll('article, section').forEach(el => {
        observer.observe(el);
    });
});
</script>

<!-- Enhanced Styling -->
<style>
/* Background noise texture */
.bg-noise {
    background-image: 
        radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0);
    background-size: 20px 20px;
}

/* Floating particles */
.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: float-particle 6s infinite ease-in-out;
}

.particle-1 { top: 20%; left: 10%; animation-delay: 0s; }
.particle-2 { top: 60%; left: 80%; animation-delay: 1s; }
.particle-3 { top: 40%; left: 20%; animation-delay: 2s; }
.particle-4 { top: 80%; left: 60%; animation-delay: 3s; }
.particle-5 { top: 10%; left: 90%; animation-delay: 4s; }

@keyframes float-particle {
    0%, 100% { transform: translateY(0px) scale(1); opacity: 0.3; }
    50% { transform: translateY(-20px) scale(1.2); opacity: 0.8; }
}

/* Animation delays */
.animation-delay-300 { animation-delay: 300ms; }
.animation-delay-600 { animation-delay: 600ms; }
.animation-delay-900 { animation-delay: 900ms; }

/* Fade in up animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

/* Line clamp utilities */
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

/* Enhanced prose styling */
.prose-2xl {
    font-size: 1.5rem;
    line-height: 1.667;
}

.prose-2xl p {
    margin-bottom: 1.5em;
}

.prose-2xl h1, .prose-2xl h2, .prose-2xl h3 {
    color: #111827;
    font-weight: 800;
    margin-top: 2em;
    margin-bottom: 1em;
}

.prose-2xl ul, .prose-2xl ol {
    margin: 1.5em 0;
    padding-left: 2em;
}

.prose-2xl blockquote {
    border-left: 5px solid #f97316;
    padding-left: 1.5rem;
    font-style: italic;
    color: #6b7280;
    margin: 2em 0;
    font-size: 1.25em;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #f97316, #ea580c);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #ea580c, #dc2626);
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

/* Print styles */
@media print {
    .bg-gradient-to-r,
    .bg-gradient-to-br,
    .backdrop-blur-xl,
    .shadow-2xl,
    .particle,
    .bg-noise {
        background: white !important;
        box-shadow: none !important;
        backdrop-filter: none !important;
        display: none !important;
    }
    
    .text-white {
        color: black !important;
    }
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .text-6xl { font-size: 3rem; }
    .text-8xl { font-size: 4rem; }
    .text-9xl { font-size: 5rem; }
}
</style>
@endpush