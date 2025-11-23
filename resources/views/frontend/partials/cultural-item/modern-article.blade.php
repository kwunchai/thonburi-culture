{{-- Cultural Item Article - Thai Style --}}{{-- Cultural Item Article - Thai Style --}}{{-- Cultural Item Article - Thai Style --}}{{-- Premium Article Design --}}{{-- Clean & Beautiful Article Design --}}{{-- Clean & Beautiful Article Design --}}

<article class="bg-gray-50">

    <article class="bg-gray-50">

    {{-- Header Section --}}

    <div class="bg-white shadow-lg">    <article class="bg-gray-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="grid md:grid-cols-2 gap-8 items-center">    {{-- Header Section --}}

                

                {{-- Left: Content --}}    <div class="bg-white shadow-lg">    <article class="relative min-h-screen bg-white">

                <div class="space-y-6">

                    {{-- Category Badge --}}        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                    @if($item->category)

                        <div class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-600 rounded-lg text-sm font-semibold">            <div class="grid md:grid-cols-2 gap-8 items-center">    {{-- Header Section --}}

                            <i class="fas {{ $item->category->icon ?? 'fa-folder' }} mr-2"></i>

                            {{ $item->category->name }}                

                        </div>

                    @endif                {{-- Left: Content --}}    <div class="bg-white shadow-lg">    <article class="bg-white"><article class="bg-white">

                    

                    {{-- Title --}}                <div class="space-y-6">

                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">

                        {{ $item->title }}                    {{-- Category Badge --}}        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                    </h1>

                                        @if($item->category)

                    {{-- Meta Information --}}

                    <div class="flex flex-wrap items-center gap-6 text-gray-600">                        <div class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-600 rounded-lg text-sm font-semibold">            <div class="grid md:grid-cols-2 gap-8 items-center">    {{-- Hero Section with Gradient Background --}}

                        @if($item->community)

                            <span class="flex items-center">                            <i class="fas {{ $item->category->icon ?? 'fa-folder' }} mr-2"></i>

                                <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>

                                {{ $item->community->name }}                            {{ $item->category->name }}                

                            </span>

                        @endif                        </div>

                        <span class="flex items-center">

                            <i class="fas fa-calendar mr-2 text-orange-500"></i>                    @endif                {{-- Left: Content --}}    <section class="relative bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 text-white overflow-hidden">    {{-- Clean Header Section --}}    {{-- Clean Header Section --}}

                            {{ $item->created_at->format('d M Y') }}

                        </span>                    

                        <span class="flex items-center">

                            <i class="fas fa-clock mr-2 text-orange-500"></i>                    {{-- Title --}}                <div class="space-y-6">

                            {{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาทีในการอ่าน

                        </span>                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">

                    </div>

                </div>                        {{ $item->title }}                    {{-- Category Badge --}}        {{-- Background Pattern --}}

                

                {{-- Right: Image --}}                    </h1>

                @if($item->image)

                    <div class="order-first md:order-last">                                        @if($item->category)

                        <div class="relative group">

                            <img src="{{ Storage::url($item->image) }}"                     {{-- Meta Information --}}

                                 alt="{{ $item->title }}" 

                                 class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg group-hover:shadow-xl transition-shadow duration-300 cursor-pointer"                    <div class="flex flex-wrap items-center gap-6 text-gray-600">                        <div class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-600 rounded-lg text-sm font-semibold">        <div class="absolute inset-0 opacity-10">    <div class="px-6 md:px-8 lg:px-12 pt-8 pb-6">    <div class="px-6 md:px-8 lg:px-12 pt-8 pb-6">

                                 onclick="openImageModal('{{ Storage::url($item->image) }}', '{{ $item->title }}')">

                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300 rounded-lg flex items-center justify-center">                        @if($item->community)

                                <div class="transform scale-0 group-hover:scale-100 transition-transform duration-300">

                                    <div class="bg-white bg-opacity-90 p-3 rounded-full">                            <span class="flex items-center">                            <i class="fas {{ $item->category->icon ?? 'fa-folder' }} mr-2"></i>

                                        <i class="fas fa-expand text-gray-700"></i>

                                    </div>                                <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>

                                </div>

                            </div>                                {{ $item->community->name }}                            {{ $item->category->name }}            <svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">

                        </div>

                    </div>                            </span>

                @endif

            </div>                        @endif                        </div>

        </div>

    </div>                        <span class="flex items-center">



    {{-- Main Content --}}                            <i class="fas fa-calendar mr-2 text-orange-500"></i>                    @endif                <defs>        <div class="max-w-4xl mx-auto">        <div class="max-w-4xl mx-auto">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="grid lg:grid-cols-3 gap-8">                            {{ $item->created_at->format('d M Y') }}

            

            {{-- Main Article Content --}}                        </span>                    

            <div class="lg:col-span-2">

                <div class="bg-white rounded-lg shadow-lg overflow-hidden">                        <span class="flex items-center">

                    

                    {{-- Article Body --}}                            <i class="fas fa-clock mr-2 text-orange-500"></i>                    {{-- Title --}}                    <pattern id="pattern" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse">

                    <div class="p-6 md:p-8">

                        {{-- Description --}}                            {{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาทีในการอ่าน

                        <div class="prose prose-lg max-w-none">

                            <div class="text-gray-700 leading-relaxed text-lg mb-8">                        </span>                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">

                                {{ $item->description }}

                            </div>                    </div>

                            

                            @if($item->content)                </div>                        {{ $item->title }}                        <circle cx="15" cy="15" r="2" fill="white"/>            {{-- Category Badge --}}            {{-- Category Badge --}}

                                <div class="border-l-4 border-orange-500 pl-6 bg-orange-50 p-6 rounded-r-lg">

                                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">                

                                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>

                                        ข้อมูลเพิ่มเติม                {{-- Right: Image --}}                    </h1>

                                    </h3>

                                    <div class="text-gray-700 leading-relaxed">                @if($item->image)

                                        {!! nl2br(e($item->content)) !!}

                                    </div>                    <div class="order-first md:order-last">                                        </pattern>

                                </div>

                            @endif                        <div class="relative group">

                        </div>

                    </div>                            <img src="{{ Storage::url($item->image) }}"                     {{-- Meta Information --}}

                    

                    {{-- Location Map Section --}}                                 alt="{{ $item->title }}" 

                    @if($item->latitude && $item->longitude)

                        <div class="border-t border-gray-200 p-6 md:p-8">                                 class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg group-hover:shadow-xl transition-shadow duration-300 cursor-pointer"                    <div class="flex flex-wrap items-center gap-6 text-gray-600">                </defs>            @if($item->category)            @if($item->category)

                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">

                                <i class="fas fa-map-marker-alt text-orange-500 mr-3"></i>                                 onclick="openImageModal('{{ Storage::url($item->image) }}', '{{ $item->title }}')">

                                ที่ตั้งและการเดินทาง

                            </h3>                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300 rounded-lg flex items-center justify-center">                        @if($item->community)

                            

                            <div class="grid md:grid-cols-2 gap-6">                                <div class="transform scale-0 group-hover:scale-100 transition-transform duration-300">

                                {{-- Coordinates Info --}}

                                <div class="space-y-4">                                    <div class="bg-white bg-opacity-90 p-3 rounded-full">                            <span class="flex items-center">                <rect width="100%" height="100%" fill="url(#pattern)"/>

                                    <div class="bg-gray-50 p-4 rounded-lg">

                                        <h4 class="font-semibold text-gray-900 mb-3">พิกัดที่ตั้ง</h4>                                        <i class="fas fa-expand text-gray-700"></i>

                                        <div class="space-y-2 text-sm text-gray-600">

                                            <div><strong>ละติจูด:</strong> {{ $item->latitude }}</div>                                    </div>                                <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>

                                            <div><strong>ลองจิจูด:</strong> {{ $item->longitude }}</div>

                                        </div>                                </div>

                                    </div>

                                                                </div>                                {{ $item->community->name }}            </svg>                <div class="mb-4">                <div class="mb-4">

                                    <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})" 

                                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center">                        </div>

                                        <i class="fas fa-route mr-2"></i>

                                        เส้นทางการเดินทาง                    </div>                            </span>

                                    </button>

                                </div>                @endif

                                

                                {{-- Map Container --}}            </div>                        @endif        </div>

                                <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center" id="map">

                                    <div class="text-center text-gray-500">        </div>

                                        <i class="fas fa-map text-3xl mb-2"></i>

                                        <p>แผนที่</p>    </div>                        <span class="flex items-center">

                                    </div>

                                </div>

                            </div>

                        </div>    {{-- Main Content --}}                            <i class="fas fa-calendar mr-2 text-orange-500"></i>                            <span class="inline-flex items-center px-3 py-1 bg-orange-500 text-white rounded-md text-sm font-medium">                    <span class="inline-flex items-center px-3 py-1 bg-orange-500 text-white rounded-md text-sm font-medium">

                    @endif

                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                    {{-- Share Section --}}

                    <div class="border-t border-gray-200 bg-gray-50 p-6 md:p-8">        <div class="grid lg:grid-cols-3 gap-8">                            {{ $item->created_at->format('d M Y') }}

                        <h3 class="text-xl font-bold text-gray-900 mb-4">แบ่งปันบทความนี้</h3>

                        <div class="flex flex-wrap gap-3">            

                            <button onclick="shareArticle()" 

                                    class="flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300">            {{-- Main Article Content --}}                        </span>        {{-- Content Container --}}

                                <i class="fas fa-share mr-2"></i>

                                แชร์            <div class="lg:col-span-2">

                            </button>

                                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">                        <span class="flex items-center">

                            <button onclick="window.print()" 

                                    class="flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300">                    

                                <i class="fas fa-print mr-2"></i>

                                พิมพ์                    {{-- Article Body --}}                            <i class="fas fa-clock mr-2 text-orange-500"></i>        <div class="relative px-6 md:px-8 lg:px-12 py-16 md:py-24">                        {{ $item->category->name }}                        {{ $item->category->name }}

                            </button>

                                                <div class="p-6 md:p-8">

                            <button onclick="saveBookmark()" 

                                    class="flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-300">                        {{-- Description --}}                            {{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาทีในการอ่าน

                                <i class="fas fa-bookmark mr-2"></i>

                                บันทึก                        <div class="prose prose-lg max-w-none">

                            </button>

                        </div>                            <div class="text-gray-700 leading-relaxed text-lg mb-8">                        </span>            <div class="max-w-6xl mx-auto">

                    </div>

                </div>                                {{ $item->description }}

            </div>

                                        </div>                    </div>

            {{-- Sidebar --}}

            <div class="space-y-6">                            

                {{-- Related Info Card --}}

                <div class="bg-white rounded-lg shadow-lg p-6">                            @if($item->content)                </div>                <div class="grid lg:grid-cols-2 gap-12 items-center">                    </span>                    </span>

                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">

                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>                                <div class="border-l-4 border-orange-500 pl-6 bg-orange-50 p-6 rounded-r-lg">

                        ข้อมูลเพิ่มเติม

                    </h3>                                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">                

                    

                    <div class="space-y-4">                                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>

                        {{-- Creator Info --}}

                        @if($item->creator)                                        ข้อมูลเพิ่มเติม                {{-- Right: Image --}}                    

                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">

                                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-3">                                    </h3>

                                    <i class="fas fa-user text-white"></i>

                                </div>                                    <div class="text-gray-700 leading-relaxed">                @if($item->image)

                                <div>

                                    <p class="text-sm text-gray-600">ผู้สร้างข้อมูล</p>                                        {!! nl2br(e($item->content)) !!}

                                    <p class="font-semibold text-gray-900">{{ $item->creator->name }}</p>

                                </div>                                    </div>                    <div class="order-first md:order-last">                    {{-- Left Content --}}                </div>                </div>

                            </div>

                        @endif                                </div>

                        

                        {{-- Community Info --}}                            @endif                        <div class="relative group">

                        @if($item->community)

                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">                        </div>

                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">

                                    <i class="fas fa-users text-white"></i>                    </div>                            <img src="{{ Storage::url($item->image) }}"                     <div class="space-y-8">

                                </div>

                                <div>                    

                                    <p class="text-sm text-gray-600">ชุมชน</p>

                                    <p class="font-semibold text-gray-900">{{ $item->community->name }}</p>                    {{-- Location Map Section (if has coordinates) --}}                                 alt="{{ $item->title }}" 

                                </div>

                            </div>                    @if($item->latitude && $item->longitude)

                        @endif

                                                <div class="border-t border-gray-200 p-6 md:p-8">                                 class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg group-hover:shadow-xl transition-shadow duration-300 cursor-pointer"                        {{-- Category Badge --}}            @endif            @endif

                        {{-- Place Info --}}

                        @if($item->place && $item->place->name)                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">

                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">

                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">                                <i class="fas fa-map-marker-alt text-orange-500 mr-3"></i>                                 onclick="openImageModal('{{ Storage::url($item->image) }}', '{{ $item->title }}')">

                                    <i class="fas fa-map-marker-alt text-white"></i>

                                </div>                                ที่ตั้งและการเดินทาง

                                <div>

                                    <p class="text-sm text-gray-600">สถานที่</p>                            </h3>                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300 rounded-lg flex items-center justify-center">                        @if($item->category)

                                    <p class="font-semibold text-gray-900">{{ $item->place->name }}</p>

                                </div>                            

                            </div>

                        @endif                            <div class="grid md:grid-cols-2 gap-6">                                <div class="transform scale-0 group-hover:scale-100 transition-transform duration-300">

                    </div>

                </div>                                {{-- Coordinates Info --}}

                

                {{-- Quick Actions --}}                                <div class="space-y-4">                                    <div class="bg-white bg-opacity-90 p-3 rounded-full">                            <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full text-sm font-medium">                        

                <div class="bg-white rounded-lg shadow-lg p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-4">การดำเนินการ</h3>                                    <div class="bg-gray-50 p-4 rounded-lg">

                    

                    <div class="space-y-3">                                        <h4 class="font-semibold text-gray-900 mb-3">พิกัดที่ตั้ง</h4>                                        <i class="fas fa-expand text-gray-700"></i>

                        <a href="{{ route('cultural.explore') }}" 

                           class="block w-full text-center px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300">                                        <div class="space-y-2 text-sm text-gray-600">

                            <i class="fas fa-search mr-2"></i>

                            สำรวจวัฒนธรรมอื่น                                            <div><strong>ละติจูด:</strong> {{ $item->latitude }}</div>                                    </div>                                <i class="fas fa-tag mr-2"></i>

                        </a>

                                                                    <div><strong>ลองจิจูด:</strong> {{ $item->longitude }}</div>

                        <a href="{{ route('home') }}" 

                           class="block w-full text-center px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300">                                        </div>                                </div>

                            <i class="fas fa-home mr-2"></i>

                            กลับหน้าแรก                                    </div>

                        </a>

                    </div>                                                                </div>                                {{ $item->category->name }}            {{-- Title --}}            {{-- Title --}}

                </div>

            </div>                                    <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})" 

        </div>

    </div>                                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center">                        </div>

</article>

                                        <i class="fas fa-route mr-2"></i>

@push('scripts')

<script>                                        เส้นทางการเดินทาง                    </div>                            </div>

// Image Modal Function

function openImageModal(imageSrc, title) {                                    </button>

    let modal = document.getElementById('imageModal');

    if (!modal) {                                </div>                @endif

        modal = document.createElement('div');

        modal.id = 'imageModal';                                

        modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4';

        modal.innerHTML = `                                {{-- Map Container --}}            </div>                        @endif            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">

            <div class="relative max-w-6xl max-h-full">

                <img id="modalImage" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">                                <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center" id="map">

                <button onclick="closeImageModal()" 

                        class="absolute top-4 right-4 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-all">                                    <div class="text-center text-gray-500">        </div>

                    <i class="fas fa-times text-xl"></i>

                </button>                                        <i class="fas fa-map text-3xl mb-2"></i>

                <div class="absolute bottom-4 left-4 right-4 text-center">

                    <h3 id="modalTitle" class="text-white text-xl font-bold mb-2"></h3>                                        <p>แผนที่</p>    </div>                        

                    <p class="text-gray-300 text-sm">กดพื้นที่ว่างหรือ ESC เพื่อปิด</p>

                </div>                                    </div>

            </div>

        `;                                </div>

        document.body.appendChild(modal);

                                    </div>

        modal.addEventListener('click', function(e) {

            if (e.target === modal) closeImageModal();                        </div>    {{-- Main Content --}}                        {{-- Title --}}                {{ $item->title }}                {{ $item->title }}

        });

                            @endif

        document.addEventListener('keydown', function(e) {

            if (e.key === 'Escape') closeImageModal();                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        });

    }                    {{-- Share Section --}}

    

    document.getElementById('modalImage').src = imageSrc;                    <div class="border-t border-gray-200 bg-gray-50 p-6 md:p-8">        <div class="grid lg:grid-cols-3 gap-8">                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">

    document.getElementById('modalTitle').textContent = title;

    modal.classList.remove('hidden');                        <h3 class="text-xl font-bold text-gray-900 mb-4">แบ่งปันบทความนี้</h3>

    document.body.style.overflow = 'hidden';

}                        <div class="flex flex-wrap gap-3">            



function closeImageModal() {                            <button onclick="shareArticle()" 

    const modal = document.getElementById('imageModal');

    if (modal) {                                    class="flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300">            {{-- Main Article Content --}}                            {{ $item->title }}            </h1>            </h1>

        modal.classList.add('hidden');

        document.body.style.overflow = '';                                <i class="fas fa-share mr-2"></i>

    }

}                                แชร์            <div class="lg:col-span-2">



// Share Functions                            </button>

function shareArticle() {

    if (navigator.share) {                                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">                        </h1>

        navigator.share({

            title: document.title,                            <button onclick="window.print()" 

            text: 'มาดูข้อมูลวัฒนธรรมไทยกัน',

            url: window.location.href                                    class="flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300">                    

        }).catch(err => console.log('Error sharing:', err));

    } else {                                <i class="fas fa-print mr-2"></i>

        navigator.clipboard.writeText(window.location.href).then(function() {

            showNotification('คัดลอกลิงก์เรียบร้อยแล้ว!');                                พิมพ์                    {{-- Article Body --}}                                                

        });

    }                            </button>

}

                                                <div class="p-6 md:p-8">

function saveBookmark() {

    if (window.external && window.external.AddFavorite) {                            <button onclick="saveBookmark()" 

        window.external.AddFavorite(location.href, document.title);

    } else if (window.sidebar && window.sidebar.addPanel) {                                    class="flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-300">                        {{-- Description --}}                        {{-- Description Preview --}}

        window.sidebar.addPanel(document.title, location.href, '');

    } else {                                <i class="fas fa-bookmark mr-2"></i>

        showNotification('กรุณาใช้ Ctrl+D เพื่อบันทึกหน้านี้');

    }                                บันทึก                        <div class="prose prose-lg max-w-none">

}

                            </button>

function showNotification(message) {

    const notification = document.createElement('div');                        </div>                            <div class="text-gray-700 leading-relaxed text-lg mb-8">                        <p class="text-xl text-white/90 leading-relaxed">            {{-- Meta Info --}}            {{-- Meta Info --}}

    notification.className = 'fixed top-4 right-4 z-50 px-6 py-3 bg-orange-500 text-white rounded-lg font-medium transform translate-x-full transition-transform duration-300';

    notification.textContent = message;                    </div>

    document.body.appendChild(notification);

                    </div>                                {{ $item->description }}

    setTimeout(() => notification.classList.remove('translate-x-full'), 100);

    setTimeout(() => {            </div>

        notification.classList.add('translate-x-full');

        setTimeout(() => document.body.removeChild(notification), 300);                                        </div>                            {{ Str::limit($item->description, 150) }}

    }, 3000);

}            {{-- Sidebar --}}



@if($item->latitude && $item->longitude)            <div class="space-y-6">                            

// Map Functions

function openMap(lat, lng) {                {{-- Related Info Card --}}

    const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;

    window.open(url, '_blank');                <div class="bg-white rounded-lg shadow-lg p-6">                            @if($item->content)                        </p>            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 border-b border-gray-200 pb-6">            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 border-b border-gray-200 pb-6">

}

                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">

document.addEventListener('DOMContentLoaded', function() {

    if (typeof google !== 'undefined' && google.maps) {                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>                                <div class="border-l-4 border-orange-500 pl-6 bg-orange-50 p-6 rounded-r-lg">

        const mapElement = document.getElementById('map');

        if (mapElement) {                        ข้อมูลเพิ่มเติม

            mapElement.innerHTML = '';

            const map = new google.maps.Map(mapElement, {                    </h3>                                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">                        

                center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },

                zoom: 15                    

            });

            new google.maps.Marker({                    <div class="space-y-4">                                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>

                position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },

                map: map,                        {{-- Creator Info --}}

                title: '{{ $item->title }}'

            });                        @if($item->creator)                                        ข้อมูลเพิ่มเติม                        {{-- Meta Info --}}                @if($item->community)                @if($item->community)

        }

    }                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">

});

