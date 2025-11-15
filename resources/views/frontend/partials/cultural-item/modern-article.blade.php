{{-- Modern Article Content --}}
<article class="relative">
    {{-- Social Share Sidebar (Fixed Position) --}}
    <div class="hidden lg:block fixed left-4 top-1/2 transform -translate-y-1/2 z-20">
        <div class="bg-white rounded-xl shadow-lg border p-2 space-y-3">
            <div class="text-center pb-2 border-b border-gray-100">
                <span class="text-xs text-gray-500 font-medium">แชร์</span>
            </div>
            
            <button onclick="shareToFacebook()" 
                    class="w-10 h-10 bg-blue-600 text-white rounded-lg hover:bg-blue-700 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"
                    title="แชร์ใน Facebook">
                <i class="fab fa-facebook-f text-sm"></i>
            </button>
            
            <button onclick="shareToTwitter()" 
                    class="w-10 h-10 bg-sky-500 text-white rounded-lg hover:bg-sky-600 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"
                    title="แชร์ใน Twitter">
                <i class="fab fa-twitter text-sm"></i>
            </button>
            
            <button onclick="shareToLine()" 
                    class="w-10 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"
                    title="แชร์ใน LINE">
                <i class="fab fa-line text-sm"></i>
            </button>
            
            <button onclick="copyToClipboard()" 
                    class="w-10 h-10 bg-gray-600 text-white rounded-lg hover:bg-gray-700 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"
                    title="คัดลอกลิงก์">
                <i class="fas fa-link text-sm"></i>
            </button>
        </div>
    </div>
    
    {{-- Main Article Content --}}
    <div class="prose prose-lg max-w-none p-8 lg:p-12">
        <div id="introduction" class="text-gray-800 leading-relaxed text-lg">
            {!! nl2br(e($item->description)) !!}
        </div>
        
        {{-- Additional Content Sections --}}
        @if($item->content)
            <div id="details" class="mt-10 pt-10 border-t border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-1 h-6 bg-orange-500 rounded-full mr-3"></div>
                    รายละเอียดเพิ่มเติม
                </h2>
                <div class="text-gray-700 leading-relaxed">
                    {!! nl2br(e($item->content)) !!}
                </div>
            </div>
        @endif

        {{-- Community Section --}}
        @if($item->community)
            <div id="community" class="mt-10 pt-10 border-t border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-1 h-6 bg-orange-500 rounded-full mr-3"></div>
                    ชุมชนและท้องถิ่น
                </h2>
                <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-6 border border-orange-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->community->name }}</h3>
                            @if($item->community->description)
                                <p class="text-gray-700 mb-3 leading-relaxed">{{ $item->community->description }}</p>
                            @endif
                            <div class="text-sm text-gray-600">
                                @if($item->community->location)
                                    <div class="flex items-center mb-1">
                                        <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                                        <span>{{ $item->community->location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Location Section --}}
        @if($item->latitude && $item->longitude)
            <div id="location" class="mt-10 pt-10 border-t border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-1 h-6 bg-orange-500 rounded-full mr-3"></div>
                    ตำแหน่งที่ตั้ง
                </h2>
                <div class="bg-gray-50 rounded-xl p-6 border">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">พิกัดที่ตั้ง</h3>
                            <div class="space-y-3 text-sm text-gray-600 bg-white rounded-lg p-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                    <span class="font-medium">ละติจูด:</span>
                                    <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ number_format($item->latitude, 6) }}°</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                    <span class="font-medium">ลองจิจูด:</span>
                                    <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ number_format($item->longitude, 6) }}°</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    เปิดใน Google Maps
                                </a>
                            </div>
                        </div>
                        <div class="lg:pl-4">
                            @include('frontend.partials.cultural-item.map')
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Tags Section --}}
        @if($item->tags)
            <div class="mt-10 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                    <i class="fas fa-tags mr-2 text-orange-500"></i>
                    ป้ายกำกับ
                </h3>
                <div class="flex flex-wrap gap-2">
                    @php
                        $tags = explode(',', $item->tags);
                    @endphp
                    @foreach($tags as $tag)
                        <span class="inline-block px-4 py-2 bg-gradient-to-r from-orange-100 to-red-100 text-orange-800 rounded-full text-sm font-medium hover:from-orange-200 hover:to-red-200 transition-colors cursor-default border border-orange-200">
                            {{ trim($tag) }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    {{-- Mobile Social Share (Bottom of Article) --}}
    <div class="lg:hidden border-t border-gray-200 p-6 bg-gray-50">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 text-center">แชร์บทความนี้</h3>
        <div class="flex justify-center gap-3">
            <button onclick="shareToFacebook()" 
                    class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                <i class="fab fa-facebook-f mr-2"></i>Facebook
            </button>
            
            <button onclick="shareToTwitter()" 
                    class="flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors text-sm font-medium">
                <i class="fab fa-twitter mr-2"></i>Twitter
            </button>
            
            <button onclick="shareToLine()" 
                    class="flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm font-medium">
                <i class="fab fa-line mr-2"></i>LINE
            </button>
        </div>
    </div>
</article>
    
    {{-- Main Article Content --}}
    <div class="prose prose-lg max-w-none">
        <div id="introduction" class="text-gray-800 leading-relaxed text-lg">
            {!! nl2br(e($item->description)) !!}
        </div>
        
        {{-- Additional Content Sections --}}
        @if($item->content)
            <div id="details" class="mt-8 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">รายละเอียดเพิ่มเติม</h2>
                <div class="text-gray-700 leading-relaxed">
                    {!! nl2br(e($item->content)) !!}
                </div>
            </div>
        @endif

        {{-- Community Section --}}
        @if($item->community)
            <div id="community" class="mt-8 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">ชุมชนและท้องถิ่น</h2>
                <div class="bg-orange-50 rounded-lg p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->community->name }}</h3>
                            @if($item->community->description)
                                <p class="text-gray-700 mb-3">{{ $item->community->description }}</p>
                            @endif
                            <div class="text-sm text-gray-600">
                                @if($item->community->location)
                                    <div class="flex items-center mb-1">
                                        <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                                        <span>{{ $item->community->location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Location Section --}}
        @if($item->latitude && $item->longitude)
            <div id="location" class="mt-8 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">ตำแหน่งที่ตั้ง</h2>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">พิกัดที่ตั้ง</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>ละติจูด:</span>
                                    <span class="font-mono">{{ $item->latitude }}°</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>ลองจิจูด:</span>
                                    <span class="font-mono">{{ $item->longitude }}°</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    เปิดใน Google Maps
                                </a>
                            </div>
                        </div>
                        <div>
                            @include('frontend.partials.cultural-item.map')
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Tags Section --}}
        @if($item->tags)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold mb-4 text-gray-900">ป้ายกำกับ</h3>
                <div class="flex flex-wrap gap-2">
                    @php
                        $tags = explode(',', $item->tags);
                    @endphp
                    @foreach($tags as $tag)
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors">
                            {{ trim($tag) }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    {{-- Mobile Social Share (Bottom of Article) --}}
    <div class="lg:hidden mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 text-center">แชร์บทความนี้</h3>
        <div class="flex justify-center gap-3">
            <button onclick="shareToFacebook()" 
                    class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                <i class="fab fa-facebook-f mr-2"></i>Facebook
            </button>
            
            <button onclick="shareToTwitter()" 
                    class="flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors text-sm">
                <i class="fab fa-twitter mr-2"></i>Twitter
            </button>
            
            <button onclick="shareToLine()" 
                    class="flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm">
                <i class="fab fa-line mr-2"></i>LINE
            </button>
        </div>
    </div>
</article>