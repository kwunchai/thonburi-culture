@extends('layouts.frontend-redesign')

@section('title', 'หน้าแรก - วัฒนธรรมเขตธนบุรี')
@section('meta_description', 'ฐานข้อมูลมรดกทางวัฒนธรรมเขตธนบุรี - สำรวจเรื่องราว ประเพณี และภูมิปัญญาท้องถิ่นของชุมชนในเขตธนบุรี กรุงเทพมหานคร')

@section('content')

<!-- =============================================
     HERO SECTION
============================================== -->
<section class="relative min-h-[600px] bg-gradient-to-br from-thonburi-sand-100 via-thonburi-gold-100 to-thonburi-lotus-100 overflow-hidden">
    
    <!-- Decorative Thai pattern -->
    <div class="absolute inset-0 opacity-10 bg-thai-pattern"></div>
    
    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-white/50"></div>
    
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl h-full flex items-center min-h-[600px]">
        <div class="w-full py-16 lg:py-24">
            
            <div class="max-w-4xl mx-auto text-center">
                
                <!-- Icon badge -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/30 backdrop-blur-sm rounded-2xl shadow-xl mb-6 animate-bounce">
                    <i class="fas fa-landmark text-4xl text-thonburi-gold-600"></i>
                </div>
                
                <!-- Main heading -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 font-display leading-tight">
                    ค้นพบมรดกทางวัฒนธรรม
                    <span class="block text-thonburi-gold-600 mt-2">เขตธนบุรี</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-700 mb-10 leading-relaxed max-w-3xl mx-auto">
                    สำรวจเรื่องราว ประเพณี และภูมิปัญญาท้องถิ่น<br class="hidden md:block">
                    ที่สืบทอดมาจากบรรพบุรุษชาวธนบุรี
                </p>
                
                <!-- Search bar -->
                <div class="max-w-2xl mx-auto mb-8">
                    <form action="{{ route('cultural.explore') }}" method="GET" class="relative">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                <i class="fas fa-search text-2xl text-gray-400"></i>
                            </div>
                            <input type="search"
                                   name="search"
                                   placeholder="ค้นหาวัฒนธรรม ประเพณี สถานที่ หรือชุมชน..."
                                   class="w-full pl-16 pr-40 py-5 bg-white border-2 border-thonburi-sand-300 rounded-2xl text-lg focus:border-thonburi-gold-500 focus:ring-4 focus:ring-thonburi-gold-100 outline-none transition-all shadow-lg">
                            <button type="submit"
                                    class="absolute right-2 top-2 bottom-2 px-8 bg-gradient-to-r from-thonburi-gold-500 to-thonburi-gold-600 text-white rounded-xl font-bold hover:shadow-xl transition-all">
                                ค้นหา
                            </button>
                        </div>
                    </form>
                    
                    <!-- Popular tags -->
                    <div class="mt-4 flex flex-wrap gap-2 justify-center">
                        <span class="text-sm text-gray-500">ยอดนิยม:</span>
                        <a href="{{ route('cultural.explore', ['search' => 'วัดอรุณ']) }}" 
                           class="px-3 py-1 bg-white/80 text-thonburi-gold-700 rounded-full text-sm font-medium hover:bg-white hover:shadow-md transition-all">
                            วัดอรุณ
                        </a>
                        <a href="{{ route('cultural.explore', ['search' => 'ขนมไทย']) }}" 
                           class="px-3 py-1 bg-white/80 text-thonburi-terra-700 rounded-full text-sm font-medium hover:bg-white hover:shadow-md transition-all">
                            ขนมไทย
                        </a>
                        <a href="{{ route('cultural.explore', ['search' => 'ตลาดน้ำ']) }}" 
                           class="px-3 py-1 bg-white/80 text-thonburi-navy-700 rounded-full text-sm font-medium hover:bg-white hover:shadow-md transition-all">
                            ตลาดน้ำ
                        </a>
                        <a href="{{ route('cultural.explore', ['search' => 'หัตถกรรม']) }}" 
                           class="px-3 py-1 bg-white/80 text-thonburi-wood-700 rounded-full text-sm font-medium hover:bg-white hover:shadow-md transition-all">
                            หัตถกรรม
                        </a>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('cultural.explore') }}" 
                       class="inline-flex items-center justify-center space-x-3 px-8 py-4 bg-gradient-to-r from-thonburi-gold-500 to-thonburi-gold-600 text-white rounded-xl font-bold text-lg shadow-heritage hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-compass text-xl"></i>
                        <span>เริ่มสำรวจ</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('about') }}" 
                       class="inline-flex items-center justify-center space-x-3 px-8 py-4 bg-white text-thonburi-gold-600 border-2 border-thonburi-gold-400 rounded-xl font-bold text-lg hover:bg-thonburi-gold-50 transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-book-open text-xl"></i>
                        <span>เกี่ยวกับเรา</span>
                    </a>
                </div>
                
            </div>
            
        </div>
    </div>
    
    <!-- Wave divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full fill-white">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
    