@endif                                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-3">                                    </h3>

</script>

@endpush                                    <i class="fas fa-user text-white"></i>

                                </div>                                    <div class="text-gray-700 leading-relaxed">                        <div class="flex flex-wrap gap-6 text-white/80">

                                <div>

                                    <p class="text-sm text-gray-600">ผู้สร้างข้อมูล</p>                                        {!! nl2br(e($item->content)) !!}

                                    <p class="font-semibold text-gray-900">{{ $item->creator->name }}</p>

                                </div>                                    </div>                            @if($item->community)                    <div class="flex items-center">                    <div class="flex items-center">

                            </div>

                        @endif                                </div>

                        

                        {{-- Community Info --}}                            @endif                                <div class="flex items-center">

                        @if($item->community)

                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">                        </div>

                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">

                                    <i class="fas fa-users text-white"></i>                    </div>                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-3">                        <i class="fas fa-map-marker-alt text-orange-500 mr-1.5"></i>                        <i class="fas fa-map-marker-alt text-orange-500 mr-1.5"></i>

                                </div>

                                <div>                    

                                    <p class="text-sm text-gray-600">ชุมชน</p>

                                    <p class="font-semibold text-gray-900">{{ $item->community->name }}</p>                    {{-- Location Map Section (if has coordinates) --}}                                        <i class="fas fa-map-marker-alt text-sm"></i>

                                </div>

                            </div>                    @if($item->latitude && $item->longitude)

                        @endif

                                                <div class="border-t border-gray-200 p-6 md:p-8">                                    </div>                        <span>{{ $item->community->name }}</span>                        <span>{{ $item->community->name }}</span>

                        {{-- Place Info --}}

                        @if($item->place && $item->place->name)                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">

                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">

                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">                                <i class="fas fa-map-marker-alt text-orange-500 mr-3"></i>                                    <div>

                                    <i class="fas fa-map-marker-alt text-white"></i>

                                </div>                                ที่ตั้งและการเดินทาง

                                <div>

                                    <p class="text-sm text-gray-600">สถานที่</p>                            </h3>                                        <p class="text-sm opacity-75">ชุมชน</p>                    </div>                    </div>

                                    <p class="font-semibold text-gray-900">{{ $item->place->name }}</p>

                                </div>                            

                            </div>

                        @endif                            <div class="grid md:grid-cols-2 gap-6">                                        <p class="font-medium">{{ $item->community->name }}</p>

                    </div>

                </div>                                {{-- Coordinates Info --}}

                

                {{-- Quick Actions --}}                                <div class="space-y-4">                                    </div>                @endif                @endif

                <div class="bg-white rounded-lg shadow-lg p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-4">การดำเนินการ</h3>                                    <div class="bg-gray-50 p-4 rounded-lg">

                    

                    <div class="space-y-3">                                        <h4 class="font-semibold text-gray-900 mb-3">พิกัดที่ตั้ง</h4>                                </div>

                        <a href="{{ route('cultural.explore') }}" 

                           class="block w-full text-center px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300">                                        <div class="space-y-2 text-sm text-gray-600">

                            <i class="fas fa-search mr-2"></i>

                            สำรวจวัฒนธรรมอื่น                                            <div><strong>ละติจูด:</strong> {{ $item->latitude }}</div>                            @endif                <div class="flex items-center">                <div class="flex items-center">

                        </a>

                                                                    <div><strong>ลองจิจูด:</strong> {{ $item->longitude }}</div>

                        <a href="{{ route('home') }}" 

                           class="block w-full text-center px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300">                                        </div>                            

                            <i class="fas fa-home mr-2"></i>

                            กลับหน้าแรก                                    </div>

                        </a>

                    </div>                                                                <div class="flex items-center">                    <i class="fas fa-clock text-gray-400 mr-1.5"></i>                    <i class="fas fa-clock text-gray-400 mr-1.5"></i>

                </div>

            </div>                                    <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})" 

        </div>

    </div>                                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center">                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-3">

