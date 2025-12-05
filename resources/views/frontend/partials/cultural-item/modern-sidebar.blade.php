{{-- Modern Sticky Sidebar --}}
<div class="space-y-6">
    
    {{-- Table of Contents --}}
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
            <i class="fas fa-list-ul mr-2 text-orange-500"></i>สารบัญ
        </h3>
        <nav class="space-y-1">
            <a href="#introduction" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg border-l-3 border-transparent hover:border-orange-500">
                <span class="text-sm font-medium">1. ข้อมูลเบื้องต้น</span>
            </a>
            @if($item->content)
                <a href="#details" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg border-l-3 border-transparent hover:border-orange-500">
                    <span class="text-sm font-medium">2. รายละเอียดเพิ่มเติม</span>
                </a>
            @endif
            @if($item->community)
                <a href="#community" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg border-l-3 border-transparent hover:border-orange-500">
                    <span class="text-sm font-medium">{{ $item->content ? '3' : '2' }}. ชุมชนและท้องถิ่น</span>
                </a>
            @endif
            @if($item->latitude && $item->longitude)
                <a href="#location" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg border-l-3 border-transparent hover:border-orange-500">
                    <span class="text-sm font-medium">
                        {{ collect([$item->content, $item->community])->filter()->count() + 2 }}. ตำแหน่งที่ตั้ง
                    </span>
                </a>
            @endif
        </nav>
    </div>
    
    {{-- Quick Info Card --}}
    <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl border border-orange-100 p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
            <i class="fas fa-info-circle mr-2 text-orange-500"></i>ข้อมูลสำคัญ
        </h3>
        
        <div class="space-y-3 text-sm">
            @if($item->category)
                <div class="flex justify-between items-center py-2 border-b border-orange-100 last:border-b-0">
                    <span class="text-gray-600 font-medium">หมวดหมู่:</span>
                    <span class="text-gray-900 bg-white px-3 py-1 rounded-full text-xs font-medium">{{ $item->category->name }}</span>
                </div>
            @endif
            
            @if($item->community)
                <div class="flex justify-between items-center py-2 border-b border-orange-100 last:border-b-0">
                    <span class="text-gray-600 font-medium">ชุมชน:</span>
                    <span class="text-gray-900 bg-white px-3 py-1 rounded-full text-xs font-medium">{{ $item->community->name }}</span>
                </div>
            @endif
            
            @if($item->publish_date)
                <div class="flex justify-between items-center py-2 border-b border-orange-100 last:border-b-0">
                    <span class="text-gray-600 font-medium">วันที่เผยแพร่:</span>
                    <span class="text-gray-900 bg-white px-3 py-1 rounded-full text-xs font-medium">{{ $item->publish_date->format('d/m/Y') }}</span>
                </div>
            @endif
            
            @if($item->creator)
                <div class="flex justify-between items-center py-2 border-b border-orange-100 last:border-b-0">
                    <span class="text-gray-600 font-medium">ผู้จัดทำ:</span>
                    <span class="text-gray-900 bg-white px-3 py-1 rounded-full text-xs font-medium">{{ $item->creator->name }}</span>
                </div>
            @endif
            
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-600 font-medium">เวลาอ่าน:</span>
                <span class="text-gray-900 bg-white px-3 py-1 rounded-full text-xs font-medium">
                    {{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาที
                </span>
            </div>
        </div>
    </div>
    
    {{-- Related Articles --}}
    @if(isset($relatedItems) && $relatedItems->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold mb-6 text-gray-900 flex items-center">
                <i class="fas fa-heart mr-2 text-pink-500"></i>เรื่องราวที่เกี่ยวข้อง
            </h3>
            
            <div class="space-y-4">
                @foreach($relatedItems->take(3) as $related)
                    <article class="group">
                        <a href="{{ route('cultural-item.show', $related->id) }}" class="block">
                            <div class="flex gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                @if($related->image)
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $related->image) }}" 
                                             alt="{{ $related->title }}" 
                                             class="w-16 h-16 object-cover rounded-lg group-hover:scale-105 transition-transform duration-200">
                                    </div>
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-image text-gray-400 text-lg"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 group-hover:text-orange-600 transition-colors text-sm leading-tight line-clamp-2 mb-2">
                                        {{ $related->title }}
                                    </h4>
                                    
                                    <div class="space-y-1">
                                        @if($related->category)
                                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                {{ $related->category->name }}
                                            </span>
                                        @endif
                                        
                                        @if($related->publish_date)
                                            <p class="text-xs text-gray-500">
                                                {{ $related->publish_date->format('d M Y') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                    
                    @if(!$loop->last)
                        <div class="border-t border-gray-100"></div>
                    @endif
                @endforeach
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('cultural.explore') }}" 
                   class="block text-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-[1.02]">
                    ดูเรื่องราวทั้งหมด →
                </a>
            </div>
        </div>
    @endif
    
</div>
    
    {{-- Related Articles --}}
    @if(isset($relatedItems) && $relatedItems->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold mb-6 text-gray-900 flex items-center">
                <i class="fas fa-heart mr-2 text-pink-500"></i>เรื่องราวที่เกี่ยวข้อง
            </h3>
            
            <div class="space-y-4">
                @foreach($relatedItems->take(3) as $related)
                    <article class="group">
                        <a href="{{ route('cultural-item.show', $related->id) }}" class="block">
                            <div class="flex gap-4">
                                @if($related->image)
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $related->image) }}" 
                                             alt="{{ $related->title }}" 
                                             class="w-16 h-16 object-cover rounded-lg group-hover:scale-105 transition-transform">
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 group-hover:text-orange-600 transition-colors text-sm leading-tight line-clamp-2 mb-1">
                                        {{ $related->title }}
                                    </h4>
                                    
                                    @if($related->category)
                                        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">
                                            {{ $related->category->name }}
                                        </span>
                                    @endif
                                    
                                    @if($related->publish_date)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $related->publish_date->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </article>
                    
                    @if(!$loop->last)
                        <div class="border-t border-gray-100"></div>
                    @endif
                @endforeach
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('cultural.explore') }}" 
                   class="block text-center px-4 py-2 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg text-sm font-medium transition-colors">
                    ดูเรื่องราวทั้งหมด →
                </a>
            </div>
        </div>
    @endif
    
    {{-- Quick Info Card --}}
    <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
            <i class="fas fa-info-circle mr-2 text-orange-500"></i>ข้อมูลสำคัญ
        </h3>
        
        <div class="space-y-3 text-sm">
            @if($item->category)
                <div class="flex justify-between">
                    <span class="text-gray-600">หมวดหมู่:</span>
                    <span class="font-medium text-gray-900">{{ $item->category->name }}</span>
                </div>
            @endif
            
            @if($item->community)
                <div class="flex justify-between">
                    <span class="text-gray-600">ชุมชน:</span>
                    <span class="font-medium text-gray-900">{{ $item->community->name }}</span>
                </div>
            @endif
            
            @if($item->publish_date)
                <div class="flex justify-between">
                    <span class="text-gray-600">วันที่เผยแพร่:</span>
                    <span class="font-medium text-gray-900">{{ $item->publish_date->format('d/m/Y') }}</span>
                </div>
            @endif
            
            @if($item->creator)
                <div class="flex justify-between">
                    <span class="text-gray-600">ผู้จัดทำ:</span>
                    <span class="font-medium text-gray-900">{{ $item->creator->name }}</span>
                </div>
            @endif
        </div>
    </div>
    
</div>