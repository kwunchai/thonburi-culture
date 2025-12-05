{{-- Featured Image --}}
@if($item->image)
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
        <img src="{{ asset('storage/' . $item->image) }}" 
             alt="{{ $item->title }}" 
             class="w-full h-80 object-cover">
    </div>
@endif