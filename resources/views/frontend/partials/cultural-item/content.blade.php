{{-- Main Content Section --}}
<main class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- Content Area --}}
            <div class="lg:col-span-3">
                @include('frontend.partials.cultural-item.featured-image')
                @include('frontend.partials.cultural-item.article')
                @include('frontend.partials.cultural-item.keywords')
            </div>
            
            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
                @include('frontend.partials.cultural-item.details')
                @include('frontend.partials.cultural-item.map')
                @include('frontend.partials.cultural-item.related-items')
            </aside>
            
        </div>
    </div>
</main>