</article>

                                        <i class="fas fa-route mr-2"></i>

{{-- JavaScript Functions --}}

@push('scripts')                                        เส้นทางการเดินทาง                                    <i class="fas fa-clock text-sm"></i>                    <span>{{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาทีในการอ่าน</span>                    <span>{{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาทีในการอ่าน</span>

    <script>

        // Image Modal Function                                    </button>

        function openImageModal(imageSrc, title) {

            let modal = document.getElementById('imageModal');                                </div>                                </div>

            if (!modal) {

                modal = document.createElement('div');                                

                modal.id = 'imageModal';

                modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4';                                {{-- Map Container --}}                                <div>                </div>                </div>

                modal.innerHTML = `

                    <div class="relative max-w-6xl max-h-full">                                <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center" id="map">

                        <img id="modalImage" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">

                        <button onclick="closeImageModal()"                                     <div class="text-center text-gray-500">                                    <p class="text-sm opacity-75">เวลาอ่าน</p>

                                class="absolute top-4 right-4 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-all">

                            <i class="fas fa-times text-xl"></i>                                        <i class="fas fa-map text-3xl mb-2"></i>

                        </button>

                        <div class="absolute bottom-4 left-4 right-4 text-center">                                        <p>แผนที่</p>                                    <p class="font-medium">{{ max(1, ceil(str_word_count(strip_tags($item->description . ' ' . ($item->content ?? ''))) / 200)) }} นาที</p>            </div>            </div>

                            <h3 id="modalTitle" class="text-white text-xl font-bold mb-2"></h3>

                            <p class="text-gray-300 text-sm">กดพื้นที่ว่างหรือ ESC เพื่อปิด</p>                                    </div>

                        </div>

                    </div>                                </div>                                </div>

                `;

                document.body.appendChild(modal);                            </div>

                

                // Close on click outside                        </div>                            </div>        </div>        </div>

                modal.addEventListener('click', function(e) {

                    if (e.target === modal) {                    @endif

                        closeImageModal();

                    }                                            </div>

                });

                                    {{-- Share Section --}}

                // Close on ESC key

                document.addEventListener('keydown', function(e) {                    <div class="border-t border-gray-200 bg-gray-50 p-6 md:p-8">                            </div>    </div>

                    if (e.key === 'Escape') {

                        closeImageModal();                        <h3 class="text-xl font-bold text-gray-900 mb-4">แบ่งปันบทความนี้</h3>

                    }

                });                        <div class="flex flex-wrap gap-3">                        {{-- CTA Button --}}

            }

                                        <button onclick="shareArticle()" 

            document.getElementById('modalImage').src = imageSrc;

            document.getElementById('modalTitle').textContent = title;                                    class="flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300">                        <div class="pt-4">

            modal.classList.remove('hidden');

            document.body.style.overflow = 'hidden';                                <i class="fas fa-share mr-2"></i>

        }

                                แชร์                            <a href="#content" class="inline-flex items-center px-8 py-4 bg-white text-orange-600 font-semibold rounded-full hover:bg-orange-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">

        function closeImageModal() {

            const modal = document.getElementById('imageModal');                            </button>

            if (modal) {

                modal.classList.add('hidden');                                                            <span>เริ่มอ่าน</span>    {{-- Featured Image --}}    {{-- Featured Image --}}

                document.body.style.overflow = '';

            }                            <button onclick="window.print()" 

        }

                                    class="flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300">                                <i class="fas fa-arrow-down ml-3"></i>

        // Share Functions

        function shareArticle() {                                <i class="fas fa-print mr-2"></i>

            if (navigator.share) {

                navigator.share({                                พิมพ์                            </a>    @if($item->image)    @if($item->image)

                    title: document.title,

                    text: 'มาดูข้อมูลวัฒนธรรมไทยกัน',                            </button>

                    url: window.location.href

                }).catch(err => console.log('Error sharing:', err));                                                    </div>

            } else {

                // Fallback - copy to clipboard                            <button onclick="saveBookmark()" 

                navigator.clipboard.writeText(window.location.href).then(function() {

                    showNotification('คัดลอกลิงก์เรียบร้อยแล้ว!');                                    class="flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-300">                    </div>        <div class="px-6 md:px-8 lg:px-12 pb-8">        <div class="px-6 md:px-8 lg:px-12 pb-8">

                });

            }                                <i class="fas fa-bookmark mr-2"></i>

        }

                                บันทึก                    

        function saveBookmark() {

            if (window.external && window.external.AddFavorite) {                            </button>

                window.external.AddFavorite(location.href, document.title);

            } else if (window.sidebar && window.sidebar.addPanel) {                        </div>                    {{-- Right Image --}}            <div class="max-w-4xl mx-auto">            <div class="max-w-4xl mx-auto">

                window.sidebar.addPanel(document.title, location.href, '');

            } else {                    </div>

                showNotification('กรุณาใช้ Ctrl+D เพื่อบันทึกหน้านี้');

            }                </div>                    @if($item->image)

        }

            </div>

        // Simple notification system

        function showNotification(message) {                                    <div class="relative">                <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $item->image) }}', '{{ $item->title }}')">                <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $item->image) }}', '{{ $item->title }}')">

            const notification = document.createElement('div');

            notification.className = 'fixed top-4 right-4 z-50 px-6 py-3 bg-orange-500 text-white rounded-lg font-medium transform translate-x-full transition-transform duration-300';            {{-- Sidebar --}}

            notification.textContent = message;

            document.body.appendChild(notification);            <div class="space-y-6">                            <div class="relative group">

            

            setTimeout(() => {                {{-- Related Info Card --}}

                notification.classList.remove('translate-x-full');

            }, 100);                <div class="bg-white rounded-lg shadow-lg p-6">                                {{-- Main Image --}}                    <img src="{{ asset('storage/' . $item->image) }}"                     <img src="{{ asset('storage/' . $item->image) }}" 

            

            setTimeout(() => {                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">

                notification.classList.add('translate-x-full');

                setTimeout(() => {                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>                                <div class="relative overflow-hidden rounded-3xl shadow-2xl transform rotate-3 group-hover:rotate-0 transition-transform duration-500">

                    document.body.removeChild(notification);

                }, 300);                        ข้อมูลเพิ่มเติม

            }, 3000);

        }                    </h3>                                    <img src="{{ asset('storage/' . $item->image) }}"                          alt="{{ $item->title }}"                          alt="{{ $item->title }}" 



        @if($item->latitude && $item->longitude)                    

            // Map Functions

            function openMap(lat, lng) {                    <div class="space-y-4">                                         alt="{{ $item->title }}" 

                const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;

                window.open(url, '_blank');                        {{-- Creator Info --}}

            }

                                    @if($item->creator)                                         class="w-full h-96 lg:h-[500px] object-cover group-hover:scale-105 transition-transform duration-700 cursor-pointer"                         class="w-full h-64 md:h-96 lg:h-[400px] object-cover rounded-lg shadow-md">                         class="w-full h-64 md:h-96 lg:h-[400px] object-cover rounded-lg shadow-md">

            // Initialize Google Maps if available

            document.addEventListener('DOMContentLoaded', function() {                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">

                if (typeof google !== 'undefined' && google.maps) {

                    const mapElement = document.getElementById('map');                                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-3">                                         onclick="openImageModal('{{ asset('storage/' . $item->image) }}', '{{ $item->title }}')">

                    if (mapElement) {

                        // Clear placeholder                                    <i class="fas fa-user text-white"></i>

                        mapElement.innerHTML = '';

                                                        </div>                                                                            

                        const map = new google.maps.Map(mapElement, {

                            center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },                                <div>

                            zoom: 15

                        });                                    <p class="text-sm text-gray-600">ผู้สร้างข้อมูล</p>                                    {{-- Click Overlay --}}

                        

                        new google.maps.Marker({                                    <p class="font-semibold text-gray-900">{{ $item->creator->name }}</p>

                            position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },

                            map: map,                                </div>                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer flex items-center justify-center">                    {{-- Hover Overlay --}}                    {{-- Hover Overlay --}}

                            title: '{{ $item->title }}'

                        });                            </div>

                    }

                }                        @endif                                        <div class="bg-white/90 p-4 rounded-full transform scale-75 group-hover:scale-100 transition-transform duration-300">

            });

        @endif                        

    </script>

