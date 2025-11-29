@extends('layouts.frontend-redesign')

@section('title', $item->name_th . ' - วัฒนธรรมเขตธนบุรี')
@section('meta_description', Str::limit(strip_tags($item->description_th), 160))

@php
    $breadcrumbs = [
        ['name' => 'สำรวจวัฒนธรรม', 'url' => route('cultural.explore')],
        ['name' => $item->name_th, 'url' => route('cultural.show', $item->slug)]
    ];
@endphp

@section('content')

<!-- =============================================
     HERO / IMAGE GALLERY
============================================== -->
<section class="bg-black">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-8">
        
        <!-- Main image -->
        <div class="relative aspect-[16/9] bg-gray-900 rounded-2xl overflow-hidden mb-4">
            @if($item->main_image)
                <img src="{{ Storage::url($item->main_image) }}" 
                     alt="{{ $item->name_th }}"
                     class="w-full h-full object-contain">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-image text-8xl text-gray-600"></i>
                </div>
            @endif
        </div>
        
        <!-- Thumbnail gallery -->
        @if($item->images && count($item->images) > 0)
        <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-2">
            @foreach($item->images as $image)
            <button onclick="changeMainImage('{{ Storage::url($image) }}')" 
                    class="aspect-square bg-gray-900 rounded-lg overflow-hidden hover:ring-2 hover:ring-thonburi-gold-400 transition-all">
                <img src="{{ Storage::url($image) }}" 
                     alt="รูปภาพ {{ $loop->iteration }}"
                     class="w-full h-full object-cover">
            </button>
            @endforeach
        </div>
        @endif
        
    </div>
</section>

<!-- =============================================
     MAIN CONTENT
