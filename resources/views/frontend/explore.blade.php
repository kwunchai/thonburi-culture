@extends('layouts.frontend')

@section('title', 'สำรวจวัฒนธรรม')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-orange-500 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">สำรวจวัฒนธรรม</h1>
            <p class="text-xl">รวบรวมข้อมูลทางวัฒนธรรมของเขตธนบุรี เพื่อให้คนรุ่นใหม่ได้เรียนรู้ ร่วมอนุรักษ์ และสืบสานต่อไป</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-6" aria-label="Breadcrumb">
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
                    <span class="text-gray-800 font-medium">สำรวจวัฒนธรรม</span>
                </li>
                @if(request('category_id') && isset($categories))
                    @php $selectedCategory = $categories->firstWhere('id', request('category_id')) @endphp
                    @if($selectedCategory)
                        <li>
                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        </li>
                        <li>
                            <span class="text-orange-600 font-medium">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $selectedCategory->name }}
                            </span>
                        </li>
                    @endif
                @endif
                @if(request('community_id') && isset($communities))
                    @php $selectedCommunity = $communities->firstWhere('id', request('community_id')) @endphp
                    @if($selectedCommunity)
                        <li>
                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        </li>
                        <li>
                            <span class="text-orange-600 font-medium">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $selectedCommunity->name }}
                            </span>
                        </li>
                    @endif
                @endif
                @if(request('search'))
                    <li>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </li>
                    <li>
                        <span class="text-orange-600 font-medium">
                            <i class="fas fa-search mr-1"></i>
                            "{{ request('search') }}"
                        </span>
                    </li>
                @endif
            </ol>
        </nav>
        
        <!-- Enhanced Filter Section -->
        <div class="mb-8">
            <!-- Filter Form -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <form method="GET" action="{{ route('cultural.explore') }}">
                    <!-- Filters Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Category Filter -->
                        <div class="space-y-2">
                            <label for="category_id" class="flex items-center text-sm font-semibold text-gray-700">
                                <i class="fas fa-tags text-orange-500 mr-2"></i>
                                หมวดหมู่
                            </label>
                            <select id="category_id" 
                                    name="category_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-gray-50 hover:bg-white transition-colors">
                                <option value="">🏷️ เลือกหมวดหมู่ทั้งหมด</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->cultural_items_count ?? 0 }} รายการ)
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Community Filter -->
                        <div class="space-y-2">
                            <label for="community_id" class="flex items-center text-sm font-semibold text-gray-700">
                                <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>
                                ชุมชน
                            </label>
                            <select id="community_id" 
                                    name="community_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-gray-50 hover:bg-white transition-colors">
                                <option value="">📍 เลือกชุมชนทั้งหมด</option>
                                @if(isset($communities))
                                    @foreach($communities as $community)
                                        <option value="{{ $community->id }}" {{ request('community_id') == $community->id ? 'selected' : '' }}>
                                            {{ $community->name }} ({{ $community->cultural_items_count ?? 0 }} รายการ)
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <!-- Divider -->
                    <hr class="border-gray-200 my-6">
                    
                    <!-- Main Search Row -->
                    <div class="space-y-4">
                        <label class="flex items-center text-sm font-semibold text-gray-700">
                            <i class="fas fa-search text-orange-500 mr-2"></i>
                            ค้นหาด้วยคำคีย์เวิร์ด
                        </label>
                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- Keyword Search -->
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="🔍 ป้อนคำค้นหา เช่น ประเพณี, งานฝีมือ, อาหาร..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-gray-50 hover:bg-white transition-colors">
                            </div>
                            
                            <!-- Search & Clear Buttons -->
                            <div class="flex flex-col md:flex-row gap-2">
                                <!-- Search Button -->
                                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 tracking-wide">
                                    <i class="fas fa-search mr-2"></i>
                                    ค้นหา
                                </button>
                                
                                <!-- Clear Filters Button -->
                                <a href="{{ route('cultural.explore') }}" 
                                   class="w-full md:w-auto px-6 py-3 bg-white text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-800 transition-all duration-300 font-medium text-center">
                                    <i class="fas fa-times mr-2"></i>
                                    ล้างตัวกรอง
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Options -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap items-center gap-6">
                            <!-- Sort Options -->
                            <div class="flex items-center gap-3">
                                <label for="sort" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-sort text-orange-500 mr-2"></i>
                                    เรียงตาม:
                                </label>
                                <select name="sort" id="sort" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 bg-gray-50 hover:bg-white transition-colors">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>📅 ล่าสุด</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>📆 เก่าสุด</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>🔤 ชื่อ A-Z</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>⭐ ยอดนิยม</option>
                                </select>
                            </div>
                            
                            <!-- Results per page -->
                            <div class="flex items-center gap-3">
                                <label for="per_page" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-list text-orange-500 mr-2"></i>
                                    แสดง:
                                </label>
                                <select name="per_page" id="per_page" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 bg-gray-50 hover:bg-white transition-colors">
                                    <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 รายการ</option>
                                    <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 รายการ</option>
                                    <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 รายการ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Search Results Info -->
        @if(isset($items) && ($items->total() > 0 || request()->anyFilled(['search', 'category_id', 'community_id'])))
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                    <div class="text-sm text-gray-600">
                        @if(request()->anyFilled(['search', 'category_id', 'community_id']))
                            <strong>พบ {{ number_format($items->total()) }} รายการ</strong>
                            @if(request('search'))
                                จากการค้นหา "<span class="text-orange-600 font-medium">{{ request('search') }}</span>"
                            @endif
                            @if(request('category_id') && isset($categories))
                                @php $selectedCategory = $categories->firstWhere('id', request('category_id')) @endphp
                                @if($selectedCategory)
                                    ในหมวดหมู่ "<span class="text-orange-600 font-medium">{{ $selectedCategory->name }}</span>"
                                @endif
                            @endif
                            @if(request('community_id') && isset($communities))
                                @php $selectedCommunity = $communities->firstWhere('id', request('community_id')) @endphp
                                @if($selectedCommunity)
                                    ในชุมชน "<span class="text-orange-600 font-medium">{{ $selectedCommunity->name }}</span>"
                                @endif
                            @endif
                        @else
                            แสดงทั้งหมด <strong>{{ number_format($items->total()) }} รายการ</strong>
                        @endif
                    </div>
                    
                    @if($items->hasPages())
                        <div class="text-sm text-gray-500">
                            หน้า {{ $items->currentPage() }} จาก {{ $items->lastPage() }}
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($items as $item)
                <article class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden h-48">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-orange-400 mb-2"></i>
                                    <p class="text-xs text-orange-400">🖼️ ขาดรูปภาพ</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                    </div>
                    
                    <!-- Content Container -->
                    <div class="p-5 flex flex-col h-44">
                        <!-- Title -->
                        <h3 class="font-bold text-base mb-2 text-gray-800 group-hover:text-orange-600 transition-colors duration-300 line-clamp-2 leading-tight">
                            {{ $item->title }}
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2 leading-relaxed flex-grow">
                            {{ Str::limit($item->description, 80) }}
                        </p>
                        
                        <!-- Meta Info Footer -->
                        <div class="mt-auto">
                            <!-- Meta Info Row -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-3 pb-2 border-b border-gray-100">
                                <!-- Community -->
                                @if($item->community)
                                    <div class="flex items-center flex-1 min-w-0">
                                        <i class="fas fa-map-marker-alt text-orange-500 mr-1 flex-shrink-0"></i>
                                        <span class="truncate">{{ $item->community->name }}</span>
                                    </div>
                                @else
                                    <div class="flex-1"></div>
                                @endif
                                
                                <!-- Category -->
                                @if($item->category)
                                    <div class="flex items-center ml-2">
                                        <span class="px-2 py-1 bg-orange-100 text-orange-600 text-xs rounded-full font-medium whitespace-nowrap">
                                            {{ $item->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Action Button -->
                            <div class="flex justify-between items-center">
                                <a href="{{ route('cultural-item.show', $item->id) }}" 
                                   aria-label="อ่านเพิ่มเติม: {{ $item->title }}"
                                   class="inline-flex items-center text-orange-500 hover:text-orange-600 font-medium text-sm group/btn transition-colors duration-200">
                                    <span class="mr-2">อ่านเพิ่ม</span>
                                    <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform duration-200"></i>
                                </a>
                                
                                <!-- Date -->
                                <div class="text-xs text-gray-400">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ $item->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="text-center py-20 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
                            <i class="fas fa-search text-2xl text-orange-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">ไม่พบข้อมูลวัฒนธรรม</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">
                            ลองปรับเปลี่ยนเงื่อนไขการค้นหา หรือเลือกหมวดหมู่และชุมชนอื่น
                        </p>
                        <a href="{{ route('cultural.explore') }}" 
                           class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors font-medium">
                            <i class="fas fa-refresh mr-2"></i>
                            เริ่มค้นหาใหม่
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
            <div class="mt-8">
                {{ $items->links('pagination.thai') }}
            </div>
        @endif
    </div>
</div>

@endsection