@endpush                        {{-- Community Info --}}                                            <i class="fas fa-expand text-gray-800 text-lg"></i>                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 rounded-lg flex items-center justify-center">                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 rounded-lg flex items-center justify-center">

                        @if($item->community)

                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">                                        </div>

                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">

                                    <i class="fas fa-users text-white"></i>                                    </div>                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                                </div>

                                <div>                                </div>

                                    <p class="text-sm text-gray-600">ชุมชน</p>

                                    <p class="font-semibold text-gray-900">{{ $item->community->name }}</p>                                                            <div class="bg-white bg-opacity-90 p-3 rounded-full">                            <div class="bg-white bg-opacity-90 p-3 rounded-full">

                                </div>

                            </div>                                {{-- Floating Elements --}}

                        @endif

                                                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full hidden lg:block"></div>                                <i class="fas fa-expand text-gray-700 text-lg"></i>                                <i class="fas fa-expand text-gray-700 text-lg"></i>

                        {{-- Place Info --}}

                        @if($item->place)                                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-yellow-400/20 backdrop-blur-sm rounded-full hidden lg:block"></div>

                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">

                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">                            </div>                            </div>                            </div>

                                    <i class="fas fa-map-marker-alt text-white"></i>

                                </div>                        </div>

                                <div>

                                    <p class="text-sm text-gray-600">สถานที่</p>                    @endif                        </div>                        </div>

                                    <p class="font-semibold text-gray-900">{{ $item->place->name }}</p>

                                </div>                </div>

                            </div>

                        @endif            </div>                    </div>                    </div>

                    </div>

                </div>        </div>

                

                {{-- Quick Actions --}}                        </div>                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-4">การดำเนินการ</h3>        {{-- Wave Separator --}}

                    

                    <div class="space-y-3">        <div class="absolute bottom-0 left-0 right-0">            </div>            </div>

                        <a href="{{ route('cultural.explore') }}" 

                           class="block w-full text-center px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300">            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-16 fill-white">

                            <i class="fas fa-search mr-2"></i>

                            สำรวจวัฒนธรรมอื่น                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>        </div>        </div>

                        </a>

                                    </svg>

                        <a href="{{ route('home') }}" 

                           class="block w-full text-center px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300">        </div>    @endif    @endif

                            <i class="fas fa-home mr-2"></i>

                            กลับหน้าแรก    </section>

                        </a>

                    </div>

                </div>

            </div>    {{-- Main Content Section --}}

        </div>

    </div>    <section id="content" class="relative py-16 md:py-24">    {{-- Main Content --}}    {{-- Main Content --}}