</section>

<!-- =============================================
     FEATURED CATEGORIES
============================================== -->
<section class="py-16 lg:py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <x-section-header 
            title="หมวดหมู่วัฒนธรรม"
            subtitle="สำรวจมรดกทางวัฒนธรรมตามประเภทที่สนใจ"
            icon="fa-th-large"
            iconColor="gold"
            align="center"
            size="lg"
        />
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-6">
            
            @foreach($categories as $category)
            <a href="{{ route('cultural.explore', ['category' => $category->slug]) }}" 
               class="group bg-gradient-to-br from-white to-thonburi-sand-50 rounded-2xl border border-thonburi-sand-200 hover:border-thonburi-gold-400 p-6 text-center transition-all duration-300 hover:scale-105 hover:shadow-lg">
                
                <!-- Icon -->
                <div class="w-16 h-16 bg-gradient-to-br {{ $category->color_from ?? 'from-thonburi-gold-400' }} {{ $category->color_to ?? 'to-thonburi-gold-600' }} rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-md">
                    <i class="fas {{ $category->icon ?? 'fa-star' }} text-2xl text-white"></i>
                </div>
                
                <!-- Name -->
                <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-thonburi-gold-600 transition-colors">
                    {{ $category->name_th }}
                </h3>
                
                <!-- Count -->
                @if(isset($category->items_count))
                <p class="text-xs text-gray-500 mt-2">
                    {{ $category->items_count }} รายการ
                </p>
                @endif
                
            </a>
            @endforeach
            
        </div>
        
        <!-- View all categories -->
        <div class="text-center mt-10">
            <a href="{{ route('categories.index') }}" 
               class="inline-flex items-center space-x-2 text-thonburi-gold-600 hover:text-thonburi-gold-700 font-medium text-lg group">
                <span>ดูหมวดหมู่ทั้งหมด</span>
                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
        
    </div>
</section>

<!-- =============================================
     FEATURED CULTURAL ITEMS
============================================== -->
<section class="py-16 lg:py-20 bg-gradient-to-b from-thonburi-sand-50 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <x-section-header 
            title="วัฒนธรรมแนะนำ"
            subtitle="รวบรวมเรื่องราวและมรดกทางวัฒนธรรมที่น่าสนใจ"
            icon="fa-star"
            iconColor="gold"
            align="center"
            size="lg"
        />
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
            
            @foreach($featuredItems as $item)
                <x-culture-card :item="$item" :featured="true" />
            @endforeach
            
        </div>
        
        <!-- View all button -->
        <div class="text-center mt-12">
            <a href="{{ route('cultural.explore') }}" 
               class="inline-flex items-center space-x-3 px-8 py-4 bg-gradient-to-r from-thonburi-gold-500 to-thonburi-gold-600 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-compass"></i>
                <span>สำรวจวัฒนธรรมทั้งหมด</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
    </div>
