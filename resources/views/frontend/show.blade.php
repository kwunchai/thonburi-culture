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
    {{-- Hero Header with Background Image --}}
    <div class="relative h-[50vh] min-h-[400px] bg-gradient-to-r from-orange-500 to-red-600 overflow-hidden">
        {{-- Background Image --}}
        @if($item->image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $item->image) }}" 
                     alt="{{ $item->title }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-black/60"></div>
            </div>
        @endif
        
        {{-- Hero Content --}}
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-6xl mx-auto px-4 w-full">
                
                {{-- Breadcrumb --}}
                <nav class="mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-white/80">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-white transition-colors">
                                <i class="fas fa-home mr-1"></i>หน้าแรก
                            </a>
                        </li>
                        <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                        <li>
                            <a href="{{ route('cultural.explore') }}" class="hover:text-white transition-colors">
                                สำรวจวัฒนธรรม
                            </a>
                        </li>
                        @if($item->category)
                            <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                            <li>
                                <a href="{{ route('cultural.explore') }}?category_id={{ $item->category->id }}" 
                                   class="hover:text-white transition-colors">
                                    {{ $item->category->name }}
                                </a>
                            </li>
                        @endif
                        <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                        <li class="text-white font-medium">{{ Str::limit($item->title, 50) }}</li>
                    </ol>
                </nav>
                
                {{-- Title Section --}}
                <div class="max-w-4xl">
                    @if($item->category)
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-white text-sm font-medium mb-4">
                            <i class="fas fa-tag mr-1"></i>{{ $item->category->name }}
                        </span>
                    @endif
                    
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                        {{ $item->title }}
                    </h1>
                    
                    {{-- Meta Information --}}
                    <div class="flex flex-wrap items-center gap-6 text-sm text-white/90">
                        @if($item->creator)
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-bold">
                                        {{ strtoupper(substr($item->creator->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $item->creator->name }}</div>
                                    <div class="text-xs text-white/70">ผู้จัดทำ</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($item->publish_date)
                            <div class="flex items-center">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <time datetime="{{ $item->publish_date->format('Y-m-d') }}">
                                    {{ $item->publish_date->format('d M Y') }}
                                </time>
                            </div>
                        @endif
                        
                        <div class="flex items-center">
                            <i class="far fa-clock mr-2"></i>
                            <span>อ่าน {{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาที</span>
                        </div>
                        
                        @if($item->community)
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $item->community->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Main Content Area --}}
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {{-- Main Content (3/4 width) --}}
                <main class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @include('frontend.partials.cultural-item.reference-article')
                    </div>
                </main>
                
                {{-- Sidebar (1/4 width) --}}
                <aside class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        @include('frontend.partials.cultural-item.reference-sidebar')
                    </div>
                </aside>
                
            </div>
        </div>
    </div>
    
    {{-- Post-Content Sections --}}
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 py-12 space-y-12">
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
    
    {{-- Share Modal --}}
    @include('frontend.partials.cultural-item.share-modal')
@endsection
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