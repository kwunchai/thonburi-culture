@extends('layouts.frontend')

@section('title', $activity->title . ' - กิจกรรม')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(180deg, #FFF7ED 0%, #FAFAFA 30%, #FAFAFA 100%);">
    <!-- Hero Section -->
    <div class="relative min-h-[400px] sm:min-h-[450px] md:min-h-[500px] bg-gradient-to-r from-orange-500 via-pink-500 to-rose-500 overflow-hidden">
        <!-- Decorative Pattern Overlay -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/40"></div>
        
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center py-12 sm:py-16">
            <div class="w-full max-w-5xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="text-sm mb-4 sm:mb-6 flex items-center flex-wrap gap-2">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/15 hover:bg-white/25 backdrop-blur-sm rounded-lg transition-all duration-300 text-white font-medium border border-white/20 hover:border-white/40">
                        <i class="fas fa-home text-sm"></i>
                        <span>หน้าแรก</span>
                    </a>
                    
                    <i class="fas fa-chevron-right text-white/70 text-sm"></i>
                    
                    <a href="{{ route('activities') }}" 
                       class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/15 hover:bg-white/25 backdrop-blur-sm rounded-lg transition-all duration-300 text-white font-medium border border-white/20 hover:border-white/40">
                        <i class="fas fa-calendar-alt text-sm"></i>
                        <span>กิจกรรม</span>
                    </a>
                    
                    <i class="fas fa-chevron-right text-white/70 text-sm"></i>
                    
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-orange-400/30 backdrop-blur-sm rounded-lg text-white font-semibold border border-orange-300/50">
                        <i class="fas fa-location-dot text-sm"></i>
                        <span class="line-clamp-1 max-w-[200px]">{{ Str::limit($activity->title, 30) }}</span>
                    </span>
                </nav>

                <!-- Category Icon Decorator -->
                <div class="mb-4 sm:mb-6 flex items-center gap-3">
                    @if($activity->category)
                        <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium border border-white/30 shadow-lg">
                            <i class="fas fa-tag mr-2"></i>{{ $activity->category->name }}
                        </span>
                    @endif
                    
                    @if($activity->is_upcoming)
                        <span class="inline-flex items-center px-3 py-1.5 bg-blue-500/80 backdrop-blur-sm text-white rounded-full text-xs font-medium border border-white/30">
                            <span class="w-1.5 h-1.5 bg-white rounded-full mr-2 animate-pulse"></span>
                            กำลังจะมาถึง
                        </span>
                    @endif
                </div>
                
                <!-- Main Title with Icon -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex items-start gap-3 sm:gap-4 mb-4">
                        <!-- Dynamic Icon based on category -->
                        <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30 shadow-xl">
                            @if($activity->category && str_contains(strtolower($activity->category->name), 'ประเพณี'))
                                <span class="text-2xl sm:text-4xl">🏮</span>
                            @elseif($activity->category && str_contains(strtolower($activity->category->name), 'วัฒนธรรม'))
                                <span class="text-2xl sm:text-4xl">🎭</span>
                            @elseif($activity->category && str_contains(strtolower($activity->category->name), 'เทศกาล'))
                                <span class="text-2xl sm:text-4xl">🎊</span>
                            @elseif($activity->category && str_contains(strtolower($activity->category->name), 'ศาสนา'))
                                <span class="text-2xl sm:text-4xl">🙏</span>
                            @else
                                <span class="text-2xl sm:text-4xl">🎉</span>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-3 sm:mb-4 drop-shadow-lg" style="text-shadow: 2px 4px 8px rgba(0,0,0,0.3);">
                                {{ $activity->title }}
                            </h1>
                            
                            <!-- Decorative Divider -->
                            <div class="flex items-center gap-3 mb-4">
                                <div class="h-1 bg-gradient-to-r from-white via-white/80 to-transparent rounded-full w-32 sm:w-48"></div>
                                <div class="w-2 h-2 bg-white rounded-full"></div>
                                <div class="w-1.5 h-1.5 bg-white/70 rounded-full"></div>
                                <div class="w-1 h-1 bg-white/50 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Info Pills -->
                    <div class="flex flex-wrap gap-3 items-center text-white/90">
                        @if($activity->activity_date)
                            <div class="flex items-center px-4 py-2 bg-white/15 backdrop-blur-sm rounded-full text-sm border border-white/20">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span class="font-medium">{{ $activity->formatted_date }}</span>
                            </div>
                        @endif
                        
                        @if($activity->location)
                            <div class="flex items-center px-4 py-2 bg-white/15 backdrop-blur-sm rounded-full text-sm border border-white/20">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span class="font-medium line-clamp-1">{{ Str::limit($activity->location, 30) }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center px-4 py-2 bg-white/15 backdrop-blur-sm rounded-full text-sm border border-white/20">
                            <i class="fas fa-eye mr-2"></i>
                            <span class="font-medium">{{ number_format($activity->views_count) }} views</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Details -->
    <div class="relative" style="background: #FAFAFA;">
        <!-- Decorative Top Border -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-400 via-pink-400 to-rose-400"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" style="max-width: 1200px;">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            <!-- Left Column (65%) - Main Content -->
            <div class="lg:col-span-8">
                <!-- Hero Image -->
                @if($activity->image)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="relative group cursor-pointer" onclick="openMainImageLightbox()">
                        <img src="{{ asset('storage/' . $activity->image) }}" 
                             alt="{{ $activity->title }}"
                             class="w-full h-64 sm:h-80 lg:h-96 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                            <div class="bg-white bg-opacity-90 rounded-full p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-search-plus text-gray-800 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- รายละเอียดการจัดงาน -->
                @if($activity->description || $activity->details)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 lg:p-8 mb-6 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center border-b pb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        รายละเอียดการจัดงาน
                    </h3>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-4">
                        @if($activity->description)
                            {!! nl2br(e($activity->description)) !!}
                        @endif
                        @if($activity->details)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                {!! nl2br(e($activity->details)) !!}
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ประวัติความเป็นมา -->
                @if($activity->history || $activity->background)
                <div class="bg-white rounded-2xl shadow-md p-6 lg:p-8 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center border-b pb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-book-open text-white"></i>
                        </div>
                        ประวัติความเป็นมา
                    </h3>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($activity->history ?? $activity->background)) !!}
                    </div>
                </div>
                @endif

                <!-- สถานที่จัดกิจกรรม -->
                @if($activity->location)
                @php
                    // สร้าง URL สำหรับเปิด Google Maps
                    $mapUrl = $activity->map_url ?? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($activity->location);
                @endphp
                <div class="bg-white rounded-2xl shadow-md p-6 lg:p-8 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center border-b pb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        สถานที่จัดกิจกรรม
                    </h3>
                    
                    <div class="p-6 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-600 text-2xl mr-4"></i>
                            <a href="{{ $mapUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-xl font-semibold text-blue-700 hover:text-blue-900 hover:underline transition-colors duration-200 flex items-center">
                                {{ $activity->location }}
                                <i class="fas fa-external-link-alt text-sm ml-2 text-blue-500"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- อัลบั้มรูปกิจกรรม -->
                @if($activity->images && count($activity->images) > 0)
                <div class="bg-white rounded-2xl shadow-md p-6 lg:p-8 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center border-b pb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        อัลบั้มรูปกิจกรรม
                        <span class="ml-auto text-sm font-normal text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            {{ count($activity->images) }} รูป
                        </span>
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 lg:gap-4">
                        @foreach($activity->images as $index => $imagePath)
                        <div class="group cursor-pointer relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300" onclick="openLightbox({{ $index }})">
                            <img src="{{ asset('storage/' . $imagePath) }}" 
                                 alt="รูปภาพกิจกรรม {{ $index + 1 }}"
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                <div class="bg-white/90 rounded-full p-3 transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fas fa-search-plus text-gray-800 text-xl"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-white text-xs font-medium text-center">
                                    <i class="fas fa-eye mr-1"></i>คลิกเพื่อดูขนาดเต็ม
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column (35%) - Side Panel -->
            <div class="lg:col-span-4">
                <!-- Empty sidebar or other widgets can go here -->
            </div>
        </div>
    </div>

    <!-- Related Activities Section (Full Width) -->
    @if($relatedActivities->count() > 0)
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-calendar-alt text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    กิจกรรมที่เกี่ยวข้อง
                </h2>
                <p class="text-gray-600 text-lg">
                    <i class="fas fa-list-ul mr-2 text-orange-500"></i>
                    สำรวจกิจกรรมอื่น ๆ ที่น่าสนใจ
                    <span class="inline-flex items-center ml-2 px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">
                        {{ $relatedActivities->count() }} รายการ
                    </span>
                </p>
            </div>

            <!-- 4-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($relatedActivities as $related)
                <a href="{{ route('activity.show', $related) }}" 
                   class="group block">
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-orange-300 hover:shadow-xl transition-all duration-300 h-full">
                        <!-- Image -->
                        @if($related->image)
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $related->image) }}" 
                                 alt="{{ $related->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Category Badge -->
                            @if($related->category)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2.5 py-1 bg-orange-500 text-white rounded-lg text-xs font-semibold shadow-lg">
                                    <i class="fas fa-tag mr-1.5"></i>
                                    {{ $related->category->name }}
                                </span>
                            </div>
                            @endif

                            <!-- Hover Icon -->
                            <div class="absolute bottom-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 shadow-lg">
                                <i class="fas fa-arrow-right text-orange-500 text-sm"></i>
                            </div>
                        </div>
                        @else
                        <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                        @endif

                        <!-- Content -->
                        <div class="p-4">
                            <h4 class="font-bold text-gray-900 group-hover:text-orange-600 transition-colors text-base leading-tight mb-3 line-clamp-2 min-h-[3rem]">
                                {{ $related->title }}
                            </h4>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                @if($related->activity_date)
                                <div class="flex items-center gap-1.5 flex-1">
                                    <i class="far fa-calendar text-orange-500"></i>
                                    <span>{{ \Carbon\Carbon::parse($related->activity_date)->locale('th')->isoFormat('D MMM YY') }}</span>
                                </div>
                                @endif
                                
                                <div class="flex items-center gap-1 text-orange-600 font-semibold">
                                    <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="text-center mt-10">
                <a href="{{ route('activities') }}" 
                   class="inline-flex items-center justify-center gap-3 py-4 px-8 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 transform active:scale-95">
                    <i class="fas fa-th-large text-xl"></i>
                    <span>ดูกิจกรรมทั้งหมด</span>
                    <i class="fas fa-arrow-right text-xl"></i>
                </a>
                <p class="text-gray-500 mt-4 text-sm">
                    <i class="fas fa-sparkles mr-1 text-orange-400"></i>
                    สำรวจกิจกรรมวัฒนธรรมธนบุรีอื่น ๆ อีกมากมาย
                </p>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Footer Gradient -->
    <div class="h-24 bg-gradient-to-b from-transparent to-gray-100"></div>