</article>

        <div class="max-w-4xl mx-auto px-6 md:px-8 lg:px-12">

{{-- JavaScript Functions --}}

@push('scripts')                <div class="px-6 md:px-8 lg:px-12 pb-8">    <div class="px-6 md:px-8 lg:px-12 pb-8">

    <script>

        // Image Modal Function            {{-- Content Card --}}

        function openImageModal(imageSrc, title) {

            let modal = document.getElementById('imageModal');            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-16">        <div class="max-w-4xl mx-auto">        <div class="max-w-4xl mx-auto">

            if (!modal) {

                modal = document.createElement('div');                <div class="p-8 md:p-12">

                modal.id = 'imageModal';

                modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4';                                <div class="prose prose-lg prose-gray max-w-none">            <div class="prose prose-lg prose-gray max-w-none">

                modal.innerHTML = `

                    <div class="relative max-w-6xl max-h-full">                    {{-- Section Header --}}

                        <img id="modalImage" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">

                        <button onclick="closeImageModal()"                     <div class="flex items-center mb-8">                {{-- Description Section --}}                {{-- Description Section --}}

                                class="absolute top-4 right-4 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-3 rounded-full transition-all">

                            <i class="fas fa-times text-xl"></i>                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-4">

                        </button>

                        <div class="absolute bottom-4 left-4 right-4 text-center">                            <i class="fas fa-info-circle text-white"></i>                <div class="mb-8">                <div class="mb-8">

                            <h3 id="modalTitle" class="text-white text-xl font-bold mb-2"></h3>

                            <p class="text-gray-300 text-sm">กดพื้นที่ว่างหรือ ESC เพื่อปิด</p>                        </div>

                        </div>

                    </div>                        <div>                    <h2 class="text-xl font-semibold text-gray-900 mb-4">เกี่ยวกับ{{ $item->title }}</h2>                    <h2 class="text-xl font-semibold text-gray-900 mb-4">เกี่ยวกับ{{ $item->title }}</h2>

                `;

                document.body.appendChild(modal);                            <h2 class="text-2xl font-bold text-gray-900">รายละเอียดครบถ้วน</h2>

                

                // Close on click outside                            <p class="text-gray-600">ข้อมูลเกี่ยวกับ{{ $item->title }}</p>                    <div class="text-gray-700 leading-relaxed space-y-4">                    <div class="text-gray-700 leading-relaxed space-y-4">

                modal.addEventListener('click', function(e) {

                    if (e.target === modal) {                        </div>

                        closeImageModal();

                    }                    </div>                        <p class="text-lg">{{ $item->description }}</p>                        <p class="text-lg">{{ $item->description }}</p>

                });

                                    

                // Close on ESC key

                document.addEventListener('keydown', function(e) {                    {{-- Main Description --}}                                                

                    if (e.key === 'Escape') {

                        closeImageModal();                    <div class="prose prose-lg max-w-none">

                    }

                });                        <div class="text-gray-700 leading-relaxed space-y-6">                        @if($item->content)                        @if($item->content)

            }

                                        <p class="text-xl leading-relaxed first-letter:text-6xl first-letter:font-bold first-letter:text-orange-500 first-letter:float-left first-letter:mr-4 first-letter:mt-2 first-letter:leading-none">

            document.getElementById('modalImage').src = imageSrc;

            document.getElementById('modalTitle').textContent = title;                                {{ $item->description }}                            <div class="border-l-4 border-orange-200 pl-6 mt-6">                            <div class="border-l-4 border-orange-200 pl-6 mt-6">

            modal.classList.remove('hidden');

            document.body.style.overflow = 'hidden';                            </p>

        }

                                                            <div class="text-gray-600">                                <div class="text-gray-600">

        function closeImageModal() {

            const modal = document.getElementById('imageModal');                            @if($item->content)

            if (modal) {

                modal.classList.add('hidden');                                <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border-l-4 border-blue-400">                                    {!! nl2br(e($item->content)) !!}                                    {!! nl2br(e($item->content)) !!}

                document.body.style.overflow = '';

            }                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">

        }

                                        <i class="fas fa-book-open text-blue-500 mr-2"></i>                                </div>                                </div>

        // Share Functions

        function shareArticle() {                                        ข้อมูลเพิ่มเติม

            if (navigator.share) {

                navigator.share({                                    </h3>                            </div>                            </div>

                    title: document.title,

                    text: 'มาดูข้อมูลวัฒนธรรมไทยกัน',                                    <div class="text-gray-700">

                    url: window.location.href

                }).catch(err => console.log('Error sharing:', err));                                        {!! nl2br(e($item->content)) !!}                        @endif                        @endif

            } else {

                // Fallback - copy to clipboard                                    </div>

                navigator.clipboard.writeText(window.location.href).then(function() {

                    showNotification('คัดลอกลิงก์เรียบร้อยแล้ว!');                                </div>                    </div>                    </div>

                });

            }                            @endif

        }

                        </div>                </div>                </div>

        function saveBookmark() {

            if (window.external && window.external.AddFavorite) {                    </div>

                window.external.AddFavorite(location.href, document.title);

            } else if (window.sidebar && window.sidebar.addPanel) {                </div>            </div>            </div>

                window.sidebar.addPanel(document.title, location.href, '');

            } else {            </div>

                showNotification('กรุณาใช้ Ctrl+D เพื่อบันทึกหน้านี้');

            }                    </div>        </div>

        }

            {{-- Location Section --}}

        // Simple notification system

        function showNotification(message) {            @if($item->latitude && $item->longitude)    </div>    </div>

            const notification = document.createElement('div');

            notification.className = 'fixed top-4 right-4 z-50 px-6 py-3 bg-orange-500 text-white rounded-lg font-medium transform translate-x-full transition-transform duration-300';                <div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 rounded-3xl shadow-xl border border-green-100 overflow-hidden mb-16">

            notification.textContent = message;

            document.body.appendChild(notification);                    <div class="p-8 md:p-12">

            

            setTimeout(() => {                        

                notification.classList.remove('translate-x-full');

            }, 100);                        {{-- Section Header --}}    {{-- Location Section --}}    {{-- Location Section --}}

            

            setTimeout(() => {                        <div class="flex items-center mb-8">

                notification.classList.add('translate-x-full');

                setTimeout(() => {                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mr-4">    @if($item->latitude && $item->longitude)    @if($item->latitude && $item->longitude)

                    document.body.removeChild(notification);

                }, 300);                                <i class="fas fa-map-marker-alt text-white"></i>

            }, 3000);

        }                            </div>        <div class="border-t border-gray-100 px-6 md:px-8 lg:px-12 py-8">        <div class="border-t border-gray-100 px-6 md:px-8 lg:px-12 py-8">



        @if($item->latitude && $item->longitude)                            <div>

            // Map Functions

            function openMap(lat, lng) {                                <h3 class="text-2xl font-bold text-gray-900">ที่ตั้งและการเดินทาง</h3>            <div class="max-w-4xl mx-auto">            <div class="max-w-4xl mx-auto">

                const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;

                window.open(url, '_blank');                                <p class="text-gray-600">พิกัดและข้อมูลสถานที่</p>

            }

                                        </div>                <h3 class="text-xl font-semibold text-gray-900 mb-6">ที่ตั้ง</h3>                <h3 class="text-xl font-semibold text-gray-900 mb-6">ที่ตั้ง</h3>

            // Initialize Google Maps if available

            document.addEventListener('DOMContentLoaded', function() {                        </div>

                if (typeof google !== 'undefined' && google.maps) {

                    const mapElement = document.getElementById('map');                                                        

                    if (mapElement) {

                        // Clear placeholder                        <div class="grid lg:grid-cols-2 gap-8">

                        mapElement.innerHTML = '';

                                                    {{-- Location Info --}}                <div class="bg-gray-50 rounded-lg p-6">                <div class="bg-gray-50 rounded-lg p-6">

                        const map = new google.maps.Map(mapElement, {

                            center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },                            <div class="space-y-6">

                            zoom: 15

                        });                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">                    <div class="grid md:grid-cols-2 gap-6">                    <div class="grid md:grid-cols-2 gap-6">

                        

                        new google.maps.Marker({                                    <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-200">

                            position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },

                            map: map,                                        <div class="flex items-center mb-3">                        <div class="space-y-3">                        <div class="space-y-3">

                            title: '{{ $item->title }}'

                        });                                            <i class="fas fa-globe text-green-600 mr-2"></i>

                    }

                }                                            <span class="text-sm font-medium text-gray-600">ละติจูด</span>                            <div class="text-sm text-gray-600">                            <div class="text-sm text-gray-600">

            });

        @endif                                        </div>

    </script>

