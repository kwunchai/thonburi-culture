{{-- Article Content with Home Page Style --}}
<article class="p-6 md:p-8">
    {{-- Article Header --}}
    <header class="mb-8">
        {{-- Category Badge --}}
        @if($item->category)
            <div class="mb-4">
                <span class="inline-block px-3 py-1 bg-orange-500 text-white rounded-full text-sm font-medium">
                    <i class="fas fa-tag mr-1.5"></i>{{ $item->category->name }}
                </span>
            </div>
        @endif
        
        {{-- Title --}}
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
            {{ $item->title }}
        </h1>
    </header>

    {{-- Main Content --}}
    <section class="prose prose-lg max-w-none">
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-orange-800 mb-4 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                เกี่ยวกับ{{ $item->title }}
            </h2>
            
            {{-- Content with Inline Image --}}
            <div class="text-gray-700 leading-relaxed">
                @if($item->image)
                    {{-- Floating Image (Desktop) / Full Width (Mobile) --}}
                    <div class="md:float-right md:ml-6 mb-4 md:w-2/5 w-full">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden group cursor-pointer"
                             onclick="openImageModal('{{ asset('storage/' . $item->image) }}', '{{ $item->title }}')">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-64 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                
                                {{-- View Full Size Button --}}
                                <div class="absolute top-2 right-2">
                                    <div class="bg-black/50 hover:bg-black/70 text-white p-1.5 rounded-full transition-colors">
                                        <i class="fas fa-expand text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Image Caption --}}
                            <div class="p-3 bg-gray-50">
                                <p class="text-sm font-medium text-gray-800">{{ $item->title }}</p>
                                @if($item->community)
                                    <p class="text-xs text-gray-600 flex items-center mt-1">
                                        <i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>
                                        {{ $item->community->name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Main Text Content --}}
                <p class="mb-4">
                    {{ $item->description }}
                </p>
                
                {{-- Additional descriptive text if needed --}}
                <p class="mb-4">
                    @if($item->community)
                        เป็นมรดกทางวัฒนธรรมที่สำคัญของ{{ $item->community->name }} 
                    @else
                        เป็นมรดกทางวัฒนธรรมที่สำคัญ
                    @endif
                    ที่สะท้อนถึงความเป็นไทยและภูมิปัญญาของบรรพบุรุษที่สืบทอดกันมาจากอดีตจนถึงปัจจุบัน
                </p>
                
                {{-- Clear float --}}
                <div class="clear-both"></div>
            </div>
        </div>
    </div>
    
    {{-- Main Content (Similar to Featured Items Layout) --}}
    @if($item->content)
        <div class="prose prose-lg max-w-none mb-10">
            <div class="bg-white border-l-4 border-orange-500 pl-6 py-4 mb-8">
                {!! nl2br(e($item->content)) !!}
            </div>
        </div>
    @endif
    
    {{-- Location Information (if available) --}}
    @if($item->latitude && $item->longitude)
        <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-map-marker-alt text-orange-500 mr-3"></i>
                ที่ตั้ง
            </h3>
            
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div>
                        @if($item->community)
                            <div class="mb-4">
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->community->name }}</h4>
                                <p class="text-gray-600">{{ $item->community->description ?? 'ชุมชนแห่งความภาคภูมิใจในมรดกทางวัฒนธรรม' }}</p>
                            </div>
                        @endif
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-globe mr-2 text-orange-500"></i>
                                <span>พิกัด: {{ number_format($item->latitude, 6) }}, {{ number_format($item->longitude, 6) }}</span>
                            </div>
                            @if($item->place)
                                <div class="flex items-center">
                                    <i class="fas fa-map-pin mr-2 text-orange-500"></i>
                                    <span>{{ $item->place->name }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})" 
                                class="mt-4 inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors">
                            <i class="fas fa-directions mr-2"></i>
                            ดูเส้นทาง
                        </button>
                    </div>
                    
                    <div class="h-64 bg-gray-200 rounded-lg" id="mapContainer">
                        <div id="map" class="w-full h-full rounded-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    {{-- Action Buttons --}}
    <footer class="border-t border-gray-200 pt-6 mt-8">
        <div class="flex flex-wrap gap-3 justify-center">
            <button onclick="showShareModal()" 
                    class="inline-flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-all transform hover:scale-105 shadow-md">
                <i class="fas fa-share-alt mr-2"></i>
                แชร์เรื่องราวนี้
            </button>
            
            <button onclick="window.print()" 
                    class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all border">
                <i class="fas fa-print mr-2"></i>
                พิมพ์ความ
            </button>
            
            <button onclick="saveToBookmarks()" 
                    class="inline-flex items-center px-5 py-2.5 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-all border">
                <i class="fas fa-bookmark mr-2"></i>
                บันทึก
            </button>
        </div>
    </footer>
</article>

{{-- Map JavaScript (if location is available) --}}
@if($item->latitude && $item->longitude)
    @push('scripts')
        <script>
            function openMap(lat, lng) {
                // Open Google Maps with directions
                const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
                window.open(url, '_blank');
            }
            
            // Initialize map when page loads
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof google !== 'undefined' && google.maps) {
                    const map = new google.maps.Map(document.getElementById('map'), {
                        center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                        zoom: 15,
                        styles: [
                            {
                                featureType: 'poi',
                                elementType: 'labels',
                                stylers: [{ visibility: 'off' }]
                            }
                        ]
                    });
                    
                    new google.maps.Marker({
                        position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },
                        map: map,
                        title: '{{ $item->title }}',
                        icon: {
                            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                    <circle cx="16" cy="16" r="12" fill="#f97316" stroke="white" stroke-width="2"/>
                                    <circle cx="16" cy="16" r="6" fill="white"/>
                                </svg>
                            `)
                        }
                    });
                }
            });
        </script>
    @endpush
@endif

{{-- Social Sharing Scripts --}}
@push('scripts')
    <script>
        function shareToFacebook() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        }
        
        function shareToTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $item->title }} - มรดกทางวัฒนธรรมไทย');
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }
        
        function shareToLine() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $item->title }}');
            window.open(`https://social-plugins.line.me/lineit/share?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }
        
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('คัดลอกลิงก์แล้ว!');
            });
        }
        
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
        
        // Image Modal Functions
        function openImageModal(imageSrc, title) {
            // Create modal if it doesn't exist
            let modal = document.getElementById('imageModal');
            if (!modal) {
                modal = document.createElement('div');
                modal.id = 'imageModal';
                modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4';
                modal.innerHTML = `
                    <div class="relative max-w-6xl max-h-full">
                        <img id="modalImage" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                        <div class="absolute top-0 left-0 right-0 p-6 bg-gradient-to-b from-black/70 to-transparent">
                            <div class="flex justify-between items-center">
                                <h3 id="modalTitle" class="text-white font-bold text-xl"></h3>
                                <button onclick="closeImageModal()" class="text-white hover:text-gray-300 text-3xl leading-none">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/70 to-transparent">
                            <p class="text-white/90 text-center">คลิกด้านนอกเพื่อปิด หรือกด ESC</p>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                // Close on click outside
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeImageModal();
                    }
                });
                
                // Close on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeImageModal();
                    }
                });
            }
            
            // Set image and title
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalTitle').textContent = title;
            
            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }
    </script>
@endpush