{{-- Reference Style Sidebar --}}
<div class="space-y-6">
    
    {{-- Table of Contents --}}
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
            <i class="fas fa-list-ul mr-2 text-orange-500"></i>
            Table of Contents
        </h3>
        
        <nav class="space-y-3">
            <a href="#introduction" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg text-sm">
                1. ข้อมูลเบื้องต้น
            </a>
            <a href="#protect-yourself" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg text-sm">
                2. ปกป้องตัวเอง
            </a>
            <a href="#preparation" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg text-sm">
                3. การเตรียมตัวก่อนเดินทาง
            </a>
            @if($item->community)
                <a href="#community" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg text-sm">
                    4. ชุมชนและท้องถิ่น
                </a>
            @endif
            @if($item->latitude && $item->longitude)
                <a href="#location" class="block text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 py-2 px-3 rounded-lg text-sm">
                    {{ $item->community ? '5' : '4' }}. ตำแหน่งที่ตั้ง
                </a>
            @endif
        </nav>
    </div>
    
    {{-- Related Articles --}}
    @if(isset($relatedItems) && $relatedItems->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold mb-6 text-gray-900">
                Related Articles
            </h3>
            
            <div class="space-y-6">
                @foreach($relatedItems->take(4) as $related)
                    <article class="group">
                        <a href="{{ route('cultural-item.show', $related->id) }}" class="block">
                            {{-- Article Image --}}
                            @if($related->image)
                                <div class="aspect-video mb-3 overflow-hidden rounded-lg">
                                    <img src="{{ asset('storage/' . $related->image) }}" 
                                         alt="{{ $related->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="aspect-video mb-3 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-3xl text-gray-400"></i>
                                </div>
                            @endif
                            
                            {{-- Article Info --}}
                            <div class="space-y-2">
                                {{-- Category --}}
                                @if($related->category)
                                    <span class="inline-block px-2 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded">
                                        {{ $related->category->name }}
                                    </span>
                                @endif
                                
                                {{-- Title --}}
                                <h4 class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors text-sm leading-tight line-clamp-2">
                                    {{ $related->title }}
                                </h4>
                                
                                {{-- Meta --}}
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    @if($related->community)
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $related->community->name }}
                                        </span>
                                    @endif
                                    
                                    @if($related->publish_date)
                                        <time datetime="{{ $related->publish_date->format('Y-m-d') }}">
                                            {{ $related->publish_date->format('M d') }}
                                        </time>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </article>
                    
                    @if(!$loop->last)
                        <div class="border-t border-gray-100 pt-6"></div>
                    @endif
                @endforeach
            </div>
            
            {{-- View More Link --}}
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('cultural.explore') }}" 
                   class="flex items-center justify-center w-full px-4 py-2 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg text-sm font-medium transition-colors">
                    <span>ดูเรื่องราวทั้งหมด</span>
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
        </div>
    @endif
    
    {{-- Newsletter Signup (Compact Version) --}}
    <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl p-6 text-white">
        <div class="text-center">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-envelope text-lg"></i>
            </div>
            
            <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
            <p class="text-white/90 text-sm mb-4">รับข่าวสารวัฒนธรรมใหม่ๆ</p>
            
            <form action="#" method="POST" class="space-y-3">
                @csrf
                <input type="email" 
                       name="email" 
                       placeholder="อีเมลของคุณ" 
                       required
                       class="w-full px-3 py-2 rounded-lg text-gray-900 text-sm border-0 focus:ring-2 focus:ring-white/50 outline-none">
                
                <button type="submit" 
                        class="w-full bg-white text-orange-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors text-sm">
                    สมัครสมาชิก
                </button>
            </form>
        </div>
    </div>
    
    {{-- Quick Info --}}
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900">
            ข้อมูลสำคัญ
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
                    <span class="font-medium text-gray-900">{{ Str::limit($item->community->name, 15) }}</span>
                </div>
            @endif
            
            @if($item->publish_date)
                <div class="flex justify-between">
                    <span class="text-gray-600">เผยแพร่:</span>
                    <span class="font-medium text-gray-900">{{ $item->publish_date->format('d/m/Y') }}</span>
                </div>
            @endif
            
            <div class="flex justify-between">
                <span class="text-gray-600">เวลาอ่าน:</span>
                <span class="font-medium text-gray-900">
                    {{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาที
                </span>
            </div>
            
            @if($item->creator)
                <div class="flex justify-between">
                    <span class="text-gray-600">ผู้จัดทำ:</span>
                    <span class="font-medium text-gray-900">{{ Str::limit($item->creator->name, 12) }}</span>
                </div>
            @endif
        </div>
    </div>
    
</div>