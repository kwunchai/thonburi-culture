{{-- Header Section --}}
<header class="bg-gradient-to-r from-orange-500 to-red-500 text-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        {{-- Breadcrumb Navigation --}}
        @include('frontend.partials.cultural-item.breadcrumb')
        
        {{-- Title & Category Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                @if($item->category)
                    <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-medium mb-3">
                        <i class="fas fa-tag mr-1"></i>{{ $item->category->name }}
                    </span>
                @endif
                <h1 class="text-3xl md:text-4xl font-bold leading-tight">{{ $item->title }}</h1>
            </div>
            
            {{-- Share Button --}}
            <button onclick="showShareModal()" 
                    class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-share-alt mr-2"></i>แชร์
            </button>
        </div>
        
        {{-- Meta Information --}}
        @include('frontend.partials.cultural-item.meta-info')
    </div>
</header>