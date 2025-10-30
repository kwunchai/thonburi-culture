@extends('layouts.admin')

@section('title', 'จัดการทรัพย์สินทางปัญญา')
@section('header', 'จัดการทรัพย์สินทางปัญญา')

@section('content')
<!-- Action Bar -->
<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="{{ route('admin.ip.index') }}" class="d-flex">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" 
                       placeholder="ค้นหาชื่อ, เลขที่ลงทะเบียน, คำอธิบาย...">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
                @if(request('q'))
                    <a href="{{ route('admin.ip.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times fa-sm"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('admin.ip.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> เพิ่มทรัพย์สินทางปัญญา
        </a>
    </div>
</div>

<!-- Main Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shield-alt mr-2"></i> 
            รายการทรัพย์สินทางปัญญา
            @if(request('q'))
                <small class="text-muted">(ผลการค้นหา: "{{ request('q') }}")</small>
            @endif
        </h3>
    </div>
    
    <div class="card-body p-0">
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
                                            @case('patent') badge-success @break
                                            @case('trademark') badge-warning @break
                                            @case('local_wisdom') badge-primary @break
                                            @case('trade_secret') badge-dark @break
                                            @default badge-secondary
                                        @endswitch
                                    ">
                                        {{ $item->type_name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($item->status)
                                            @case('active') badge-success @break
                                            @case('registered') badge-primary @break
                                            @case('pending') badge-warning @break
                                            @case('expired') badge-danger @break
                                            @case('draft') badge-secondary @break
                                            @default badge-light
                                        @endswitch
                                    ">
                                        {{ $item->status_name }}
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
                @if(request('q'))
                    <p class="text-muted mb-3">ไม่พบผลการค้นหาสำหรับ "{{ request('q') }}"</p>
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
    </div>
    
    @if($items->hasPages())
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        แสดง {{ $items->firstItem() }}-{{ $items->lastItem() }} 
                        จากทั้งหมด {{ $items->total() }} รายการ
                    </small>
                </div>
                <div class="col-md-6">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif
@endsection
