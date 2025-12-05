{{-- Modern Featured Image --}}
@if($item->image)
    <div class="mb-8">
        <figure class="relative overflow-hidden rounded-2xl shadow-xl">
            <img src="{{ asset('storage/' . $item->image) }}" 
                 alt="{{ $item->title }}" 
                 class="w-full h-96 md:h-[500px] object-cover">
            
            {{-- Image Overlay with Caption (if needed) --}}
            <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6 text-white">
                <p class="text-sm opacity-90">{{ $item->title }}</p>
            </figcaption>
        </figure>
    </div>
@endif