============================================== -->
<section class="py-12 lg:py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <div class="lg:flex lg:gap-12">
            
            <!-- ========== MAIN CONTENT ========== -->
            <div class="lg:flex-1 lg:pr-8">
                
                <!-- Category badge -->
                @if($item->category)
                <div class="mb-4">
                    <x-category-badge :category="$item->category" size="lg" />
                </div>
                @endif
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-display leading-tight">
                    {{ $item->name_th }}
                </h1>
                
                <!-- English name -->
                @if($item->name_en)
                <p class="text-xl text-gray-600 mb-6">{{ $item->name_en }}</p>
                @endif
                
                <!-- Meta info -->
                <div class="flex flex-wrap gap-4 mb-8 pb-8 border-b border-thonburi-sand-200">
                    
                    <!-- Community -->
                    @if($item->community)
                    <a href="{{ route('communities.show', $item->community->slug) }}" 
                       class="inline-flex items-center space-x-2 px-4 py-2 bg-thonburi-navy-50 text-thonburi-navy-700 rounded-lg hover:bg-thonburi-navy-100 transition-colors">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="font-medium">{{ $item->community->name_th }}</span>
                    </a>
                    @endif
                    
                    <!-- Place -->
                    @if($item->place)
                    <div class="inline-flex items-center space-x-2 px-4 py-2 bg-thonburi-sand-100 text-gray-700 rounded-lg">
                        <i class="fas fa-location-dot"></i>
                        <span>{{ $item->place->name_th }}</span>
                    </div>
                    @endif
                    
                    <!-- Date added -->
                    <div class="inline-flex items-center space-x-2 text-gray-500">
                        <i class="far fa-clock"></i>
                        <span class="text-sm">เพิ่มเมื่อ {{ $item->created_at->locale('th')->translatedFormat('j F Y') }}</span>
                    </div>
                    
                </div>
                
                <!-- Description -->
                <div class="prose prose-lg max-w-none mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-book-open text-thonburi-gold-600 mr-3"></i>
                        รายละเอียด
                    </h2>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($item->description_th)) !!}
                    </div>
                </div>
                
                <!-- English description -->
                @if($item->description_en)
                <div class="prose prose-lg max-w-none mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">English Description</h2>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($item->description_en)) !!}
                    </div>
                </div>
                @endif
                
                <!-- Additional metadata -->
                @if($item->metadata && count($item->metadata) > 0)
                <div class="bg-thonburi-sand-50 rounded-2xl p-6 mb-12">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-thonburi-navy-600 mr-3"></i>
                        ข้อมูลเพิ่มเติม
                    </h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($item->metadata as $key => $value)
                        <div>
                            <dt class="text-sm font-semibold text-gray-600 mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                            <dd class="text-base text-gray-900">{{ $value }}</dd>
                        </div>
                        @endforeach
                    </dl>
                </div>
                @endif
                
                <!-- Tags -->
                @if($item->tags && count($item->tags) > 0)
                <div class="mb-12">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-tags text-thonburi-emerald-600 mr-2"></i>
                        แท็ก
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($item->tags as $tag)
                        <a href="{{ route('cultural.explore', ['search' => $tag]) }}" 
                           class="px-3 py-1.5 bg-thonburi-emerald-100 text-thonburi-emerald-700 rounded-full text-sm font-medium hover:bg-thonburi-emerald-200 transition-colors">
                            #{{ $tag }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Share buttons -->
                <div class="border-t border-thonburi-sand-200 pt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">แชร์</h3>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($item->name_th) }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center w-12 h-12 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="https://social-plugins.line.me/lineit/share?url={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center w-12 h-12 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                            <i class="fab fa-line text-xl"></i>
                        </a>
                        <button onclick="copyLink()" 
                                class="inline-flex items-center justify-center w-12 h-12 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-link text-xl"></i>
                        </button>
                    </div>
                </div>
                
            </div>
            
            <!-- ========== SIDEBAR ========== -->
            <aside class="lg:w-80 flex-shrink-0 mt-12 lg:mt-0">
                <div class="sticky top-24 space-y-6">
                    
                    <!-- Quick info card -->
                    <div class="bg-gradient-to-br from-thonburi-gold-50 to-thonburi-sand-50 border border-thonburi-gold-200 rounded-2xl p-6 shadow-soft">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-thonburi-gold-600 mr-2"></i>
                            ข้อมูลสรุป
                        </h3>
                        <dl class="space-y-3">
                            @if($item->category)
                            <div>
                                <dt class="text-sm text-gray-600 mb-1">หมวดหมู่</dt>
                                <dd><x-category-badge :category="$item->category" size="sm" /></dd>
                            </div>
                            @endif
                            
                            @if($item->community)
                            <div>
                                <dt class="text-sm text-gray-600 mb-1">ชุมชน</dt>
                                <dd class="text-base font-medium text-gray-900">{{ $item->community->name_th }}</dd>
                            </div>
                            @endif
                            
                            @if($item->place)
                            <div>
                                <dt class="text-sm text-gray-600 mb-1">สถานที่</dt>
                                <dd class="text-base font-medium text-gray-900">{{ $item->place->name_th }}</dd>
                            </div>
                            @endif
                            
                            <div>
                                <dt class="text-sm text-gray-600 mb-1">วันที่เพิ่มข้อมูล</dt>
                                <dd class="text-base font-medium text-gray-900">
                                    {{ $item->created_at->locale('th')->translatedFormat('j F Y') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    
                    <!-- Map (if coordinates available) -->
                    @if($item->place && $item->place->latitude && $item->place->longitude)
                    <div class="bg-white border border-thonburi-sand-200 rounded-2xl overflow-hidden shadow-soft">
                        <div class="p-4 bg-thonburi-navy-50 border-b border-thonburi-navy-100">
                            <h3 class="font-bold text-gray-900 flex items-center">
                                <i class="fas fa-map text-thonburi-navy-600 mr-2"></i>
                                แผนที่
                            </h3>
                        </div>
                        <div class="aspect-square bg-gray-100">
                            <div id="map" class="w-full h-full"></div>
                        </div>
                        <div class="p-4 text-sm text-gray-600">
                            <i class="fas fa-location-dot text-thonburi-terra-500 mr-2"></i>
                            {{ $item->place->address ?? $item->place->name_th }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Contact/Visit info -->
                    @if($item->contact_info || $item->opening_hours)
                    <div class="bg-white border border-thonburi-sand-200 rounded-2xl p-6 shadow-soft">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-phone text-thonburi-emerald-600 mr-2"></i>
                            ข้อมูลติดต่อ
                        </h3>
                        <div class="space-y-3 text-sm">
                            @if($item->contact_info)
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-phone text-gray-400 mt-1"></i>
                                <span class="text-gray-700">{{ $item->contact_info }}</span>
                            </div>
                            @endif
                            @if($item->opening_hours)
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-clock text-gray-400 mt-1"></i>
                                <span class="text-gray-700">{{ $item->opening_hours }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                </div>
            </aside>
            
        </div>
        
    </div>
</section>

<!-- =============================================
     RELATED ITEMS
============================================== -->
@if(isset($relatedItems) && $relatedItems->count() > 0)
<section class="py-16 bg-thonburi-sand-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <x-section-header 
            title="รายการที่เกี่ยวข้อง"
            subtitle="วัฒนธรรมอื่น ๆ ที่คุณอาจสนใจ"
            icon="fa-layer-group"
            iconColor="gold"
            align="center"
            size="md"
        />
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedItems as $relatedItem)
                <x-culture-card :item="$relatedItem" />
            @endforeach
        </div>
        
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
function changeMainImage(src) {
    const mainImage = document.querySelector('section.bg-black img');
    if (mainImage) {
        mainImage.src = src;
    }
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('คัดลอกลิงก์แล้ว!');
    });
}

// Initialize map if coordinates available
@if($item->place && $item->place->latitude && $item->place->longitude)
// Add your Google Maps initialization here
@endif
</script>
@endpush
