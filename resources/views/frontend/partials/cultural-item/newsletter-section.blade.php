{{-- Newsletter Section (Home Page Style) --}}
<div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-xl p-8 text-white text-center">
    <div class="max-w-2xl mx-auto">
        {{-- Icon --}}
        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-envelope text-3xl"></i>
        </div>
        
        {{-- Heading --}}
        <h3 class="text-2xl md:text-3xl font-bold mb-4">ติดตามข่าวสารวัฒนธรรมไทย</h3>
        <p class="text-lg opacity-90 mb-8">
            รับข้อมูลล่าสุดเกี่ยวกับมรดกทางวัฒนธรรม และกิจกรรมพิเศษ ส่งตรงถึงอีเมลของคุณ
        </p>
        
        {{-- Newsletter Form --}}
        <form onsubmit="subscribeNewsletter(event)" class="max-w-md mx-auto">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="email" 
                       placeholder="กรอกอีเมลของคุณ"
                       class="flex-1 px-4 py-3 rounded-lg text-gray-800 placeholder-gray-500 border-0 focus:outline-none focus:ring-2 focus:ring-white/50"
                       required>
                <button type="submit" 
                        class="px-6 py-3 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors whitespace-nowrap">
                    สมัครรับข่าวสาร
                </button>
            </div>
            <p class="text-sm opacity-80 mt-3">
                เราจะไม่ส่งข้อมูลของคุณให้ผู้อื่น และคุณสามารถยกเลิกได้ตลอดเวลา
            </p>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        function subscribeNewsletter(event) {
            event.preventDefault();
            const email = event.target.querySelector('input[type="email"]').value;
            
            // Show success message (you can implement actual subscription logic here)
            alert('ขอบคุณสำหรับการสมัครรับข่าวสาร! เราจะส่งข้อมูลล่าสุดให้คุณเร็วๆ นี้');
            event.target.reset();
        }
    </script>
@endpush
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