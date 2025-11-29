@extends('layouts.frontend')

@section('title', 'หน้าแรก')

@push('meta')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="cache-bust" content="{{ time() }}">
@endpush

@section('content')

<!-- Hero Slideshow Section -->
<section class="relative h-[600px] md:h-[700px] overflow-hidden bg-gray-900">
    <!-- Slideshow Container -->
    <div class="relative h-full" id="heroSlideshow">
        @php
            // Filter เฉพาะ items ที่ is_featured = 1 จริงๆ
            $actualFeaturedItems = $featuredItems->filter(function($item) {
                return $item->is_featured == 1;
            });
        @endphp
        
        @forelse($actualFeaturedItems as $index => $item)
        <!-- Slide {{ $index + 1 }} -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
            <!-- Background Image -->
            <div class="absolute inset-0">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <img src="https://images.unsplash.com/photo-1569154941061-e231b4725ef1?w=1920" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover">
                @endif
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-transparent"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-3xl">
                        <!-- Category Badge -->
                        <span class="inline-block px-4 py-2 bg-orange-500/90 backdrop-blur-sm text-white rounded-full text-sm font-semibold mb-4 transform translate-y-0 opacity-0 animate-slide-up animation-delay-200">
                            <i class="fas {{ $item->category->icon ?? 'fa-folder' }} mr-2"></i>
                            {{ $item->category->name }}
                        </span>
                        
                        <!-- Title -->
                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight transform translate-y-0 opacity-0 animate-slide-up animation-delay-400">
                            {{ $item->title }}
                        </h1>
                        
                        <!-- Description -->
                        <p class="text-lg md:text-xl text-white/90 mb-6 line-clamp-3 transform translate-y-0 opacity-0 animate-slide-up animation-delay-600">
                            {{ $item->description }}
                        </p>
                        
                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-4 text-white/80 mb-8 transform translate-y-0 opacity-0 animate-slide-up animation-delay-800">
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $item->community->name }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $item->publish_date->format('d M Y') }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                {{ $item->creator->name }}
                            </span>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4 transform translate-y-0 opacity-0 animate-slide-up animation-delay-1000">
                            <a href="{{ route('cultural-item.show', $item->id) }}" 
                               class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-full transition-all transform hover:scale-105 shadow-lg">
                                <i class="fas fa-book-open mr-2"></i>
                                อ่านเพิ่มเติม
                            </a>
                            @if($item->category && $item->category->slug)
                            <a href="{{ route('category', $item->category->slug) }}" 
                               class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold rounded-full transition-all border border-white/50">
                                <i class="fas fa-compass mr-2"></i>
                                ดูหมวดหมู่นี้
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Fallback Slide ถ้าไม่มีข้อมูล -->
        <div class="hero-slide absolute inset-0">
            <div class="absolute inset-0">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Wat_Arun_temple_Bangkok.jpg/1280px-Wat_Arun_temple_Bangkok.jpg" 
                     alt="วัดอรุณ" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            </div>
            <div class="relative z-10 h-full flex items-center justify-center text-center">
                <div class="text-white px-4">
                    <h1 class="text-5xl md:text-6xl font-bold mb-4">วัฒนธรรมเขตธนบุรี</h1>
                    <p class="text-xl md:text-2xl max-w-2xl mx-auto">
                        ค้นพบเสน่ห์แห่งฝั่งธนบุรี ดินแดนแห่งประวัติศาสตร์ ศิลปวัฒนธรรม และวิถีชีวิตริมน้ำเจ้าพระยา
                    </p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- Slide Indicators -->
    @if($actualFeaturedItems->count() > 1)
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex gap-2">
        @foreach($actualFeaturedItems as $index => $item)
        <button class="slide-indicator w-12 h-1.5 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300 {{ $index === 0 ? 'bg-white w-16' : '' }}"
                data-slide-to="{{ $index }}"
                aria-label="Go to slide {{ $index + 1 }}">
        </button>
        @endforeach
    </div>
    
    <!-- Navigation Arrows -->
    <button class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition-all group"
            id="prevSlide"
            aria-label="Previous slide">
        <i class="fas fa-chevron-left text-white group-hover:scale-110 transition-transform"></i>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition-all group"
            id="nextSlide"
            aria-label="Next slide">
        <i class="fas fa-chevron-right text-white group-hover:scale-110 transition-transform"></i>
    </button>
    @endif
    
    <!-- Slide Counter -->
    @if($featuredItems->count() > 1)
        @endif
    
    <!-- Slide Counter -->
    @if($actualFeaturedItems->count() > 1)
    <div class="absolute top-8 right-8 z-20 bg-black/50 backdrop-blur-sm px-4 py-2 rounded-full">
        <span class="text-white text-sm font-medium">
            <span id="current-slide">1</span> / <span id="total-slides">{{ $actualFeaturedItems->count() }}</span>
        </span>
    </div>
    @endif
