{{-- Recommended for You Section --}}
@if(isset($relatedItems) && $relatedItems->count() > 0)
    <section class="py-12 border-t border-gray-200">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">แนะนำสำหรับคุณ</h2>
            <p class="text-gray-600">เรื่องราวทางวัฒนธรรมที่น่าสนใจอื่นๆ</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedItems->take(6) as $recommended)
                <article class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border">
                    <a href="{{ route('cultural-item.show', $recommended->id) }}" class="block">
                        {{-- Article Image --}}
                        @if($recommended->image)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ asset('storage/' . $recommended->image) }}" 
                                     alt="{{ $recommended->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="aspect-video bg-gradient-to-r from-orange-100 to-red-100 flex items-center justify-center">
                                <i class="fas fa-image text-4xl text-orange-300"></i>
                            </div>
                        @endif
                        
                        {{-- Article Content --}}
                        <div class="p-6">
                            {{-- Category Badge --}}
                            @if($recommended->category)
                                <span class="inline-block px-2 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded mb-3">
                                    {{ $recommended->category->name }}
                                </span>
                            @endif
                            
                            {{-- Title --}}
                            <h3 class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors mb-2 line-clamp-2">
                                {{ $recommended->title }}
                            </h3>
                            
                            {{-- Excerpt --}}
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($recommended->description), 120) }}
                            </p>
                            
                            {{-- Meta Info --}}
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                @if($recommended->community)
                                    <span class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $recommended->community->name }}
                                    </span>
                                @endif
                                
                                @if($recommended->publish_date)
                                    <time datetime="{{ $recommended->publish_date->format('Y-m-d') }}">
                                        {{ $recommended->publish_date->format('d M Y') }}
                                    </time>
                                @endif
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
        
        {{-- View More Button --}}
        <div class="text-center mt-8">
            <a href="{{ route('cultural.explore') }}" 
               class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium">
                <i class="fas fa-search mr-2"></i>
                สำรวจเรื่องราวทั้งหมด
            </a>
        </div>
    </section>
@endif