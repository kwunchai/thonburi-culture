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
    {{-- Simplified Breadcrumb Only --}}
    <section class="relative py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb Only --}}
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">
                            <i class="fas fa-home mr-1"></i>หน้าแรก
                        </a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                    <li>
                        <a href="{{ route('cultural.explore') }}" class="hover:text-orange-600 transition-colors">
                            สำรวจวัฒนธรรม
                        </a>
                    </li>
                    @if($item->category)
                        <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                        <li>
                            <a href="{{ route('cultural.explore') }}?category_id={{ $item->category->id }}" 
                               class="hover:text-orange-600 transition-colors">
                                {{ $item->category->name }}
                            </a>
                        </li>
                    @endif
                    <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                    <li class="text-gray-900 font-medium">{{ Str::limit($item->title, 50) }}</li>
                </ol>
            </nav>
        </div>
    </section>
    
    {{-- Main Content Section (Using Home Page Container Style) --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Main Content --}}
            <main class="max-w-6xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    
                    {{-- Header Section with Title Only --}}
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6">
                        @if($item->category)
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium">
                                    <i class="fas {{ $item->category->icon ?? 'fa-folder' }} mr-2"></i>
                                    {{ $item->category->name }}
                                </span>
                            </div>
                        @endif
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">{{ $item->title }}</h1>
                    </div>

                    {{-- Meta Information Bar --}}
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                            @if($item->community)
                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                                    <span class="font-medium">{{ $item->community->name }}</span>
                                </span>
                            @endif
                            
                            @if($item->creator)
                                <span class="flex items-center">
                                    <i class="fas fa-user mr-2 text-orange-500"></i>
                                    <span>โดย <span class="font-medium">{{ $item->creator->name }}</span></span>
                                </span>
                            @endif
                            
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-2 text-orange-500"></i>
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                            </span>
                            
                            <span class="flex items-center">
                                <i class="fas fa-clock mr-2 text-orange-500"></i>
                                <span>{{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาทีในการอ่าน</span>
                            </span>
                        </div>
                    </div>

                    {{-- Main Content Body --}}
                    <div class="p-4 md:p-6">
                        
                        {{-- Image Section in Content --}}
                        @if($item->image)
                            <div class="mb-6">
                                <div class="max-w-2xl mx-auto">
                                    <img src="{{ Storage::url($item->image) }}" 
                                         alt="{{ $item->title }}" 
                                         class="w-full h-auto object-contain rounded-lg shadow-lg">
                                </div>
                                
                                {{-- Image Caption --}}
                                <p class="text-sm text-gray-500 text-center mt-3">{{ $item->title }}</p>
                            </div>
                        @endif
                        
                        {{-- Description Section --}}
                        <div class="prose prose-lg max-w-none mb-6">
                            <div class="text-gray-700 leading-relaxed text-lg">
                                <p class="first-letter:text-4xl first-letter:font-bold first-letter:text-orange-500 first-letter:float-left first-letter:mr-2 first-letter:mt-1 first-letter:leading-none">
                                    {{ $item->description }}
                                </p>
                            </div>
                        </div>
                        
                        {{-- Additional Content --}}
                        @if($item->content)
                            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r-lg mb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                                    ข้อมูลเพิ่มเติม
                                </h3>
                                <div class="text-gray-700 leading-relaxed">
                                    {!! nl2br(e($item->content)) !!}
                                </div>
                            </div>
                        @endif

                        {{-- Location Information --}}
                        @if($item->latitude && $item->longitude)
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                    ที่ตั้งและการเดินทาง
                                </h3>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    {{-- Coordinates --}}
                                    <div class="space-y-3">
                                        <div class="bg-white p-3 rounded-lg shadow-sm">
                                            <h4 class="font-semibold text-gray-900 mb-2 text-sm">พิกัดที่ตั้ง</h4>
                                            <div class="space-y-1 text-sm text-gray-600">
                                                <div class="flex justify-between">
                                                    <span>ละติจูด:</span>
                                                    <span class="font-mono font-semibold">{{ $item->latitude }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>ลองจิจูด:</span>
                                                    <span class="font-mono font-semibold">{{ $item->longitude }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})" 
                                                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center text-sm">
                                            <i class="fas fa-route mr-2"></i>
                                            เส้นทางการเดินทาง
                                        </button>
                                    </div>
                                    
                                    {{-- Map Placeholder --}}
                                    <div class="bg-gray-100 rounded-lg h-32 md:h-40 flex items-center justify-center" id="mapContainer">
                                        <div class="text-center text-gray-500">
                                            <i class="fas fa-map text-2xl mb-1"></i>
                                            <p class="font-medium text-sm">แผนที่</p>
                                            <p class="text-xs">กำลังโหลด...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Additional Info Section --}}
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            {{-- Details Card --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-base font-bold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    รายละเอียด
                                </h4>
                                
                                <div class="space-y-2">
                                    @if($item->category)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">หมวดหมู่:</span>
                                            <span class="font-semibold text-gray-900">{{ $item->category->name }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($item->community)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">ชุมชน:</span>
                                            <span class="font-semibold text-gray-900">{{ $item->community->name }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">วันที่เผยแพร่:</span>
                                        <span class="font-semibold text-gray-900">{{ $item->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Map Card --}}
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <h4 class="text-base font-bold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-map-marked-alt text-green-500 mr-2"></i>
                                    แผนที่ตำแหน่ง
                                </h4>
                                
                                @if($item->latitude && $item->longitude)
                                    {{-- Interactive Map Container --}}
                                    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
                                        <div id="itemMap" style="height: 200px; min-height: 200px;" class="w-full"></div>
                                    </div>
                                    
                                    {{-- Map Controls --}}
                                    <div class="space-y-2">
                                        <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                            <div>
                                                <span class="font-semibold">ละติจูด:</span>
                                                <span class="font-mono">{{ $item->latitude }}</span>
                                            </div>
                                            <div>
                                                <span class="font-semibold">ลองจิจูด:</span>
                                                <span class="font-mono">{{ $item->longitude }}</span>
                                            </div>
                                        </div>
                                        
                                        <button onclick="openDirections({{ $item->latitude }}, {{ $item->longitude }})" 
                                                class="w-full flex items-center justify-center px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-300 text-sm">
                                            <i class="fas fa-directions mr-2"></i>
                                            เส้นทางการเดินทาง
                                        </button>
                                    </div>
                                @else
                                    {{-- No Location Available --}}
                                    <div class="text-center py-8 text-gray-500">
                                        <i class="fas fa-map-pin text-2xl mb-2"></i>
                                        <p class="text-sm">ไม่มีข้อมูลตำแหน่งที่ตั้ง</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Navigation Links --}}
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('cultural.explore') }}" 
                                   class="inline-flex items-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300 text-sm">
                                    <i class="fas fa-search mr-2"></i>
                                    สำรวจวัฒนธรรมอื่น
                                </a>
                                
                                <a href="{{ route('home') }}" 
                                   class="inline-flex items-center px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300 text-sm">
                                    <i class="fas fa-home mr-2"></i>
                                    กลับหน้าแรก
                                </a>
                                
                                @if($item->category)
                                    <a href="{{ route('cultural.explore') }}?category_id={{ $item->category->id }}" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-300 text-sm">
                                        <i class="fas fa-layer-group mr-2"></i>
                                        {{ $item->category->name }} อื่นๆ
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>
    
    {{-- Related Items Section (Using Home Page Style) --}}
    @if(isset($relatedItems) && $relatedItems->count() > 0)
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">เรื่องราวที่เกี่ยวข้อง</h2>
                <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    ข้อมูลวัฒนธรรมและเรื่องราวน่าสนใจอื่นๆ ที่คล้ายกัน
                </p>
            </div>
            
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedItems->take(8) as $related)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                            <div class="relative h-48 overflow-hidden">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" 
                                         alt="{{ $related->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <i class="fas fa-image text-5xl text-gray-400"></i>
                                    </div>
                                @endif
                                
                                {{-- Category Badge --}}
                                @if($related->category)
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 bg-orange-500/90 backdrop-blur-sm text-white rounded-full text-xs font-medium">
                                            {{ $related->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                    {{ $related->title }}
                                </h3>
                                
                                <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                    {{ Str::limit($related->description, 100) }}
                                </p>
                                
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    @if($related->community)
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $related->community->name }}
                                        </span>
                                    @endif
                                    @if($related->publish_date)
                                        <time datetime="{{ $related->publish_date->format('Y-m-d') }}">
                                            {{ $related->publish_date->format('d M Y') }}
                                        </time>
                                    @endif
                                </div>
                                
                                <div class="mt-3">
                                    <a href="{{ route('cultural-item.show', $related->id) }}" 
                                       class="inline-flex items-center text-orange-500 hover:text-orange-600 text-sm font-medium">
                                        อ่านเพิ่มเติม
                                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    
    {{-- Newsletter Section (Using Home Page Container Style) --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('frontend.partials.cultural-item.newsletter-section')
        </div>
    </section>
    
    {{-- Back to Top Button --}}
    <button id="backToTop" 
            class="fixed bottom-6 right-6 bg-orange-600 text-white p-3 rounded-full shadow-lg hover:bg-orange-700 transition-all duration-300 opacity-0 pointer-events-none transform translate-y-4"
            onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    {{-- Share Modal --}}
    @include('frontend.partials.cultural-item.share-modal')
@endsection

{{-- Google Maps API --}}
@if($item->latitude && $item->longitude)
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.google.api_key') }}&libraries=places" async defer></script>
@endif

{{-- JavaScript Functions --}}
@push('scripts')
<script>
// Image Modal Function
function openImageModal(imageSrc, title) {
    let modal = document.getElementById('imageModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'imageModal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4';
        modal.innerHTML = `
            <div class="relative max-w-6xl max-h-full">
                <img id="modalImage" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">
                <button onclick="closeImageModal()" 
                        class="absolute top-4 right-4 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
                <div class="absolute bottom-4 left-4 right-4 text-center">
                    <h3 id="modalTitle" class="text-white text-xl font-bold mb-2"></h3>
                    <p class="text-gray-300 text-sm">กดพื้นที่ว่างหรือ ESC เพื่อปิด</p>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Close on click outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeImageModal();
        });
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeImageModal();
        });
    }
    
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// Share Functions
function shareArticle() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $item->title }}',
            text: 'มาดูข้อมูลวัฒนธรรมไทยกัน - {{ $item->title }}',
            url: window.location.href
        }).catch(err => console.log('Error sharing:', err));
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            showNotification('คัดลอกลิงก์เรียบร้อยแล้ว!', 'success');
        }).catch(err => {
            showNotification('ไม่สามารถคัดลอกลิงก์ได้', 'error');
        });
    }
}

function saveBookmark() {
    // Try to add to browser bookmarks
    if (window.external && window.external.AddFavorite) {
        window.external.AddFavorite(location.href, document.title);
    } else if (window.sidebar && window.sidebar.addPanel) {
        window.sidebar.addPanel(document.title, location.href, '');
    } else {
        // Fallback - show instruction
        showNotification('กรุณาใช้ Ctrl+D เพื่อบันทึกหน้านี้', 'info');
    }
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transform translate-x-full transition-transform duration-300';
    
    // Set colors based on type
    switch(type) {
        case 'success':
            notification.classList.add('bg-green-500');
            break;
        case 'error':
            notification.classList.add('bg-red-500');
            break;
        case 'info':
        default:
            notification.classList.add('bg-orange-500');
    }
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    
    // Animate out and remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => document.body.removeChild(notification), 300);
    }, 3000);
}

@if($item->latitude && $item->longitude)
// Map Functions
function openMap(lat, lng) {
    const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
    window.open(url, '_blank');
}

// Function to open directions in Google Maps
function openDirections(lat, lng) {
    const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
    window.open(url, '_blank');
}

// Initialize Google Maps if available
document.addEventListener('DOMContentLoaded', function() {
    if (typeof google !== 'undefined' && google.maps) {
        // Initialize legacy map container (location information section)
        const mapContainer = document.getElementById('mapContainer');
        if (mapContainer) {
            // Clear placeholder
            mapContainer.innerHTML = '';
            
            // Create map
            const map = new google.maps.Map(mapContainer, {
                center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                zoom: 15,
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    }
                ]
            });
            
            // Add marker
            new google.maps.Marker({
                position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                map: map,
                title: '{{ $item->title }}',
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                    scaledSize: new google.maps.Size(32, 32)
                }
            });
        }
        
        // Initialize main item map (Map Card)
        const itemMapElement = document.getElementById('itemMap');
        if (itemMapElement) {
            const itemMap = new google.maps.Map(itemMapElement, {
                center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                zoom: 15,
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    },
                    {
                        featureType: 'transit',
                        stylers: [{ visibility: 'off' }]
                    }
                ],
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true,
                zoomControl: true
            });
            
            // Add custom marker
            const marker = new google.maps.Marker({
                position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                map: itemMap,
                title: '{{ $item->title }}',
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/orange-dot.png',
                    scaledSize: new google.maps.Size(40, 40)
                }
            });
            
            // Add info window
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div class="p-2 max-w-xs">
                        <h3 class="font-bold text-gray-900 mb-1">{{ $item->title }}</h3>
                        @if($item->community)
                        <p class="text-sm text-gray-600 mb-2">{{ $item->community->name }}</p>
                        @endif
                        <p class="text-xs text-gray-500">
                            ละติจูด: {{ $item->latitude }}<br>
                            ลองจิจูด: {{ $item->longitude }}
                        </p>
                    </div>
                `
            });
            
            // Show info window on marker click
            marker.addListener('click', function() {
                infoWindow.open(itemMap, marker);
            });
        }
    } else {
        // If Google Maps API is not loaded, try to load it
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config("maps.google.api_key") }}';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }
});
@endif

// Smooth scroll to top functionality
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide back to top button
    window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (backToTop) {
            if (window.pageYOffset > 300) {
                backToTop.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
                backToTop.classList.add('opacity-100');
            } else {
                backToTop.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                backToTop.classList.remove('opacity-100');
            }
        }
    });
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
</script>
@endpush

{{-- Remove the problematic styles push --}}
{{-- @push('styles')
    @include('frontend.partials.cultural-item.styles')
@endpush --}}