</section>

<!-- =============================================
     COMMUNITIES
============================================== -->
<section class="py-16 lg:py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <x-section-header 
            title="ชุมชนในเขตธนบุรี"
            subtitle="ชุมชนต่าง ๆ ที่เป็นแหล่งรวมวัฒนธรรมและประเพณีท้องถิ่น"
            icon="fa-users"
            iconColor="navy"
            align="center"
            size="lg"
        />
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            
            @foreach($communities as $community)
                <x-community-card :community="$community" :showItemCount="true" />
            @endforeach
            
        </div>
        
        <!-- View all communities -->
        <div class="text-center mt-12">
            <a href="{{ route('communities.index') }}" 
               class="inline-flex items-center space-x-3 px-8 py-4 bg-gradient-to-r from-thonburi-navy-600 to-thonburi-navy-700 text-white rounded-xl font-bold text-lg shadow-river hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-map-marked-alt"></i>
                <span>ดูชุมชนทั้งหมด</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
    </div>
</section>

<!-- =============================================
     ABOUT SNIPPET + CTA
============================================== -->
<section class="py-16 lg:py-20 bg-gradient-to-br from-thonburi-navy-700 to-thonburi-navy-900 text-white relative overflow-hidden">
    
    <!-- Decorative pattern -->
    <div class="absolute inset-0 opacity-10 bg-thai-pattern"></div>
    
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl text-center">
        
        <!-- Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl shadow-xl mb-6">
            <i class="fas fa-heart text-4xl text-thonburi-gold-400"></i>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-bold mb-6 font-display">
            เรื่องราวของเรา
        </h2>
        
        <p class="text-xl md:text-2xl text-white/90 leading-relaxed mb-10 max-w-3xl mx-auto">
            ฐานข้อมูลมรดกทางวัฒนธรรมเขตธนบุรีถูกสร้างขึ้นเพื่อเป็นศูนย์กลางในการรวบรวม
            อนุรักษ์ และเผยแพร่เรื่องราวทางวัฒนธรรมของชุมชนต่าง ๆ ในเขตธนบุรี
        </p>
        
        <a href="{{ route('about') }}" 
           class="inline-flex items-center space-x-3 px-8 py-4 bg-white text-thonburi-navy-700 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
            <i class="fas fa-info-circle text-xl"></i>
            <span>เรียนรู้เพิ่มเติมเกี่ยวกับเรา</span>
            <i class="fas fa-arrow-right"></i>
        </a>
        
    </div>
    
</section>

<!-- =============================================
     STATISTICS
============================================== -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Stat 1 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-thonburi-gold-400 to-thonburi-gold-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-layer-group text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-bold text-gray-900 mb-2">{{ $stats['total_items'] ?? 0 }}</div>
                <div class="text-gray-600">รายการวัฒนธรรม</div>
            </div>
            
            <!-- Stat 2 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-thonburi-navy-400 to-thonburi-navy-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-bold text-gray-900 mb-2">{{ $stats['total_communities'] ?? 0 }}</div>
                <div class="text-gray-600">ชุมชน</div>
            </div>
            
            <!-- Stat 3 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-thonburi-terra-400 to-thonburi-terra-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-th-large text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-bold text-gray-900 mb-2">{{ $stats['total_categories'] ?? 0 }}</div>
                <div class="text-gray-600">หมวดหมู่</div>
            </div>
            
            <!-- Stat 4 -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-thonburi-emerald-400 to-thonburi-emerald-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-images text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-bold text-gray-900 mb-2">{{ $stats['total_images'] ?? 0 }}</div>
                <div class="text-gray-600">รูปภาพ</div>
            </div>
            
        </div>
        
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Add any home page specific JavaScript here
    console.log('Home page loaded');
</script>
@endpush
