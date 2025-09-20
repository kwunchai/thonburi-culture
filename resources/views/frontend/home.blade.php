@extends('layouts.frontend')

@section('title', 'หน้าแรก')

@section('content')
<!-- Hero Slideshow Section -->
<section class="relative h-[600px] md:h-[700px] overflow-hidden bg-gray-900">
    <!-- Slideshow Container -->
    <div class="relative h-full" id="heroSlideshow">
        @forelse($featuredItems as $index => $item)
        <!-- Slide {{ $index + 1 }} -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
            <!-- Background Image -->
            <div class="absolute inset-0">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <img src="https://images.unsplash.com/photo-1569154941061-e231b4725ef1?w=1920" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover">
                @endif
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-transparent"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-3xl">
                        <!-- Category Badge -->
                        <span class="inline-block px-4 py-2 bg-orange-500/90 backdrop-blur-sm text-white rounded-full text-sm font-semibold mb-4 transform translate-y-0 opacity-0 animate-slide-up animation-delay-200">
                            <i class="fas {{ $item->category->icon ?? 'fa-folder' }} mr-2"></i>
                            {{ $item->category->name }}
                        </span>
                        
                        <!-- Title -->
                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight transform translate-y-0 opacity-0 animate-slide-up animation-delay-400">
                            {{ $item->title }}
                        </h1>
                        
                        <!-- Description -->
                        <p class="text-lg md:text-xl text-white/90 mb-6 line-clamp-3 transform translate-y-0 opacity-0 animate-slide-up animation-delay-600">
                            {{ $item->description }}
                        </p>
                        
                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-4 text-white/80 mb-8 transform translate-y-0 opacity-0 animate-slide-up animation-delay-800">
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $item->community->name }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $item->publish_date->format('d M Y') }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                {{ $item->creator->name }}
                            </span>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4 transform translate-y-0 opacity-0 animate-slide-up animation-delay-1000">
                            <a href="{{ route('cultural-item.show', $item->id) }}" 
                               class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-full transition-all transform hover:scale-105 shadow-lg">
                                <i class="fas fa-book-open mr-2"></i>
                                อ่านเพิ่มเติม
                            </a>
                            <a href="{{ route('category', $item->category->slug) }}" 
                               class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold rounded-full transition-all border border-white/50">
                                <i class="fas fa-compass mr-2"></i>
                                ดูหมวดหมู่นี้
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Fallback Slide ถ้าไม่มีข้อมูล -->
        <div class="hero-slide absolute inset-0">
            <div class="absolute inset-0">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Wat_Arun_temple_Bangkok.jpg/1280px-Wat_Arun_temple_Bangkok.jpg" 
                     alt="วัดอรุณ" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            </div>
            <div class="relative z-10 h-full flex items-center justify-center text-center">
                <div class="text-white px-4">
                    <h1 class="text-5xl md:text-6xl font-bold mb-4">วัฒนธรรมเขตธนบุรี</h1>
                    <p class="text-xl md:text-2xl max-w-2xl mx-auto">
                        ค้นพบเสน่ห์แห่งฝั่งธนบุรี ดินแดนแห่งประวัติศาสตร์ ศิลปวัฒนธรรม และวิถีชีวิตริมน้ำเจ้าพระยา
                    </p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- Slide Indicators -->
    @if($featuredItems->count() > 1)
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex gap-2">
        @foreach($featuredItems as $index => $item)
        <button class="slide-indicator w-12 h-1.5 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300 {{ $index === 0 ? 'bg-white w-16' : '' }}"
                data-slide-to="{{ $index }}"
                aria-label="Go to slide {{ $index + 1 }}">
        </button>
        @endforeach
    </div>
    
    <!-- Navigation Arrows -->
    <button class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition-all group"
            id="prevSlide"
            aria-label="Previous slide">
        <i class="fas fa-chevron-left text-white group-hover:scale-110 transition-transform"></i>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 rounded-full flex items-center justify-center transition-all group"
            id="nextSlide"
            aria-label="Next slide">
        <i class="fas fa-chevron-right text-white group-hover:scale-110 transition-transform"></i>
    </button>
    @endif
    
    <!-- Slide Counter -->
    @if($featuredItems->count() > 1)
    <div class="absolute top-8 right-8 z-20 bg-black/50 backdrop-blur-sm px-4 py-2 rounded-full">
        <span class="text-white font-semibold">
            <span id="currentSlide">1</span> / {{ $featuredItems->count() }}
        </span>
    </div>
    @endif