@endpush                                        <p class="font-mono text-lg font-semibold text-gray-900">{{ $item->latitude }}</p>                                <p><span class="font-medium text-gray-800">ละติจูด:</span> {{ $item->latitude }}</p>                                <p><span class="font-medium text-gray-800">ละติจูด:</span> {{ $item->latitude }}</p>

                                    </div>

                                                                    <p><span class="font-medium text-gray-800">ลองจิจูด:</span> {{ $item->longitude }}</p>                                <p><span class="font-medium text-gray-800">ลองจิจูด:</span> {{ $item->longitude }}</p>

                                    <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-200">

                                        <div class="flex items-center mb-3">                            </div>                            </div>

                                            <i class="fas fa-compass text-green-600 mr-2"></i>

                                            <span class="text-sm font-medium text-gray-600">ลองจิจูด</span>                                                        

                                        </div>

                                        <p class="font-mono text-lg font-semibold text-gray-900">{{ $item->longitude }}</p>                            <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})"                             <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})" 

                                    </div>

                                </div>                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">

                                

                                <button onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})"                                 <i class="fas fa-directions mr-2"></i>                                <i class="fas fa-directions mr-2"></i>

                                        class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold py-4 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center">

                                    <i class="fas fa-route mr-3"></i>                                เส้นทางการเดินทาง                                เส้นทางการเดินทาง

                                    เส้นทางการเดินทาง

                                </button>                            </button>                            </button>

                            </div>

                                                    </div>                        </div>

                            {{-- Map --}}

                            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 border border-green-200">                                                

                                <div id="map" class="w-full h-64 bg-gray-100 rounded-xl flex items-center justify-center">

                                    <div class="text-center text-gray-500">                        <div>                        <div>

                                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">

                                            <i class="fas fa-map text-green-600 text-2xl"></i>                            <div id="map" class="w-full h-48 bg-gray-200 rounded-md flex items-center justify-center">                            <div id="map" class="w-full h-48 bg-gray-200 rounded-md flex items-center justify-center">

                                        </div>

                                        <p class="font-medium">แผนที่</p>                                <div class="text-center text-gray-500">                                <div class="text-center text-gray-500">

                                        <p class="text-sm">กำลังโหลด...</p>

                                    </div>                                    <i class="fas fa-map text-2xl mb-1"></i>                                    <i class="fas fa-map text-2xl mb-1"></i>

                                </div>

                            </div>                                    <p class="text-sm">แผนที่</p>                                    <p class="text-sm">แผนที่</p>

                        </div>

                    </div>                                </div>                                </div>

                </div>

            @endif                            </div>                            </div>

            

            {{-- Action Section --}}                        </div>                        </div>

            <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 rounded-3xl shadow-2xl overflow-hidden">

                <div class="p-8 md:p-12 text-center">                    </div>                    </div>

                    

                    {{-- Header --}}                </div>                </div>

                    <div class="mb-8">

                        <h4 class="text-3xl font-bold text-white mb-4">แบ่งปันเรื่องราวนี้</h4>            </div>            </div>

                        <p class="text-gray-300 text-lg max-w-2xl mx-auto">

                            ช่วยเผยแพร่มรดกทางวัฒนธรรมไทยให้คนรุ่นใหม่ได้รู้จักและภาคภูมิใจ        </div>        </div>

                        </p>

                    </div>    @endif    @endif

                    

                    {{-- Action Buttons --}}

                    <div class="flex flex-wrap gap-4 justify-center mb-8">

                        {{-- Primary CTA --}}    {{-- Action Buttons --}}    {{-- Action Buttons --}}

                        <button onclick="showShareModal()" 

                                class="group relative overflow-hidden bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 hover:from-orange-600 hover:via-red-600 hover:to-pink-600 text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 shadow-xl transform hover:scale-105">    <div class="border-t border-gray-100 px-6 md:px-8 lg:px-12 py-8">    <div class="border-t border-gray-100 px-6 md:px-8 lg:px-12 py-8">

                            <span class="relative z-10 flex items-center">

                                <i class="fas fa-heart mr-3"></i>        <div class="max-w-4xl mx-auto">        <div class="max-w-4xl mx-auto">

                                แชร์เรื่องราวนี้

                            </span>            <div class="flex flex-wrap gap-3 justify-center">            <div class="flex flex-wrap gap-3 justify-center">

                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/25 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>

                        </button>                <button onclick="showShareModal()"                 <button onclick="showShareModal()" 

                        

                        {{-- Secondary Actions --}}                        class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-md transition-colors">                        class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-md transition-colors">

                        <button onclick="window.print()" 

                                class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 text-white font-semibold px-8 py-4 rounded-2xl transition-all duration-300">                    <i class="fas fa-share-alt mr-2"></i>                    <i class="fas fa-share-alt mr-2"></i>

                            <i class="fas fa-print mr-3"></i>

                            พิมพ์บทความ                    แชร์เรื่องราวนี้                    แชร์เรื่องราวนี้

                        </button>

                                        </button>                </button>

                        <button onclick="saveToBookmarks()" 

                                class="bg-blue-500/20 hover:bg-blue-500/30 backdrop-blur-sm border border-blue-400/30 text-blue-200 hover:text-white font-semibold px-8 py-4 rounded-2xl transition-all duration-300">                                

                            <i class="fas fa-bookmark mr-3"></i>

                            บันทึก                <button onclick="window.print()"                 <button onclick="window.print()" 

                        </button>

                    </div>                        class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-md transition-colors">                        class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-md transition-colors">

                    

                    {{-- Footer Text --}}                    <i class="fas fa-print mr-2"></i>                    <i class="fas fa-print mr-2"></i>

                    <div class="text-gray-400">

                        <p class="flex items-center justify-center">                    พิมพ์บทความ                    พิมพ์บทความ

                            <i class="fas fa-heart text-red-400 mr-2"></i>

                            ขอบคุณที่ร่วมอนุรักษ์วัฒนธรรมไทย                </button>                </button>

                        </p>

                    </div>                                

                </div>

            </div>                <button onclick="saveToBookmarks()"                 <button onclick="saveToBookmarks()" 

        </div>

    </section>                        class="inline-flex items-center px-6 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-md transition-colors">                        class="inline-flex items-center px-6 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-md transition-colors">

