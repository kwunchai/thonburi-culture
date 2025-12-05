@extends('layouts.frontend-redesign')

@section('title', 'สำรวจวัฒนธรรม - วัฒนธรรมเขตธนบุรี')
@section('meta_description', 'สำรวจและค้นหามรดกทางวัฒนธรรมเขตธนบุรี พร้อมกรองตามหมวดหมู่และชุมชน')

@php
    $breadcrumbs = [
        ['name' => 'สำรวจวัฒนธรรม', 'url' => route('cultural.explore')]
    ];
@endphp

@section('content')

<!-- =============================================
     PAGE HEADER
============================================== -->
<section class="bg-gradient-to-br from-thonburi-gold-100 via-thonburi-sand-100 to-white py-12 lg:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-thonburi-gold-400 to-thonburi-gold-600 rounded-2xl shadow-lg mb-4">
                <i class="fas fa-compass text-2xl text-white"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3 font-display">
                สำรวจวัฒนธรรม
            </h1>
            <p class="text-lg text-gray-600">
                ค้นพบมรดกทางวัฒนธรรมและเรื่องราวจากชุมชนในเขตธนบุรี
            </p>
        </div>
        
        <!-- Search bar -->
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('cultural.explore') }}" method="GET" id="search-form">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <i class="fas fa-search text-xl text-gray-400"></i>
                    </div>
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="ค้นหาชื่อ คำอธิบาย หรือสถานที่..."
                           class="w-full pl-16 pr-32 py-4 bg-white border-2 border-thonburi-sand-300 rounded-xl text-lg focus:border-thonburi-gold-500 focus:ring-4 focus:ring-thonburi-gold-100 outline-none transition-all shadow-md">
                    <button type="submit"
                            class="absolute right-2 top-2 bottom-2 px-8 bg-gradient-to-r from-thonburi-gold-500 to-thonburi-gold-600 text-white rounded-lg font-bold hover:shadow-lg transition-all">
                        ค้นหา
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</section>

<!-- =============================================
     FILTERS & CONTENT
