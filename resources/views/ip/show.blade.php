@extends('layouts.frontend')
@section('title', $ip->title . ' - ทรัพย์สินทางปัญญา')

@section('content')
<section class="max-w-5xl mx-auto px-4 lg:px-6 py-8 mt-4">
    <!-- Breadcrumb -->
    <nav class="text-sm text-neutral-text-secondary mb-6 bg-white px-4 py-3 rounded-lg shadow-sm">
        <a href="{{ route('home') }}" class="hover:text-thonburi-gold-600 font-medium">หน้าแรก</a>
        <span class="mx-2 text-neutral-border">/</span>
        <a href="{{ route('ip.public.index') }}" class="hover:text-thonburi-gold-600 font-medium">ทรัพย์สินทางปัญญา</a>
        <span class="mx-2 text-neutral-border">/</span>
        <span class="text-neutral-text-primary font-semibold">{{ $ip->title }}</span>
    </nav>

    <!-- Main Content -->
    <article class="bg-white rounded-2xl shadow-heritage overflow-hidden border border-neutral-border-light">
        <!-- Header -->
        <div class="bg-gradient-to-r from-thonburi-river-600 to-thonburi-river-700 px-6 py-8 md:px-8 md:py-10">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-white text-thonburi-river-700 shadow-lg">
                            <i class="fas fa-copyright mr-2 text-base"></i>
                            {{ ucfirst($ip->type) }}
                        </span>
                        @if($ip->status)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-thonburi-emerald-500 text-white shadow-lg">
                            <i class="fas fa-check-circle mr-2 text-base"></i>
                            {{ ucfirst($ip->status) }}
                        </span>
                        @endif
                    </div>
                    <h1 class="text-3xl md:text-4xl font-display font-bold leading-tight text-white drop-shadow-md">
                        {{ $ip->title }}
                    </h1>
                </div>
            </div>
            
            @if($ip->registration_number)
            <div class="flex items-center bg-white/15 backdrop-blur-sm rounded-xl px-5 py-4 mt-4 border border-white/20">
                <i class="fas fa-file-certificate mr-3 text-thonburi-gold-300 text-xl"></i>
                <span class="text-base text-white font-medium">
                    เลขที่จดทะเบียน: 
                    <strong class="text-thonburi-gold-300 text-lg ml-1">{{ $ip->registration_number }}</strong>
                </span>
            </div>
            @endif
        </div>

        <!-- Body -->
        <div class="px-6 py-8 md:px-8 md:py-10 space-y-8">
            <!-- Registration Details -->
            @if($ip->registration_date || $ip->expiry_date)
            <div class="grid md:grid-cols-2 gap-6 p-6 bg-thonburi-sand-50 rounded-xl border border-thonburi-sand-200">
                @if($ip->registration_date)
                <div>
                    <h3 class="text-sm font-semibold text-neutral-text-secondary mb-1">
                        <i class="fas fa-calendar-check text-thonburi-gold-600 mr-2"></i>
                        วันที่จดทะเบียน
                    </h3>
                    <p class="text-lg font-medium text-neutral-text-primary">
                        {{ $ip->registration_date->locale('th')->translatedFormat('j F Y') }}
                    </p>
                </div>
                @endif
                
                @if($ip->expiry_date)
                <div>
                    <h3 class="text-sm font-semibold text-neutral-text-secondary mb-1">
                        <i class="fas fa-calendar-times text-thonburi-terra-600 mr-2"></i>
                        วันหมดอายุ
                    </h3>
                    <p class="text-lg font-medium text-neutral-text-primary">
                        {{ $ip->expiry_date->locale('th')->translatedFormat('j F Y') }}
                    </p>
                </div>
                @endif
            </div>
            @endif

            <!-- Description -->
            <div>
                <h2 class="text-xl font-display font-semibold text-neutral-text-primary mb-4 flex items-center">
                    <span class="w-1 h-6 bg-thonburi-gold-500 rounded-full mr-3"></span>
                    รายละเอียด
                </h2>
                <div class="prose prose-lg max-w-none text-neutral-text-secondary leading-relaxed">
                    {!! nl2br(e($ip->description)) !!}
                </div>
            </div>

            <!-- Metadata -->
            @if($ip->metadata && is_array($ip->metadata) && count($ip->metadata) > 0)
            <div>
                <h2 class="text-xl font-display font-semibold text-neutral-text-primary mb-4 flex items-center">
                    <span class="w-1 h-6 bg-thonburi-gold-500 rounded-full mr-3"></span>
                    ข้อมูลเพิ่มเติม
                </h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach($ip->metadata as $key => $value)
                    <div class="p-4 bg-neutral-bg-secondary rounded-lg border border-neutral-border">
                        <dt class="text-sm font-medium text-neutral-text-secondary mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                        <dd class="text-base text-neutral-text-primary">
                            @if(is_array($value))
                                {{ implode(', ', $value) }}
                            @else
                                {{ $value }}
                            @endif
                        </dd>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Attachments -->
            @if($ip->attachments && is_array($ip->attachments) && count($ip->attachments) > 0)
            <div>
                <h2 class="text-xl font-display font-semibold text-neutral-text-primary mb-4 flex items-center">
                    <span class="w-1 h-6 bg-thonburi-gold-500 rounded-full mr-3"></span>
                    เอกสารแนบ
                </h2>
                <div class="space-y-2">
                    @foreach($ip->attachments as $attachment)
                    <a href="{{ Storage::url($attachment) }}" 
                       target="_blank"
                       class="flex items-center p-4 bg-white border border-neutral-border rounded-lg hover:border-thonburi-gold-500 hover:bg-thonburi-sand-50 transition-all group">
                        <i class="fas fa-file-pdf text-2xl text-thonburi-terra-600 mr-4"></i>
                        <div class="flex-1">
                            <p class="font-medium text-neutral-text-primary group-hover:text-thonburi-gold-700">
                                {{ basename($attachment) }}
                            </p>
                        </div>
                        <i class="fas fa-external-link-alt text-neutral-text-tertiary group-hover:text-thonburi-gold-600"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Owner Info -->
            @if($ip->owner)
            <div class="border-t border-neutral-border pt-6">
                <h3 class="text-sm font-semibold text-neutral-text-secondary mb-3">
                    <i class="fas fa-user text-thonburi-river-600 mr-2"></i>
                    เจ้าของทรัพย์สินทางปัญญา
                </h3>
                <p class="text-base text-neutral-text-primary">{{ $ip->owner->name ?? 'ไม่ระบุ' }}</p>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="flex flex-wrap gap-6 text-sm text-neutral-text-tertiary border-t border-neutral-border pt-6">
                <div>
                    <i class="fas fa-clock mr-1.5"></i>
                    สร้างเมื่อ: {{ $ip->created_at->locale('th')->translatedFormat('j M Y, H:i น.') }}
                </div>
                @if($ip->updated_at && !$ip->created_at->eq($ip->updated_at))
                <div>
                    <i class="fas fa-sync mr-1.5"></i>
                    อัปเดตล่าสุด: {{ $ip->updated_at->locale('th')->translatedFormat('j M Y, H:i น.') }}
                </div>
                @endif
            </div>
        </div>
    </article>

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('ip.public.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-white border-2 border-thonburi-river-600 text-thonburi-river-600 font-medium rounded-lg hover:bg-thonburi-river-600 hover:text-white transition-all shadow-sm hover:shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>
            กลับไปหน้ารายการ
        </a>
    </div>
</section>
@endsection
