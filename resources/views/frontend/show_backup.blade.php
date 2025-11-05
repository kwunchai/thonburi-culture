@extends('layouts.frontend')

@section('title', $item->title)

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
<meta property="og:title" content="{{ $item->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
@if($item->image)
<meta property="og:image" content="{{ asset('storage/' . $item->image) }}">
@endif
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('content')
<!-- Progress Bar -->
<div id="reading-progress" class="fixed top-0 left-0 w-0 h-1 bg-gradient-to-r from-orange-500 to-red-500 z-50 transition-all duration-300"></div>

<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb Navigation -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-600 transition-colors">
                            <i class="fas fa-home mr-1"></i>
                            หน้าแรก
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </li>
                    <li>
                        <a href="{{ route('cultural.explore') }}" class="text-gray-500 hover:text-orange-600 transition-colors">
                            สำรวจวัฒนธรรม
                        </a>
                    </li>
                    @if($item->category && $item->category->slug)
                    <li>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </li>
                    <li>
                        <a href="{{ route('category', $item->category->slug) }}" class="text-orange-600 hover:text-orange-700 transition-colors font-medium">
                            <i class="fas fa-tag mr-1"></i>
                            {{ $item->category->name }}
                        </a>
                    </li>
                    @else
                    <li>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </li>
                    <li>
                        <span class="text-gray-500">{{ $item->category->name ?? 'ไม่ระบุหมวดหมู่' }}</span>
                    </li>
                    @endif
                    <li>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </li>
                    <li>
                        <span class="text-gray-800 font-medium">{{ Str::limit($item->title, 30) }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

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

                                <p class="text-sm text-gray-500 mb-1">วันที่เผยแพร่</p>
                                <p class="font-medium text-gray-800">{{ $item->publish_date->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        @if($item->creator)
                        <div class="flex items-start">
                            <i class="fas fa-user text-orange-500 mt-1 mr-3 text-sm"></i>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">ผู้เผยแพร่</p>
                                <p class="font-medium text-gray-800">{{ $item->creator->name }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Table of Contents -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6" id="toc-sidebar" style="display: none;">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                        <i class="fas fa-list text-orange-500 mr-2"></i>
                        สารบัญเนื้อหา
                    </h3>
                    <div id="table-of-contents" class="text-sm space-y-2">
                        <!-- TOC will be generated by JavaScript -->
                    </div>
                </div>

                <!-- Related Items -->
                @if(isset($relatedItems) && $relatedItems->count() > 0)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                        <i class="fas fa-lightbulb text-orange-500 mr-3"></i>
                        เนื้อหาที่เกี่ยวข้อง
                    </h3>
                    
                    <!-- Related Items Grid -->
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($relatedItems as $related)
                        <div class="group related-card">
                            <a href="{{ route('cultural-item.show', $related->id) }}" 
                               class="flex bg-gray-50 hover:bg-white rounded-xl border border-gray-200 hover:border-orange-300 hover:shadow-lg transition-all duration-300 overflow-hidden">
                                
                                <!-- Thumbnail -->
                                <div class="relative w-24 h-20 flex-shrink-0 overflow-hidden">
                                    @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" 
                                         alt="{{ $related->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <!-- Overlay on hover -->
                                    <div class="absolute inset-0 bg-orange-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    @else
                                    <div class="w-full h-full bg-gradient-to-br from-orange-100 to-red-100 flex items-center justify-center group-hover:from-orange-200 group-hover:to-red-200 transition-colors duration-300">
                                        <i class="fas fa-image text-orange-400 text-lg"></i>
                                    </div>
                                    @endif
                                    
                                    <!-- Category Badge on Image -->
                                    @if($related->category)
                                    <div class="absolute top-1 left-1">
                                        <span class="px-2 py-1 bg-black/70 text-white text-xs rounded-full">
                                            {{ Str::limit($related->category->name, 6) }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 p-3 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-800 group-hover:text-orange-600 line-clamp-2 text-sm leading-snug mb-1 transition-colors duration-200">
                                            {{ $related->title }}
                                        </h4>
                                        <p class="text-xs text-gray-600 line-clamp-1 mb-2">
                                            {{ Str::limit(strip_tags($related->description), 60) }}
                                        </p>
                                    </div>
                                    
                                    <!-- Meta Information -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <div class="flex items-center space-x-2">
                                            @if($related->community)
                                            <span class="flex items-center">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ Str::limit($related->community->name, 8) }}
                                            </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Read More Arrow -->
                                        <div class="flex items-center text-orange-500 group-hover:text-orange-600">
                                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-200"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- View All Link -->
                    <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                        <a href="{{ route('cultural.explore') }}?category={{ $item->category->id ?? '' }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-grid-3x3 mr-2"></i>
                            <span>ดูเนื้อหาทั้งหมดในหมวด {{ $item->category->name ?? 'นี้' }}</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
@section('scripts')
<style>
    /* Additional CSS for enhanced visual effects */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Smooth scroll offset for fixed header */
    html {
        scroll-padding-top: 100px;
    }
    
    /* Enhanced backdrop blur */
    .backdrop-blur-lg {
        backdrop-filter: blur(16px);
    }
    
    /* Custom gradient animations */
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient 3s ease infinite;
    }
    
    /* Hero image zoom effect */
    .hero-zoom {
        transform-origin: center;
    }
    
    /* Floating animation for scroll indicator */
    @keyframes float {
        0%, 100% { transform: translate(-50%, 0px) rotate(0deg); }
        50% { transform: translate(-50%, -10px) rotate(0deg); }
    }
    
    .animate-float {
        animation: float 2s ease-in-out infinite;
    }
    
    /* Fade in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }
    
    /* Related cards hover effect */
    .related-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    
    .related-card.animate-fade-in {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    // Reading Progress Bar with smooth animation
    let ticking = false;
    
    function updateProgressBar() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.getElementById('reading-progress').style.width = scrolled + '%';
        ticking = false;
    }

    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateProgressBar);
            ticking = true;
        }
    });

    // Hero parallax effect
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const heroImage = document.querySelector('.hero-zoom');
        if (heroImage) {
            const rate = scrolled * -0.5;
            heroImage.style.transform = `translateY(${rate}px)`;
        }
    });

    // Copy to Clipboard Function with enhanced feedback
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            
            // Success animation
            btn.innerHTML = '<i class="fas fa-check mr-2"></i>คัดลอกแล้ว!';
            btn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
            btn.classList.add('bg-green-600', 'transform', 'scale-105');
            
            setTimeout(function() {
                btn.innerHTML = originalText;
                btn.classList.remove('bg-green-600', 'transform', 'scale-105');
                btn.classList.add('bg-gray-600', 'hover:bg-gray-700');
            }, 2000);
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = window.location.href;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check mr-2"></i>คัดลอกแล้ว!';
                setTimeout(() => { btn.innerHTML = originalText; }, 2000);
            } catch (err) {
                console.error('Copy failed:', err);
            }
            document.body.removeChild(textArea);
        });
    }

    // Enhanced Table of Contents
    function generateTOC() {
        const content = document.getElementById('article-content');
        const toc = document.getElementById('table-of-contents');
        const tocSidebar = document.getElementById('toc-sidebar');
        const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');
        
        if (headings.length === 0) {
            return;
        }
        
        let tocHTML = '';
        headings.forEach(function(heading, index) {
            const id = 'heading-' + index;
            heading.id = id;
            heading.classList.add('scroll-mt-24'); // Add scroll offset
            
            const level = parseInt(heading.tagName.charAt(1));
            const indent = (level - 1) * 16;
            
            tocHTML += `
                <a href="#${id}" class="block py-2 text-gray-600 hover:text-orange-600 transition-all duration-200 hover:bg-orange-50 rounded px-2" 
                   style="padding-left: ${16 + indent}px">
                    <span class="text-orange-400 mr-2">${level === 1 ? '●' : level === 2 ? '◦' : '▸'}</span>
                    ${heading.textContent}
                </a>
            `;
        });
        
        toc.innerHTML = tocHTML;
        tocSidebar.style.display = 'block';
    }

    // Smooth scroll for TOC links with offset
    document.addEventListener('click', function(e) {
        if (e.target.closest('a[href^="#heading-"]')) {
            e.preventDefault();
            const href = e.target.closest('a').getAttribute('href');
            const target = document.querySelector(href);
            if (target) {
                const offset = 100; // Account for fixed header
                const elementPosition = target.offsetTop;
                const offsetPosition = elementPosition - offset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        }
    });

    // Scroll indicator click handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.animate-float')) {
            e.preventDefault();
            const contentStart = document.querySelector('#article-content');
            if (contentStart) {
                contentStart.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start'
                });
            }
        }
    });

    @if($item->latitude && $item->longitude)
    // Enhanced Google Maps Integration
    function initMap() {
        const itemLocation = { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} };
        
        const map = new google.maps.Map(document.getElementById('map-display'), {
            zoom: 16,
            center: itemLocation,
            styles: [
                {
                    featureType: 'poi',
                    elementType: 'labels',
                    stylers: [{ visibility: 'on' }]
                },
                {
                    featureType: 'water',
                    elementType: 'geometry',
                    stylers: [{ color: '#e9e9e9' }, { lightness: 17 }]
                },
                {
                    featureType: 'landscape',
                    elementType: 'geometry',
                    stylers: [{ color: '#f5f5f5' }, { lightness: 20 }]
                }
            ],
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true,
            zoomControl: true
        });

        // Custom marker with animation
        const marker = new google.maps.Marker({
            position: itemLocation,
            map: map,
            title: '{{ $item->title }}',
            animation: google.maps.Animation.DROP,
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                    <svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 0C7.163 0 0 7.163 0 16c0 8.837 16 24 16 24s16-15.163 16-24C32 7.163 24.837 0 16 0z" fill="#ea580c"/>
                        <circle cx="16" cy="16" r="8" fill="white"/>
                        <circle cx="16" cy="16" r="4" fill="#ea580c"/>
                    </svg>
                `),
                scaledSize: new google.maps.Size(32, 40)
            }
        });

        // Enhanced InfoWindow
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div class="p-4 max-w-sm">
                    <div class="flex items-start gap-3">
                        @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                        @endif
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-2 text-lg">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3 leading-relaxed">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>
                                    {{ number_format($item->latitude, 4) }}, {{ number_format($item->longitude, 4) }}
                                </span>
                                @if($item->community)
                                <span class="flex items-center">
                                    <i class="fas fa-home mr-1 text-blue-500"></i>
                                    {{ $item->community->name }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            `,
            maxWidth: 350
        });

        // Show info window on marker click with bounce animation
        marker.addListener('click', function() {
            marker.setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(() => marker.setAnimation(null), 2000);
            infoWindow.open(map, marker);
        });

        // Show info window by default
        setTimeout(() => infoWindow.open(map, marker), 1000);
    }

    // Load Google Maps API with error handling
    function loadGoogleMaps() {
        if (typeof google === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('maps.google_maps_api_key') }}&callback=initMap&libraries=geometry';
            script.async = true;
            script.defer = true;
            script.onerror = function() {
                const mapContainer = document.getElementById('map-display');
                if (mapContainer) {
                    mapContainer.innerHTML = `
                        <div class="flex items-center justify-center h-full bg-gray-100 text-gray-500 rounded-xl">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle text-3xl mb-3 text-orange-400"></i>
                                <p class="font-medium">ไม่สามารถโหลดแผนที่ได้</p>
                                <p class="text-sm mt-1">กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต</p>
                                <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                   target="_blank" 
                                   class="inline-flex items-center mt-3 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    เปิดใน Google Maps
                                </a>
                            </div>
                        </div>
                    `;
                }
            };
            document.head.appendChild(script);
        } else {
            initMap();
        }
    }

    // Initialize maps when page loads
    document.addEventListener('DOMContentLoaded', loadGoogleMaps);
    @endif

    // Initialize TOC when page loads
    document.addEventListener('DOMContentLoaded', generateTOC);

    // Enhanced image loading with fade-in effect
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.3s ease-in-out';
            
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });
    });

    // Add intersection observer for animations
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        });

        document.querySelectorAll('.related-card').forEach(card => {
            observer.observe(card);
        });
    });
</script>
@endsection