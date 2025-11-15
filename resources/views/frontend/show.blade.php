@extends('layouts.frontend')

@section('title', $item->title)

@section('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
    <meta property="og:title" content="{{ $item->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
    @if($item->image)
        <meta property="og:image" content="{{ asset('storage/' . $item->image) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
    {{-- Modern Blog Layout Structure --}}
    <div class="bg-white">
        {{-- Main Container --}}
        <div class="max-w-6xl mx-auto px-4 py-8">
            
            {{-- Breadcrumb --}}
            @include('frontend.partials.cultural-item.breadcrumb')
            
            {{-- Article Header Section --}}
            @include('frontend.partials.cultural-item.modern-header')
            
            {{-- Featured Image --}}
            @include('frontend.partials.cultural-item.modern-featured-image')
            
            {{-- Two Column Layout (Main Content + Sidebar) --}}
            <div class="flex flex-col lg:flex-row gap-8 mt-8">
                
                {{-- Main Content Column (70%) --}}
                <main class="lg:w-2/3">
                    @include('frontend.partials.cultural-item.modern-article')
                </main>
                
                {{-- Sidebar Column (30%) --}}
                <aside class="lg:w-1/3">
                    @include('frontend.partials.cultural-item.modern-sidebar')
                </aside>
                
            </div>
            
            {{-- Post-Content Sections (Full Width) --}}
            <div class="mt-12 space-y-8">
                @include('frontend.partials.cultural-item.recommended-section')
                @include('frontend.partials.cultural-item.author-bio')
                @include('frontend.partials.cultural-item.newsletter-section')
            </div>
            
        </div>
    </div>
    
    {{-- Share Modal --}}
    @include('frontend.partials.cultural-item.share-modal')
@endsection

@push('scripts')
    @include('frontend.partials.cultural-item.scripts')
@endpush

@push('styles')
    @include('frontend.partials.cultural-item.styles')
@endpush