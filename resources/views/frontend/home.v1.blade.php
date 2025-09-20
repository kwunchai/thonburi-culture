@extends('layouts.frontend')

@section('title', 'หน้าแรก')

@section('content')
<!-- Hero Section -->
<section class="relative h-96 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Wat_Arun_temple_Bangkok.jpg/1280px-Wat_Arun_temple_Bangkok.jpg" 
             alt="วัดอรุณ" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
    </div>
    <div class="relative z-10 h-full flex items-center justify-center text-center">
        <div class="text-white px-4">
            <h1 class="text-5xl font-bold mb-4">วัฒนธรรมเขตธนบุรี</h1>
            <p class="text-xl max-w-2xl mx-auto">
                ค้นพบเสน่ห์แห่งฝั่งธนบุรี ดินแดนแห่งประวัติศาสตร์ ศิลปวัฒนธรรม และวิถีชีวิตริมน้ำเจ้าพระยา
            </p>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">หมวดหมู่วัฒนธรรม</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @forelse($categories as $category)
            <a href="{{ route('category', $category->slug) }}" 
               class="text-center p-6 rounded-lg hover:bg-orange-50 transition-colors">
                <div class="w-20 h-20 mx-auto mb-4 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas {{ $category->icon ?? 'fa-folder' }} text-2xl text-orange-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
            </a>
            @empty
            <div class="col-span-6 text-center text-gray-500">
                ยังไม่มีหมวดหมู่
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Latest Items Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">ข้อมูลวัฒนธรรมล่าสุด</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($latestItems as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-4xl text-gray-400"></i>
                    </div>
                @endif
                <div class="p-4">
                    <span class="bg-orange-100 text-orange-600 px-2 py-1 rounded text-xs">
                        {{ $item->category->name }}
                    </span>
                    <h3 class="font-semibold text-lg mt-2 mb-2">{{ $item->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-map-marker-alt"></i> {{ $item->community->name }}
                        </span>
                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                           class="text-orange-600 hover:text-orange-700 text-sm">
                            อ่านเพิ่มเติม →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-500">
                ยังไม่มีข้อมูลวัฒนธรรม
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Communities Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">ชุมชนในเขตธนบุรี</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse($communities as $community)
            <div class="text-center">
                <div class="aspect-square rounded-lg overflow-hidden mb-2 bg-gray-200">
                    @if($community->image)
                        <img src="{{ Storage::url($community->image) }}" alt="{{ $community->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-building text-4xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                <p class="text-sm font-medium text-gray-700">{{ $community->name }}</p>
            </div>
            @empty
            <div class="col-span-6 text-center text-gray-500">
                ยังไม่มีข้อมูลชุมชน
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection