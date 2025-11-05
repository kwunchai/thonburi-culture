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
    <!-- Breadcrumb -->
    <nav class="bg-white border-b border-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-600 transition-colors">
                    <i class="fas fa-home"></i>
                    หน้าแรก
                </a>
                <i class="fas fa-chevron-right text-gray-400"></i>
                <a href="{{ route('cultural.explore') }}" class="text-gray-500 hover:text-orange-600 transition-colors">
                    สำรวจวัฒนธรรม
                </a>
                @if($item->category)
                <i class="fas fa-chevron-right text-gray-400"></i>
                <a href="{{ route('category', $item->category->slug) }}" class="text-orange-600 hover:text-orange-700 transition-colors font-medium">
                    {{ $item->category->name }}
                </a>
                @endif
                <i class="fas fa-chevron-right text-gray-400"></i>
                <span class="text-gray-800 font-medium">{{ Str::limit($item->title, 50) }}</span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-0">
        <!-- Hero Section - Full Width -->
        @if($item->image)
            <div class="relative h-96 overflow-hidden group mb-8">
                <!-- Background Image -->
                <img src="{{ asset('storage/' . $item->image) }}" 
                     alt="{{ $item->title }}" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 hero-zoom"
                     loading="lazy">
                
                <!-- Overlay Gradients -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
                
                <!-- Hero Content Overlay -->
                <div class="absolute inset-0 flex flex-col justify-end p-8">
                    <!-- Meta Badges -->
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        @if($item->category)
                        <span class="inline-flex items-center px-4 py-2 bg-orange-500/90 backdrop-blur-sm text-white rounded-full text-sm font-medium shadow-lg">
                            <i class="fas fa-folder mr-2"></i>
                            {{ $item->category->name }}
                        </span>
                        @endif
                        
                        @if($item->community)
                        <span class="inline-flex items-center px-4 py-2 bg-blue-500/90 backdrop-blur-sm text-white rounded-full text-sm font-medium shadow-lg">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $item->community->name }}
                        </span>
                        @endif
                        
                        <span class="inline-flex items-center px-4 py-2 bg-green-500/90 backdrop-blur-sm text-white rounded-full text-sm font-medium shadow-lg">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ $item->publish_date->format('d/m/Y') }}
                        </span>
                        
                        @if($item->creator)
                        <span class="inline-flex items-center px-4 py-2 bg-purple-500/90 backdrop-blur-sm text-white rounded-full text-sm font-medium shadow-lg">
                            <i class="fas fa-user mr-2"></i>
                            {{ $item->creator->name }}
                        </span>
                        @endif
                    </div>
                    
                    <!-- Hero Title -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight drop-shadow-2xl max-w-4xl">
                        {{ $item->title }}
                    </h1>
                    
                    <!-- Hero Description Preview -->
                    <p class="text-xl text-white/90 max-w-3xl leading-relaxed drop-shadow-lg">
                        {{ Str::limit(strip_tags($item->description), 200) }}
                    </p>
                </div>
                
                <!-- Scroll Indicator -->
                <div class="absolute bottom-6 left-1/2 animate-float">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                        <i class="fas fa-chevron-down text-white text-lg"></i>
                    </div>
                </div>
            </div>
        @else
            <div class="relative h-96 bg-gradient-to-br from-orange-400 via-red-400 to-pink-500 flex items-center justify-center mb-8">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/30"></div>
                
                <!-- No Image Content -->
                <div class="relative z-10 text-center text-white">
                    <i class="fas fa-image text-8xl mb-6 opacity-80"></i>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
                        {{ $item->title }}
                    </h1>
                    
                    <!-- Meta Badges for No Image -->
                    <div class="flex flex-wrap justify-center gap-3 mb-6">
                        @if($item->category)
                        <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium">
                            <i class="fas fa-folder mr-2"></i>
                            {{ $item->category->name }}
                        </span>
                        @endif
                        
                        @if($item->community)
                        <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $item->community->name }}
                        </span>
                        @endif
                        
                        <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ $item->publish_date->format('d/m/Y') }}
                        </span>
                    </div>
                    
                    <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                        {{ Str::limit(strip_tags($item->description), 200) }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Main Content Container - Single Column -->
        <div class="max-w-4xl mx-auto">
            <!-- Additional Meta Data Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                    ข้อมูลเพิ่มเติม
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($item->category)
                    <div class="flex items-center p-3 bg-orange-50 rounded-lg">
                        <i class="fas fa-folder text-orange-500 mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">หมวดหมู่</p>
                            <a href="{{ route('category', $item->category->slug) }}" 
                               class="font-medium text-gray-800 hover:text-orange-600 transition-colors">
                                {{ $item->category->name }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($item->community)
                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">ชุมชน</p>
                            <p class="font-medium text-gray-800">{{ $item->community->name }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center p-3 bg-green-50 rounded-lg">
                        <i class="fas fa-calendar-alt text-green-500 mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">วันที่เผยแพร่</p>
                            <p class="font-medium text-gray-800">{{ $item->publish_date->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    @if($item->creator)
                    <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                        <i class="fas fa-user text-purple-500 mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">ผู้เผยแพร่</p>
                            <p class="font-medium text-gray-800">{{ $item->creator->name }}</p>
                        </div>
                    </div>
                    @endif

                    @if($item->place)
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-building text-gray-500 mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">สถานที่</p>
                            <p class="font-medium text-gray-800">{{ $item->place->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Article Content -->
            <article class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="p-8">
                    <!-- Article Body -->
                    <div class="prose prose-lg max-w-none" id="article-content">
                        {!! nl2br(e($item->description)) !!}
                    </div>

                    <!-- Social Share -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">แชร์บทความนี้</h3>
                                <div class="flex flex-wrap gap-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fab fa-facebook-f mr-2"></i>
                                        Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($item->title) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors">
                                        <i class="fab fa-twitter mr-2"></i>
                                        Twitter
                                    </a>
                                    <button onclick="navigator.share({title: '{{ $item->title }}', url: '{{ request()->url() }}'})" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-share mr-2"></i>
                                        แชร์
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Quick Navigation -->
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('cultural.explore') }}" 
                                   class="inline-flex items-center px-3 py-2 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-200 transition-colors text-sm font-medium">
                                    <i class="fas fa-search mr-2"></i>
                                    ค้นหาเพิ่มเติม
                                </a>
                                
                                @if($item->category)
                                <a href="{{ route('category', $item->category->slug) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm font-medium">
                                    <i class="fas fa-layer-group mr-2"></i>
                                    หมวดหมู่นี้
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Google Maps Section -->
            @if($item->latitude && $item->longitude)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="p-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-map-marked-alt text-red-500 mr-2"></i>
                        ตำแหน่งที่ตั้ง
                    </h3>
                </div>
                <div id="map" class="h-80"></div>
            </div>
            @endif
        </div>

        <!-- Related Items Section -->
        @if($relatedItems->count() > 0)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-heart text-red-500 mr-3"></i>
                    รายการที่เกี่ยวข้อง
                </h3>
                <p class="text-gray-600 mt-2">สำรวจวัฒนธรรมอื่นๆ ที่น่าสนใจ</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedItems as $related)
                    <div class="group">
                        <a href="{{ route('cultural-item.show', $related->id) }}" 
                           class="block bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-orange-200 transition-all duration-300">
                            <!-- Thumbnail Image -->
                            @if($related->image)
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $related->image) }}" 
                                     alt="{{ $related->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            @else
                            <div class="h-48 bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                <i class="fas fa-image text-orange-400 text-4xl"></i>
                            </div>
                            @endif
                            
                            <!-- Card Content -->
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-800 text-lg mb-2 group-hover:text-orange-600 transition-colors line-clamp-2">
                                    {{ $related->title }}
                                </h4>
                                
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ Str::limit(strip_tags($related->description), 100) }}
                                </p>
                                
                                <!-- Related Item Meta -->
                                <div class="flex items-center justify-between">
                                    @if($related->category)
                                    <span class="inline-flex items-center px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $related->category->name }}
                                    </span>
                                    @endif
                                    
                                    <span class="text-xs text-gray-500">
                                        {{ $related->publish_date->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                
                <!-- View More Related -->
                <div class="text-center mt-8">
                    <a href="{{ route('cultural.explore') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl font-medium">
                        <i class="fas fa-search mr-2"></i>
                        สำรวจเพิ่มเติม
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection

    <!-- Additional Styles -->
    @push('head')
    <style>
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

    <!-- Google Maps JavaScript -->
    @if($item->latitude && $item->longitude)
    @push('scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.google_maps_api_key') }}&callback=initMap"></script>
    <script>
        function initMap() {
            const location = { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} };
            
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: location,
                styles: [
                    {
                        featureType: "all",
                        elementType: "geometry.fill",
                        stylers: [{ color: "#f5f5f5" }]
                    },
                    {
                        featureType: "water",
                        elementType: "geometry",
                        stylers: [{ color: "#e9e9e9" }, { lightness: 17 }]
                    }
                ]
            });

            new google.maps.Marker({
                position: location,
                map: map,
                title: "{{ $item->title }}",
                icon: {
                    url: "data:image/svg+xml;charset=UTF-8,%3csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z' fill='%23f97316'/%3e%3ccircle cx='12' cy='9' r='2.5' fill='white'/%3e%3c/svg%3e",
                    scaledSize: new google.maps.Size(40, 40),
                    anchor: new google.maps.Point(20, 40)
                }
            });
        }

        // Fallback if Google Maps fails to load
        window.addEventListener('load', function() {
            setTimeout(() => {
                if (typeof google === 'undefined') {
                    const mapElement = document.getElementById('map');
                    if (mapElement) {
                        mapElement.innerHTML = `
                            <div class="flex items-center justify-center h-full bg-gray-100 rounded-lg">
                                <div class="text-center">
                                    <i class="fas fa-map-marked-alt text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-600">ไม่สามารถโหลดแผนที่ได้</p>
                                    <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                       target="_blank" 
                                       class="inline-flex items-center mt-3 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                        <i class="fas fa-external-link-alt mr-2"></i>
                                        เปิดใน Google Maps
                                    </a>
                                </div>
                            </div>
                        `;
                    }
                }
            }, 3000);
        });
    </script>
    @endpush
    @endif