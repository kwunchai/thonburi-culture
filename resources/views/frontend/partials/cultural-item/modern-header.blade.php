{{-- Modern Article Header --}}
<header class="text-center mb-12">
    {{-- Category Badge --}}
    @if($item->category)
        <div class="mb-6">
            <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full text-sm font-medium shadow-sm">
                <i class="fas fa-tag mr-2"></i>
                {{ $item->category->name }}
            </span>
        </div>
    @endif
    
    {{-- Article Title --}}
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-8 max-w-4xl mx-auto">
        {{ $item->title }}
    </h1>
    
    {{-- Article Metadata --}}
    <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-gray-600 mb-8 max-w-3xl mx-auto">
        {{-- Author --}}
        @if($item->creator)
            <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm border">
                <div class="w-8 h-8 bg-gradient-to-r from-orange-400 to-red-500 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-xs font-bold">
                        {{ strtoupper(substr($item->creator->name, 0, 1)) }}
                    </span>
                </div>
                <div class="text-left">
                    <div class="text-xs text-gray-500">เขียนโดย</div>
                    <div class="font-medium text-gray-900">{{ $item->creator->name }}</div>
                </div>
            </div>
        @endif
        
        {{-- Date and Reading Time --}}
        <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm border">
            <i class="far fa-calendar-alt mr-3 text-orange-500"></i>
            <div class="text-left">
                @if($item->publish_date)
                    <div class="font-medium text-gray-900">
                        <time datetime="{{ $item->publish_date->format('Y-m-d') }}">
                            {{ $item->publish_date->format('d M Y') }}
                        </time>
                    </div>
                    <div class="text-xs text-gray-500">
                        อ่าน {{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาที
                    </div>
                @endif
            </div>
        </div>
        
        {{-- Community --}}
        @if($item->community)
            <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm border">
                <i class="fas fa-map-marker-alt mr-3 text-orange-500"></i>
                <div class="text-left">
                    <div class="text-xs text-gray-500">ชุมชน</div>
                    <div class="font-medium text-gray-900">{{ $item->community->name }}</div>
                </div>
            </div>
        @endif
    </div>
    
    {{-- Action Buttons --}}
    <div class="flex items-center justify-center gap-4 flex-wrap">
        <button onclick="showShareModal()" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 text-sm font-medium shadow-sm hover:shadow-md transform hover:scale-105">
            <i class="fas fa-share-alt mr-2"></i>แชร์บทความ
        </button>
        
        <button onclick="window.print()" 
                class="inline-flex items-center px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 text-sm font-medium shadow-sm hover:shadow-md">
            <i class="fas fa-print mr-2"></i>พิมพ์
        </button>
        
        <button onclick="addToBookmark()" 
                class="inline-flex items-center px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 text-sm font-medium shadow-sm hover:shadow-md">
            <i class="far fa-bookmark mr-2"></i>บันทึก
        </button>
    </div>
</header>