</section>

<!-- Categories Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">หมวดหมู่วัฒนธรรม</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                สำรวจความหลากหลายทางวัฒนธรรมของเขตธนบุรีผ่านหมวดหมู่ต่างๆ
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @forelse($categories as $category)
            <a href="{{ route('category', $category->slug) }}" 
               class="group text-center p-6 rounded-2xl hover:bg-orange-50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center group-hover:from-orange-400 group-hover:to-orange-500 transition-all duration-300">
                    <i class="fas {{ $category->icon ?? 'fa-folder' }} text-2xl text-orange-600 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">{{ $category->name }}</h3>
                @if($category->cultural_items_count ?? 0 > 0)
                <span class="text-xs text-gray-500 mt-1">{{ $category->cultural_items_count }} รายการ</span>
                @endif
            </a>
            @empty
            <div class="col-span-6 text-center text-gray-500 py-8">
                <i class="fas fa-folder-open text-6xl mb-4"></i>
                <p>ยังไม่มีหมวดหมู่</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Latest Items Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">ข้อมูลวัฒนธรรมล่าสุด</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                อัปเดตข้อมูลและเรื่องราวน่าสนใจล่าสุดจากชุมชนต่างๆ
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($latestItems as $item)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative h-48 overflow-hidden">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <i class="fas fa-image text-5xl text-gray-400"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-orange-500 text-white rounded-full text-xs font-semibold">
                            {{ $item->category->name }}
                        </span>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="font-bold text-lg mb-2 text-gray-800 group-hover:text-orange-600 transition-colors line-clamp-2">
                        {{ $item->title }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $item->description }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-map-marker-alt mr-1"></i> 
                            {{ Str::limit($item->community->name, 15) }}
                        </span>
                        <a href="{{ route('cultural-item.show', $item->id) }}" 
                           class="text-orange-600 hover:text-orange-700 font-medium text-sm flex items-center group">
                            อ่านเพิ่ม 
                            <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-500 py-12">
                <i class="fas fa-newspaper text-6xl mb-4"></i>
                <p>ยังไม่มีข้อมูลวัฒนธรรม</p>
            </div>
            @endforelse
        </div>
        
        @if($latestItems->count() > 0)
        <div class="text-center mt-10">
            <a href="#" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-full transition-all transform hover:scale-105 shadow-lg">
                ดูทั้งหมด
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Communities Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">ชุมชนในเขตธนบุรี</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                ทำความรู้จักกับชุมชนต่างๆ ที่เป็นหัวใจสำคัญของวัฒนธรรมธนบุรี
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @forelse($communities as $community)
            <div class="group cursor-pointer">
                <div class="relative aspect-square rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                    @if($community->image)
                        <img src="{{ Storage::url($community->image) }}" alt="{{ $community->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                            <i class="fas fa-building text-4xl text-orange-400"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-xs">{{ $community->description ?? 'ชุมชนเก่าแก่' }}</p>
                    </div>
                </div>
                <h3 class="text-center mt-3 font-medium text-gray-700 group-hover:text-orange-600 transition-colors">
                    {{ $community->name }}
                </h3>
            </div>
            @empty
            <div class="col-span-6 text-center text-gray-500 py-12">
                <i class="fas fa-map-marked-alt text-6xl mb-4"></i>
                <p>ยังไม่มีข้อมูลชุมชน</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<section class="grid gap-6">
    <div>
    {{-- ใส่กราฟตัวอย่าง --}}
    <h1 class="text-xl font-semibold mb-6">สถิติข้อมูล</h1>
  @include('partials.home-charts')
    </div>
</section>


  <!-- Google Map Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">แผนที่วัฒนธรรม</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                สำรวจตำแหน่งของชุมชนและสถานที่สำคัญทางวัฒนธรรม
            </p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31006.11844937!2d100.47247!3d13.7263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2991a19b1b707%3A0x40056b34e3d9f70!2sThon%20Buri%2C%20Bangkok!5e0!3m2!1sen!2sth!4v1234567890"
                width="100%" 
                height="500" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<!-- CSS Animations -->
