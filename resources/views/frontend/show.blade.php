@extends('layouts.frontend')

@section('title', $item->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <nav class="mb-4">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-600">หน้าแรก</a>
        <span class="mx-2">/</span>
        <a href="{{ route('category', $item->category->slug) }}" class="text-gray-500 hover:text-orange-600">
            {{ $item->category->name }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-gray-700">{{ $item->title }}</span>
    </nav>

    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($item->image)
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-96 object-cover">
        @endif
        
        <div class="p-8">
            <h1 class="text-3xl font-bold mb-4">{{ $item->title }}</h1>
            
            <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4">
                <span>
                    <i class="fas fa-folder"></i> {{ $item->category->name }}
                </span>
                <span>
                    <i class="fas fa-map-marker-alt"></i> {{ $item->community->name }}
                </span>
                <span>
                    <i class="fas fa-calendar"></i> {{ $item->publish_date->format('d/m/Y') }}
                </span>
            </div>
            
            <div class="prose max-w-none">
                {!! nl2br(e($item->description)) !!}
            </div>
        </div>
    </article>

    @if($relatedItems->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">ข้อมูลที่เกี่ยวข้อง</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($relatedItems as $related)
                <a href="{{ route('cultural-item.show', $related->id) }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg">
                    <h3 class="font-semibold mb-2">{{ $related->title }}</h3>
                    <p class="text-sm text-gray-600">{{ Str::limit($related->description, 80) }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection