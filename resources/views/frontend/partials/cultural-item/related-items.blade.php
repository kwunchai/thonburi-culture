{{-- Related Items Section --}}
@if(isset($relatedItems) && $relatedItems->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900">
            <i class="fas fa-heart text-pink-500 mr-2"></i>เรื่องราวที่เกี่ยวข้อง
        </h3>
        
        <div class="space-y-4">
            @foreach($relatedItems->take(4) as $related)
                <a href="{{ route('cultural-item.show', $related->id) }}" 
                   class="block group hover:bg-gray-50 rounded-lg p-3 transition-colors">
                    <div class="flex gap-3">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" 
                                 alt="{{ $related->title }}" 
                                 class="w-12 h-12 object-cover rounded-lg flex-shrink-0">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-image text-gray-400 text-sm"></i>
                            </div>
                        @endif
                        
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-900 group-hover:text-orange-600 transition-colors text-sm leading-tight line-clamp-2">
                                {{ $related->title }}
                            </h4>
                            @if($related->category)
                                <p class="text-xs text-gray-500 mt-1">{{ $related->category->name }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('cultural.explore') }}" 
               class="block text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-search mr-2"></i>ดูเรื่องราวทั้งหมด
            </a>
        </div>
    </div>
@endif