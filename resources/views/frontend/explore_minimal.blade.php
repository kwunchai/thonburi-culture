@extends('layouts.frontend')

@section('title', 'สำรวจวัฒนธรรม')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-orange-400 to-red-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">สำรวจวัฒนธรรม</h1>
            <p class="text-xl">ค้นพบมรดกวัฒนธรรมไทย</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Search -->
        <div class="mb-8">
            <form method="GET" action="{{ route('explore') }}">
                <div class="flex gap-4">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="ค้นหา..."
                           class="flex-1 px-4 py-2 border rounded-lg">
                    <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg">ค้นหา</button>
                </div>
            </form>
        </div>

        <!-- Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($items as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->name }}" 
                             class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2">{{ $item->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ Str::limit($item->description, 100) }}</p>
                        <a href="{{ route('cultural-item.show', $item->slug) }}" 
                           class="inline-block mt-3 text-orange-500 hover:text-orange-600">
                            ดูรายละเอียด →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-gray-500 text-lg">ไม่พบข้อมูลวัฒนธรรม</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
            <div class="mt-8">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection