@extends('layouts.app')
@section('title',$ip->title)

@section('content')
<section class="mx-auto max-w-4xl px-4 lg:px-6 py-8 space-y-4">
  <nav class="text-sm text-slate-500"><a href="{{ route('ip.index') }}" class="hover:underline">ทรัพย์สินทางปัญญา</a> › รายการ</nav>

  <div class="rounded-2xl border bg-white p-6 space-y-3">
    <div class="text-xs text-slate-500">เลขที่คำขอ: {{ $ip->application_no ?? '—' }}</div>
    <h1 class="text-2xl font-semibold">{{ $ip->title }}</h1>
    <div class="flex flex-wrap gap-2">
      <span class="px-2 py-0.5 rounded bg-slate-100">{{ $ip->type }}</span>
      @if($ip->status)<span class="px-2 py-0.5 rounded bg-emerald-100">{{ $ip->status }}</span>@endif
      @if($ip->budget_year)<span class="px-2 py-0.5 rounded bg-sky-100">ปี {{ $ip->budget_year }}</span>@endif
    </div>

    <dl class="grid sm:grid-cols-2 gap-3 text-sm">
      <div><dt class="text-slate-500">ผู้ขอ</dt><dd>{{ $ip->applicant_name ?? '—' }}</dd></div>
      <div><dt class="text-slate-500">คณะ</dt><dd>{{ $ip->faculty ?? '—' }}</dd></div>
      <div class="sm:col-span-2"><dt class="text-slate-500">ชื่องานวิจัย</dt><dd>{{ $ip->research_title ?? '—' }}</dd></div>
      <div><dt class="text-slate-500">แหล่งทุน</dt><dd>{{ $ip->funding_source ?? '—' }}</dd></div>
      <div><dt class="text-slate-500">ผู้ยื่น</dt><dd>{{ $ip->submitter_name ?? '—' }}</dd></div>
      <div><dt class="text-slate-500">เลขใบรับรอง</dt><dd>{{ $ip->certificate_no ?? '—' }}</dd></div>
      <div><dt class="text-slate-500">ไฟล์ใบรับรอง</dt>
        <dd>
        @if($ip->certificate_path)
          <a class="text-indigo-600 hover:underline" href="{{ asset('storage/'.$ip->certificate_path) }}" target="_blank">เปิดไฟล์</a>
        @else — @endif
        </dd>
      </div>
    </dl>

    @if($ip->remark)
    <div class="pt-3 border-t text-sm"><span class="text-slate-500">หมายเหตุ:</span> {{ $ip->remark }}</div>
    @endif
  </div>
</section>
@endsection