</section>

<!-- end removed Categories Section -->

<!-- Latest Items Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">ข้อมูลวัฒนธรรมล่าสุด</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                อัปเดตข้อมูลและเรื่องราวน่าสนใจล่าสุดจากชุมชนต่างๆ
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($latestItems as $item)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative h-48 overflow-hidden">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <i class="fas fa-image text-5xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-orange-500 text-white rounded-full text-xs font-semibold">
                            {{ $item->category->name }}
                        </span>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="font-bold text-lg mb-2 text-gray-800 group-hover:text-orange-600 transition-colors line-clamp-2">
                        {{ $item->title }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $item->description }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-map-marker-alt mr-1"></i> 
                            {{ Str::limit($item->community->name, 15) }}
                        </span>
                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                           class="text-orange-600 hover:text-orange-700 font-medium text-sm flex items-center group">
                            อ่านเพิ่ม 
                            <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-500 py-12">
                <i class="fas fa-newspaper text-6xl mb-4"></i>
                <p>ยังไม่มีข้อมูลวัฒนธรรม</p>
            </div>
            @endforelse
        </div>
        
        @if($latestItems->count() > 0)
        <div class="text-center mt-10">
            <a href="#" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-full transition-all transform hover:scale-105 shadow-lg">
                ดูทั้งหมด
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Statistics Section -->
<section class="py-12 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">สถิติข้อมูลทั้งหมด</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                ภาพรวมข้อมูลทางวัฒนธรรม นวัตกรรม งานวิจัย และทรัพย์สินทางปัญญา
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
            <!-- ข้อมูลวัฒนธรรม -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 text-center hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group float-animation" style="animation-delay: 0s;">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl text-white">🏛️</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2" id="cultural-count">{{ $stats['total_items'] ?? 0 }}</h3>
                <p class="text-gray-600 font-medium mb-3">ข้อมูลวัฒนธรรม</p>
                <div class="bg-green-50 border border-green-200 rounded-full px-3 py-1 inline-flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-green-500 font-semibold text-sm">▲</span>
                    <span class="text-green-700 font-semibold text-sm ml-1">เพิ่มขึ้น 12%</span>
                </div>
            </div>

            <!-- ข้อมูลนวัตกรรม -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 text-center hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group float-animation" style="animation-delay: 1s;">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-violet-400 to-violet-600 rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl text-white">💡</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2" id="innovation-count">{{ $stats['total_innovations'] ?? 0 }}</h3>
                <p class="text-gray-600 font-medium mb-3">ข้อมูลนวัตกรรม</p>
                <div class="bg-green-50 border border-green-200 rounded-full px-3 py-1 inline-flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-green-500 font-semibold text-sm">▲</span>
                    <span class="text-green-700 font-semibold text-sm ml-1">เพิ่มขึ้น 8%</span>
                </div>
            </div>

            <!-- ข้อมูลงานวิจัย -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 text-center hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group float-animation" style="animation-delay: 2s;">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-rose-400 to-rose-600 rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl text-white">🔬</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2" id="research-count">{{ $stats['total_research'] ?? 0 }}</h3>
                <p class="text-gray-600 font-medium mb-3">ข้อมูลงานวิจัย</p>
                <div class="bg-red-50 border border-red-200 rounded-full px-3 py-1 inline-flex items-center">
                    <div class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-red-500 font-semibold text-sm">▼</span>
                    <span class="text-red-700 font-semibold text-sm ml-1">ลดลง 5%</span>
                </div>
            </div>

            <!-- ข้อมูลทรัพย์สินทางปัญญา -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 text-center hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group float-animation" style="animation-delay: 3s;">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl text-white">📜</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2" id="ip-count">{{ $stats['total_ip'] ?? 0 }}</h3>
                <p class="text-gray-600 font-medium mb-3">ทรัพย์สินทางปัญญา</p>
                <div class="bg-green-50 border border-green-200 rounded-full px-3 py-1 inline-flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-green-500 font-semibold text-sm">▲</span>
                    <span class="text-green-700 font-semibold text-sm ml-1">เพิ่มขึ้น 20%</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- กราฟแท่งเปรียบเทียบ -->
            <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-50 p-6 chart-container hover:shadow-2xl transition-all duration-500">
                <h3 class="text-xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-chart-bar text-white text-lg"></i>
                    </div>
                    เปรียบเทียบจำนวนข้อมูล
                </h3>
                <div class="relative h-64 md:h-80">
                    <canvas id="dataComparisonChart"></canvas>
                </div>
            </div>

            <!-- กราฟวงกลม -->
            <div class="bg-white rounded-3xl border border-gray-50 p-6 chart-container hover:shadow-2xl transition-all duration-500">
                <h3 class="text-xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-chart-pie text-white text-lg"></i>
                    </div>
                    สัดส่วนข้อมูล
                </h3>
                <div class="relative h-64 md:h-80">
                    <canvas id="dataProportionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Trend Chart -->
        <div class="bg-white rounded-3xl border border-gray-50 p-6 chart-container hover:shadow-2xl transition-all duration-500">
            <h3 class="text-xl font-bold text-gray-800 mb-6 text-center flex items-center justify-center">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
                แนวโน้มการเพิ่มข้อมูลรายเดือน (6 เดือนที่ผ่านมา)
            </h3>
            <div class="relative h-64 md:h-72 lg:h-80">
                <canvas id="dataTrendChart"></canvas>
            </div>
        </div>
    </div>
