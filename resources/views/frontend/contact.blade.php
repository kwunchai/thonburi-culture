@extends('layouts.frontend')

@section('title', 'ติดต่อเรา')

@section('content')
<div class="bg-gradient-to-r from-orange-500 to-orange-600 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">ติดต่อเรา</h1>
        <p class="text-xl text-white/90">ติดต่อสอบถามข้อมูลเพิ่มเติม</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">ส่งข้อความถึงเรา</h2>
                
                <form action="#" method="POST">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-2">ชื่อ-นามสกุล</label>
                            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-orange-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">อีเมล</label>
                            <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-orange-500" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">หัวข้อ</label>
                        <input type="text" name="subject" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-orange-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">ข้อความ</label>
                        <textarea name="message" rows="5" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-orange-500" required></textarea>
                    </div>
                    
                    <button type="submit" class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>ส่งข้อความ
                    </button>
                </form>
            </div>
        </div>
        
        <div>
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <h3 class="text-xl font-bold mb-4">ข้อมูลติดต่อ</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-orange-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-semibold">ที่อยู่</p>
                            <p class="text-gray-600">เขตธนบุรี กรุงเทพมหานคร 10600</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-phone text-orange-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-semibold">โทรศัพท์</p>
                            <p class="text-gray-600">02-XXX-XXXX</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-orange-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-semibold">อีเมล</p>
                            <p class="text-gray-600">info@thonburi-culture.go.th</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-xl font-bold mb-4">เวลาทำการ</h3>
                
                <div class="space-y-2 text-gray-600">
                    <div class="flex justify-between">
                        <span>จันทร์ - ศุกร์</span>
                        <span>08:30 - 16:30 น.</span>
                    </div>
                    <div class="flex justify-between">
                        <span>เสาร์ - อาทิตย์</span>
                        <span>ปิดทำการ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31006.11844937!2d100.47247!3d13.7263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2991a19b1b707%3A0x40056b34e3d9f70!2sThon%20Buri%2C%20Bangkok!5e0!3m2!1sen!2sth!4v1234567890"
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>
@endsection