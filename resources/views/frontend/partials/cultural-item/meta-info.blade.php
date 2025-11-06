{{-- Meta Information --}}
<div class="flex flex-wrap items-center gap-6 mt-6 text-sm text-white/90">
    @if($item->community)
        <span>
            <i class="fas fa-map-marker-alt mr-2"></i>{{ $item->community->name }}
        </span>
    @endif
    
    <span>
        <i class="fas fa-calendar mr-2"></i>{{ $item->publish_date->format('d M Y') }}
    </span>
    
    @if($item->place)
        <span>
            <i class="fas fa-location-dot mr-2"></i>{{ $item->place->name }}
        </span>
    @endif
</div>