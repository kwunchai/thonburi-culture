@props([
    'community',
    'showItemCount' => true,
    'size' => 'md', // sm, md, lg
])

@php
    $sizeClasses = [
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
    ];
    
    $imageHeightClasses = [
        'sm' => 'h-32',
        'md' => 'h-40',
        'lg' => 'h-48',
    ];
    
    $paddingClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $imageHeight = $imageHeightClasses[$size] ?? $imageHeightClasses['md'];
@endphp

<div class="group bg-white rounded-2xl shadow-soft hover:shadow-river border border-thonburi-sand-200 overflow-hidden transition-all duration-300 hover:scale-[1.02]">
    
    <!-- Header Image/Icon -->
    <div class="relative {{ $imageHeight }} overflow-hidden bg-gradient-to-br from-thonburi-navy-400 to-thonburi-navy-600">
        
        @if($community->image)
            <img src="{{ Storage::url($community->image) }}" 
                 alt="{{ $community->name_th }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        @else
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-map-marked-alt text-5xl text-white/50"></i>
            </div>
        @endif
        
        <!-- Community icon badge -->
        <div class="absolute top-3 left-3">
            <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-users text-thonburi-navy-600 text-xl"></i>
            </div>
        </div>
        
        <!-- Item count badge -->
        @if($showItemCount && isset($community->cultural_items_count))
        <div class="absolute top-3 right-3">
            <div class="px-3 py-1.5 bg-white/90 backdrop-blur-sm rounded-full text-xs font-bold text-thonburi-navy-700 shadow-lg flex items-center space-x-1">
                <i class="fas fa-layer-group"></i>
                <span>{{ $community->cultural_items_count }} รายการ</span>
            </div>
        </div>
        @endif
        
    </div>
    
    <!-- Content -->
    <div class="{{ $paddingClass }}">
        
        <!-- Community name -->
        <h3 class="{{ $size === 'lg' ? 'text-2xl' : ($size === 'md' ? 'text-xl' : 'text-lg') }} font-bold text-gray-900 mb-3 group-hover:text-thonburi-navy-600 transition-colors">
            <a href="{{ route('communities.show', $community->slug) }}">
                {{ $community->name_th }}
            </a>
        </h3>
        
        <!-- Location -->
        @if($community->district || $community->province)
        <div class="flex items-center space-x-2 mb-3 text-gray-600">
            <i class="fas fa-map-marker-alt text-thonburi-terra-500"></i>
            <span class="text-sm">
                @if($community->district){{ $community->district }}@endif
                @if($community->district && $community->province), @endif
                @if($community->province){{ $community->province }}@endif
            </span>
        </div>
        @endif
        
        <!-- Description -->
        @if($community->description_th)
        <p class="text-sm text-gray-600 leading-relaxed mb-4 line-clamp-3">
            {{ Str::limit(strip_tags($community->description_th), 150) }}
        </p>
        @endif
        
        <!-- Footer -->
        <div class="flex items-center justify-between pt-4 border-t border-thonburi-sand-200">
            <a href="{{ route('communities.show', $community->slug) }}" 
               class="inline-flex items-center space-x-2 text-thonburi-navy-600 hover:text-thonburi-navy-700 font-medium text-sm group/link transition-colors">
                <span>เข้าชมชุมชน</span>
                <i class="fas fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
            </a>
            
            <!-- Optional: Cultural items button -->
            @if($showItemCount && isset($community->cultural_items_count) && $community->cultural_items_count > 0)
            <a href="{{ route('cultural.explore', ['community' => $community->slug]) }}" 
               class="text-xs text-gray-500 hover:text-thonburi-gold-600 transition-colors flex items-center space-x-1">
                <i class="fas fa-images"></i>
                <span>ดูวัฒนธรรม</span>
            </a>
            @endif
        </div>
        
    </div>
    
</div>
