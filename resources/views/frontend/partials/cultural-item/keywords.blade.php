{{-- Keywords Section --}}
@if($item->keywords)
    <div class="bg-white rounded-lg shadow-sm p-6 mt-8">
        <h3 class="text-lg font-semibold mb-4 text-gray-900">
            <i class="fas fa-tags text-orange-500 mr-2"></i>คำสำคัญ
        </h3>
        <div class="flex flex-wrap gap-2">
            @foreach(explode(',', $item->keywords) as $keyword)
                <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm">
                    #{{ trim($keyword) }}
                </span>
            @endforeach
        </div>
    </div>
@endif