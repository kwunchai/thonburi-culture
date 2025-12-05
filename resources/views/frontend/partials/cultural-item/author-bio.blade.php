{{-- Author Bio Section --}}
@if($item->creator)
    <section class="py-8 border-t border-gray-200">
        <div class="bg-gray-50 rounded-xl p-8">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Author Avatar --}}
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-400 to-red-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">
                            {{ strtoupper(substr($item->creator->name, 0, 1)) }}
                        </span>
                    </div>
                </div>
                
                {{-- Author Info --}}
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $item->creator->name }}</h3>
                    
                    <p class="text-gray-600 mb-4">
                        ผู้จัดทำข้อมูลวัฒนธรรมท้องถิ่น มีความสนใจในการอนุรักษ์และเผยแพร่ภูมิปัญญาท้องถิ่นไทย 
                        เพื่อให้คนรุ่นใหม่ได้เรียนรู้และสืบทอดต่อไป
                    </p>
                    
                    {{-- Author Stats --}}
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            สมาชิกตั้งแต่ {{ $item->creator->created_at->format('M Y') }}
                        </span>
                        
                        <span class="flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            บทความโดย {{ $item->creator->name }}
                        </span>
                    </div>
                    
                    {{-- Contact Button --}}
                    <div class="mt-4">
                        <a href="#" onclick="showShareModal()" 
                           class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors text-sm font-medium">
                            <i class="fas fa-envelope mr-2"></i>
                            ติดต่อผู้เขียน
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif