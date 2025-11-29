@props([
    'item',
    'showCommunity' => true,
    'featured' => false,
])

<div class="group bg-white rounded-2xl shadow-soft hover:shadow-heritage border border-thonburi-sand-200 overflow-hidden transition-all duration-300 hover:scale-[1.02] {{ $featured ? 'ring-2 ring-thonburi-gold-400' : '' }}">
    
    <!-- Image Section -->
    <div class="relative aspect-[4/3] overflow-hidden bg-thonburi-sand-100">
        @if($item->main_image)
            <img src="{{ Storage::url($item->main_image) }}" 
                 alt="{{ $item->name_th }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-thonburi-sand-100 to-thonburi-gold-100">
                <i class="fas fa-image text-6xl text-thonburi-sand-300"></i>
            </div>
        @endif
        
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <!-- Featured badge -->
        @if($featured)
        <div class="absolute top-3 left-3">
            <div class="px-3 py-1.5 bg-thonburi-gold-500 text-white rounded-full text-xs font-bold shadow-lg flex items-center space-x-1">
                <i class="fas fa-star"></i>
                <span>แนะนำ</span>
            </div>
        </div>
        @endif
        
        <!-- Category badge -->
        @if($item->category)
        <div class="absolute top-3 right-3">
            <x-category-badge :category="$item->category" size="sm" />
        </div>
        @endif
        
        <!-- Quick view icon -->
        <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-colors">
                <i class="fas fa-eye text-thonburi-gold-600"></i>
            </div>
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="p-5">
        
        <!-- Community info (if enabled) -->
        @if($showCommunity && $item->community)
        <div class="flex items-center space-x-2 mb-3">
            <i class="fas fa-map-marker-alt text-thonburi-terra-500 text-sm"></i>
            <a href="{{ route('communities.show', $item->community->slug) }}" 
               class="text-sm text-gray-600 hover:text-thonburi-gold-600 transition-colors font-medium">
                {{ $item->community->name_th }}
            </a>
        </div>
        @endif
        
        <!-- Title -->
        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-thonburi-gold-600 transition-colors">
            <a href="{{ route('cultural.show', $item->slug) }}">
                {{ $item->name_th }}
            </a>
        </h3>
        
        <!-- Description -->
        @if($item->description_th)
        <p class="text-sm text-gray-600 leading-relaxed mb-4 line-clamp-3">
            {{ Str::limit(strip_tags($item->description_th), 120) }}
        </p>
        @endif
        
        <!-- Footer: View button -->
        <div class="flex items-center justify-between pt-4 border-t border-thonburi-sand-200">
            <a href="{{ route('cultural.show', $item->slug) }}" 
               class="inline-flex items-center space-x-2 text-thonburi-gold-600 hover:text-thonburi-gold-700 font-medium text-sm group/link transition-colors">
                <span>ดูรายละเอียด</span>
                <i class="fas fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
            </a>
            
            <!-- Optional: View count or date -->
            @if(isset($item->created_at))
            <div class="text-xs text-gray-400 flex items-center space-x-1">
                <i class="far fa-clock"></i>
                <span>{{ $item->created_at->diffForHumans() }}</span>
            </div>
            @endif
        </div>
        
    </div>
    
</div>
