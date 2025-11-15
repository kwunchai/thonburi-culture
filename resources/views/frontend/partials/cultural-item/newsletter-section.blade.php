{{-- Newsletter Subscription Section --}}
<section class="relative overflow-hidden">
    <div class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 rounded-2xl p-8 md:p-12 text-white relative">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="20" cy="20" r="2"/></g></svg>'); background-size: 40px 40px;"></div>
        </div>
        
        <div class="relative max-w-3xl mx-auto text-center">
            {{-- Newsletter Icon --}}
            <div class="inline-flex w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl items-center justify-center mx-auto mb-8 shadow-lg">
                <i class="fas fa-envelope-open text-3xl"></i>
            </div>
            
            {{-- Newsletter Title --}}
            <h2 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                ติดตามเรื่องราววัฒนธรรม
            </h2>
            
            {{-- Newsletter Subtitle --}}
            <p class="text-xl text-white/90 mb-8 leading-relaxed max-w-2xl mx-auto">
                รับข่าวสารล่าสุดเกี่ยวกับภูมิปัญญาท้องถิ่น ประเพณีไทย และความรู้ทางวัฒนธรรมส่งตรงถึงคุณ
            </p>
            
            {{-- Newsletter Form --}}
            <form action="#" method="POST" class="max-w-lg mx-auto mb-8">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="email" 
                               name="email" 
                               placeholder="อีเมลของคุณ..." 
                               required
                               class="w-full px-6 py-4 rounded-xl text-gray-900 placeholder-gray-500 border-0 focus:ring-2 focus:ring-white/50 outline-none text-lg shadow-lg backdrop-blur-sm bg-white/95">
                    </div>
                    <button type="submit" 
                            class="bg-white text-orange-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl transform hover:scale-105 text-lg">
                        เริ่มติดตาม
                    </button>
                </div>
            </form>
            
            {{-- Features --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="flex items-center justify-center md:justify-start gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                    <span class="text-white/90">ส่งทุกสัปดาห์</span>
                </div>
                <div class="flex items-center justify-center md:justify-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                    <span class="text-white/90">ไม่มีสแปม</span>
                </div>
                <div class="flex items-center justify-center md:justify-end gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-gift text-sm"></i>
                    </div>
                    <span class="text-white/90">เนื้อหาพิเศษ</span>
                </div>
            </div>
            
            {{-- Privacy Notice --}}
            <p class="text-white/70 text-sm mb-8 max-w-2xl mx-auto">
                เราให้ความสำคัญกับความเป็นส่วนตัวของคุณ ข้อมูลของคุณจะถูกเก็บรักษาอย่างปลอดภัย และเราจะไม่แชร์ให้กับบุคคลที่สาม
                <a href="#" class="underline hover:no-underline">อ่านนโยบายความเป็นส่วนตัว</a>
            </p>
            
            {{-- Social Media Links --}}
            <div class="border-t border-white/20 pt-8">
                <p class="text-white/80 text-sm mb-4">หรือติดตามเราได้ที่</p>
                <div class="flex justify-center gap-4">
                    <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-200 transform hover:scale-110">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-200 transform hover:scale-110">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-200 transform hover:scale-110">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-200 transform hover:scale-110">
                        <i class="fab fa-line text-lg"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-200 transform hover:scale-110">
                        <i class="fab fa-youtube text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>