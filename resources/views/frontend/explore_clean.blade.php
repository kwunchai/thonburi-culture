@extends('layouts.frontend')

@section('title', 'สำรวจวัฒนธรรม')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-orange-500 to-red-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">สำรวจวัฒนธรรม</h1>
            <p class="text-xl text-orange-100">ค้นพบและเรียนรู้เกี่ยวกับวัฒนธรรมไทยที่หลากหลาย</p>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="bg-white py-8 border-b">
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('cultural.explore') }}" class="bg-gray-50 p-6 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">ค้นหา</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="ค้นหาชื่อหรือคำอธิบาย..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">หมวดหมู่</label>
                    <select id="category_id" 
                            name="category_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        <option value="">ทุกหมวดหมู่</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Community Filter -->
                <div>
                    <label for="community_id" class="block text-sm font-medium text-gray-700 mb-2">ชุมชน</label>
                    <select id="community_id" 
                            name="community_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        <option value="">ทุกชุมชน</option>
                        @foreach($communities as $community)
                            <option value="{{ $community->id }}" {{ $community_id == $community->id ? 'selected' : '' }}>
                                {{ $community->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">เรียงตาม</label>
                    <select id="sort" 
                            name="sort"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>ล่าสุด</option>
                        <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>เก่าสุด</option>
                        <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>ชื่อ A-Z</option>
                        <option value="title_desc" {{ $sort == 'title_desc' ? 'selected' : '' }}>ชื่อ Z-A</option>
                        <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>ยอดนิยม</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-col sm:flex-row gap-4">
                <button type="submit" 
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                    <i class="fas fa-search mr-2"></i>ค้นหา
                </button>
                <a href="{{ route('cultural.explore') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium transition duration-200 text-center">
                    <i class="fas fa-undo mr-2"></i>ล้างการค้นหา
                </a>
            </div>
        </form>
    </div>
</section>

<!-- Main Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <!-- Results Info -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                                ผลการค้นหา
                                @if($search || $category_id || $community_id)
                                    <span class="text-orange-500">
                                        @if($search) "{{ $search }}" @endif
                                    </span>
                                @endif
                            </h2>
                            <p class="text-gray-600">
                                พบ <span class="font-semibold text-orange-600">{{ $items->total() }}</span> รายการ
                                @if($items->hasPages())
                                    (หน้า {{ $items->currentPage() }}/{{ $items->lastPage() }})
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($items->count() > 0)
                    <!-- Cultural Items Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($items as $item)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                                <!-- Image -->
                                <div class="relative h-48 overflow-hidden">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" 
                                             alt="{{ $item->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                                        </div>
                                    @endif
                                    
                                    @if($item->is_featured)
                                        <div class="absolute top-2 left-2">
                                            <span class="bg-orange-500 text-white px-2 py-1 rounded text-xs font-bold">
                                                แนะนำ
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-4">
                                    <h3 class="font-bold text-lg text-gray-800 mb-2">
                                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                                           class="hover:text-orange-500 transition-colors">
                                            {{ $item->title }}
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                        {{ Str::limit($item->description, 120) }}
                                    </p>

                                    <!-- Meta Info -->
                                    <div class="flex flex-wrap gap-2 mb-3 text-xs">
                                        @if($item->category)
                                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded">
                                                {{ $item->category->name }}
                                            </span>
                                        @endif
                                        @if($item->community)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                {{ $item->community->name }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Footer -->
                                    <div class="flex justify-between items-center pt-3 border-t">
                                        <span class="text-sm text-gray-500">
                                            {{ $item->publish_date ? $item->publish_date->format('d/m/Y') : 'ไม่ระบุ' }}
                                        </span>
                                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                                           class="text-orange-500 hover:text-orange-600 font-semibold text-sm">
                                            อ่านเพิ่มเติม →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- No Results -->
                    <div class="text-center py-12">
                        <div class="mb-4">
                            <i class="fas fa-search text-gray-400 text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">ไม่พบผลการค้นหา</h3>
                        <p class="text-gray-500 mb-4">
                            ขออภัย ไม่พบวัฒนธรรมที่ตรงกับเงื่อนไขที่คุณค้นหา
                        </p>
                        <a href="{{ route('cultural.explore') }}" 
                           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md">
                            ดูทั้งหมด
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Statistics -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">สถิติ</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">รายการทั้งหมด</span>
                            <span class="font-semibold">{{ $stats['total_items'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">หมวดหมู่</span>
                            <span class="font-semibold">{{ $stats['total_categories'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">ชุมชน</span>
                            <span class="font-semibold">{{ $stats['total_communities'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Popular Items -->
                @if(isset($popularItems) && $popularItems->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">ยอดนิยม</h3>
                    <div class="space-y-3">
                        @foreach($popularItems->take(5) as $item)
                            <div class="flex space-x-3">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" 
                                         alt="{{ $item->title }}"
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-sm text-gray-800 line-clamp-2">
                                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                                           class="hover:text-orange-500">
                                            {{ $item->title }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $item->category->name ?? '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Latest Items -->
                @if(isset($latestItems) && $latestItems->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">ล่าสุด</h3>
                    <div class="space-y-3">
                        @foreach($latestItems->take(5) as $item)
                            <div class="flex space-x-3">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" 
                                         alt="{{ $item->title }}"
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-sm text-gray-800 line-clamp-2">
                                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                                           class="hover:text-orange-500">
                                            {{ $item->title }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $item->publish_date ? $item->publish_date->format('d/m/Y') : '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
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
</style>
@endpush