</section>

<!-- Cultural Heritage Map Section -->
@if($culturalItemsWithLocation->count() > 0)
<section class="py-12 bg-gradient-to-br from-orange-50 to-orange-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">แผนที่มรดกทางวัฒนธรรม</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-3xl mx-auto">
                สำรวจตำแหน่งที่ตั้งของมรดกทางวัฒนธรรมต่างๆ ทั่วประเทศไทย นำเมาส์ไปชี้ที่หมุดเพื่อดูรายละเอียด
            </p>
            <div class="mt-4 flex flex-wrap justify-center gap-4 text-sm text-gray-600">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-orange-500 rounded-full mr-2"></div>
                    <span>มรดกทางวัฒนธรรม</span>
                </div>
                <div class="flex items-center">
                    <span class="text-lg mr-2">📍</span>
                    <span>{{ $culturalItemsWithLocation->count() }} แห่ง</span>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="relative">
                    <!-- Map -->
                    <div id="culturalMap" class="w-full h-96 md:h-[500px] lg:h-[600px] rounded-2xl shadow-lg bg-gray-100 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500 mx-auto mb-4"></div>
                            <p class="font-medium">กำลังโหลดแผนที่...</p>
                            <p class="text-sm mt-1">โปรดรอสักครู่</p>
                        </div>
                    </div>

                    <!-- Map Controls -->
                    <div class="absolute top-4 right-4 bg-white rounded-lg shadow-lg p-3 space-y-2 z-10">
                        <button onclick="toggleMapType()" 
                                class="w-full flex items-center justify-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300 text-sm">
                            <i class="fas fa-map mr-2"></i>
                            <span id="mapTypeText">ดาวเทียม</span>
                        </button>
                        <button onclick="fitMapToMarkers()" 
                                class="w-full flex items-center justify-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-300 text-sm">
                            <i class="fas fa-expand-arrows-alt mr-2"></i>
                            ดูทั้งหมด
                        </button>
                    </div>

                    <!-- Map Info Panel -->
                    <div class="absolute bottom-4 left-4 bg-white bg-opacity-95 backdrop-blur-sm rounded-lg shadow-lg p-4 max-w-sm z-10">
                        <h4 class="font-bold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                            วิธีการใช้งาน
                        </h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-start">
                                <span class="text-orange-500 mr-2">•</span>
                                <span>คลิกหมุดเพื่อดูรายละเอียด</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-orange-500 mr-2">•</span>
                                <span>ลากเพื่อเลื่อนแผนที่</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-orange-500 mr-2">•</span>
                                <span>ใช้ล้อเมาส์เพื่อซูม</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Map Statistics -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-white text-center">
                    <div>
                        <div class="text-2xl font-bold">{{ $culturalItemsWithLocation->count() }}</div>
                        <div class="text-sm opacity-90">ทั้งหมด</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $culturalItemsWithLocation->pluck('category_id')->unique()->count() }}</div>
                        <div class="text-sm opacity-90">หมวดหมู่</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $culturalItemsWithLocation->pluck('community_id')->filter()->unique()->count() }}</div>
                        <div class="text-sm opacity-90">ชุมชน</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $culturalItemsWithLocation->where('created_at', '>=', now()->subYear())->count() }}</div>
                        <div class="text-sm opacity-90">ปีนี้</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Legend and Categories -->
        <div class="mt-8">
            <!-- Show All Button -->
            <div class="flex justify-center mb-4">
                <button onclick="showAllMarkers()" 
                        class="flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl transition-colors duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-eye mr-2"></i>
                    แสดงทั้งหมดบนแผนที่
                </button>
            </div>
            
            <!-- Category Filters -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $categories = $culturalItemsWithLocation->groupBy('category_id')->map(function($items) {
                        return [
                            'category' => $items->first()->category,
                            'count' => $items->count(),
                            'items' => $items
                        ];
                    });
                @endphp
                
                @foreach($categories as $categoryData)
                    @if($categoryData['category'])
                    <div class="bg-white rounded-xl p-4 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $categoryData['category']->name }}</h4>
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-bold">{{ $categoryData['count'] }}</span>
                        </div>
                        <button onclick="filterMapByCategory({{ $categoryData['category']->id }})" 
                                class="w-full text-left text-xs text-gray-600 hover:text-orange-600 transition-colors duration-300 flex items-center">
                            <i class="fas fa-map-pin text-orange-500 mr-1"></i>
                            กรองตามหมวดหมู่
                        </button>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- CSS Animations and Chart Styling -->
