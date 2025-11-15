{{-- Newsletter Subscription Section --}}
<section class="py-12 border-t border-gray-200">
    <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-8 md:p-12 text-white text-center">
        <div class="max-w-2xl mx-auto">
            {{-- Newsletter Icon --}}
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-envelope text-2xl"></i>
            </div>
            
            {{-- Newsletter Title --}}
            <h2 class="text-2xl md:text-3xl font-bold mb-4">
                รับข่าวสารวัฒนธรรมไทย
            </h2>
            
            {{-- Newsletter Description --}}
            <p class="text-white/90 text-lg mb-8">
                สมัครรับจดหมายข่าวเพื่อติดตามเรื่องราววัฒนธรรมใหม่ๆ และข้อมูลภูมิปัญญาท้องถิ่นล่าสุด
            </p>
            
            {{-- Newsletter Form --}}
            <form action="#" method="POST" class="max-w-md mx-auto">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="email" 
                           name="email" 
                           placeholder="กรุณาใส่อีเมลของคุณ" 
                           required
                           class="flex-1 px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500 border-0 focus:ring-2 focus:ring-white/50 outline-none">
                    
                    <button type="submit" 
                            class="bg-white text-orange-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors whitespace-nowrap">
                        สมัครสมาชิก
                    </button>
                </div>
                
                {{-- Privacy Notice --}}
                <p class="text-white/70 text-sm mt-4">
                    เราให้ความสำคัญกับความเป็นส่วนตัวของคุณ และจะไม่แชร์อีเมลให้กับบุคคลที่สาม
                </p>
            </form>
            
            {{-- Social Media Links --}}
            <div class="flex justify-center gap-4 mt-8 pt-8 border-t border-white/20">
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fab fa-line"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
</section>