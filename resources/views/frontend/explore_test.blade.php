@extends('layouts.frontend')

@section('title', 'ทดสอบ Explore')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">ทดสอบหน้า Explore</h1>
    
    <div class="bg-blue-100 p-4 rounded mb-4">
        <h2 class="text-xl font-bold">ข้อมูลที่ได้รับ:</h2>
        <ul class="mt-2">
            <li>Items count: {{ $items->count() ?? 'NULL' }}</li>
            <li>Items total: {{ $items->total() ?? 'NULL' }}</li>
            <li>Categories count: {{ $categories->count() ?? 'NULL' }}</li>
            <li>Communities count: {{ $communities->count() ?? 'NULL' }}</li>
            <li>Search: "{{ $search ?? 'NULL' }}"</li>
            <li>Category ID: {{ $category_id ?? 'NULL' }}</li>
            <li>Community ID: {{ $community_id ?? 'NULL' }}</li>
        </ul>
    </div>

    @if(isset($stats))
    <div class="bg-green-100 p-4 rounded mb-4">
        <h2 class="text-xl font-bold">สถิติ:</h2>
        <ul class="mt-2">
            @foreach($stats as $key => $value)
                <li>{{ $key }}: {{ $value }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(isset($items) && $items->count() > 0)
    <div class="bg-yellow-100 p-4 rounded mb-4">
        <h2 class="text-xl font-bold">รายการ ({{ $items->count() }} รายการแรก):</h2>
        <ul class="mt-2">
            @foreach($items->take(5) as $item)
                <li>{{ $item->title }} ({{ $item->category->name ?? 'ไม่มีหมวดหมู่' }})</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(isset($categories) && $categories->count() > 0)
    <div class="bg-purple-100 p-4 rounded mb-4">
        <h2 class="text-xl font-bold">หมวดหมู่:</h2>
        <ul class="mt-2">
            @foreach($categories as $category)
                <li>{{ $category->name }} ({{ $category->cultural_items_count ?? 0 }} รายการ)</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mt-8">
        <a href="{{ route('cultural.explore') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            กลับหน้า Explore
        </a>
    </div>
</div>
@endsection