</article>

                    <i class="fas fa-bookmark mr-2"></i>                    <i class="fas fa-bookmark mr-2"></i>

{{-- Enhanced JavaScript --}}

@push('scripts')                    บันทึก                    บันทึก

    <script>

        // Smooth scrolling for anchor links                </button>                </button>

        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {            </div>            </div>

                anchor.addEventListener('click', function (e) {

                    e.preventDefault();        </div>        </div>

                    const target = document.querySelector(this.getAttribute('href'));

                    if (target) {    </div>    </div>

                        target.scrollIntoView({ 

                            behavior: 'smooth',</article></article>

                            block: 'start'

                        });                    class="w-10 h-10 bg-blue-600 text-white rounded-lg hover:bg-blue-700 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"

                    }

                });{{-- JavaScript --}}                    title="แชร์ใน Facebook">

            });

        });@push('scripts')                <i class="fab fa-facebook-f text-sm"></i>



        // Share Modal Function    <script>            </button>

        function showShareModal() {

            if (navigator.share) {        // Share Modal Function            

                navigator.share({

                    title: document.title,        function showShareModal() {            <button onclick="shareToTwitter()" 

                    text: 'มาดู{{ $item->title }}กัน - มรดกทางวัฒนธรรมไทย',

                    url: window.location.href            // Simple share functionality                    class="w-10 h-10 bg-sky-500 text-white rounded-lg hover:bg-sky-600 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"

                }).catch(err => console.log('Error sharing:', err));

            } else {            if (navigator.share) {                    title="แชร์ใน Twitter">

                copyToClipboard();

            }                navigator.share({                <i class="fab fa-twitter text-sm"></i>

        }

                    title: document.title,            </button>

        function copyToClipboard() {

            navigator.clipboard.writeText(window.location.href).then(function() {                    url: window.location.href            

                showNotification('คัดลอกลิงก์เรียบร้อยแล้ว!', 'success');

            }).catch(err => {                });            <button onclick="shareToLine()" 

                console.error('Failed to copy:', err);

                showNotification('ไม่สามารถคัดลอกลิงก์ได้', 'error');            } else {                    class="w-10 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"

            });

        }                // Fallback                    title="แชร์ใน LINE">



        function saveToBookmarks() {                alert('คัดลอกลิงก์: ' + window.location.href);                <i class="fab fa-line text-sm"></i>

            if (window.external && window.external.AddFavorite) {

                window.external.AddFavorite(location.href, document.title);                navigator.clipboard.writeText(window.location.href);            </button>

            } else if (window.sidebar && window.sidebar.addPanel) {

                window.sidebar.addPanel(document.title, location.href, '');            }            

            } else {

                showNotification('กรุณาใช้ Ctrl+D เพื่อบันทึกหน้านี้', 'info');        }            <button onclick="copyToClipboard()" 

            }

        }                    class="w-10 h-10 bg-gray-600 text-white rounded-lg hover:bg-gray-700 hover:scale-110 transition-all duration-200 flex items-center justify-center social-btn"



        // Simple notification system        // Save to Bookmarks Function                    title="คัดลอกลิงก์">

        function showNotification(message, type = 'info') {

            const notification = document.createElement('div');        function saveToBookmarks() {                <i class="fas fa-link text-sm"></i>

            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transform translate-x-full transition-transform duration-300`;

                        if (window.external && window.external.AddFavorite) {            </button>

            switch(type) {

                case 'success':                window.external.AddFavorite(location.href, document.title);        </div>

                    notification.classList.add('bg-green-500');

                    break;            } else if (window.sidebar && window.sidebar.addPanel) {    </div>

                case 'error':

                    notification.classList.add('bg-red-500');                window.sidebar.addPanel(document.title, location.href, '');    

                    break;

                default:            } else {    {{-- Main Article Content --}}

                    notification.classList.add('bg-blue-500');

            }                alert('กรุณาใช้ Ctrl+D เพื่อบันทึกหน้านี้');    <div class="prose prose-lg max-w-none p-8 lg:p-12">

            

            notification.textContent = message;            }        <div id="introduction" class="text-gray-800 leading-relaxed text-lg">

            document.body.appendChild(notification);

                    }            {!! nl2br(e($item->description)) !!}

            setTimeout(() => {

                notification.classList.remove('translate-x-full');        </div>

            }, 100);

                    // Image Modal Functions        

            setTimeout(() => {

                notification.classList.add('translate-x-full');        function openImageModal(imageSrc, title) {        {{-- Additional Content Sections --}}

                setTimeout(() => {

                    document.body.removeChild(notification);            let modal = document.getElementById('imageModal');        @if($item->content)

                }, 300);

            }, 3000);            if (!modal) {            <div id="details" class="mt-10 pt-10 border-t border-gray-200">

        }

                modal = document.createElement('div');                <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">

        // Image Modal Functions

        function openImageModal(imageSrc, title) {                modal.id = 'imageModal';                    <div class="w-1 h-6 bg-orange-500 rounded-full mr-3"></div>

            let modal = document.getElementById('imageModal');

            if (!modal) {                modal.className = 'fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4';                    รายละเอียดเพิ่มเติม

                modal = document.createElement('div');

                modal.id = 'imageModal';                modal.innerHTML = `                </h2>

                modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4';

                modal.innerHTML = `                    <div class="relative max-w-5xl max-h-full">                <div class="text-gray-700 leading-relaxed">

                    <div class="relative max-w-6xl max-h-full">

                        <img id="modalImage" class="max-w-full max-h-[90vh] object-contain rounded-2xl shadow-2xl">                        <img id="modalImage" class="max-w-full max-h-full object-contain rounded-lg">                    {!! nl2br(e($item->content)) !!}

                        <button onclick="closeImageModal()" 

                                class="absolute top-4 right-4 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all backdrop-blur-sm">                        <button onclick="closeImageModal()"                 </div>

                            <i class="fas fa-times text-xl"></i>

                        </button>                                class="absolute top-2 right-2 bg-white bg-opacity-90 hover:bg-opacity-100 text-gray-800 p-2 rounded-full transition-all">            </div>

                        <div class="absolute bottom-4 left-4 right-4 text-center">

                            <h3 id="modalTitle" class="text-white text-xl font-bold mb-2"></h3>                            <i class="fas fa-times"></i>        @endif

                            <p class="text-gray-300 text-sm">กดพื้นที่ว่างหรือ ESC เพื่อปิด</p>

                        </div>                        </button>

                    </div>

                `;                        <div class="absolute bottom-2 left-2 right-2 bg-black bg-opacity-50 text-white p-3 rounded">        {{-- Community Section --}}

                document.body.appendChild(modal);

                                            <p id="modalTitle" class="font-medium"></p>        @if($item->community)

                // Close on click outside

                modal.addEventListener('click', function(e) {                        </div>            <div id="community" class="mt-10 pt-10 border-t border-gray-200">

                    if (e.target === modal) {

                        closeImageModal();                    </div>                <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">

                    }

                });                `;                    <div class="w-1 h-6 bg-orange-500 rounded-full mr-3"></div>

                

                // Close on ESC key                document.body.appendChild(modal);                    ชุมชนและท้องถิ่น

                document.addEventListener('keydown', function(e) {

                    if (e.key === 'Escape') {            }                </h2>

                        closeImageModal();

                    }                            <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-6 border border-orange-100">

                });

            }            document.getElementById('modalImage').src = imageSrc;                    <div class="flex items-start gap-4">

            

            document.getElementById('modalImage').src = imageSrc;            document.getElementById('modalTitle').textContent = title;                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0">

            document.getElementById('modalTitle').textContent = title;

            modal.classList.remove('hidden');            modal.classList.remove('hidden');                            <i class="fas fa-users text-white"></i>

            document.body.style.overflow = 'hidden';

        }            document.body.style.overflow = 'hidden';                        </div>



        function closeImageModal() {        }                        <div class="flex-1">

            const modal = document.getElementById('imageModal');

            if (modal) {                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->community->name }}</h3>

                modal.classList.add('hidden');

                document.body.style.overflow = '';        function closeImageModal() {                            @if($item->community->description)

            }

        }            const modal = document.getElementById('imageModal');                                <p class="text-gray-700 mb-3 leading-relaxed">{{ $item->community->description }}</p>



        @if($item->latitude && $item->longitude)            if (modal) {                            @endif

            // Map Functions

            function openMap(lat, lng) {                modal.classList.add('hidden');                            <div class="text-sm text-gray-600">

                const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;

                window.open(url, '_blank');                document.body.style.overflow = '';                                @if($item->community->location)

            }

                        }                                    <div class="flex items-center mb-1">

            // Initialize Google Maps if available

            document.addEventListener('DOMContentLoaded', function() {        }                                        <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>

                if (typeof google !== 'undefined' && google.maps) {

                    const mapElement = document.getElementById('map');                                        <span>{{ $item->community->location }}</span>

                    if (mapElement) {

                        // Clear placeholder        @if($item->latitude && $item->longitude)                                    </div>

                        mapElement.innerHTML = '';

                                    // Map Function                                @endif

                        const map = new google.maps.Map(mapElement, {

                            center: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },            function openMap(lat, lng) {                            </div>

                            zoom: 15,

                            styles: [                const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;                        </div>

                                {

                                    featureType: 'poi',                window.open(url, '_blank');                    </div>

                                    elementType: 'labels',

                                    stylers: [{ visibility: 'off' }]            }                </div>

                                }

                            ]        @endif            </div>

                        });

                            </script>        @endif

                        new google.maps.Marker({

                            position: { lat: {{ $item->latitude }}, lng: {{ $item->longitude }} },@endpush

                            map: map,        {{-- Location Section --}}

                            title: '{{ $item->title }}'        @if($item->latitude && $item->longitude)

                        });            <div id="location" class="mt-10 pt-10 border-t border-gray-200">

                    }                <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">

                }                    <div class="w-1 h-6 bg-orange-500 rounded-full mr-3"></div>

            });                    ตำแหน่งที่ตั้ง

        @endif                </h2>

    </script>                <div class="bg-gray-50 rounded-xl p-6 border">

@endpush                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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