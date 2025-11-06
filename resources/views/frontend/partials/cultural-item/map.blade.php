{{-- Google Maps Section --}}
@if($item->latitude && $item->longitude)
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900">
            <i class="fas fa-map-marked-alt text-red-500 mr-2"></i>ตำแหน่งที่ตั้ง
        </h3>
        <div id="map" class="h-64 rounded-lg bg-gray-100 mb-4"></div>
        <div class="text-center">
            <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
               target="_blank" 
               class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-external-link-alt mr-2"></i>เปิดใน Google Maps
            </a>
        </div>
    </div>
@endif