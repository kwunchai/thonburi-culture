@extends('layouts.frontend')

@section('title', 'สำรวจวัฒนธรรม')

@section('content')
<!-- Hero Section with Background -->
<section class="relative bg-gradient-to-br from-orange-600 via-red-500 to-pink-600 text-white py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-16 h-16 bg-white bg-opacity-10 rounded-full animate-bounce"></div>
    <div class="absolute top-1/2 right-10 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-ping"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    <span class="block">สำรวจ</span>
                    <span class="block bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">วัฒนธรรมไทย</span>
                </h1>
                <p class="text-xl md:text-2xl text-orange-100 mb-8 leading-relaxed max-w-2xl mx-auto">
                    ดื่มด่ำกับความงดงามของมรดกทางวัฒนธรรมไทย ค้นพบเรื่องราวที่น่าทึ่งและสัมผัสกับภูมิปัญญาท้องถิ่น
                </p>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold mb-2">{{ $stats['total_items'] ?? 0 }}</div>
                    <div class="text-orange-200 text-sm">ข้อมูลวัฒนธรรม</div>
                </div>
                <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold mb-2">{{ $stats['total_categories'] ?? 0 }}</div>
                    <div class="text-orange-200 text-sm">หมวดหมู่</div>
                </div>
                <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold mb-2">{{ $stats['total_communities'] ?? 0 }}</div>
                    <div class="text-orange-200 text-sm">ชุมชน</div>
                </div>
                <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold mb-2">{{ ($popularItems ? $popularItems->count() : 0) + ($latestItems ? $latestItems->count() : 0) }}</div>
                    <div class="text-orange-200 text-sm">รายการพิเศษ</div>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#search-section" class="bg-white text-orange-600 px-8 py-4 rounded-full font-semibold hover:bg-orange-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-search mr-2"></i>เริ่มสำรวจ
                </a>
                <a href="#featured-section" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-orange-600 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-star mr-2"></i>รายการแนะนำ
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Advanced Search and Filter Section -->
<section id="search-section" class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Search Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">ค้นหาวัฒนธรรมที่คุณสนใจ</h2>
                <p class="text-lg text-gray-600">ใช้เครื่องมือค้นหาที่ละเอียดเพื่อค้นพบสิ่งที่คุณต้องการ</p>
            </div>
            
            <!-- Search Form -->
            <form method="GET" action="{{ route('cultural.explore') }}" class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                    <!-- Main Search Input -->
                    <div class="lg:col-span-4">
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-search text-orange-500 mr-2"></i>ค้นหา
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ $search }}"
                                   placeholder="พิมพ์ชื่อ คำอธิบาย หรือแท็ก..."
                                   class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 text-lg">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="lg:col-span-3">
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
                    <div class="lg:col-span-3">
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

                    <!-- Search Button -->
                    <div class="lg:col-span-2">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-4 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <i class="fas fa-search mr-2"></i>ค้นหา
                        </button>
                    </div>
                </div>
                
                <!-- Advanced Filters -->
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <div class="flex flex-wrap gap-4 items-center justify-between">
                        <!-- Sort Options -->
                        <div class="flex items-center space-x-4">
                            <label for="sort" class="text-sm font-semibold text-gray-700">
                                <i class="fas fa-sort text-purple-500 mr-2"></i>เรียงตาม:
                            </label>
                            <select id="sort" 
                                    name="sort"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white"
                                    onchange="this.form.submit()">
                                <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>ล่าสุด</option>
                                <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>เก่าสุด</option>
                                <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>ชื่อ A-Z</option>
                                <option value="title_desc" {{ $sort == 'title_desc' ? 'selected' : '' }}>ชื่อ Z-A</option>
                                <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>ยอดนิยม</option>
                            </select>
                        </div>

                        <!-- Items Per Page -->
                        <div class="flex items-center space-x-4">
                            <label for="per_page" class="text-sm font-semibold text-gray-700">
                                <i class="fas fa-list text-indigo-500 mr-2"></i>แสดง:
                            </label>
                            <select id="per_page" 
                                    name="per_page"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white"
                                    onchange="this.form.submit()">
                                <option value="12" {{ $per_page == 12 ? 'selected' : '' }}>12 รายการ</option>
                                <option value="24" {{ $per_page == 24 ? 'selected' : '' }}>24 รายการ</option>
                                <option value="48" {{ $per_page == 48 ? 'selected' : '' }}>48 รายการ</option>
                            </select>
                        </div>

                        <!-- Clear Filters -->
                        @if($search || $category_id || $community_id || $sort != 'latest')
                        <a href="{{ route('cultural.explore') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-times mr-2"></i>ล้างตัวกรอง
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Featured Items Section -->
@if(isset($popularItems) && $popularItems->count() > 0)
<section id="featured-section" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                <i class="fas fa-star text-yellow-500 mr-3"></i>วัฒนธรรมแนะนำ
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">สำรวจวัฒนธรรมที่น่าสนใจและได้รับความนิยมจากชุมชน</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($popularItems->take(3) as $item)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                <!-- Image -->
                <div class="relative h-64 overflow-hidden">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center">
                            <i class="fas fa-image text-white text-6xl opacity-50"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                            <i class="fas fa-star mr-1"></i>แนะนำ
                        </span>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                        <a href="{{ route('cultural-item.show', $item->id) }}">{{ $item->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ Str::limit($item->description, 120) }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        @if($item->category)
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                            {{ $item->category->name }}
                        </span>
                        @endif
                        @if($item->community)
                        <span class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-1"></i>{{ $item->community->name }}
                        </span>
                        @endif
                    </div>
                    <a href="{{ route('cultural-item.show', $item->id) }}" 
                       class="inline-flex items-center text-orange-500 hover:text-orange-600 font-semibold group">
                        อ่านเพิ่มเติม 
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="#results-section" class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-3 rounded-full font-semibold hover:from-orange-600 hover:to-red-600 transform hover:scale-105 transition-all duration-300 shadow-lg">
                <i class="fas fa-th-large mr-2"></i>ดูทั้งหมด
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categories Showcase -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                <i class="fas fa-layer-group text-blue-500 mr-3"></i>หมวดหมู่วัฒนธรรม
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">เลือกสำรวจตามหมวดหมู่ที่คุณสนใจ</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories->take(8) as $category)
            <a href="{{ route('cultural.explore', ['category_id' => $category->id]) }}" 
               class="group bg-white rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-folder text-white text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
                    {{ $category->name }}
                </h3>
                <p class="text-sm text-gray-500">
                    {{ $category->cultural_items_count ?? 0 }} รายการ
                </p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Search Results Section -->
<section id="results-section" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Main Results -->
            <div class="lg:col-span-3">
                <!-- Results Header -->
                <div class="mb-8">
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800 mb-2 flex items-center">
                                    <i class="fas fa-search text-orange-500 mr-3"></i>
                                    ผลการค้นหา
                                    @if($search || $category_id || $community_id)
                                        <span class="text-orange-500 ml-2">
                                            @if($search) "{{ $search }}" @endif
                                        </span>
                                    @endif
                                </h2>
                                <p class="text-gray-600 flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    พบ <span class="font-semibold text-orange-600 mx-1">{{ $items->total() }}</span> รายการ
                                    @if($items->hasPages())
                                        จากทั้งหมด {{ $stats['total_items'] }} รายการ 
                                        (หน้า {{ $items->currentPage() }}/{{ $items->lastPage() }})
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">แสดง {{ $items->count() }} รายการ</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($items->count() > 0)
                    <!-- Results Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                        @foreach($items as $item)
                            <article class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 border border-gray-100 overflow-hidden">
                                <!-- Image -->
                                <div class="relative h-56 overflow-hidden">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" 
                                             alt="{{ $item->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                            <i class="fas fa-image text-white text-4xl opacity-50"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                                    
                                    <!-- Featured Badge -->
                                    @if($item->is_featured)
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                                <i class="fas fa-star mr-1"></i>แนะนำ
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <h3 class="font-bold text-xl text-gray-800 mb-3 line-clamp-2 leading-tight">
                                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                                           class="hover:text-orange-500 transition-colors">
                                            {{ $item->title }}
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($item->description, 140) }}
                                    </p>

                                    <!-- Meta Info -->
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @if($item->category)
                                            <span class="inline-flex items-center bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-medium">
                                                <i class="fas fa-folder text-orange-600 mr-1"></i>
                                                {{ $item->category->name }}
                                            </span>
                                        @endif
                                        @if($item->community)
                                            <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                                                <i class="fas fa-users text-blue-600 mr-1"></i>
                                                {{ $item->community->name }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Footer -->
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                        <span class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                            {{ $item->publish_date ? $item->publish_date->format('d/m/Y') : 'ไม่ระบุ' }}
                                        </span>
                                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                                           class="inline-flex items-center text-orange-500 hover:text-orange-600 font-semibold text-sm transition-all duration-200 hover:bg-orange-50 px-3 py-2 rounded-lg group">
                                            อ่านเพิ่มเติม 
                                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
                            {{ $items->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <!-- No Results -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">ไม่พบผลการค้นหา</h3>
                        <p class="text-gray-500 mb-8 text-lg max-w-md mx-auto">
                            ขออภัย ไม่พบวัฒนธรรมที่ตรงกับเงื่อนไขที่คุณค้นหา ลองปรับเปลี่ยนคำค้นหาหรือตัวกรองใหม่
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('cultural.explore') }}" 
                               class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-semibold transition duration-200 shadow-lg">
                                <i class="fas fa-list mr-2"></i>ดูทั้งหมด
                            </a>
                            <a href="#search-section" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition duration-200">
                                <i class="fas fa-search mr-2"></i>ค้นหาใหม่
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-md p-8 border border-gray-100">
                    <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-chart-pie text-purple-500 mr-3"></i>สถิติ
                    </h3>
                    <div class="space-y-5">
                        <div class="flex justify-between items-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-list text-white"></i>
                                </div>
                                <span class="text-gray-700 font-semibold">รายการทั้งหมด</span>
                            </div>
                            <span class="font-bold text-2xl text-orange-600">{{ $stats['total_items'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-folder text-white"></i>
                                </div>
                                <span class="text-gray-700 font-semibold">หมวดหมู่</span>
                            </div>
                            <span class="font-bold text-2xl text-blue-600">{{ $stats['total_categories'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <span class="text-gray-700 font-semibold">ชุมชน</span>
                            </div>
                            <span class="font-bold text-2xl text-green-600">{{ $stats['total_communities'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Popular Items -->
                @if(isset($popularItems) && $popularItems->count() > 0)
                <div class="bg-white rounded-xl shadow-md p-8 border border-gray-100">
                    <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-fire text-red-500 mr-3"></i>ยอดนิยม
                    </h3>
                    <div class="space-y-5">
                        @foreach($popularItems->take(5) as $item)
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-all border border-gray-100 hover:border-red-200 hover:shadow-md">
                                <a href="{{ route('cultural-item.show', $item->id) }}" class="block">
                                    <div class="flex items-center space-x-4">
                                        @if($item->image)
                                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 border-2 border-red-100 group-hover:border-red-300 transition-colors">
                                                <img src="{{ Storage::url($item->image) }}" 
                                                     alt="{{ $item->title }}" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                            </div>
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-image text-red-500"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-800 group-hover:text-red-700 transition-colors line-clamp-2">
                                                {{ $item->title }}
                                            </h4>
                                            <p class="text-gray-600 text-sm mt-1 flex items-center">
                                                @if($item->category)
                                                    <i class="fas fa-folder text-gray-400 mr-2"></i>
                                                    {{ $item->category->name }}
                                                @else
                                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                                    {{ $item->publish_date ? $item->publish_date->format('d/m/Y') : 'ไม่ระบุ' }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Latest Items -->
                @if(isset($latestItems) && $latestItems->count() > 0)
                <div class="bg-white rounded-xl shadow-md p-8 border border-gray-100">
                    <h3 class="font-bold text-2xl text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-clock text-green-500 mr-3"></i>ล่าสุด
                    </h3>
                    <div class="space-y-5">
                        @foreach($latestItems->take(5) as $item)
                            <div class="group hover:bg-gray-50 p-4 rounded-xl transition-all border border-gray-100 hover:border-green-200 hover:shadow-md">
                                <a href="{{ route('cultural-item.show', $item->id) }}" class="block">
                                    <div class="flex items-center space-x-4">
                                        @if($item->image)
                                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 border-2 border-green-100 group-hover:border-green-300 transition-colors">
                                                <img src="{{ Storage::url($item->image) }}" 
                                                     alt="{{ $item->title }}" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                            </div>
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-image text-green-500"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-800 group-hover:text-green-700 transition-colors line-clamp-2">
                                                {{ $item->title }}
                                            </h4>
                                            <p class="text-gray-600 text-sm mt-1 flex items-center">
                                                <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                                {{ $item->publish_date ? $item->publish_date->format('d/m/Y') : 'ไม่ระบุ' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white rounded-xl p-8 border border-gray-100">
                    <h3 class="font-bold text-2xl mb-4 flex items-center">
                        <i class="fas fa-rocket mr-3"></i>เริ่มต้นสำรวจ
                    </h3>
                    <p class="text-orange-100 mb-6">ค้นพบเรื่องราวน่าทึ่งของวัฒนธรรมไทย</p>
                    <div class="space-y-3">
                        <a href="{{ route('cultural.explore', ['sort' => 'popular']) }}" 
                           class="block w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-center py-3 rounded-lg font-semibold transition-all">
                            <i class="fas fa-star mr-2"></i>ดูยอดนิยม
                        </a>
                        <a href="{{ route('cultural.explore', ['sort' => 'latest']) }}" 
                           class="block w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-center py-3 rounded-lg font-semibold transition-all">
                            <i class="fas fa-clock mr-2"></i>ดูล่าสุด
                        </a>
                        <a href="#search-section" 
                           class="block w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-center py-3 rounded-lg font-semibold transition-all">
                            <i class="fas fa-search mr-2"></i>ค้นหาแบบละเอียด
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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

/* Custom animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Custom gradient text */
.bg-clip-text {
    background-clip: text;
    -webkit-background-clip: text;
}

/* Enhanced hover effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}

/* Loading animation for images */
img {
    transition: opacity 0.3s ease;
}

img[src=""] {
    opacity: 0;
}

/* Enhanced shadows */
.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Backdrop blur support */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}

/* Custom border gradients */
.border-gradient {
    border: 1px solid;
    border-image: linear-gradient(45deg, #f97316, #ef4444) 1;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-submit form on select change (optional enhancement)
    const sortSelect = document.getElementById('sort');
    const perPageSelect = document.getElementById('per_page');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            // Optional: Auto-submit form when sort changes
            // this.form.submit();
        });
    }

    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            // Optional: Auto-submit form when per_page changes
            // this.form.submit();
        });
    }

    // Add loading states to forms
    const searchForm = document.querySelector('form[method="GET"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>กำลังค้นหา...';
                submitBtn.disabled = true;
            }
        });
    }

    // Image lazy loading with fade-in effect
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        if (img.complete) {
            img.style.opacity = '1';
        }
    });

    // Add intersection observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe sections for scroll animations
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });
});
</script>
@endpush