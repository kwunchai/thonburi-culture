@extends('layouts.admin')

@section('title', 'จัดการสิทธิ์ผู้ใช้งาน')
@section('header', 'จัดการสิทธิ์ผู้ใช้งาน')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>ผู้ใช้งานทั้งหมด</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['admin_users'] }}</h3>
                <p>ผู้ดูแลระบบ</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['editor_users'] }}</h3>
                <p>บรรณาธิการ</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-edit"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $stats['ip_manager_users'] }}</h3>
                <p>ผู้จัดการ IP</p>
            </div>
            <div class="icon">
                <i class="fas fa-certificate"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-6 col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['verified_users'] }}</h3>
                <p>ยืนยันแล้ว</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $stats['viewer_users'] }}</h3>
                <p>ผู้ดู</p>
            </div>
            <div class="icon">
                <i class="fas fa-eye"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-search"></i> ค้นหาและกรองข้อมูล
        </h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>ค้นหา</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="ชื่อ หรือ Email" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>บทบาท</label>
                        <select name="role" class="form-control">
                            <option value="">ทั้งหมด</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ</option>
                            <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>บรรณาธิการ</option>
                            <option value="ip_manager" {{ request('role') == 'ip_manager' ? 'selected' : '' }}>ผู้จัดการ IP</option>
                            <option value="viewer" {{ request('role') == 'viewer' ? 'selected' : '' }}>ผู้ดู</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>เรียงลำดับ</label>
                        <select name="order" class="form-control">
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>ใหม่ล่าสุด</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>เก่าสุด</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> ค้นหา
                        </button>
                    </div>
                </div>
            </div>
            @if(request('search') || request('role') || request('order') != 'desc')
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> ล้างการค้นหา
                        </a>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Header Section -->
<div class="row align-items-center mb-3">
    <div class="col-md-6">
        <h3 class="mb-0">
            <i class="fas fa-users"></i> รายการผู้ใช้งาน
            @if(request('search'))
                <small class="text-muted">(ผลการค้นหา: "{{ request('search') }}")</small>
            @endif
        </h3>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> เพิ่มผู้ใช้งานใหม่
        </a>
    </div>
</div>

<!-- Data Table -->
@if($users->count() > 0)
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>ชื่อ</th>
                        <th>Email</th>
                        <th>บทบาท</th>
                        <th>สถานะ</th>
                        <th>วันที่สร้าง</th>
                        <th class="text-center" width="150">การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span class="badge badge-secondary ml-1">คุณ</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge 
                                    @switch($user->role ?? 'viewer')
                                        @case('admin') badge-danger @break
                                        @case('editor') badge-warning @break
                                        @case('ip_manager') badge-purple @break
                                        @default badge-info
                                    @endswitch
                                ">
                                    @switch($user->role ?? 'viewer')
                                        @case('admin') ผู้ดูแลระบบ @break
                                        @case('editor') บรรณาธิการ @break
                                        @case('ip_manager') ผู้จัดการ IP @break
                                        @default ผู้ดู
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge badge-success">ใช้งานได้</span>
                                @else
                                    <span class="badge badge-secondary">ยังไม่ยืนยัน</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="btn btn-sm btn-info" title="ดูรายละเอียด">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-sm btn-warning" title="แก้ไข">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $user->email_verified_at ? 'btn-secondary' : 'btn-success' }}" 
                                                    title="{{ $user->email_verified_at ? 'ปิดใช้งาน' : 'เปิดใช้งาน' }}">
                                                <i class="fas {{ $user->email_verified_at ? 'fa-ban' : 'fa-check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('ยืนยันการลบผู้ใช้งาน {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="ลบ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">ไม่พบข้อมูลผู้ใช้งาน</h5>
            @if(request('search') || request('role'))
                <p class="text-muted">ลองปรับเงื่อนไขการค้นหาใหม่</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> ล้างการค้นหา
                </a>
            @else
                <p class="text-muted">เริ่มต้นด้วยการเพิ่มผู้ใช้งานใหม่</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> เพิ่มผู้ใช้งาน
                </a>
            @endif
        </div>
    </div>
@endif

<!-- Pagination -->
@if($users->hasPages())
    <div class="card mt-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        แสดง {{ $users->firstItem() }} ถึง {{ $users->lastItem() }} จากทั้งหมด {{ $users->total() }} รายการ
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end mb-0">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">« ก่อนหน้า</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">« ก่อนหน้า</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                @if ($page == $users->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">ถัดไป »</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">ถัดไป »</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Flash messages now centralized in layout --}}
@endsection