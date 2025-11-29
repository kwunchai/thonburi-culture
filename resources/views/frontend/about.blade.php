@extends('layouts.frontend')

@section('title', 'เกี่ยวกับเรา - วัฒนธรรมเขตธนบุรี')

@section('content')
<!-- Hero / Intro Section -->
<div class="relative min-h-[500px] bg-gradient-to-br from-orange-500 via-orange-600 to-pink-600 overflow-hidden">
    <!-- Decorative Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/30"></div>
    
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center min-h-[500px]">
        <div class="max-w-4xl mx-auto text-center py-16">
            <!-- Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-users text-4xl text-white"></i>
            </div>
            
            <!-- Main Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">
                เกี่ยวกับเรา
            </h1>
            <p class="text-lg md:text-xl text-white/80 font-light mb-6">
                about us
            </p>
            
            <!-- Description -->
            <p class="text-xl md:text-2xl text-white/95 leading-relaxed mb-8 max-w-3xl mx-auto">
                รวบรวมและเผยแพร่เรื่องราวทางวัฒนธรรม<br class="hidden md:block">
                ประเพณี และวิถีชีวิตของชุมชนในเขตธนบุรี
            </p>
            
            <!-- CTA Button -->
            <a href="{{ route('cultural.explore') }}" 
               class="inline-flex items-center gap-3 px-8 py-4 bg-white hover:bg-gray-50 text-orange-600 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-compass text-xl"></i>
                <span>สำรวจวัฒนธรรม</span>
                <i class="fas fa-arrow-right text-lg"></i>
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gradient-to-b from-gray-50 to-white py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <!-- Our Story / เรื่องราวของเรา -->
        <section class="mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-book-open text-2xl text-white"></i>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">เรื่องราวของเรา</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-orange-400 to-pink-500 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-6">
                    <p class="text-lg text-gray-700 leading-relaxed">
                        โครงการ<strong>วัฒนธรรมเขตธนบุรี</strong>เกิดขึ้นจากความตั้งใจที่จะอนุรักษ์และเผยแพร่มรดกทางวัฒนธรรม
                        ที่ทรงคุณค่าของเขตธนบุรี ซึ่งเป็นพื้นที่ที่มีประวัติศาสตร์ยาวนานและเคยเป็นราชธานีของไทยในอดีต
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        ด้วยการพัฒนาเมืองที่รวดเร็ว วัฒนธรรมดั้งเดิมหลายอย่างกำลังถูกลืมเลือน เราจึงริเริ่มโครงการนี้ขึ้นเพื่อเป็น
                        ศูนย์กลางข้อมูลดิจิทัลที่รวบรวมเรื่องราว ภาพถ่าย และความรู้ทางวัฒนธรรมจากชุมชนต่าง ๆ 
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        ผ่านความร่วมมือจากผู้นำชุมชน นักวิชาการ และคนรุ่นใหม่ที่มีใจรักในท้องถิ่น เรามุ่งหวังให้แพลตฟอร์มนี้เป็น
                        สะพานเชื่อมระหว่างอดีตกับปัจจุบัน และเป็นแหล่งเรียนรู้สำหรับคนทุกเจเนอเรชั่น
                    </p>
                </div>
                
                <!-- Image Placeholder -->
                <div class="relative">
                    <div class="aspect-[4/3] bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl shadow-xl overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-landmark text-6xl text-orange-400 mb-4"></i>
                                <p class="text-xl font-semibold text-gray-600">วัดอรุณราชวราราม</p>
                                <p class="text-sm text-gray-500">สัญลักษณ์แห่งเขตธนบุรี</p>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative Element -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-orange-500 rounded-2xl opacity-20 -z-10"></div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-pink-500 rounded-full opacity-20 -z-10"></div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <section class="mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-bullseye text-2xl text-white"></i>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">เป้าหมายและวิสัยทัศน์</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Vision Card -->
                <div class="bg-white rounded-2xl border-2 border-orange-200 p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-eye text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">วิสัยทัศน์</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-orange-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">เป็นแพลตฟอร์มดิจิทัลชั้นนำด้านวัฒนธรรมท้องถิ่นในประเทศไทย</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-orange-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">สร้างความตระหนักและความภาคภูมิใจในเอกลักษณ์ทางวัฒนธรรมของธนบุรี</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-orange-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">เชื่อมโยงคนรุ่นใหม่กับรากเหง้าทางวัฒนธรรมของท้องถิ่น</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Mission Card -->
                <div class="bg-white rounded-2xl border-2 border-blue-200 p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-tasks text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">พันธกิจ</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">รวบรวมและจัดเก็บข้อมูลวัฒนธรรมอย่างเป็นระบบ</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">เผยแพร่องค์ความรู้สู่สาธารณะผ่านช่องทางดิจิทัล</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">สนับสนุนกิจกรรมและการท่องเที่ยวเชิงวัฒนธรรม</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">ส่งเสริมความร่วมมือระหว่างชุมชนและหน่วยงานต่าง ๆ</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-500 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">พัฒนาและปรับปรุงระบบอย่างต่อเนื่องตามความต้องการของผู้ใช้</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- What We Do -->
        <section class="mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-cogs text-2xl text-white"></i>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">สิ่งที่เราทำ</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-400 to-teal-500 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-orange-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg">
                        <i class="fas fa-search text-4xl text-white drop-shadow-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">สำรวจและเก็บข้อมูล</h3>
                    <p class="text-gray-600 leading-relaxed">
                        ลงพื้นที่สำรวจและบันทึกข้อมูลวัฒนธรรม ภาพถ่าย และเรื่องราวจากชุมชนต่าง ๆ ในเขตธนบุรี
                    </p>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-blue-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg">
                        <i class="fas fa-network-wired text-4xl text-white drop-shadow-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">เชื่อมโยงชุมชน</h3>
                    <p class="text-gray-600 leading-relaxed">
                        สร้างเครือข่ายและเชื่อมโยงระหว่างชุมชน กิจกรรม และผู้สนใจวัฒนธรรมท้องถิ่น
                    </p>
                </div>
                
                <!-- Card 3 -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-green-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg">
                        <i class="fas fa-book-reader text-4xl text-white drop-shadow-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">เผยแพร่ความรู้</h3>
                    <p class="text-gray-600 leading-relaxed">
                        นำเสนอข้อมูลและองค์ความรู้ทางวัฒนธรรมให้สาธารณะเข้าถึงได้ง่ายผ่านแพลตฟอร์มออนไลน์
                    </p>
                </div>
                
                <!-- Card 4 -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 hover:border-purple-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center mb-5 shadow-lg">
                        <i class="fas fa-calendar-alt text-4xl text-white drop-shadow-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">จัดกิจกรรม</h3>
                    <p class="text-gray-600 leading-relaxed">
                        ประสานงานและประชาสัมพันธ์กิจกรรมทางวัฒนธรรมและการท่องเที่ยวในพื้นที่
                    </p>
                </div>
            </div>
        </section>

        <!-- Our Team -->
        <section class="mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-users-cog text-2xl text-white"></i>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">ทีมงานของเรา</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-purple-400 to-pink-500 mx-auto rounded-full"></div>
                <p class="text-gray-600 mt-4 text-lg">ผู้ร่วมสร้างสรรค์และดูแลโครงการ</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Team Member 1 -->
                <div class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <div class="aspect-square bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center relative overflow-hidden">
                            <i class="fas fa-user text-8xl text-white drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)] group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">ดร.สมชาย วัฒนธรรม</h3>
                            <p class="text-orange-600 font-semibold mb-3">ผู้อำนวยการโครงการ</p>
                            <p class="text-sm text-gray-600">กำกับดูแลและพัฒนาโครงการโดยรวม</p>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <div class="aspect-square bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative overflow-hidden">
                            <i class="fas fa-user text-8xl text-white drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)] group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">คุณสมหญิง ชุมชนดี</h3>
                            <p class="text-blue-600 font-semibold mb-3">ผู้ประสานงานชุมชน</p>
                            <p class="text-sm text-gray-600">ติดต่อประสานงานกับชุมชนต่าง ๆ</p>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <div class="aspect-square bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center relative overflow-hidden">
                            <i class="fas fa-user text-8xl text-white drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)] group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">คุณภัทรพล เทคโนโลยี</h3>
                            <p class="text-green-600 font-semibold mb-3">ผู้ดูแลระบบเว็บไซต์</p>
                            <p class="text-sm text-gray-600">พัฒนาและดูแลเว็บไซต์และระบบ</p>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 4 -->
                <div class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <div class="aspect-square bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center relative overflow-hidden">
                            <i class="fas fa-user text-8xl text-white drop-shadow-[0_4px_8px_rgba(0,0,0,0.3)] group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">คุณรัตนา ศิลปกรรม</h3>
                            <p class="text-purple-600 font-semibold mb-3">ผู้จัดการเนื้อหา</p>
                            <p class="text-sm text-gray-600">รวบรวมและจัดการข้อมูลวัฒนธรรม</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Timeline -->
        <section class="mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-400 to-pink-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-history text-2xl text-white"></i>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">พัฒนาการโครงการ</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-pink-400 to-orange-500 mx-auto rounded-full"></div>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-orange-400 via-pink-400 to-purple-400 hidden md:block"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-12">
                        <!-- Item 1 -->
                        <div class="relative">
                            <div class="md:grid md:grid-cols-2 md:gap-8 items-center">
                                <div class="md:text-right">
                                    <div class="bg-white rounded-xl border-2 border-orange-200 p-6 shadow-lg hover:shadow-xl transition-all">
                                        <div class="flex items-center gap-3 mb-3 md:justify-end">
                                            <span class="text-2xl font-bold text-orange-600">2022</span>
                                            <i class="fas fa-lightbulb text-orange-500 text-xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">เริ่มต้นโครงการ</h3>
                                        <p class="text-gray-600">ริเริ่มแนวคิดและวางแผนโครงการรวบรวมวัฒนธรรมเขตธนบุรี</p>
                                    </div>
                                </div>
                                <div class="hidden md:block"></div>
                            </div>
                            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-orange-500 rounded-full border-4 border-white shadow-lg hidden md:block"></div>
                        </div>
                        
                        <!-- Item 2 -->
                        <div class="relative">
                            <div class="md:grid md:grid-cols-2 md:gap-8 items-center">
                                <div class="hidden md:block"></div>
                                <div class="md:text-left">
                                    <div class="bg-white rounded-xl border-2 border-pink-200 p-6 shadow-lg hover:shadow-xl transition-all">
                                        <div class="flex items-center gap-3 mb-3">
                                            <i class="fas fa-rocket text-pink-500 text-xl"></i>
                                            <span class="text-2xl font-bold text-pink-600">2023</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">เปิดตัวเว็บไซต์</h3>
                                        <p class="text-gray-600">เปิดตัวแพลตฟอร์มออนไลน์พร้อมข้อมูลวัฒนธรรม 50+ รายการ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-pink-500 rounded-full border-4 border-white shadow-lg hidden md:block"></div>
                        </div>
                        
                        <!-- Item 3 -->
                        <div class="relative">
                            <div class="md:grid md:grid-cols-2 md:gap-8 items-center">
                                <div class="md:text-right">
                                    <div class="bg-white rounded-xl border-2 border-blue-200 p-6 shadow-lg hover:shadow-xl transition-all">
                                        <div class="flex items-center gap-3 mb-3 md:justify-end">
                                            <span class="text-2xl font-bold text-blue-600">2024</span>
                                            <i class="fas fa-handshake text-blue-500 text-xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">ขยายเครือข่าย</h3>
                                        <p class="text-gray-600">ร่วมมือกับชุมชนและองค์กรต่าง ๆ กว่า 15 แห่ง</p>
                                    </div>
                                </div>
                                <div class="hidden md:block"></div>
                            </div>
                            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-blue-500 rounded-full border-4 border-white shadow-lg hidden md:block"></div>
                        </div>
                        
                        <!-- Item 4 -->
                        <div class="relative">
                            <div class="md:grid md:grid-cols-2 md:gap-8 items-center">
                                <div class="hidden md:block"></div>
                                <div class="md:text-left">
                                    <div class="bg-white rounded-xl border-2 border-purple-200 p-6 shadow-lg hover:shadow-xl transition-all">
                                        <div class="flex items-center gap-3 mb-3">
                                            <i class="fas fa-star text-purple-500 text-xl"></i>
                                            <span class="text-2xl font-bold text-purple-600">2025</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">ปัจจุบัน</h3>
                                        <p class="text-gray-600">พัฒนาฟีเจอร์ใหม่และขยายฐานข้อมูลอย่างต่อเนื่อง</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-purple-500 rounded-full border-4 border-white shadow-lg hidden md:block"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-envelope text-2xl text-white"></i>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">ติดต่อเรา</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-teal-400 to-blue-500 mx-auto rounded-full"></div>
                <p class="text-gray-600 mt-4 text-lg">พร้อมรับฟังความคิดเห็นและข้อเสนอแนะจากคุณ</p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <div class="bg-gradient-to-br from-orange-50 to-pink-50 rounded-2xl border-2 border-orange-200 p-8 md:p-12 shadow-xl">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Contact Info -->
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="fas fa-envelope text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">อีเมล</h3>
                                    <a href="mailto:info@thonburi-culture.com" class="text-orange-600 hover:text-orange-700">
                                        info@thonburi-culture.com
                                    </a>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="fas fa-phone text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">โทรศัพท์</h3>
                                    <a href="tel:0812345678" class="text-blue-600 hover:text-blue-700">
                                        08-1234-5678
                                    </a>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="fab fa-line text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Line</h3>
                                    <a href="https://line.me/ti/p/@thonburi-culture" class="text-green-600 hover:text-green-700" target="_blank">
                                        @thonburi-culture
                                    </a>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="fab fa-facebook text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Facebook</h3>
                                    <a href="https://facebook.com/thonburi-culture" class="text-blue-600 hover:text-blue-700" target="_blank">
                                        Thonburi Culture
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA Button -->
                        <div class="flex flex-col justify-center items-center">
                            <div class="text-center mb-6">
                                <i class="fas fa-comments text-5xl text-orange-500 mb-4"></i>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">มีคำถามหรือข้อเสนอแนะ?</h3>
                                <p class="text-gray-600">เราพร้อมรับฟังและตอบคำถามของคุณ</p>
                            </div>
                            <a href="mailto:info@thonburi-culture.com" 
                               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-paper-plane text-xl"></i>
                                <span>ส่งข้อความถึงเรา</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- Footer CTA -->
<div class="bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500 py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            พร้อมสำรวจวัฒนธรรมธนบุรีแล้วหรือยัง?
        </h2>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            เริ่มต้นการเดินทางของคุณเพื่อค้นพบเรื่องราวทางวัฒนธรรมที่น่าสนใจ
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('cultural.explore') }}" 
               class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white hover:bg-gray-50 text-orange-600 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-compass text-xl"></i>
                <span>สำรวจวัฒนธรรม</span>
            </a>
            <a href="{{ route('activities') }}" 
               class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-transparent hover:bg-white/10 text-white border-2 border-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-calendar-alt text-xl"></i>
                <span>ดูกิจกรรม</span>
            </a>
        </div>
    </div>
</div>
@endsection