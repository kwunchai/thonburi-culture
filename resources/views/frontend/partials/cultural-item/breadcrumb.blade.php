{{-- Modern Breadcrumb Navigation --}}
<nav class="mb-8" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li>
            <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">
                <i class="fas fa-home mr-1"></i>หน้าแรก
            </a>
        </li>
        <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
        <li>
            <a href="{{ route('cultural.explore') }}" class="hover:text-orange-600 transition-colors">
                สำรวจวัฒนธรรม
            </a>
        </li>
        @if($item->category)
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li>
                <a href="{{ route('cultural.explore', ['category_id' => $item->category->id]) }}" class="hover:text-orange-600 transition-colors">
                    {{ $item->category->name }}
                </a>
            </li>
        @endif
        <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
        <li class="text-gray-900 font-medium">{{ Str::limit($item->title, 50) }}</li>
    </ol>
</nav>