</div>

<!-- Image Lightbox Modal -->
@if($activity->images && count($activity->images) > 0 || $activity->image)
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 items-center justify-center p-2 sm:p-4 hidden">
    <div class="relative max-w-4xl max-h-full w-full">
        <button onclick="closeLightbox()" class="absolute top-2 right-2 sm:top-4 sm:right-4 text-white text-xl sm:text-2xl hover:text-gray-300 z-10 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center">
            <i class="fas fa-times"></i>
        </button>
        @if($activity->images && count($activity->images) > 0)
        <button onclick="prevImage()" class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 text-white text-xl sm:text-2xl hover:text-gray-300 z-10 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-black bg-opacity-50 rounded-full">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button onclick="nextImage()" class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 text-white text-xl sm:text-2xl hover:text-gray-300 z-10 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-black bg-opacity-50 rounded-full">
            <i class="fas fa-chevron-right"></i>
        </button>
        @endif
        <img id="lightboxImage" src="" alt="" class="max-w-full max-h-full object-contain mx-auto">
        <div class="absolute bottom-2 sm:bottom-4 left-1/2 transform -translate-x-1/2 text-white text-center bg-black bg-opacity-50 px-3 py-1 rounded-full">
            <span id="imageCounter" class="text-sm sm:text-base">
                @if($activity->images && count($activity->images) > 0)
                    1 / {{ count($activity->images) }}
                @else
                    รูปภาพหลัก
                @endif
            </span>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    /* Enhanced Depth & Contrast */
    .shadow-soft {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06), 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .shadow-strong {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    /* Section Dividers */
    .section-divider {
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(251, 146, 60, 0.2) 20%, 
            rgba(251, 146, 60, 0.2) 80%, 
            transparent 100%
        );
        height: 1px;
        margin: 2rem 0;
    }

    /* Card Elevation Levels */
    .card-level-1 {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .card-level-2 {
        background: #FFFFFF;
        border: 1px solid #D1D5DB;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Subtle Background Pattern */
    .bg-pattern {
        background-image: 
            radial-gradient(circle at 20% 50%, rgba(251, 146, 60, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(236, 72, 153, 0.03) 0%, transparent 50%);
    }

    /* Zone Separators */
    .zone-separator {
        position: relative;
    }

    .zone-separator::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, 
            transparent, 
            #FB923C 20%, 
            #FB923C 80%, 
            transparent
        );
        border-radius: 2px;
    }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #f97316, #ec4899);
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #ea580c, #db2777);
    }
    
    /* Line Clamp Utilities */
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

    /* Smooth Animations */
    .sticky {
        position: -webkit-sticky;
        position: sticky;
    }

    /* Hero Section Animations */
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

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }
        50% {
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.6);
        }
    }

    h1 {
        animation: fadeInUp 0.8s ease-out;
    }

    .breadcrumb-nav {
        animation: slideInLeft 0.6s ease-out;
    }

    /* Breadcrumb Styles */
    nav a {
        position: relative;
    }

    nav a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: white;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    nav a:hover::after {
        width: 80%;
    }

    @keyframes breadcrumb-fade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    nav > * {
        animation: breadcrumb-fade 0.5s ease-out;
    }

    nav > *:nth-child(1) { animation-delay: 0.1s; }
    nav > *:nth-child(2) { animation-delay: 0.2s; }
    nav > *:nth-child(3) { animation-delay: 0.3s; }
    nav > *:nth-child(4) { animation-delay: 0.4s; }
    nav > *:nth-child(5) { animation-delay: 0.5s; }

    /* Backdrop Blur Support */
    @supports ((-webkit-backdrop-filter: blur(10px)) or (backdrop-filter: blur(10px))) {
        .backdrop-blur-sm {
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
        }
        .backdrop-blur-md {
            -webkit-backdrop-filter: blur(16px);
            backdrop-filter: blur(16px);
        }
    }

    /* Text Shadow Enhancement */
    .text-shadow-lg {
        text-shadow: 2px 4px 12px rgba(0, 0, 0, 0.4);
    }

    /* Gradient Animation */
    @keyframes gradient-shift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    .gradient-animated {
        background-size: 200% 200%;
        animation: gradient-shift 15s ease infinite;
    }

    /* Mini Cards Hover Effects */
    .mini-card-hover:hover {
        background-color: #FFF7E6;
        transform: translateX(2px);
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .mini-card {
        animation: slideInRight 0.3s ease-out;
    }

    /* Thumbnail Zoom Effect */
    .thumbnail-zoom {
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .thumbnail-zoom:hover {
        transform: scale(1.1) rotate(2deg);
    }

    /* Arrow Slide Effect */
    .arrow-slide {
        transition: transform 0.3s ease;
    }

    .group:hover .arrow-slide {
        transform: translateX(4px);
    }

    /* CTA Button Effects */
    .cta-button {
        position: relative;
        overflow: hidden;
    }

    .cta-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .cta-button:hover::before {
        left: 100%;
    }

    @keyframes pulse-scale {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    /* Button Glow Effect */
    @keyframes button-glow {
        0%, 100% {
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.4);
        }
        50% {
            box-shadow: 0 6px 25px rgba(255, 140, 66, 0.6);
        }
    }
</style>
@endpush

@push('scripts')
<script>
let currentImageIndex = 0;
const images = @json($activity->images ? array_map(function($path) { return asset('storage/' . $path); }, $activity->images) : []);

function openLightbox(index) {
    if (images.length > 0) {
        currentImageIndex = index;
        updateLightboxImage();
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function openMainImageLightbox() {
    const mainImage = '{{ $activity->image ? asset("storage/" . $activity->image) : "" }}';
    if (mainImage) {
        document.getElementById('lightboxImage').src = mainImage;
        document.getElementById('imageCounter').textContent = 'รูปภาพหลัก';
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    updateLightboxImage();
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    updateLightboxImage();
}

function updateLightboxImage() {
    if (images.length > 0) {
        document.getElementById('lightboxImage').src = images[currentImageIndex];
        document.getElementById('imageCounter').textContent = `${currentImageIndex + 1} / ${images.length}`;
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('lightbox').classList.contains('hidden')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
    }
});
</script>
@endpush

@push('styles')
<style>
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.prose {
    line-height: 1.7;
}

.prose p {
    margin-bottom: 1rem;
}
</style>
@endpush
@endsection