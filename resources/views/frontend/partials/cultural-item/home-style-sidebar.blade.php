{{-- Sidebar Components in Grid Layout --}}

{{-- Table of Contents Card --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white p-4">
        <h3 class="text-lg font-bold flex items-center">
            <i class="fas fa-list mr-2"></i>
            สารบัญ
        </h3>
    </div>
    <div class="p-4">
        <nav class="space-y-2">
            <a href="#about" class="block py-2 px-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                <i class="fas fa-info-circle w-4 mr-2"></i>
                เกี่ยวกับ
            </a>
            @if($item->content)
                <a href="#content" class="block py-2 px-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                    <i class="fas fa-file-text w-4 mr-2"></i>
                    เนื้อหา
                </a>
            @endif
            @if($item->latitude && $item->longitude)
                <a href="#location" class="block py-2 px-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                    <i class="fas fa-map-marker-alt w-4 mr-2"></i>
                    ที่ตั้ง
                </a>
            @endif
            <a href="#additional" class="block py-2 px-3 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                <i class="fas fa-lightbulb w-4 mr-2"></i>
                ข้อมูลเพิ่มเติม
            </a>
        </nav>
    </div>
</div>

{{-- Quick Facts Card (Home Page Style) --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4">
        <h3 class="text-lg font-bold flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            ข้อมูลสรุป
        </h3>
    </div>
    <div class="p-4 space-y-4">
        {{-- Category --}}
        @if($item->category)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-gray-600 text-sm">หมวดหมู่</span>
                <span class="text-gray-800 font-medium text-sm">{{ $item->category->name }}</span>
            </div>
        @endif
        
        {{-- Community --}}
        @if($item->community)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-gray-600 text-sm">ชุมชน</span>
                <span class="text-gray-800 font-medium text-sm">{{ $item->community->name }}</span>
            </div>
        @endif
        
        {{-- Creator --}}
        @if($item->creator)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-gray-600 text-sm">ผู้จัดทำ</span>
                <span class="text-gray-800 font-medium text-sm">{{ $item->creator->name }}</span>
            </div>
        @endif
        
        {{-- Publish Date --}}
        @if($item->publish_date)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <span class="text-gray-600 text-sm">วันที่เผยแพร่</span>
                <span class="text-gray-800 font-medium text-sm">{{ $item->publish_date->format('d M Y') }}</span>
            </div>
        @endif
        
        {{-- Status --}}
        <div class="flex items-center justify-between py-2">
            <span class="text-gray-600 text-sm">สถานะ</span>
            @php
                $statusClasses = match($item->status ?? 'draft') {
                    'published' => 'bg-green-100 text-green-800',
                    'featured' => 'bg-orange-100 text-orange-800',
                    default => 'bg-gray-100 text-gray-800'
                };
            @endphp
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusClasses }}">
                @if(($item->status ?? 'draft') === 'published')
                    <i class="fas fa-check-circle mr-1"></i>เผยแพร่แล้ว
                @elseif(($item->status ?? 'draft') === 'featured')
                    <i class="fas fa-star mr-1"></i>แนะนำ
                @else
                    {{ ucfirst($item->status ?? 'draft') }}
                @endif
            </span>
        </div>
    </div>
</div>

{{-- Action Tools Card --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-purple-500 to-pink-600 text-white p-4">
        <h3 class="text-lg font-bold flex items-center">
            <i class="fas fa-tools mr-2"></i>
            เครื่องมือ
        </h3>
    </div>
    <div class="p-4">
        <div class="space-y-3">
            {{-- Share Button --}}
            <button onclick="showShareModal()" 
                    class="w-full flex items-center justify-center px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-share-alt mr-2"></i>
                แชร์เรื่องราวนี้
            </button>
            
            {{-- Print Button --}}
            <button onclick="window.print()" 
                    class="w-full flex items-center justify-center px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-print mr-2"></i>
                พิมพ์บทความ
            </button>
            
            {{-- Save Button --}}
            <button onclick="saveToBookmarks()" 
                    class="w-full flex items-center justify-center px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-bookmark mr-2"></i>
                บันทึก
            </button>
        </div>
        
        {{-- Statistics --}}
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="text-sm font-semibold text-gray-800 mb-3">สถิติ</h4>
            <div class="space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-600">จำนวนการเข้าชม</span>
                    <span class="font-bold text-orange-600">{{ rand(150, 2500) }}</span>
                </div>
                
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-600">การแชร์</span>
                    <span class="font-bold text-blue-600">{{ rand(5, 50) }}</span>
                </div>
                
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-600">ความนิยม</span>
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-yellow-400 text-xs {{ $i <= 4 ? '' : 'opacity-30' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for Actions --}}
@push('scripts')
    <script>
        function saveToBookmarks() {
            // Add to browser bookmarks (if supported)
            if (window.external && window.external.AddFavorite) {
                window.external.AddFavorite(location.href, document.title);
            } else if (window.sidebar && window.sidebar.addPanel) {
                window.sidebar.addPanel(document.title, location.href, '');
            } else {
                alert('กรุณาใช้ Ctrl+D เพื่อบันทึกหน้านี้');
            }
        }
        
        function subscribeNewsletter(event) {
            event.preventDefault();
            const email = event.target.querySelector('input[type="email"]').value;
            
            // Here you would normally send to your backend
            alert('ขอบคุณสำหรับการสมัครรับข่าวสาร!');
            event.target.reset();
        }
    </script>
@endpush