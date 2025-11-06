@extends('layouts.frontend')

@section('title', $item->title)

@section('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
    <meta property="og:title" content="{{ $item->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($item->description), 160) }}">
    @if($item->image)
        <meta property="og:image" content="{{ asset('storage/' . $item->image) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
    @include('frontend.partials.cultural-item.header')
    @include('frontend.partials.cultural-item.content')
    @include('frontend.partials.cultural-item.share-modal')
@endsection

@push('scripts')
    @include('frontend.partials.cultural-item.scripts')
@endpush

@push('styles')
    @include('frontend.partials.cultural-item.styles')
@endpush