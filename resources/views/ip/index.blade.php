@extends('layouts.frontend')
@section('title','ทรัพย์สินทางปัญญา')

@section('content')
<section class="mx-auto max-w-7xl px-4 lg:px-6 py-8 space-y-6">
  <div class="flex items-end justify-between gap-3 flex-wrap">
    <div>
      <h1 class="text-2xl font-semibold">ทรัพย์สินทางปัญญา</h1>
      <p class="text-slate-600 text-sm">ค้นหา/กรองตาม ประเภท, สถานะ, ปีงบประมาณ</p>
    </div>
    <form method="get" class="flex gap-2">
      <input type="search" name="q" value="{{ request('q') }}" placeholder="ค้นหา..."
             class="input input-bordered px-3 py-2 rounded-lg border" />
      <select name="type" class="px-3 py-2 rounded-lg border">
        <option value="">ทุกประเภท</option>
        @foreach($types as $t)
          <option value="{{ $t }}" @selected(request('type')===$t)>{{ $t }}</option>
        @endforeach
      </select>
      <select name="status" class="px-3 py-2 rounded-lg border">
        <option value="">ทุกสถานะ</option>
        @foreach($statuses as $s)
          <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
        @endforeach
      </select>
      <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">กรอง</button>
    </form>
  </div>

  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($items as $ip)
      <a href="{{ route('ip.public.show', $ip->ip_id) }}" class="block rounded-xl border bg-white p-4 hover:shadow">
        <div class="text-xs text-slate-500">{{ $ip->registration_number ?? '—' }}</div>
        <h3 class="mt-1 font-semibold line-clamp-2">{{ $ip->title }}</h3>
        <div class="mt-2 flex items-center gap-2 text-sm">
          <span class="px-2 py-0.5 rounded bg-slate-100">{{ $ip->type }}</span>
          @if($ip->status)
          <span class="px-2 py-0.5 rounded bg-emerald-100">{{ $ip->status }}</span>
          @endif
        </div>
        <div class="mt-2 text-sm text-slate-600 line-clamp-2">{{ Str::limit($ip->description, 100) }}</div>
      </a>
    @empty
      <div class="col-span-full text-slate-500">ไม่พบข้อมูล</div>
    @endforelse
  </div>

  <div>{{ $items->links() }}</div>
</section>
@endsection