============================================== -->
<section class="py-8 lg:py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <div class="lg:flex lg:gap-8">
            
            <!-- ========== SIDEBAR FILTERS (Desktop) ========== -->
            <aside class="hidden lg:block lg:w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-6">
                    
                    <!-- Category filter -->
                    <div class="bg-white border border-thonburi-sand-200 rounded-xl p-5 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-th-large text-thonburi-gold-600 mr-2"></i>
                            หมวดหมู่
                        </h3>
                        <div class="space-y-2 max-h-80 overflow-y-auto">
                            @foreach($categories as $category)
                            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-thonburi-sand-50 cursor-pointer transition-colors">
                                <input type="checkbox" 
                                       name="categories[]" 
                                       value="{{ $category->slug }}"
                                       {{ in_array($category->slug, request('categories', [])) ? 'checked' : '' }}
                                       onchange="document.getElementById('filter-form').submit()"
                                       class="w-4 h-4 text-thonburi-gold-600 border-gray-300 rounded focus:ring-thonburi-gold-500">
                                <span class="text-sm text-gray-700 flex-1">{{ $category->name_th }}</span>
                                <span class="text-xs text-gray-400">{{ $category->items_count ?? 0 }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Community filter -->
                    <div class="bg-white border border-thonburi-sand-200 rounded-xl p-5 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt text-thonburi-navy-600 mr-2"></i>
                            ชุมชน
                        </h3>
                        <div class="space-y-2 max-h-80 overflow-y-auto">
                            @foreach($communities as $community)
                            <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-thonburi-sand-50 cursor-pointer transition-colors">
                                <input type="checkbox" 
                                       name="communities[]" 
                                       value="{{ $community->slug }}"
                                       {{ in_array($community->slug, request('communities', [])) ? 'checked' : '' }}
                                       onchange="document.getElementById('filter-form').submit()"
                                       class="w-4 h-4 text-thonburi-navy-600 border-gray-300 rounded focus:ring-thonburi-navy-500">
                                <span class="text-sm text-gray-700 flex-1">{{ $community->name_th }}</span>
                                <span class="text-xs text-gray-400">{{ $community->items_count ?? 0 }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Clear filters -->
                    @if(request()->has('categories') || request()->has('communities') || request()->has('search'))
                    <a href="{{ route('cultural.explore') }}" 
                       class="block w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center rounded-lg font-medium transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        ล้างตัวกรอง
                    </a>
                    @endif
                    
                </div>
            </aside>
            
            <!-- ========== MAIN CONTENT ========== -->
            <div class="flex-1 min-w-0">
                
                <!-- Mobile filter button -->
                <div class="lg:hidden mb-6">
                    <button onclick="toggleMobileFilters()" 
                            class="w-full px-4 py-3 bg-white border-2 border-thonburi-sand-300 rounded-xl font-medium text-gray-700 hover:bg-thonburi-sand-50 transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-filter"></i>
                        <span>ตัวกรอง</span>
                        <span class="px-2 py-0.5 bg-thonburi-gold-100 text-thonburi-gold-700 rounded-full text-xs">
                            {{ count(request('categories', [])) + count(request('communities', [])) }}
                        </span>
                    </button>
                </div>
                
                <!-- Results header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    
                    <!-- Results count -->
                    <div class="text-gray-600">
                        พบ <span class="font-bold text-gray-900">{{ $items->total() }}</span> รายการ
                        @if(request('search'))
                            <span class="text-sm">
                                สำหรับ "<span class="font-semibold text-thonburi-gold-600">{{ request('search') }}</span>"
                            </span>
                        @endif
                    </div>
                    
                    <!-- Sort dropdown -->
                    <form action="{{ route('cultural.explore') }}" method="GET" id="filter-form" class="hidden">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @foreach(request('categories', []) as $cat)
                            <input type="hidden" name="categories[]" value="{{ $cat }}">
                        @endforeach
                        @foreach(request('communities', []) as $comm)
                            <input type="hidden" name="communities[]" value="{{ $comm }}">
                        @endforeach
                    </form>
                    
                    <select name="sort" 
                            onchange="this.form = document.getElementById('filter-form'); this.form.appendChild(this); this.form.submit();"
                            class="px-4 py-2 bg-white border border-thonburi-sand-300 rounded-lg text-sm focus:border-thonburi-gold-500 focus:ring-2 focus:ring-thonburi-gold-100 outline-none">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>ล่าสุด</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>เก่าสุด</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>ชื่อ ก-ฮ</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>ชื่อ ฮ-ก</option>
                    </select>
                </div>
                
                <!-- Active filters display -->
                @if(request()->has('categories') || request()->has('communities'))
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="text-sm text-gray-600">ตัวกรองที่ใช้:</span>
                    
                    @foreach(request('categories', []) as $catSlug)
                        @php $cat = $categories->firstWhere('slug', $catSlug); @endphp
                        @if($cat)
                        <span class="inline-flex items-center space-x-2 px-3 py-1.5 bg-thonburi-gold-100 text-thonburi-gold-700 rounded-full text-sm">
                            <span>{{ $cat->name_th }}</span>
                            <button onclick="removeFilter('categories[]', '{{ $catSlug }}')" class="hover:text-thonburi-gold-900">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                        @endif
                    @endforeach
                    
                    @foreach(request('communities', []) as $commSlug)
                        @php $comm = $communities->firstWhere('slug', $commSlug); @endphp
                        @if($comm)
                        <span class="inline-flex items-center space-x-2 px-3 py-1.5 bg-thonburi-navy-100 text-thonburi-navy-700 rounded-full text-sm">
                            <span>{{ $comm->name_th }}</span>
                            <button onclick="removeFilter('communities[]', '{{ $commSlug }}')" class="hover:text-thonburi-navy-900">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                        @endif
                    @endforeach
                </div>
                @endif
                
                <!-- Items grid -->
                @if($items->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8 mb-12">
                        @foreach($items as $item)
                            <x-culture-card :item="$item" />
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $items->links('vendor.pagination.tailwind-custom') }}
                    </div>
                @else
                    <!-- Empty state -->
                    <div class="text-center py-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-thonburi-sand-100 rounded-full mb-6">
                            <i class="fas fa-search text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">ไม่พบรายการที่ค้นหา</h3>
                        <p class="text-gray-600 mb-8">
                            ลองปรับเงื่อนไขการค้นหาหรือตัวกรองใหม่อีกครั้ง
                        </p>
                        <a href="{{ route('cultural.explore') }}" 
                           class="inline-flex items-center space-x-2 px-6 py-3 bg-thonburi-gold-500 hover:bg-thonburi-gold-600 text-white rounded-lg font-medium transition-colors">
                            <i class="fas fa-redo"></i>
                            <span>รีเซ็ตการค้นหา</span>
                        </a>
                    </div>
                @endif
                
            </div>
            
        </div>
        
    </div>
</section>

<!-- Mobile filters modal -->
<div id="mobile-filters" class="hidden fixed inset-0 z-50 overflow-y-auto lg:hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="toggleMobileFilters()"></div>
        
        <!-- Modal panel -->
        <div class="relative inline-block bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
            
            <!-- Header -->
            <div class="bg-thonburi-gold-500 px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">ตัวกรอง</h3>
                <button onclick="toggleMobileFilters()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Filters content -->
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                
                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-3">หมวดหมู่</h4>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                        <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-thonburi-sand-50 cursor-pointer">
                            <input type="checkbox" 
                                   class="w-4 h-4 text-thonburi-gold-600 border-gray-300 rounded"
                                   data-filter-type="categories"
                                   data-filter-value="{{ $category->slug }}"
                                   {{ in_array($category->slug, request('categories', [])) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700 flex-1">{{ $category->name_th }}</span>
                            <span class="text-xs text-gray-400">{{ $category->items_count ?? 0 }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Communities -->
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-3">ชุมชน</h4>
                    <div class="space-y-2">
                        @foreach($communities as $community)
                        <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-thonburi-sand-50 cursor-pointer">
                            <input type="checkbox" 
                                   class="w-4 h-4 text-thonburi-navy-600 border-gray-300 rounded"
                                   data-filter-type="communities"
                                   data-filter-value="{{ $community->slug }}"
                                   {{ in_array($community->slug, request('communities', [])) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700 flex-1">{{ $community->name_th }}</span>
                            <span class="text-xs text-gray-400">{{ $community->items_count ?? 0 }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
            </div>
            
            <!-- Footer buttons -->
            <div class="bg-gray-50 px-6 py-4 flex gap-3">
                <button onclick="clearMobileFilters()" 
                        class="flex-1 px-4 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    ล้างตัวกรอง
                </button>
                <button onclick="applyMobileFilters()" 
                        class="flex-1 px-4 py-3 bg-thonburi-gold-500 hover:bg-thonburi-gold-600 text-white rounded-lg font-medium transition-colors">
                    ใช้ตัวกรอง
                </button>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleMobileFilters() {
    document.getElementById('mobile-filters').classList.toggle('hidden');
}

function removeFilter(name, value) {
    const form = document.getElementById('filter-form');
    const inputs = form.querySelectorAll(`input[name="${name}"][value="${value}"]`);
    inputs.forEach(input => input.remove());
    form.submit();
}

function applyMobileFilters() {
    const form = document.getElementById('filter-form');
    const checkboxes = document.querySelectorAll('#mobile-filters input[type="checkbox"]:checked');
    
    // Remove existing filter inputs
    form.querySelectorAll('input[name="categories[]"], input[name="communities[]"]').forEach(el => el.remove());
    
    // Add checked filters
    checkboxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = checkbox.dataset.filterType + '[]';
        input.value = checkbox.dataset.filterValue;
        form.appendChild(input);
    });
    
    form.submit();
}

function clearMobileFilters() {
    window.location.href = '{{ route("cultural.explore") }}';
}
</script>
@endpush