<style>
    /* Modern Card Styles */
    .shadow-xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    /* Google Maps Styling */
    .gm-style-iw {
        padding: 0 !important;
        border-radius: 12px !important;
        overflow: hidden !important;
    }
    
    .gm-style-iw-d {
        overflow: hidden !important;
        padding: 0 !important;
    }
    
    .gm-ui-hover-effect {
        opacity: 0.6 !important;
    }
    
    /* Line clamp utility for text truncation */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Map container styling */
    #culturalMap {
        border-radius: 16px;
    }
    
    .map-loading {
        backdrop-filter: blur(5px);
        background: rgba(255, 255, 255, 0.9);
    }
    
    /* Glassmorphism effect for cards */
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Smooth animations */
    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .float-animation {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-slide-up {
        animation: slide-up 0.8s ease-out forwards;
    }
    
    .animation-delay-200 { animation-delay: 200ms; }
    
    /* Enhanced Chart Container Styles */
    .chart-container {
        position: relative;
        width: 100%;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .chart-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .chart-container:hover::before {
        left: 100%;
    }
    
    .chart-container:hover {
        transform: translateY(-5px);
    }
    
    /* Enhanced Mobile responsive adjustments */
    @media (max-width: 768px) {
        .grid.lg\\:grid-cols-4 {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .grid.lg\\:grid-cols-3 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .lg\\:col-span-2 {
            grid-column: span 1;
        }
        
        /* Adjust chart heights for mobile */
        .relative.h-64 {
            height: 12rem;
        }
        
        .relative.h-72 {
            height: 16rem;
        }
        
        .lg\\:h-80 {
            height: 16rem;
        }
        
        /* Smaller padding for mobile cards */
        .rounded-3xl.p-8 {
            padding: 1.5rem;
        }
        
        .w-20.h-20 {
            width: 4rem;
            height: 4rem;
        }
        
        .text-3xl {
            font-size: 1.5rem;
        }
        
        .text-2xl {
            font-size: 1.25rem;
        }
    }
    
    /* Small mobile adjustments */
    @media (max-width: 480px) {
        .relative.h-64 {
            height: 10rem; /* h-40 */
        }
        
        .relative.h-72 {
            height: 12rem; /* h-48 */
        }
        
        .lg\\:h-80 {
            height: 14rem; /* h-56 */
        }
    }
    
    /* Improve chart text readability */
    canvas {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    /* Loading animation for charts */
    @keyframes chart-fade-in {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .chart-container canvas {
        animation: chart-fade-in 0.6s ease-out;
    }
    
    /* Additional animation delays for statistics cards */
    .animation-delay-200 { animation-delay: 200ms; }
    .animation-delay-400 { animation-delay: 400ms; }
    .animation-delay-600 { animation-delay: 600ms; }
    .animation-delay-800 { animation-delay: 800ms; }
    
    /* Line clamp utilities for text overflow */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- JavaScript for Slideshow -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.slide-indicator');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    const currentSlideSpan = document.getElementById('currentSlide');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    let slideInterval;
    
    // Function to show specific slide
    function showSlide(index) {
        // Hide all slides
        slides.forEach((slide, i) => {
            slide.classList.remove('opacity-100');
            slide.classList.add('opacity-0');
            
            // Reset animations
            const animatedElements = slide.querySelectorAll('[class*="animate-slide-up"]');
            animatedElements.forEach(el => {
                el.style.animation = 'none';
            });
        });
        
        // Show current slide
        slides[index].classList.remove('opacity-0');
        slides[index].classList.add('opacity-100');
        
        // Trigger animations for current slide
        setTimeout(() => {
            const animatedElements = slides[index].querySelectorAll('[class*="animate-slide-up"]');
            animatedElements.forEach(el => {
                el.style.animation = '';
            });
        }, 100);
        
        // Update indicators
        if (indicators.length > 0) {
            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.classList.add('bg-white', 'w-16');
                    indicator.classList.remove('bg-white/40', 'w-12');
                } else {
                    indicator.classList.remove('bg-white', 'w-16');
                    indicator.classList.add('bg-white/40', 'w-12');
                }
            });
        }
        
        // Update counter
        if (currentSlideSpan) {
            currentSlideSpan.textContent = index + 1;
        }
        
        currentSlide = index;
    }
    
    // Auto slide function
    function nextSlide() {
        const next = (currentSlide + 1) % totalSlides;
        showSlide(next);
    }
    
    function prevSlide() {
        const prev = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(prev);
    }
    
    // Start auto slide
    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }
    
    // Stop auto slide
    function stopAutoSlide() {
        clearInterval(slideInterval);
    }
    
    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            nextSlide();
            startAutoSlide();
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            prevSlide();
            startAutoSlide();
        });
    }
    
    // Indicator clicks
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopAutoSlide();
            showSlide(index);
            startAutoSlide();
        });
    });
    
    // Pause on hover
    const slideshowContainer = document.getElementById('heroSlideshow');
    if (slideshowContainer && totalSlides > 1) {
        slideshowContainer.addEventListener('mouseenter', stopAutoSlide);
        slideshowContainer.addEventListener('mouseleave', startAutoSlide);
    }
    
    // Start slideshow if there are multiple slides
    if (totalSlides > 1) {
        startAutoSlide();
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft' && prevBtn) {
            prevBtn.click();
        } else if (e.key === 'ArrowRight' && nextBtn) {
            nextBtn.click();
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Statistics Charts Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ข้อมูลสถิติ
    const culturalCount = {{ $stats['total_items'] ?? 0 }};
    const innovationCount = {{ $stats['total_innovations'] ?? 0 }};
    const researchCount = {{ $stats['total_research'] ?? 0 }};
    const ipCount = {{ $stats['total_ip'] ?? 0 }};

    // กราฟแท่งเปรียบเทียบ
    const comparisonCtx = document.getElementById('dataComparisonChart').getContext('2d');
    new Chart(comparisonCtx, {
        type: 'bar',
        data: {
            labels: ['วัฒนธรรม', 'นวัตกรรม', 'งานวิจัย', 'ทรัพย์สินฯ'],
            datasets: [{
                label: 'จำนวนข้อมูล',
                data: [culturalCount, innovationCount, researchCount, ipCount],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',   // Emerald - วัฒนธรรม
                    'rgba(139, 92, 246, 0.8)',   // Violet - นวัตกรรม  
                    'rgba(244, 63, 94, 0.8)',    // Rose - งานวิจัย
                    'rgba(245, 158, 11, 0.8)'    // Amber - ทรัพย์สินฯ
                ],
                borderColor: [
                    'rgb(16, 185, 129)',    // Emerald
                    'rgb(139, 92, 246)',    // Violet
                    'rgb(244, 63, 94)',     // Rose
                    'rgb(245, 158, 11)'     // Amber
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' รายการ';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        lineWidth: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        maxRotation: 45
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });

    // กราฟวงกลม
    const proportionCtx = document.getElementById('dataProportionChart').getContext('2d');
    new Chart(proportionCtx, {
        type: 'doughnut',
        data: {
            labels: ['ข้อมูลวัฒนธรรม', 'ข้อมูลนวัตกรรม', 'ข้อมูลงานวิจัย', 'ทรัพย์สินทางปัญญา'],
            datasets: [{
                data: [culturalCount, innovationCount, researchCount, ipCount],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',   // Emerald
                    'rgba(139, 92, 246, 0.8)',   // Violet
                    'rgba(244, 63, 94, 0.8)',    // Rose
                    'rgba(245, 158, 11, 0.8)'    // Amber
                ],
                borderColor: [
                    'rgb(16, 185, 129)',    // Emerald
                    'rgb(139, 92, 246)',    // Violet
                    'rgb(244, 63, 94)',     // Rose
                    'rgb(245, 158, 11)'     // Amber
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 11
                        },
                        boxWidth: 12,
                        boxHeight: 12
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });

    // กราฟเส้นแนวโน้ม
    const trendCtx = document.getElementById('dataTrendChart').getContext('2d');
    
    // สร้างข้อมูลตัวอย่าง 6 เดือนที่ผ่านมา
    const months = [];
    const culturalTrend = [];
    const innovationTrend = [];
    const researchTrend = [];
    const ipTrend = [];
    
    for (let i = 5; i >= 0; i--) {
        const date = new Date();
        date.setMonth(date.getMonth() - i);
        months.push(date.toLocaleDateString('th-TH', { month: 'short', year: '2-digit' }));
        
        culturalTrend.push(Math.floor(Math.random() * 5) + 1);
        innovationTrend.push(Math.floor(Math.random() * 3) + 1);
        researchTrend.push(Math.floor(Math.random() * 4) + 1);
        ipTrend.push(Math.floor(Math.random() * 3) + 1);
    }

    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'ข้อมูลวัฒนธรรม',
                    data: culturalTrend,
                    borderColor: 'rgb(16, 185, 129)',      // Emerald
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3
                },
                {
                    label: 'ข้อมูลนวัตกรรม',
                    data: innovationTrend,
                    borderColor: 'rgb(139, 92, 246)',      // Violet
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3
                },
                {
                    label: 'ข้อมูลงานวิจัย',
                    data: researchTrend,
                    borderColor: 'rgb(244, 63, 94)',       // Rose
                    backgroundColor: 'rgba(244, 63, 94, 0.1)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3
                },
                {
                    label: 'ทรัพย์สินทางปัญญา',
                    data: ipTrend,
                    borderColor: 'rgb(245, 158, 11)',      // Amber
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 11
                        },
                        boxWidth: 12,
                        boxHeight: 12
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' รายการ';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        lineWidth: 1
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        lineWidth: 1
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            },
            elements: {
                point: {
                    radius: 4,
                    hoverRadius: 6,
                    borderWidth: 2
                },
                line: {
                    borderWidth: 3
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Counter Animation
    function animateCounter(elementId, endValue, duration = 2000) {
        const element = document.getElementById(elementId);
        const startValue = 0;
        const increment = endValue / (duration / 16);
        let currentValue = startValue;

        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= endValue) {
                currentValue = endValue;
                clearInterval(timer);
            }
            element.textContent = Math.floor(currentValue);
        }, 16);
    }

    // เริ่ม Animation เมื่อ scroll ถึงส่วนนี้
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter('cultural-count', culturalCount);
                animateCounter('innovation-count', innovationCount);
                animateCounter('research-count', researchCount);
                animateCounter('ip-count', ipCount);
                observer.unobserve(entry.target);
            }
        });
    });

    observer.observe(document.querySelector('#cultural-count').closest('.grid'));
});
</script>

