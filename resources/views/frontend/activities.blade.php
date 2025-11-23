@extends('layouts.frontend')

@section('title', 'กิจกรรม')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-orange-50 to-orange-100 py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                <i class="fas fa-images mr-2 sm:mr-3 text-orange-500"></i>
                กิจกรรมของเรา
            </h1>
            <div class="w-16 sm:w-24 h-1 bg-orange-500 mx-auto mb-4 sm:mb-6"></div>
            <p class="text-base sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed px-4">
                ชมภาพบรรยากาศและกิจกรรมต่างๆ ที่เกี่ยวข้องกับการอนุรักษ์และส่งเสริมมรดกทางวัฒนธรรมธนบุรี
            </p>
        </div>
    </div>
</section>

<!-- Activities Gallery Section -->
<section class="py-12 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($activities->count() > 0)
            <!-- Filter/Sort Options -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                        <i class="fas fa-photo-video mr-2 text-orange-500"></i>
                        แกลเลอรี่ภาพกิจกรรม
                    </h2>
                    <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium w-fit">
                        {{ $activities->count() }} กิจกรรม
                    </span>
                </div>
                
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <button onclick="changeView('grid')" id="gridViewBtn" 
                            class="px-3 sm:px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors active text-sm sm:text-base">
                        <i class="fas fa-th-large mr-1"></i>
                        <span class="hidden sm:inline">ตารางภาพ</span>
                    </button>
                    <button onclick="changeView('list')" id="listViewBtn" 
                            class="px-3 sm:px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm sm:text-base">
                        <i class="fas fa-list mr-1"></i>
                        <span class="hidden sm:inline">รายการ</span>
                    </button>
                </div>
            </div>

            <!-- Grid View -->
            <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                @foreach($activities as $activity)
                <div class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 sm:hover:-translate-y-2">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('activity.show', $activity) }}">
                            @if($activity->image)
                                <img src="{{ asset('storage/' . $activity->image) }}" 
                                     alt="{{ $activity->title }}" 
                                     class="w-full h-40 sm:h-48 object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-3xl sm:text-4xl text-gray-400"></i>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Additional Images Indicator -->
                        @if($activity->images && count($activity->images) > 0)
                            <div class="absolute top-2 sm:top-3 right-2 sm:right-3 bg-black bg-opacity-60 text-white px-2 py-1 rounded-full text-xs">
                                <i class="fas fa-images mr-1"></i>+{{ count($activity->images) }}
                            </div>
                        @endif
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-opacity duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100 space-x-2">
                                <button class="bg-white text-gray-800 px-2 sm:px-3 py-1 sm:py-2 rounded-full font-medium hover:bg-orange-500 hover:text-white transition-colors text-sm"
                                        onclick="event.preventDefault(); openLightbox('{{ asset('storage/' . $activity->image) }}', '{{ $activity->title }}', '{{ $activity->description }}')">
                                    <i class="fas fa-expand-alt"></i>
                                </button>
                                <a href="{{ route('activity.show', $activity) }}" 
                                   class="inline-block bg-orange-500 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-full font-medium hover:bg-orange-600 transition-colors text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3 sm:p-4">
                        <a href="{{ route('activity.show', $activity) }}">
                            <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-2 line-clamp-2 hover:text-orange-500 transition-colors">
                                {{ $activity->title }}
                            </h3>
                        </a>
                        @if($activity->description)
                            <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ Str::limit($activity->description, 120) }}</p>
                        @endif
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs sm:text-sm text-gray-500 mb-2 sm:mb-3 gap-1 sm:gap-0">
                            @if($activity->activity_date)
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1 text-orange-400"></i>
                                    <span class="truncate">{{ $activity->formatted_date }}</span>
                                </span>
                            @endif
                            @if($activity->views_count > 0)
                                <span class="flex items-center">
                                    <i class="fas fa-eye mr-1 text-blue-400"></i>
                                    <span>{{ number_format($activity->views_count) }}</span>
                                </span>
                            @endif
                        </div>
                        
                        @if($activity->location)
                            <div class="flex items-center text-xs sm:text-sm text-gray-500 mb-2 sm:mb-3">
                                <i class="fas fa-map-marker-alt mr-1 text-red-400 flex-shrink-0"></i>
                                <span class="truncate">{{ $activity->location }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between gap-2">
                            @if($activity->category)
                                <span class="inline-block px-2 py-1 bg-orange-100 text-orange-600 text-xs rounded-full flex-shrink-0">
                                    {{ $activity->category->name }}
                                </span>
                            @endif
                            
                            <a href="{{ route('activity.show', $activity) }}" 
                               class="text-orange-500 hover:text-orange-600 font-medium text-xs sm:text-sm transition-colors flex-shrink-0">
                                <span class="hidden sm:inline">ดูรายละเอียด</span>
                                <i class="fas fa-arrow-right sm:ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- List View -->
            <div id="listView" class="space-y-4 sm:space-y-6 hidden">
                @foreach($activities as $activity)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-1/3 lg:w-1/4">
                            <a href="{{ route('activity.show', $activity) }}">
                                @if($activity->image)
                                    <img src="{{ asset('storage/' . $activity->image) }}" 
                                         alt="{{ $activity->title }}" 
                                         class="w-full h-48 sm:h-32 lg:h-40 object-cover hover:opacity-90 transition-opacity">
                                @else
                                    <div class="w-full h-48 sm:h-32 lg:h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-3xl text-gray-400"></i>
                                    </div>
                                @endif
                            </a>
                        </div>
                        <div class="sm:flex-1 p-4 sm:p-6">
                            <a href="{{ route('activity.show', $activity) }}" 
                               class="block group">
                                <h3 class="text-lg sm:text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors mb-2 sm:mb-3 line-clamp-2">
                                    {{ $activity->title }}
                                </h3>
                            </a>
                            
                            @if($activity->description)
                                <p class="text-gray-600 text-sm sm:text-base mb-3 sm:mb-4 leading-relaxed line-clamp-3">
                                    {{ Str::limit($activity->description, 120) }}
                                </p>
                            @endif
                            
                            <div class="space-y-2 sm:space-y-3">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-500">
                                    @if($activity->activity_date)
                                        <span class="flex items-center bg-gray-100 px-2 sm:px-3 py-1 rounded-full">
                                            <i class="fas fa-calendar mr-1 sm:mr-2 text-orange-500"></i>
                                            <span>{{ $activity->formatted_date }}</span>
                                        </span>
                                    @endif
                                    @if($activity->location)
                                        <span class="flex items-center bg-gray-100 px-2 sm:px-3 py-1 rounded-full">
                                            <i class="fas fa-map-marker-alt mr-1 sm:mr-2 text-orange-500 flex-shrink-0"></i>
                                            <span class="truncate">{{ $activity->location }}</span>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between gap-2">
                                    @if($activity->category)
                                        <span class="inline-block px-2 sm:px-3 py-1 bg-orange-100 text-orange-600 text-xs sm:text-sm rounded-full">
                                            {{ $activity->category->name }}
                                        </span>
                                    @endif
                                    
                                    <a href="{{ route('activity.show', $activity) }}" 
                                       class="bg-orange-500 hover:bg-orange-600 text-white px-3 sm:px-4 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors flex items-center gap-1 sm:gap-2">
                                        <span class="hidden sm:inline">ดูรายละเอียด</span>
                                        <span class="sm:hidden">ดู</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-images text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">ยังไม่มีกิจกรรม</h3>
                    <p class="text-gray-600 mb-6">ขณะนี้ยังไม่มีภาพกิจกรรมที่แสดง กรุณากลับมาดูใหม่อีกครั้ง</p>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-home mr-2"></i>
                        กลับหน้าแรก
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-2 sm:p-4">
    <div class="relative max-w-5xl max-h-full">
        <button onclick="closeLightbox()" 
                class="absolute top-2 sm:top-4 right-2 sm:right-4 text-white hover:text-orange-400 transition-colors z-10 bg-black bg-opacity-50 rounded-full p-1 sm:p-2">
            <i class="fas fa-times text-lg sm:text-xl"></i>
        </button>
        
        <img id="lightboxImage" src="" alt="" class="max-w-full max-h-[85vh] sm:max-h-screen object-contain">
        
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3 sm:p-6">
            <h3 id="lightboxTitle" class="text-white text-lg sm:text-xl font-bold mb-1 sm:mb-2"></h3>
            <p id="lightboxDescription" class="text-gray-300 text-sm sm:text-base"></p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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
@endpush

@push('scripts')
<script>
// View Toggle Functions
function changeView(viewType) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
    if (viewType === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.remove('bg-gray-200', 'text-gray-700');
        gridBtn.classList.add('bg-orange-500', 'text-white');
        listBtn.classList.remove('bg-orange-500', 'text-white');
        listBtn.classList.add('bg-gray-200', 'text-gray-700');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.remove('bg-gray-200', 'text-gray-700');
        listBtn.classList.add('bg-orange-500', 'text-white');
        gridBtn.classList.remove('bg-orange-500', 'text-white');
        gridBtn.classList.add('bg-gray-200', 'text-gray-700');
    }
}

// Lightbox Functions
function openLightbox(imageSrc, title, description) {
    const modal = document.getElementById('lightboxModal');
    const image = document.getElementById('lightboxImage');
    const titleEl = document.getElementById('lightboxTitle');
    const descEl = document.getElementById('lightboxDescription');
    
    image.src = imageSrc;
    image.alt = title;
    titleEl.textContent = title;
    descEl.textContent = description || '';
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const modal = document.getElementById('lightboxModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close lightbox on background click
document.getElementById('lightboxModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});

// Close lightbox with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});
</script>
@endpush