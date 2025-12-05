{{-- Reference Style Article Content --}}
<article class="p-8 lg:p-12">
    
    {{-- Social Share Buttons (Left Fixed) --}}
    <div class="hidden lg:block fixed left-4 top-1/2 transform -translate-y-1/2 z-20">
        <div class="bg-white rounded-lg shadow-lg border p-3 space-y-3">
            <div class="text-center pb-2 border-b border-gray-100">
                <span class="text-xs text-gray-500 font-medium">แชร์</span>
            </div>
            
            <button onclick="shareToFacebook()" 
                    class="w-10 h-10 bg-blue-600 text-white rounded-lg hover:bg-blue-700 hover:scale-110 transition-all duration-200 flex items-center justify-center"
                    title="แชร์ใน Facebook">
                <i class="fab fa-facebook-f text-sm"></i>
            </button>
            
            <button onclick="shareToTwitter()" 
                    class="w-10 h-10 bg-sky-500 text-white rounded-lg hover:bg-sky-600 hover:scale-110 transition-all duration-200 flex items-center justify-center"
                    title="แชร์ใน Twitter">
                <i class="fab fa-twitter text-sm"></i>
            </button>
            
            <button onclick="shareToLine()" 
                    class="w-10 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600 hover:scale-110 transition-all duration-200 flex items-center justify-center"
                    title="แชร์ใน LINE">
                <i class="fab fa-line text-sm"></i>
            </button>
            
            <button onclick="copyToClipboard()" 
                    class="w-10 h-10 bg-gray-600 text-white rounded-lg hover:bg-gray-700 hover:scale-110 transition-all duration-200 flex items-center justify-center"
                    title="คัดลอกลิงก์">
                <i class="fas fa-link text-sm"></i>
            </button>
        </div>
    </div>
    
    {{-- Article Introduction --}}
    <div id="introduction" class="prose prose-lg max-w-none mb-8">
        <div class="text-gray-800 leading-relaxed text-lg">
            {!! nl2br(e($item->description)) !!}
        </div>
    </div>
    
    {{-- Section: ปกป้องตัวเอง (Protect Yourself) --}}
    <section id="protect-yourself" class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">1</span>
            ปกป้องตัวเอง
        </h2>
        
        <div class="space-y-4 text-gray-700 leading-relaxed">
            @if($item->content)
                <div class="prose max-w-none">
                    {!! nl2br(e($item->content)) !!}
                </div>
            @else
                <p>การปกป้องตัวเองในการท่องเที่ยวเดี่ยวเป็นสิ่งสำคัญที่สุด ควรศึกษาข้อมูลเบื้องต้นเกี่ยวกับสถานที่ท่องเที่ยว วางแผนการเดินทาง และเตรียมอุปกรณ์ที่จำเป็นให้พร้อม รวมถึงการแจ้งแผนการเดินทางให้คนใกล้ชิดทราบ</p>
                
                <ul class="list-disc list-inside space-y-2 ml-6">
                    <li>ศึกษาข้อมูลเส้นทางและสภาพอากาศล่วงหน้า</li>
                    <li>เตรียมอุปกรณ์ปฐมพยาบาลและยาฉุกเฉิน</li>
                    <li>แจ้งแผนการเดินทางให้เพื่อนหรือครอบครัวทราบ</li>
                    <li>เก็บเอกสารสำคัญไว้ในที่ปลอดภัย</li>
                </ul>
            @endif
        </div>
    </section>
    
    {{-- Section: การเตรียมตัว (Preparation) --}}
    <section id="preparation" class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">2</span>
            การเตรียมตัวก่อนเดินทาง
        </h2>
        
        <div class="bg-orange-50 border-l-4 border-orange-500 p-6 rounded-r-lg mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-orange-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-orange-800">เคล็ดลับสำคัญ</h3>
                    <p class="text-orange-700 leading-relaxed">การเตรียมตัวที่ดีจะช่วยให้การเดินทางเป็นไปอย่างราบรื่นและปลอดภัย</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <h3 class="text-lg font-semibold text-gray-800">อุปกรณ์ที่จำเป็น</h3>
                <ul class="list-disc list-inside space-y-1 text-gray-700">
                    <li>เป้สะพายหลังที่เหมาะสม</li>
                    <li>เสื้อผ้าสำหรับสภาพอากาศต่างๆ</li>
                    <li>รองเท้าเดินป่าที่มั่นคง</li>
                    <li>อุปกรณ์นำทาง (GPS, แผนที่)</li>
                </ul>
            </div>
            
            <div class="space-y-3">
                <h3 class="text-lg font-semibold text-gray-800">เอกสารสำคัญ</h3>
                <ul class="list-disc list-inside space-y-1 text-gray-700">
                    <li>บัตรประจำตัวประชาชน</li>
                    <li>ใบขับขี่ (หากใช้รถยนต์)</li>
                    <li>ประกันการเดินทาง</li>
                    <li>หมายเลขติดต่อฉุกเฉิน</li>
                </ul>
            </div>
        </div>
    </section>
    
    {{-- Community Section --}}
    @if($item->community)
        <section id="community" class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <span class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">3</span>
                ชุมชนและท้องถิ่น
            </h2>
            
            <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-8 border border-orange-200">
                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $item->community->name }}</h3>
                        @if($item->community->description)
                            <p class="text-gray-700 mb-4 leading-relaxed">{{ $item->community->description }}</p>
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            @if($item->community->location)
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                                    <span class="text-gray-600">ที่ตั้ง: {{ $item->community->location }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2 text-orange-500"></i>
                                <span class="text-gray-600">ข้อมูลเพิ่มเติม: ติดต่อชุมชนท้องถิ่น</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    
    {{-- Location Section --}}
    @if($item->latitude && $item->longitude)
        <section id="location" class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <span class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">4</span>
                ตำแหน่งที่ตั้ง
            </h2>
            
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">พิกัดภูมิศาสตร์</h3>
                        <div class="bg-white rounded-lg p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">ละติจูด:</span>
                                <span class="font-mono text-gray-900 bg-gray-100 px-3 py-1 rounded">
                                    {{ number_format($item->latitude, 6) }}°
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">ลองจิจูด:</span>
                                <span class="font-mono text-gray-900 bg-gray-100 px-3 py-1 rounded">
                                    {{ number_format($item->longitude, 6) }}°
                                </span>
                            </div>
                        </div>
                        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                           target="_blank"
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            ดูใน Google Maps
                        </a>
                    </div>
                    <div>
                        @include('frontend.partials.cultural-item.map')
                    </div>
                </div>
            </div>
        </section>
    @endif
    
    {{-- Tags Section --}}
    @if($item->tags)
        <section class="border-t border-gray-200 pt-8">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                <i class="fas fa-tags mr-2 text-orange-500"></i>
                หมวดหมู่และป้ายกำกับ
            </h3>
            <div class="flex flex-wrap gap-3">
                @php
                    $tags = explode(',', $item->tags);
                @endphp
                @foreach($tags as $tag)
                    <span class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 rounded-full text-sm font-medium hover:bg-orange-200 transition-colors">
                        <i class="fas fa-tag mr-1 text-xs"></i>
                        {{ trim($tag) }}
                    </span>
                @endforeach
            </div>
        </section>
    @endif
    
    {{-- Mobile Social Share --}}
    <div class="lg:hidden mt-12 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 text-center">แชร์บทความนี้</h3>
        <div class="flex justify-center gap-3 flex-wrap">
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
            
            <button onclick="copyToClipboard()" 
                    class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                <i class="fas fa-link mr-2"></i>คัดลอก
            </button>
        </div>
    </div>
    
</article>