<!-- Google Maps Scripts for Cultural Heritage Map -->
@if($culturalItemsWithLocation->count() > 0)
@php
    $mapData = $culturalItemsWithLocation->map(function($item) {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'description' => Str::limit(strip_tags($item->description), 100),
            'image' => $item->image ? Storage::url($item->image) : null,
            'latitude' => (float) $item->latitude,
            'longitude' => (float) $item->longitude,
            'category' => $item->category ? $item->category->name : 'ไม่ระบุ',
            'category_id' => $item->category_id,
            'community' => $item->community ? $item->community->name : null,
            'url' => route('cultural-item.show', $item->id),
            'created_at' => $item->created_at->format('d/m/Y')
        ];
    });
@endphp
<script>
let culturalMap;
let mapMarkers = [];
let infoWindow;
let currentMapType = 'roadmap';

// Cultural items data from Laravel
const culturalItems = @json($mapData);

// Initialize Google Map
function initializeCulturalMap() {
    console.log('Initializing cultural map...');
    console.log('Cultural items:', culturalItems.length);
    
    if (culturalItems.length === 0) {
        console.log('No cultural items with location');
        const mapContainer = document.getElementById('culturalMap');
        if (mapContainer) {
            mapContainer.innerHTML = '<div class="text-center text-gray-500 py-12"><i class="fas fa-map-marked-alt text-6xl mb-4 text-gray-300"></i><p>ไม่มีข้อมูลตำแหน่งสำหรับแสดงบนแผนที่</p></div>';
        }
        return;
    }
    
    if (typeof google === 'undefined' || !google.maps) {
        console.error('Google Maps API not loaded');
        const mapContainer = document.getElementById('culturalMap');
        if (mapContainer) {
            mapContainer.innerHTML = '<div class="text-center text-red-500 py-12"><i class="fas fa-exclamation-triangle text-6xl mb-4"></i><p>ไม่สามารถโหลด Google Maps ได้</p></div>';
        }
        return;
    }
    
    // Remove loading indicator first
    const mapContainer = document.getElementById('culturalMap');
    if (mapContainer) {
        mapContainer.innerHTML = '';
    }

    // Calculate map bounds
    const bounds = new google.maps.LatLngBounds();
    culturalItems.forEach(item => {
        bounds.extend(new google.maps.LatLng(item.latitude, item.longitude));
    });

    // Map options
    const mapOptions = {
        zoom: 6,
        center: bounds.getCenter(),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
            {
                featureType: 'poi',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }]
            }
        ],
        mapTypeControl: false,
        streetViewControl: true,
        fullscreenControl: true,
        zoomControl: true,
        gestureHandling: 'cooperative'
    };

    // Create map
    culturalMap = new google.maps.Map(document.getElementById('culturalMap'), mapOptions);
    
    // Create info window
    infoWindow = new google.maps.InfoWindow({
        maxWidth: 350
    });

    // Create markers
    culturalItems.forEach(item => {
        createMarker(item);
    });

    // Fit map to show all markers
    culturalMap.fitBounds(bounds);
    
    // Ensure minimum zoom level
    google.maps.event.addListenerOnce(culturalMap, 'bounds_changed', function() {
        if (culturalMap.getZoom() > 15) {
            culturalMap.setZoom(15);
        }
    });
    
    console.log('Map initialized successfully with', mapMarkers.length, 'markers');
}

