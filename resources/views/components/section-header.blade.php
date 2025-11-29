@props([
    'title',
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'gold', // gold, navy, terra, emerald, lotus, wood
    'align' => 'center', // center, left
    'size' => 'lg', // sm, md, lg, xl
])

@php
    // Alignment classes
    $alignClass = $align === 'center' ? 'text-center' : 'text-left';
    
    // Icon color mapping
    $iconColorClasses = [
        'gold' => 'from-thonburi-gold-400 to-thonburi-gold-600',
        'navy' => 'from-thonburi-navy-400 to-thonburi-navy-600',
        'terra' => 'from-thonburi-terra-400 to-thonburi-terra-600',
        'emerald' => 'from-thonburi-emerald-400 to-thonburi-emerald-600',
        'lotus' => 'from-thonburi-lotus-400 to-thonburi-lotus-600',
        'wood' => 'from-thonburi-wood-400 to-thonburi-wood-600',
    ];
    
    $iconBgClass = $iconColorClasses[$iconColor] ?? $iconColorClasses['gold'];
    
    // Underline color mapping
    $underlineColorClasses = [
        'gold' => 'from-thonburi-gold-400 to-thonburi-gold-600',
        'navy' => 'from-thonburi-navy-400 to-thonburi-navy-600',
        'terra' => 'from-thonburi-terra-400 to-thonburi-terra-600',
        'emerald' => 'from-thonburi-emerald-400 to-thonburi-emerald-600',
        'lotus' => 'from-thonburi-lotus-400 to-thonburi-lotus-600',
        'wood' => 'from-thonburi-wood-400 to-thonburi-wood-600',
    ];
    
    $underlineClass = $underlineColorClasses[$iconColor] ?? $underlineColorClasses['gold'];
    
    // Size classes for title
    $titleSizeClasses = [
        'sm' => 'text-2xl md:text-3xl',
        'md' => 'text-3xl md:text-4xl',
        'lg' => 'text-4xl md:text-5xl',
        'xl' => 'text-5xl md:text-6xl',
    ];
    
    $titleSizeClass = $titleSizeClasses[$size] ?? $titleSizeClasses['lg'];
@endphp

<div class="mb-8 lg:mb-12 {{ $alignClass }}">
    
    <!-- Icon (if provided) -->
    @if($icon)
    <div class="{{ $align === 'center' ? 'inline-flex' : 'flex' }} items-center justify-center w-16 h-16 bg-gradient-to-br {{ $iconBgClass }} rounded-2xl shadow-lg mb-4">
        <i class="fas {{ $icon }} text-2xl text-white"></i>
    </div>
    @endif
    
    <!-- Title -->
    <h2 class="{{ $titleSizeClass }} font-bold text-gray-900 mb-3 font-display">
        {{ $title }}
    </h2>
    
    <!-- Decorative underline -->
    <div class="w-24 h-1 bg-gradient-to-r {{ $underlineClass }} {{ $align === 'center' ? 'mx-auto' : '' }} rounded-full mb-4"></div>
    
    <!-- Subtitle (if provided) -->
    @if($subtitle)
    <p class="text-gray-600 {{ $size === 'xl' ? 'text-xl' : ($size === 'lg' ? 'text-lg' : 'text-base') }} max-w-3xl {{ $align === 'center' ? 'mx-auto' : '' }}">
        {{ $subtitle }}
    </p>
    @endif
    
    <!-- Slot for additional content -->
    @if(isset($slot) && !empty(trim($slot)))
    <div class="mt-4">
        {{ $slot }}
    </div>
    @endif
    
</div>
