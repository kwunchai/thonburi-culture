{{-- Item Details Card --}}
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-900">
        <i class="fas fa-info-circle text-blue-500 mr-2"></i>รายละเอียด
    </h3>
    <div class="space-y-4">
        @if($item->category)
            <div class="border-b border-gray-100 pb-3">
                <label class="text-sm font-medium text-gray-500">หมวดหมู่</label>
                <p class="text-gray-900">{{ $item->category->name }}</p>
            </div>
        @endif
        
        @if($item->community)
            <div class="border-b border-gray-100 pb-3">
                <label class="text-sm font-medium text-gray-500">ชุมชน</label>
                <p class="text-gray-900">{{ $item->community->name }}</p>
            </div>
        @endif
        
        @if($item->place)
            <div class="border-b border-gray-100 pb-3">
                <label class="text-sm font-medium text-gray-500">สถานที่</label>
                <p class="text-gray-900">{{ $item->place->name }}</p>
            </div>
        @endif
        
        <div>
            <label class="text-sm font-medium text-gray-500">วันที่เผยแพร่</label>
            <p class="text-gray-900">{{ $item->publish_date->format('d M Y') }}</p>
        </div>
    </div>
</div>