// Create marker for cultural item
function createMarker(item) {
    const marker = new google.maps.Marker({
        position: { lat: item.latitude, lng: item.longitude },
        map: culturalMap,
        title: item.title,
        icon: {
            url: 'https://maps.google.com/mapfiles/ms/icons/orange-dot.png',
            scaledSize: new google.maps.Size(32, 32)
        },
        animation: google.maps.Animation.DROP
    });

    // Create info window content
    const infoContent = `
        <div class="max-w-sm">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                ${item.image ? `
                    <div class="h-32 overflow-hidden">
                        <img src="${item.image}" 
                             alt="${item.title}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'">
                    </div>
                ` : ''}
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2">${item.title}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-3">${item.description}</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-tag mr-1 text-orange-500"></i>
                            <span>${item.category}</span>
                        </div>
                        ${item.community ? `
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-users mr-1 text-blue-500"></i>
                                <span>${item.community}</span>
                            </div>
                        ` : ''}
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-calendar mr-1 text-purple-500"></i>
                            <span>${item.created_at}</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="${item.url}" 
                           class="flex-1 bg-orange-500 hover:bg-orange-600 text-white text-center py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-300">
                            <i class="fas fa-eye mr-1"></i>
                            ดูรายละเอียด
                        </a>
                        <button onclick="openDirectionsTo(${item.latitude}, ${item.longitude})" 
                                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-300">
                            <i class="fas fa-directions"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Add click event to marker
    marker.addListener('click', function() {
        infoWindow.setContent(infoContent);
        infoWindow.open(culturalMap, marker);
        
        // Center map on marker
        culturalMap.panTo(marker.getPosition());
    });

    // Store marker with item data
    marker.itemData = item;
    mapMarkers.push(marker);
}

// Toggle map type
function toggleMapType() {
    if (currentMapType === 'roadmap') {
        culturalMap.setMapTypeId(google.maps.MapTypeId.SATELLITE);
        currentMapType = 'satellite';
        document.getElementById('mapTypeText').textContent = 'แผนที่';
    } else {
        culturalMap.setMapTypeId(google.maps.MapTypeId.ROADMAP);
        currentMapType = 'roadmap';
        document.getElementById('mapTypeText').textContent = 'ดาวเทียม';
    }
}

// Fit map to show all markers
function fitMapToMarkers() {
    const bounds = new google.maps.LatLngBounds();
    mapMarkers.forEach(marker => {
        bounds.extend(marker.getPosition());
    });
    culturalMap.fitBounds(bounds);
    
    // Ensure minimum zoom level
    google.maps.event.addListenerOnce(culturalMap, 'bounds_changed', function() {
        if (culturalMap.getZoom() > 15) {
            culturalMap.setZoom(15);
        }
    });
}

// Filter map by category
function filterMapByCategory(categoryId) {
    // Hide all markers first
    mapMarkers.forEach(marker => {
        marker.setVisible(false);
    });
    
    // Show only markers of selected category
    const filteredMarkers = mapMarkers.filter(marker => {
        return marker.itemData.category_id === categoryId;
    });
    
    filteredMarkers.forEach(marker => {
        marker.setVisible(true);
    });
    
    // Fit map to filtered markers
    if (filteredMarkers.length > 0) {
        const bounds = new google.maps.LatLngBounds();
        filteredMarkers.forEach(marker => {
            bounds.extend(marker.getPosition());
        });
        culturalMap.fitBounds(bounds);
        
        // Ensure minimum zoom level
        google.maps.event.addListenerOnce(culturalMap, 'bounds_changed', function() {
            if (culturalMap.getZoom() > 15) {
                culturalMap.setZoom(15);
            }
        });
    }
    
    // Show notification
    showMapNotification(`แสดงเฉพาะหมวดหมู่ที่เลือก (${filteredMarkers.length} รายการ)`);
}

// Show all markers
function showAllMarkers() {
    mapMarkers.forEach(marker => {
        marker.setVisible(true);
    });
    fitMapToMarkers();
    showMapNotification('แสดงทั้งหมด');
}

// Open directions to location
function openDirectionsTo(lat, lng) {
    const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
    window.open(url, '_blank');
}

// Show map notification
function showMapNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-orange-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    
    // Animate out and remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => document.body.removeChild(notification), 300);
    }, 2000);
}

// Initialize map when page loads
function initMapWhenReady() {
    if (typeof google !== 'undefined' && google.maps) {
        console.log('Google Maps API loaded, initializing map...');
        initializeCulturalMap();
    } else {
        console.log('Waiting for Google Maps API...');
        setTimeout(initMapWhenReady, 500);
    }
}

// Start checking when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, waiting for Google Maps API...');
    initMapWhenReady();
});

// Backup: Initialize when Google Maps callback fires
window.initMap = initializeCulturalMap;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.api_key') }}&libraries=places&callback=initMap" async defer></script>
@endif

@endsection