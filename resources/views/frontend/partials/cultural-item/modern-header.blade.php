{{-- Modern Article Header --}}
<header class="text-center mb-8">
    {{-- Category Badge --}}
    @if($item->category)
        <span class="inline-block px-4 py-2 bg-orange-100 text-orange-800 rounded-full text-sm font-medium mb-4">
            {{ $item->category->name }}
        </span>
    @endif
    
    {{-- Article Title --}}
    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
        {{ $item->title }}
    </h1>
    
    {{-- Article Metadata --}}
    <div class="flex flex-wrap items-center justify-center gap-4 text-sm text-gray-600 mb-6">
        {{-- Author --}}
        @if($item->creator)
            <div class="flex items-center">
                <span class="mr-1">โดย</span>
                <span class="font-medium text-gray-900">{{ $item->creator->name }}</span>
            </div>
        @endif
        
        {{-- Date --}}
        @if($item->publish_date)
            <div class="flex items-center">
                <i class="far fa-calendar-alt mr-2 text-gray-400"></i>
                <time datetime="{{ $item->publish_date->format('Y-m-d') }}">
                    {{ $item->publish_date->format('d M Y') }}
                </time>
            </div>
        @endif
        
        {{-- Reading Time --}}
        <div class="flex items-center">
            <i class="far fa-clock mr-2 text-gray-400"></i>
            <span>{{ max(1, ceil(str_word_count(strip_tags($item->description)) / 200)) }} นาที</span>
        </div>
        
        {{-- Community --}}
        @if($item->community)
            <div class="flex items-center">
                <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                <span>{{ $item->community->name }}</span>
            </div>
        @endif
    </div>
    
    {{-- Social Share Buttons --}}
    <div class="flex items-center justify-center gap-3">
        <button onclick="showShareModal()" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
            <i class="fas fa-share-alt mr-2"></i>แชร์บทความ
        </button>
        
        <button onclick="window.print()" 
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
            <i class="fas fa-print mr-2"></i>พิมพ์
        </button>
    </div>
</header>