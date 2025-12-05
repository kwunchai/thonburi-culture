@extends('layouts.frontend')

@section('title', 'สำรวจวัฒนธรรม')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-orange-400 via-orange-500 to-red-600 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute transform rotate-45 -top-20 -right-20 w-40 h-40 bg-white rounded-3xl"></div>
        <div class="absolute transform -rotate-12 top-32 right-1/4 w-32 h-32 bg-white rounded-full"></div>
        <div class="absolute transform rotate-12 bottom-20 -left-10 w-24 h-24 bg-white rounded-2xl"></div>
        <div class="absolute transform -rotate-45 bottom-32 right-10 w-16 h-16 bg-white rounded-full"></div>
    </div>
    
    <div class="relative z-10 px-4 py-16 md:py-24">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white/90 text-sm font-medium mb-6">
                    <i class="fas fa-compass mr-2"></i>
                    สำรวจและค้นหา
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    ค้นพบมรดกวัฒนธรรมไทย
                </h1>
                
                <!-- Description -->
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
        </div>
    </div>
</section>

<!-- Advanced Search Section -->
<section class="py-16 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
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

                <!-- Advanced Options -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                    <!-- Sort Options -->
                    <div>
                        <label for="sort" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-sort text-purple-500 mr-2"></i>เรียงลำดับ
                        </label>
                        <select id="sort" 
                                name="sort"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300">
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>ล่าสุด</option>
                            <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>เก่าสุด</option>
                            <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>ชื่อ A-Z</option>
                            <option value="title_desc" {{ $sort == 'title_desc' ? 'selected' : '' }}>ชื่อ Z-A</option>
                            <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>ยอดนิยม</option>
                        </select>
                    </div>

                    <!-- Per Page -->
                    <div>
                        <label for="per_page" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-list text-indigo-500 mr-2"></i>จำนวนต่อหน้า
                        </label>
                        <select id="per_page" 
                                name="per_page"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300">
                            <option value="12" {{ $per_page == 12 ? 'selected' : '' }}>12 รายการ</option>
                            <option value="24" {{ $per_page == 24 ? 'selected' : '' }}>24 รายการ</option>
                            <option value="36" {{ $per_page == 36 ? 'selected' : '' }}>36 รายการ</option>
                            <option value="48" {{ $per_page == 48 ? 'selected' : '' }}>48 รายการ</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end gap-3">
                        <button type="submit" 
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transform hover:scale-105 transition-all shadow-lg">
                            <i class="fas fa-search mr-2"></i>ค้นหา
                        </button>
                        <a href="{{ route('cultural.explore') }}" 
                           class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                            <i class="fas fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Quick Category Access -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">หมวดหมู่ยอดนิยม</h2>
            <p class="text-lg text-gray-600">เลือกสำรวจตามหมวดหมู่ที่คุณสนใจ</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach($categories->take(12) as $category)
            <a href="{{ route('cultural.explore', ['category_id' => $category->id]) }}" 
               class="group bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 hover:border-orange-200">
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
<!-- Results Section -->
<section id="results-section" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Main Results -->
            <div class="lg:col-span-3">
                <!-- Results Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">ผลการค้นหา</h2>
                            <p class="text-gray-600">
                                @if($items->total() > 0)
                                    พบ <span class="font-semibold text-orange-600">{{ number_format($items->total()) }}</span> รายการ
                                    @if($search)
                                        สำหรับ "<span class="font-medium text-gray-800">{{ $search }}</span>"
                                    @endif
                                    @if($category_id && isset($categories))
                                        @php
                                            $selectedCategory = $categories->find($category_id);
                                        @endphp
                                        @if($selectedCategory)
                                            ในหมวด "<span class="font-medium text-blue-600">{{ $selectedCategory->name }}</span>"
                                        @endif
                                    @endif
                                    @if($community_id && isset($communities))
                                        @php
                                            $selectedCommunity = $communities->find($community_id);
                                        @endphp
                                        @if($selectedCommunity)
                                            จากชุมชน "<span class="font-medium text-green-600">{{ $selectedCommunity->name }}</span>"
                                        @endif
                                    @endif
                                @else
                                    <span class="text-red-600">ไม่พบรายการที่ตรงกับเงื่อนไข</span>
                                @endif
                            </p>
                        </div>

                        @if($items->total() > 0)
                        <!-- Quick Actions -->
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <div class="text-sm text-gray-500">มุมมอง:</div>
                            <button onclick="toggleView('grid')" 
                                    id="grid-view-btn" 
                                    class="view-btn active p-2 rounded-lg border border-gray-200 hover:bg-orange-50 hover:border-orange-200 transition-colors">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button onclick="toggleView('list')" 
                                    id="list-view-btn" 
                                    class="view-btn p-2 rounded-lg border border-gray-200 hover:bg-orange-50 hover:border-orange-200 transition-colors">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                @if($items->count() > 0)
                <!-- Items Grid/List -->
                <div id="items-container">
                    <!-- Grid View -->
                    <div id="grid-view" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($items as $item)
                            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-1">
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
                                    <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors leading-tight">
                                        <a href="{{ route('cultural-item.show', $item->id) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h3>

                                    <!-- Description -->
                                    @if($item->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($item->description, 140) }}
                                    </p>
                                    @endif

                                    <!-- Meta Info -->
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @if($item->community)
                                            <span class="inline-flex items-center bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                                <i class="fas fa-map-marker-alt text-green-600 mr-1"></i>
                                                {{ $item->community->name }}
                                            </span>
                                        @endif
                                        @if($item->publish_date)
                                            <span class="inline-flex items-center bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full font-medium">
                                                <i class="fas fa-clock text-gray-600 mr-1"></i>
                                                {{ $item->publish_date->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('cultural-item.show', $item->id) }}" 
                                       class="inline-flex items-center justify-center w-full px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all transform group-hover:scale-105 shadow-sm">
                                        <i class="fas fa-eye mr-2"></i>
                                        ดูรายละเอียด
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- List View (Hidden by default) -->
                    <div id="list-view" class="space-y-4 hidden">
                        @foreach($items as $item)
                            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-orange-200 overflow-hidden">
                                <div class="flex">
                                    <!-- Image -->
                                    <div class="relative w-48 h-32 flex-shrink-0 overflow-hidden">
                                        @if($item->image)
                                            <img src="{{ Storage::url($item->image) }}" 
                                                 alt="{{ $item->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                                <i class="fas fa-image text-orange-400 text-2xl"></i>
                                            </div>
                                        @endif
                                        
                                        @if($item->is_featured)
                                            <div class="absolute top-2 left-2">
                                                <span class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                                    <i class="fas fa-star mr-1"></i>
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 p-6">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="font-bold text-xl text-gray-900 group-hover:text-orange-600 transition-colors line-clamp-2 pr-4">
                                                <a href="{{ route('cultural-item.show', $item->id) }}">
                                                    {{ $item->title }}
                                                </a>
                                            </h3>
                                            @if($item->category)
                                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full whitespace-nowrap">
                                                    {{ $item->category->name }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($item->description)
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {{ Str::limit($item->description, 200) }}
                                        </p>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <div class="flex flex-wrap gap-2">
                                                @if($item->community)
                                                    <span class="inline-flex items-center bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-medium">
                                                        <i class="fas fa-map-marker-alt text-green-600 mr-1"></i>
                                                        {{ $item->community->name }}
                                                    </span>
                                                @endif
                                                @if($item->publish_date)
                                                    <span class="inline-flex items-center bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded font-medium">
                                                        <i class="fas fa-clock text-gray-600 mr-1"></i>
                                                        {{ $item->publish_date->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <a href="{{ route('cultural-item.show', $item->id) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                                <i class="fas fa-eye mr-2"></i>
                                                ดูรายละเอียด
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">ไม่พบรายการที่ตรงกับเงื่อนไข</h3>
                    <p class="text-gray-600 mb-6">ลองปรับเปลี่ยนคำค้นหาหรือตัวกรองเพื่อหาผลลัพธ์ที่ต้องการ</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('cultural.explore') }}" 
                           class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-colors">
                            <i class="fas fa-refresh mr-2"></i>
                            ดูทั้งหมด
                        </a>
                        <button onclick="clearFilters()" 
                                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                            <i class="fas fa-filter mr-2"></i>
                            ล้างตัวกรอง
                        </button>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="space-y-8 sticky top-6">
                    
                    <!-- Popular Items -->
                    @if(isset($popularItems) && $popularItems->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6">
                            <h3 class="text-lg font-bold flex items-center">
                                <i class="fas fa-fire mr-3"></i>
                                รายการยอดนิยม
                            </h3>
                            <p class="text-orange-100 text-sm mt-1">รายการที่ได้รับความสนใจ</p>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($popularItems as $item)
                                <div class="flex space-x-3 group hover:bg-gray-50 p-2 rounded-lg transition-colors -m-2">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" 
                                             alt="{{ $item->title }}"
                                             class="w-12 h-12 object-cover rounded-lg flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-image text-gray-400 text-sm"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-sm text-gray-800 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                            <a href="{{ route('cultural-item.show', $item->id) }}">
                                                {{ $item->title }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500 mt-1 space-x-2">
                                            @if($item->category)
                                                <span>{{ $item->category->name }}</span>
                                                <span>•</span>
                                            @endif
                                            @if($item->community)
                                                <span>{{ $item->community->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Latest Items -->
                    @if(isset($latestItems) && $latestItems->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white p-6">
                            <h3 class="text-lg font-bold flex items-center">
                                <i class="fas fa-clock mr-3"></i>
                                รายการล่าสุด
                            </h3>
                            <p class="text-blue-100 text-sm mt-1">ข้อมูลที่เพิ่งอัปเดต</p>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($latestItems as $item)
                                <div class="flex space-x-3 group hover:bg-gray-50 p-2 rounded-lg transition-colors -m-2">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" 
                                             alt="{{ $item->title }}"
                                             class="w-12 h-12 object-cover rounded-lg flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-image text-gray-400 text-sm"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-sm text-gray-800 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                            <a href="{{ route('cultural-item.show', $item->id) }}">
                                                {{ $item->title }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500 mt-1 space-x-2">
                                            @if($item->publish_date)
                                                <span>{{ $item->publish_date->format('d/m/Y') }}</span>
                                                <span>•</span>
                                            @endif
                                            @if($item->community)
                                                <span>{{ $item->community->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Search Tips -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
                        <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center">
                            <i class="fas fa-lightbulb mr-3 text-yellow-500"></i>
                            เทิปการค้นหา
                        </h3>
                        <ul class="space-y-3 text-sm text-indigo-800">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                ใช้คำค้นหาเฉพาะเจาะจง เช่น "ประเพณีสงกรานต์"
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                เลือกหมวดหมู่เพื่อจำกัดผลลัพธ์
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                กรองตามชุมชนสำหรับข้อมูลเฉพาะพื้นที่
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                ใช้การเรียงลำดับตามความเหมาะสม
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
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

/* Hero Animations */
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

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.float-animation {
    animation: float 6s ease-in-out infinite;
}

/* View Toggle Buttons */
.view-btn {
    transition: all 0.3s ease;
}

.view-btn.active {
    background-color: #f97316;
    color: white;
    border-color: #f97316;
}

.view-btn:not(.active):hover {
    background-color: #fff7ed;
    border-color: #fed7aa;
}

/* Search Form Enhancements */
.search-form input:focus,
.search-form select:focus {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.15);
}

/* Card Hover Effects */
.cultural-card {
    transition: all 0.3s ease;
}

.cultural-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination a,
.pagination span {
    padding: 0.5rem 0.75rem;
    border: 1px solid #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.pagination a:hover {
    background-color: #f97316;
    color: white;
    border-color: #f97316;
}

.pagination .active span {
    background-color: #f97316;
    color: white;
    border-color: #f97316;
}

/* Category Grid Responsive */
@media (max-width: 640px) {
    .hero-stats {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    
    .hero-stats > div {
        padding: 1rem;
    }
    
    .hero-stats .text-2xl {
        font-size: 1.5rem;
    }
}

/* Mobile Optimizations */
@media (max-width: 768px) {
    .search-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .category-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .results-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}

/* Tablet Optimizations */
@media (min-width: 769px) and (max-width: 1024px) {
    .category-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .items-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin-top: -10px;
    margin-left: -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #f97316;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Focus States for Accessibility */
button:focus,
input:focus,
select:focus,
a:focus {
    outline: 2px solid #f97316;
    outline-offset: 2px;
}

/* Print Styles */
@media print {
    .no-print {
        display: none !important;
    }
    
    .cultural-card {
        break-inside: avoid;
        margin-bottom: 1rem;
    }
    
    body {
        font-size: 12pt;
        line-height: 1.4;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Toggle Functionality
    window.toggleView = function(viewType) {
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        const gridBtn = document.getElementById('grid-view-btn');
        const listBtn = document.getElementById('list-view-btn');
        
        if (viewType === 'grid') {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            localStorage.setItem('preferredView', 'grid');
        } else {
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            localStorage.setItem('preferredView', 'list');
        }
    };
    
    // Load preferred view from localStorage
    const preferredView = localStorage.getItem('preferredView') || 'grid';
    toggleView(preferredView);
    
    // Clear Filters Function
    window.clearFilters = function() {
        const form = document.querySelector('form[action*="explore"]');
        if (form) {
            const inputs = form.querySelectorAll('input[type="text"], select');
            inputs.forEach(input => {
                input.value = '';
            });
            form.submit();
        }
    };
    
    // Auto-submit form on select change (for better UX)
    const sortSelect = document.getElementById('sort');
    const perPageSelect = document.getElementById('per_page');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
    
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
    
    // Smooth scroll to results after search
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('search') || urlParams.get('category_id') || urlParams.get('community_id')) {
        setTimeout(() => {
            const resultsSection = document.getElementById('results-section');
            if (resultsSection) {
                resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
    }
    
    // Enhanced form submission with loading state
    const searchForm = document.querySelector('form[action*="explore"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>กำลังค้นหา...';
            }
        });
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+F or Cmd+F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
        
        // Escape to clear search
        if (e.key === 'Escape') {
            const searchInput = document.getElementById('search');
            if (searchInput && searchInput === document.activeElement) {
                searchInput.value = '';
            }
        }
    });
    
    // Lazy loading for images (if supported)
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Enhanced category quick filter
    window.filterByCategory = function(categoryId) {
        const form = document.querySelector('form[action*="explore"]');
        if (form) {
            const categorySelect = form.querySelector('#category_id');
            if (categorySelect) {
                categorySelect.value = categoryId;
                form.submit();
            }
        }
    };
    
    // Search suggestions (basic implementation)
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // Here you could implement AJAX search suggestions
                    console.log('Search suggestions for:', query);
                }, 300);
            }
        });
    }
    
    // Analytics tracking (placeholder)
    window.trackEvent = function(action, category, label) {
        // Implement your analytics tracking here
        console.log('Analytics:', { action, category, label });
    };
    
    // Track search events
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const searchTerm = document.getElementById('search')?.value;
            if (searchTerm) {
                trackEvent('search', 'cultural_items', searchTerm);
            }
        });
    }
    
    // Track category clicks
    document.querySelectorAll('a[href*="category_id"]').forEach(link => {
        link.addEventListener('click', function() {
            const url = new URL(this.href);
            const categoryId = url.searchParams.get('category_id');
            trackEvent('filter', 'category', categoryId);
        });
    });
});

// Utility functions
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
        const context = this;
        const args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Copy link functionality
function copyLink(url) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            // Show toast notification
            showToast('ลิงก์ถูกคัดลอกแล้ว');
        });
    }
}

// Simple toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity';
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 2000);
}
</script>
@endpush