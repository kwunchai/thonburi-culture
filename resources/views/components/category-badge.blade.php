@props([
    'category',
    'size' => 'md', // sm, md, lg
    'clickable' => true,
])

@php
    // Category color mapping
    $colorMap = [
        'อาหาร' => 'terra',
        'food' => 'terra',
        'ศิลปะ' => 'navy',
        'art' => 'navy',
        'การแสดง' => 'lotus',
        'performance' => 'lotus',
        'หัตถกรรม' => 'wood',
        'handicraft' => 'wood',
        'สถาปัตยกรรม' => 'gold',
        'architecture' => 'gold',
        'ประเพณี' => 'emerald',
        'tradition' => 'emerald',
        'เทศกาล' => 'lotus',
        'festival' => 'lotus',
        'วัด' => 'gold',
        'temple' => 'gold',
        'ชุมชน' => 'navy',
        'community' => 'navy',
    ];
    
    // Determine color based on category name or slug
    $categoryKey = strtolower($category->name_th ?? $category->slug ?? '');
    $colorTheme = 'gold'; // default
    
    foreach ($colorMap as $key => $color) {
        if (str_contains($categoryKey, $key)) {
            $colorTheme = $color;
            break;
        }
    }
    
    // Size classes
    $sizeClasses = [
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-4 py-2 text-base',
    ];
    
    // Color classes
    $colorClasses = [
        'gold' => 'bg-thonburi-gold-100 text-thonburi-gold-700 border-thonburi-gold-300 hover:bg-thonburi-gold-200',
        'navy' => 'bg-thonburi-navy-100 text-thonburi-navy-700 border-thonburi-navy-300 hover:bg-thonburi-navy-200',
        'terra' => 'bg-thonburi-terra-100 text-thonburi-terra-700 border-thonburi-terra-300 hover:bg-thonburi-terra-200',
        'wood' => 'bg-thonburi-wood-100 text-thonburi-wood-700 border-thonburi-wood-300 hover:bg-thonburi-wood-200',
        'emerald' => 'bg-thonburi-emerald-100 text-thonburi-emerald-700 border-thonburi-emerald-300 hover:bg-thonburi-emerald-200',
        'lotus' => 'bg-thonburi-lotus-100 text-thonburi-lotus-700 border-thonburi-lotus-300 hover:bg-thonburi-lotus-200',
    ];
    
    // Icon mapping
    $iconMap = [
        'อาหาร' => 'fa-utensils',
        'food' => 'fa-utensils',
        'ศิลปะ' => 'fa-palette',
        'art' => 'fa-palette',
        'การแสดง' => 'fa-masks-theater',
        'performance' => 'fa-masks-theater',
        'หัตถกรรม' => 'fa-hammer',
        'handicraft' => 'fa-hammer',
        'สถาปัตยกรรม' => 'fa-building',
        'architecture' => 'fa-building',
        'ประเพณี' => 'fa-hand-holding-heart',
        'tradition' => 'fa-hand-holding-heart',
        'เทศกาล' => 'fa-calendar-days',
        'festival' => 'fa-calendar-days',
        'วัด' => 'fa-gopuram',
        'temple' => 'fa-gopuram',
        'ชุมชน' => 'fa-users',
        'community' => 'fa-users',
    ];
    
    $icon = 'fa-tag'; // default
    foreach ($iconMap as $key => $ico) {
        if (str_contains($categoryKey, $key)) {
            $icon = $ico;
            break;
        }
    }
    
    $baseClasses = 'inline-flex items-center space-x-1.5 rounded-full font-medium border transition-all duration-200';
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $colorClass = $colorClasses[$colorTheme] ?? $colorClasses['gold'];
@endphp

@if($clickable)
    <a href="{{ route('cultural.explore', ['category' => $category->slug]) }}" 
       class="{{ $baseClasses }} {{ $sizeClass }} {{ $colorClass }} hover:scale-105">
        <i class="fas {{ $icon }}"></i>
        <span>{{ $category->name_th }}</span>
    </a>
@else
    <span class="{{ $baseClasses }} {{ $sizeClass }} {{ $colorClass }}">
        <i class="fas {{ $icon }}"></i>
        <span>{{ $category->name_th }}</span>
    </span>
@endif
