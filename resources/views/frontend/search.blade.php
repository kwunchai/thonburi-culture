@extends('layouts.frontend')

@section('title', 'ค้นหา: ' . $query)

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <!-- Search Header -->
    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl mb-4">
                    <i class="fas fa-search text-3xl"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-3">ผลการค้นหา</h1>
                <p class="text-lg md:text-xl text-white/90">
                    ค้นหา: <span class="font-semibold">"{{ $query }}"</span>
                </p>
                @if($items->total() > 0)
                    <p class="text-sm text-white/80 mt-2">
                        พบทั้งหมด {{ number_format($items->total()) }} รายการ
                    </p>
                @endif
            </div>

            <!-- Search Box -->
            <div class="max-w-3xl mx-auto">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <div class="relative">
                        <input type="text" 
                               name="q" 
                               value="{{ $query }}"
                               placeholder="ค้นหาวัฒนธรรม สถานที่ ชุมชน..." 
                               class="w-full px-6 py-4 pr-32 text-gray-900 bg-white rounded-2xl shadow-xl focus:outline-none focus:ring-4 focus:ring-white/30 transition-all"
                               required>
                        <button type="submit" 
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 font-medium">
                            <i class="fas fa-search mr-2"></i>
                            ค้นหา
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        
        <!-- Breadcrumb -->
        <nav class="mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-600 transition-colors">
                        <i class="fas fa-home mr-1"></i>หน้าแรก
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-orange-600 font-medium">
                    <i class="fas fa-search mr-1"></i>ผลการค้นหา
                </li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <aside class="lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-filter mr-2 text-orange-500"></i>
                        กรองผลลัพธ์
                    </h3>
                    
                    <form action="{{ route('search') }}" method="GET">
                        <input type="hidden" name="q" value="{{ $query }}">
                        
                        <!-- Category Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-tag mr-1"></i>หมวดหมู่
                            </label>
                            <select name="category_id" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50"
                                    onchange="this.form.submit()">
                                <option value="">ทั้งหมด</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Community Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-map-marker-alt mr-1"></i>ชุมชน
                            </label>
                            <select name="community_id" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50"
                                    onchange="this.form.submit()">
                                <option value="">ทั้งหมด</option>
                                @foreach($communities as $comm)
                                    <option value="{{ $comm->id }}" {{ $community_id == $comm->id ? 'selected' : '' }}>
                                        {{ $comm->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-sort mr-1"></i>เรียงลำดับ
                            </label>
                            <select name="sort" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50"
                                    onchange="this.form.submit()">
                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>ล่าสุด</option>
                                <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>เก่าสุด</option>
                                <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>ชื่อ (ก-ฮ)</option>
                                <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>ชื่อ (ฮ-ก)</option>
                            </select>
                        </div>

                        <!-- Clear Filters -->
                        @if($category_id || $community_id || $sort != 'newest')
                            <a href="{{ route('search', ['q' => $query]) }}" 
                               class="block w-full text-center px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                                <i class="fas fa-times-circle mr-2"></i>ล้างตัวกรอง
                            </a>
                        @endif
                    </form>
                </div>
            </aside>

            <!-- Results Grid -->
            <div class="flex-1">
                
                @if($items->total() > 0)
                    <!-- Results Info -->
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-gray-600">
                            แสดง {{ $items->firstItem() }}-{{ $items->lastItem() }} จาก {{ number_format($items->total()) }} รายการ
                        </p>
                    </div>

                    <!-- Items Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($items as $item)
                            <article class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                                <a href="{{ route('cultural-item.show', $item->id) }}" class="block">
                                    <!-- Image -->
                                    <div class="relative h-52 overflow-hidden bg-gradient-to-br from-orange-100 to-red-100">
                                        @if($item->image_url)
                                            <img src="{{ $item->image_url }}" 
                                                 alt="{{ $item->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                 loading="lazy">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-image text-6xl text-gray-300"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Category Badge -->
                                        @if($item->category)
                                            <div class="absolute top-3 right-3">
                                                <span class="inline-flex items-center px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full text-xs font-medium text-orange-600 shadow-lg">
                                                    <i class="fas fa-tag mr-1.5"></i>
                                                    {{ $item->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-5">
                                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                            {{ $item->name }}
                                        </h3>
                                        
                                        @if($item->description)
                                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                                {{ $item->description }}
                                            </p>
                                        @endif

                                        <!-- Meta Info -->
                                        <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
                                            @if($item->community)
                                                <span class="flex items-center">
                                                    <i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>
                                                    {{ $item->community->name }}
                                                </span>
                                            @endif
                                            
                                            @if($item->publish_date)
                                                <span class="flex items-center">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($item->publish_date)->locale('th')->isoFormat('D MMM YYYY') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $items->links() }}
                    </div>

                @else
                    <!-- No Results -->
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                            <i class="fas fa-search text-5xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">ไม่พบผลลัพธ์</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            ขออภัย ไม่พบข้อมูลที่ตรงกับคำค้นหา "<span class="font-semibold text-orange-600">{{ $query }}</span>"
                        </p>
                        
                        <!-- Suggestions -->
                        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 max-w-2xl mx-auto text-left">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                คำแนะนำในการค้นหา:
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    ตรวจสอบการสะกดคำให้ถูกต้อง
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    ลองใช้คำค้นหาที่สั้นกว่าหรือกว้างกว่า
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    ลองค้นหาด้วยคำที่เกี่ยวข้องหรือใกล้เคียง
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    ลองปรับตัวกรองหมวดหมู่หรือชุมชน
                                </li>
                            </ul>
                        </div>

                        <!-- Quick Links -->
                        <div class="mt-8 flex flex-wrap justify-center gap-3">
                            <a href="{{ route('home') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <i class="fas fa-home mr-2"></i>
                                กลับหน้าแรก
                            </a>
                            <a href="{{ route('cultural.explore') }}" 
                               class="inline-flex items-center px-6 py-3 bg-white text-gray-700 border-2 border-gray-300 rounded-xl hover:border-orange-500 hover:text-orange-600 transition-all duration-300">
                                <i class="fas fa-compass mr-2"></i>
                                สำรวจวัฒนธรรม
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
