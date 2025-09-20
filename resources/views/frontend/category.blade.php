@extends('layouts.frontend')

@section('title', $category->name)

@section('content')
<div class="bg-gradient-to-r from-orange-500 to-orange-600 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-white">{{ $category->name }}</h1>
        <p class="text-white/90 mt-2">{{ $category->description }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($items as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-4xl text-gray-400"></i>
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">{{ $item->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-map-marker-alt"></i> {{ $item->community->name }}
                        </span>
                        <a href="{{ route('cultural-item.show', $item->id) }}" class="text-orange-600 hover:text-orange-700">
                            อ่านเพิ่มเติม →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">ยังไม่มีข้อมูลในหมวดหมู่นี้</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $items->links() }}
    </div>
</div>
@endsection