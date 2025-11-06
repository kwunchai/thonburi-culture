{{-- Breadcrumb Navigation --}}
<nav class="mb-4" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm text-white/80">
        <li>
            <a href="{{ route('home') }}" class="hover:text-white">
                <i class="fas fa-home mr-1"></i>หน้าแรก
            </a>
        </li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li>
            <a href="{{ route('cultural.explore') }}" class="hover:text-white">
                สำรวจวัฒนธรรม
            </a>
        </li>
        @if($item->category)
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li>
                <a href="{{ route('category', $item->category->slug) }}" class="hover:text-white">
                    {{ $item->category->name }}
                </a>
            </li>
        @endif
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li class="text-white font-medium">{{ Str::limit($item->title, 40) }}</li>
    </ol>
</nav>