<style>
    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-up {
        animation: slide-up 0.8s ease-out forwards;
    }
    
    .animation-delay-200 { animation-delay: 200ms; }
    .animation-delay-400 { animation-delay: 400ms; }
    .animation-delay-600 { animation-delay: 600ms; }
    .animation-delay-800 { animation-delay: 800ms; }
    .animation-delay-1000 { animation-delay: 1000ms; }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- JavaScript for Slideshow -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.slide-indicator');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    const currentSlideSpan = document.getElementById('currentSlide');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    let slideInterval;
    
    // Function to show specific slide
    function showSlide(index) {
        // Hide all slides
        slides.forEach((slide, i) => {
            slide.classList.remove('opacity-100');
            slide.classList.add('opacity-0');
            
            // Reset animations
            const animatedElements = slide.querySelectorAll('[class*="animate-slide-up"]');
            animatedElements.forEach(el => {
                el.style.animation = 'none';
            });
        });
        
        // Show current slide
        slides[index].classList.remove('opacity-0');
        slides[index].classList.add('opacity-100');
        
        // Trigger animations for current slide
        setTimeout(() => {
            const animatedElements = slides[index].querySelectorAll('[class*="animate-slide-up"]');
            animatedElements.forEach(el => {
                el.style.animation = '';
            });
        }, 100);
        
        // Update indicators
        if (indicators.length > 0) {
            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.classList.add('bg-white', 'w-16');
                    indicator.classList.remove('bg-white/40', 'w-12');
                } else {
                    indicator.classList.remove('bg-white', 'w-16');
                    indicator.classList.add('bg-white/40', 'w-12');
                }
            });
        }
        
        // Update counter
        if (currentSlideSpan) {
            currentSlideSpan.textContent = index + 1;
        }
        
        currentSlide = index;
    }
    
    // Auto slide function
    function nextSlide() {
        const next = (currentSlide + 1) % totalSlides;
        showSlide(next);
    }
    
    function prevSlide() {
        const prev = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(prev);
    }
    
    // Start auto slide
    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }
    
    // Stop auto slide
    function stopAutoSlide() {
        clearInterval(slideInterval);
    }
    
    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            nextSlide();
            startAutoSlide();
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            prevSlide();
            startAutoSlide();
        });
    }
    
    // Indicator clicks
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopAutoSlide();
            showSlide(index);
            startAutoSlide();
        });
    });
    
    // Pause on hover
    const slideshowContainer = document.getElementById('heroSlideshow');
    if (slideshowContainer && totalSlides > 1) {
        slideshowContainer.addEventListener('mouseenter', stopAutoSlide);
        slideshowContainer.addEventListener('mouseleave', startAutoSlide);
    }
    
    // Start slideshow if there are multiple slides
    if (totalSlides > 1) {
        startAutoSlide();
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft' && prevBtn) {
            prevBtn.click();
        } else if (e.key === 'ArrowRight' && nextBtn) {
            nextBtn.click();
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
      const url = "{{ route('stats.home', ['months' => 12]) }}";
      const res = await fetch(url);
      const json = await res.json();

      // === Line: New items by month ===
      new Chart(document.getElementById('chart-line-new'), {
        type: 'line',
        data: {
          labels: json.labels,
          datasets: [
            { label: 'วัฒนธรรม', data: json.line.cultural },
            { label: 'งานวิจัย', data: json.line.research },
            { label: 'ทรัพย์สินทางปัญญา', data: json.line.ip },
            { label: 'นวัตกรรม', data: json.line.innov },
            { label: 'สถานที่', data: json.line.places },
          ]
        },
        options: { responsive: true, maintainAspectRatio: false }
      });

      // === Doughnut: IP Types ===
      const ipLabels = Object.keys(json.ipTypes);
      const ipValues = Object.values(json.ipTypes);
      new Chart(document.getElementById('chart-ip-donut'), {
        type: 'doughnut',
        data: { labels: ipLabels, datasets: [{ data: ipValues }] },
        options: { responsive: true, maintainAspectRatio: false }
      });

      // === Bar: Top Communities ===
      new Chart(document.getElementById('chart-top-communities'), {
        type: 'bar',
        data: {
          labels: json.topCommunities.map(x => x.name),
          datasets: [{ label: 'จำนวนรายการ', data: json.topCommunities.map(x => x.count) }]
        },
        options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false }
      });
    });
</script>

@endsection