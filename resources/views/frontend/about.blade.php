@extends('layouts.frontend')

@section('title', 'เกี่ยวกับเรา')

@section('content')
<div class="bg-gradient-to-r from-orange-500 to-orange-600 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">เกี่ยวกับเรา</h1>
        <p class="text-xl text-white/90">รู้จักกับโครงการวัฒนธรรมเขตธนบุรี</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">โครงการวัฒนธรรมเขตธนบุรี</h2>
        
        <div class="prose max-w-none">
            <p class="mb-4">
                เว็บไซต์วัฒนธรรมเขตธนบุรีเป็นโครงการที่จัดทำขึ้นเพื่อรวบรวม อนุรักษ์ และเผยแพร่ข้อมูลทางวัฒนธรรม 
                ประเพณี ศิลปะ และวิถีชีวิตของชุมชนต่างๆ ในเขตธนบุรี กรุงเทพมหานคร
            </p>
            
            <h3 class="text-xl font-semibold mt-6 mb-3">วัตถุประสงค์</h3>
            <ul class="list-disc list-inside space-y-2 mb-6">
                <li>เพื่อเป็นแหล่งรวบรวมข้อมูลทางวัฒนธรรมของเขตธนบุรี</li>
                <li>เพื่อส่งเสริมการเรียนรู้และความเข้าใจในวัฒนธรรมท้องถิ่น</li>
                <li>เพื่ออนุรักษ์และสืบสานมรดกทางวัฒนธรรมให้คงอยู่สืบไป</li>
                <li>เพื่อส่งเสริมการท่องเที่ยวเชิงวัฒนธรรมในเขตธนบุรี</li>
            </ul>
            
            <h3 class="text-xl font-semibold mb-3">พื้นที่ดำเนินการ</h3>
            <p class="mb-4">
                เขตธนบุรีเป็นพื้นที่ที่มีประวัติศาสตร์ยาวนาน เคยเป็นราชธานีของไทยในสมัยกรุงธนบุรี 
                ปัจจุบันยังคงมีชุมชนเก่าแก่ วัด และสถานที่สำคัญทางประวัติศาสตร์มากมาย
            </p>
            
            <div class="grid md:grid-cols-2 gap-6 mt-8">
                <div class="bg-orange-50 rounded-lg p-6">
                    <h4 class="font-semibold text-orange-600 mb-3">ชุมชนที่ร่วมโครงการ</h4>
                    <ul class="space-y-1 text-sm">
                        <li>• ชุมชนกุฎีจีน</li>
                        <li>• ชุมชนวัดกัลยาณ์</li>
                        <li>• ชุมชนวัดอรุณ</li>
                        <li>• ชุมชนตลาดพลู</li>
                        <li>• ชุมชนคลองบางกอกใหญ่</li>
                        <li>• ชุมชนวัดราชโอรส</li>
                    </ul>
                </div>
                
                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-semibold text-blue-600 mb-3">หมวดหมู่วัฒนธรรม</h4>
                    <ul class="space-y-1 text-sm">
                        <li>• ประวัติศาสตร์</li>
                        <li>• ศิลปะพื้นบ้าน</li>
                        <li>• อาหารท้องถิ่น</li>
                        <li>• เทศกาลและประเพณี</li>
                        <li>• วัดและศาสนสถาน</li>
                        <li>• วิถีชีวิตริมน้ำ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection