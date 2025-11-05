@extends('layouts.frontend')

@section('title', 'สำรวจวัฒนธรรม')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-600 text-white overflow-hidden py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">ค้นพบมรดกวัฒนธรรมไทย</h1>
        <p class="text-lg md:text-xl text-white/90 mb-8 max-w-3xl mx-auto">
            สำรวจและเรียนรู้เกี่ยวกับวัฒนธรรมไทยที่หลากหลาย ค้นหาข้อมูลที่น่าสนใจจากชุมชนต่างๆ ทั่วประเทศ
        </p>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <div class="text-2xl font-bold mb-1">{{ number_format($stats['total_items'] ?? 0) }}</div>
                <div class="text-white/80 text-sm">รายการทั้งหมด</div>
            </div>
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <div class="text-2xl font-bold mb-1">{{ number_format($stats['total_categories'] ?? 0) }}</div>
                <div class="text-white/80 text-sm">หมวดหมู่</div>
            </div>
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <div class="text-2xl font-bold mb-1">{{ number_format($stats['total_communities'] ?? 0) }}</div>
                <div class="text-white/80 text-sm">ชุมชน</div>
            </div>
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <div class="text-2xl font-bold mb-1">{{ number_format(rand(500, 2000)) }}</div>
                <div class="text-white/80 text-sm">ผู้เข้าชม</div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="py-16 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">ค้นหาและกรองข้อมูล</h2>
            <p class="text-lg text-gray-600">ใช้เครื่องมือค้นหาขั้นสูงเพื่อค้นหาวัฒนธรรมที่คุณสนใจ</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <form action="{{ route('cultural.explore') }}" method="GET" class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Search Input -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-search text-orange-500 mr-2"></i>ค้นหา
                        </label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ $search }}"
                               placeholder="พิมพ์คำค้นหา เช่น ประเพณี, อาหาร, หัตถกรรม..."
                               class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 text-lg">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-folder text-blue-500 mr-2"></i>หมวดหมู่
                        </label>
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 text-lg bg-white">
                            <option value="">ทุกหมวดหมู่</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->cultural_items_count ?? 0 }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Community Filter -->
                    <div>
                        <label for="community_id" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-users text-green-500 mr-2"></i>ชุมชน
                        </label>
                        <select id="community_id" 
                                name="community_id"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 text-lg bg-white">
                            <option value="">ทุกชุมชน</option>
                            @foreach($communities as $community)
                                <option value="{{ $community->id }}" {{ $community_id == $community->id ? 'selected' : '' }}>
                                    {{ $community->name }} ({{ $community->cultural_items_count ?? 0 }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="text-center pt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transform hover:scale-105 transition-all shadow-lg">
                        <i class="fas fa-search mr-3"></i>
                        ค้นหา
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Results Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Results Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">ผลการค้นหา</h2>
                <p class="text-gray-600">
                    @if($items->total() > 0)
                        พบ <span class="font-semibold text-orange-600">{{ number_format($items->total()) }}</span> รายการ
                        @if($search)
                            สำหรับ "<span class="font-medium text-gray-800">{{ $search }}</span>"
                        @endif
                    @else
                        <span class="text-red-600">ไม่พบรายการที่ตรงกับเงื่อนไข</span>
                    @endif
                </p>
            </div>
        </div>

        @if($items->count() > 0)
        <!-- Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($items as $item)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-2">
                    <!-- Image -->
                    <div class="relative aspect-[16/10] overflow-hidden">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" 
                                 alt="{{ $item->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                <i class="fas fa-image text-orange-400 text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Featured Badge -->
                        @if($item->is_featured)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                    <i class="fas fa-star mr-1"></i>แนะนำ
                                </span>
                            </div>
                        @endif

                        <!-- Category Badge -->
                        @if($item->category)
                        <div class="absolute top-3 right-3">
                            <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm text-blue-600 text-xs font-semibold rounded-full">
                                {{ $item->category->name }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                            <a href="{{ route('cultural-item.show', $item->id) }}">
                                {{ $item->title }}
                            </a>
                        </h3>

                        <!-- Description -->
                        @if($item->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit($item->description, 120) }}
                        </p>
                        @endif

                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            @if($item->community)
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $item->community->name }}
                            </span>
                            @endif
                            
                            @if($item->publish_date)
                            <span class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $item->publish_date->format('d/m/Y') }}
                            </span>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                           class="inline-flex items-center justify-center w-full px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-semibold rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all transform group-hover:scale-105">
                            <i class="fas fa-eye mr-2"></i>
                            ดูรายละเอียด
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $items->appends(request()->query())->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">ไม่พบรายการที่ตรงกับเงื่อนไข</h3>
            <p class="text-gray-600 mb-6">ลองปรับเปลี่ยนคำค้นหาหรือตัวกรองเพื่อหาผลลัพธ์ที่ต้องการ</p>
            <a href="{{ route('cultural.explore') }}" 
               class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors">
                <i class="fas fa-refresh mr-2"></i>
                ดูทั้งหมด
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Quick Category Access -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">หมวดหมู่ยอดนิยม</h2>
            <p class="text-lg text-gray-600">เลือกสำรวจตามหมวดหมู่ที่คุณสนใจ</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach($categories->take(12) as $category)
            <a href="{{ route('cultural.explore', ['category_id' => $category->id]) }}" 
               class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 hover:border-orange-200">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-folder text-white text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors text-sm">
                    {{ $category->name }}
                </h3>
                <p class="text-xs text-gray-500">
                    {{ $category->cultural_items_count ?? 0 }} รายการ
                </p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Popular & Latest Items -->
@if((isset($popularItems) && $popularItems->count() > 0) || (isset($latestItems) && $latestItems->count() > 0))
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Popular Items -->
            @if(isset($popularItems) && $popularItems->count() > 0)
            <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-3xl p-8 border border-orange-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-fire text-white text-lg"></i>
                    </div>
                    รายการยอดนิยม
                </h3>
                <div class="space-y-4">
                    @foreach($popularItems->take(5) as $item)
                        <div class="flex space-x-3 hover:bg-white/50 p-3 rounded-lg transition-colors">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" 
                                     alt="{{ $item->title }}"
                                     class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-800 line-clamp-2 hover:text-orange-600 transition-colors">
                                    <a href="{{ route('cultural-item.show', $item->id) }}">
                                        {{ $item->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $item->category->name ?? '' }} • {{ $item->community->name ?? '' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Latest Items -->
            @if(isset($latestItems) && $latestItems->count() > 0)
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-3xl p-8 border border-blue-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-white text-lg"></i>
                    </div>
                    รายการล่าสุด
                </h3>
                <div class="space-y-4">
                    @foreach($latestItems->take(5) as $item)
                        <div class="flex space-x-3 hover:bg-white/50 p-3 rounded-lg transition-colors">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" 
                                     alt="{{ $item->title }}"
                                     class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-800 line-clamp-2 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('cultural-item.show', $item->id) }}">
                                        {{ $item->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $item->publish_date ? $item->publish_date->format('d/m/Y') : '' }} • {{ $item->community->name ?? '' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif
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

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Form focus effects */
input:focus, select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
}

/* Card hover effects */
.cultural-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Mobile optimizations */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endpush