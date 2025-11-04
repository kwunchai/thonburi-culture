@extends('layouts.admin')

@section('title', 'จัดการทรัพย์สินทางปัญญา')
@section('header', 'จัดการทรัพย์สินทางปัญญา')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_items'] }}</h3>
                <p>ทรัพย์สินทางปัญญาทั้งหมด</p>
            </div>
            <div class="icon">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['active_items'] }}</h3>
                <p>สถานะใช้งาน</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['registered_items'] }}</h3>
                <p>ลงทะเบียนแล้ว</p>
            </div>
            <div class="icon">
                <i class="fas fa-certificate"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending_items'] }}</h3>
                <p>รอการอนุมัติ</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
</div>

<!-- Type Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $stats['copyright_items'] }}</h3>
                <p>ลิขสิทธิ์</p>
            </div>
            <div class="icon">
                <i class="fas fa-copyright"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-teal">
            <div class="inner">
                <h3>{{ $stats['patent_items'] }}</h3>
                <p>สิทธิบัตร</p>
            </div>
            <div class="icon">
                <i class="fas fa-lightbulb"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ $stats['trademark_items'] }}</h3>
                <p>เครื่องหมายการค้า</p>
            </div>
            <div class="icon">
                <i class="fas fa-trademark"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-indigo">
            <div class="inner">
                <h3>{{ $stats['local_wisdom_items'] }}</h3>
                <p>ภูมิปัญญาท้องถิ่น</p>
            </div>
            <div class="icon">
                <i class="fas fa-leaf"></i>
            </div>
        </div>
    </div>
</div>

<!-- Additional Statistics -->
<div class="row mb-4">
    <div class="col-lg-4 col-12">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $stats['with_registration'] }}</h3>
                <p>มีเลขทะเบียน</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['expired_items'] }}</h3>
                <p>หมดอายุแล้ว</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3>{{ $stats['expiring_soon'] }}</h3>
                <p>ใกล้หมดอายุ (30 วัน)</p>
            </div>
            <div class="icon">
                <i class="fas fa-bell"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="mb-4">
    <form method="GET" action="{{ route('admin.ip.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="ค้นหาชื่อ, เลขทะเบียน..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-control" onchange="this.form.submit()">
                        <option value="">ทุกประเภท</option>
                        @foreach(\App\Enums\IpType::cases() as $type)
                            <option value="{{ $type->value }}" {{ request('type') == $type->value ? 'selected' : '' }}>
                                {{ $type->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">ทุกสถานะ</option>
                        @foreach(\App\Enums\IpStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order" class="form-control" onchange="this.form.submit()">
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>ใหม่→เก่า</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>เก่า→ใหม่</option>
                    </select>
                </div>
                @if(request('search') || request('type') || request('status') || request('order') != 'desc')
                <div class="col-md-2">
                    <a href="{{ route('admin.ip.index') }}" class="btn btn-default btn-block">
                        <i class="fas fa-times"></i> ล้างการค้นหา
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Header Section -->
    <div class="row align-items-center mb-3">
        <div class="col-md-6">
            <h3 class="mb-0">
                <i class="fas fa-shield-alt"></i> รายการทรัพย์สินทางปัญญา
                @if(request('search'))
                    <small class="text-muted">(ผลการค้นหา: "{{ request('search') }}")</small>
                @endif
            </h3>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.ip.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> เพิ่มข้อมูลใหม่
            </a>
            <a href="{{ route('admin.ip.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Data Table -->
    @if($items->count() > 0)
        <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 120px;">เลขทะเบียน</th>
                            <th>ชื่อเรื่อง</th>
                            <th style="width: 100px;">ประเภท</th>
                            <th style="width: 100px;">สถานะ</th>
                            <th style="width: 100px;">วันที่ลงทะเบียน</th>
                            <th style="width: 120px;" class="text-center">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ $item->registration_number ?: 'ยังไม่มี' }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $item->title }}</strong>
                                    @if($item->description)
                                        <br>
                                        <small class="text-muted">
                                            {{ Str::limit($item->description, 80) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($item->type)
                                            @case('copyright') badge-info @break
                                            @case('invention_patent') badge-success @break
                                            @case('trademark') badge-warning @break
                                            @case('tk') badge-primary @break
                                            @case('petty_patent') badge-success @break
                                            @case('design_patent') badge-success @break
                                            @case('gi') badge-info @break
                                            @default badge-secondary
                                        @endswitch
                                    ">
                                        {{ $item->type_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($item->status)
                                            @case('registered') badge-success @break
                                            @case('submitted') badge-warning @break
                                            @case('under_review') badge-info @break
                                            @case('expired') badge-danger @break
                                            @case('draft') badge-secondary @break
                                            @case('rejected') badge-danger @break
                                            @default badge-light
                                        @endswitch
                                    ">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->registration_date)
                                        {{ $item->registration_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.ip.edit', $item->ip_id) }}" 
                                           class="btn btn-warning btn-xs" title="แก้ไข">
                                            <i class="fas fa-edit fa-sm"></i>
                                        </a>
                                        <form action="{{ route('admin.ip.destroy', $item->ip_id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('ยืนยันการลบข้อมูลนี้?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs" title="ลบ">
                                                <i class="fas fa-trash fa-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-2x text-muted"></i>
                </div>
                <h5 class="text-muted">ไม่พบข้อมูลทรัพย์สินทางปัญญา</h5>
                @if(request('search'))
                    <p class="text-muted mb-3">ไม่พบผลการค้นหาสำหรับ "{{ request('search') }}"</p>
                    <a href="{{ route('admin.ip.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> กลับไปดูทั้งหมด
                    </a>
                @else
                    <p class="text-muted mb-3">เริ่มต้นด้วยการเพิ่มทรัพย์สินทางปัญญาแรกของคุณ</p>
                    <a href="{{ route('admin.ip.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> เพิ่มทรัพย์สินทางปัญญา
                    </a>
                @endif
            </div>
        @endif

        <!-- Pagination -->
        @if($items->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <small class="text-muted">
                        แสดง {{ $items->firstItem() }}-{{ $items->lastItem() }} 
                        จากทั้งหมด {{ $items->total() }} รายการ
                    </small>
                </div>
                <div>
                    {{ $items->links('pagination.custom') }}
                </div>
            </div>
        @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif
@endsection
