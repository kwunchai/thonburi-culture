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
    <div class="min-h-screen bg-gray-50">
        {{-- Main Container --}}
        <div class="max-w-7xl mx-auto">
            
            {{-- Breadcrumb Container --}}
            <div class="bg-white shadow-sm">
                <div class="max-w-4xl mx-auto px-4 py-4">
                    @include('frontend.partials.cultural-item.breadcrumb')
                </div>
            </div>
            
            {{-- Article Content Container --}}
            <div class="max-w-4xl mx-auto px-4 py-8">
                {{-- Article Header Section --}}
                @include('frontend.partials.cultural-item.modern-header')
                
                {{-- Featured Image --}}
                @include('frontend.partials.cultural-item.modern-featured-image')
            </div>
            
            {{-- Two Column Layout Container --}}
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col xl:flex-row gap-8">
                    
                    {{-- Main Content Column (68%) --}}
                    <main class="xl:w-[68%] max-w-4xl">
                        <div class="bg-white rounded-xl shadow-sm">
                            @include('frontend.partials.cultural-item.modern-article')
                        </div>
                    </main>
                    
                    {{-- Sidebar Column (32%) --}}
                    <aside class="xl:w-[32%] xl:max-w-sm">
                        <div class="sticky top-8 space-y-6">
                            @include('frontend.partials.cultural-item.modern-sidebar')
                        </div>
                    </aside>
                    
                </div>
            </div>
            
            {{-- Post-Content Sections (Full Width) --}}
            <div class="max-w-6xl mx-auto px-4 mt-16 space-y-12">
                @include('frontend.partials.cultural-item.recommended-section')
                
                <div class="max-w-4xl mx-auto space-y-8">
                    @include('frontend.partials.cultural-item.author-bio')
                    @include('frontend.partials.cultural-item.newsletter-section')
                </div>
            </div>
            
        </div>
        
        {{-- Back to Top Button --}}
        <button id="backToTop" 
                class="fixed bottom-6 right-6 bg-orange-600 text-white p-3 rounded-full shadow-lg hover:bg-orange-700 transition-all duration-300 opacity-0 pointer-events-none transform translate-y-4"
                onclick="scrollToTop()">
            <i class="fas fa-chevron-up"></i>
        </button>
    </div>
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