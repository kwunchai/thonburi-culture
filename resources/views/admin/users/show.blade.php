@extends('layouts.admin')

@section('title', 'รายละเอียดผู้ใช้งาน')
@section('header', 'รายละเอียดผู้ใช้งาน')

@section('content')
<!-- Breadcrumb -->
<div class="row mb-3">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> แดชบอร์ด
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.users.index') }}">จัดการสิทธิ์ผู้ใช้งาน</a>
                </li>
                <li class="breadcrumb-item active">รายละเอียด</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i> ข้อมูลพื้นฐาน
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-primary">
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="badge badge-secondary ml-2">คุณ</span>
                            @endif
                        </h4>
                        <p class="text-muted mb-3">{{ $user->email }}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <strong>บทบาท:</strong>
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
                    </div>
                    <div class="col-md-6">
                        <strong>สถานะ:</strong>
                        @if($user->email_verified_at)
                            <span class="badge badge-success">ยืนยันแล้ว</span>
                        @else
                            <span class="badge badge-secondary">ยังไม่ยืนยัน</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>วันที่สร้าง:</strong>
                        <p class="mb-1">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>อัปเดตล่าสุด:</strong>
                        <p class="mb-1">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($user->email_verified_at)
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>ยืนยันอีเมลเมื่อ:</strong>
                            <p class="mb-1">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Activity Statistics -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i> สถิติการใช้งาน
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="fas fa-landmark fa-2x text-info mb-2"></i>
                            <h5>{{ $user->culturalItems()->count() }}</h5>
                            <p class="text-muted">ข้อมูลวัฒนธรรมที่สร้าง</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="fas fa-certificate fa-2x text-warning mb-2"></i>
                            <h5>{{ $user->intellectualProperties()->count() ?? 0 }}</h5>
                            <p class="text-muted">ทรัพย์สินทางปัญญา</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="fas fa-clock fa-2x text-success mb-2"></i>
                            <h5>{{ $user->created_at->diffForHumans() }}</h5>
                            <p class="text-muted">สมาชิกมาแล้ว</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Information -->
    <div class="col-lg-4">
        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cogs"></i> การจัดการ
                </h3>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-block mb-2">
                    <i class="fas fa-edit"></i> แก้ไขข้อมูล
                </a>
                
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="mb-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $user->email_verified_at ? 'btn-secondary' : 'btn-success' }} btn-block">
                            <i class="fas {{ $user->email_verified_at ? 'fa-ban' : 'fa-check' }}"></i>
                            {{ $user->email_verified_at ? 'ปิดใช้งาน' : 'เปิดใช้งาน' }}
                        </button>
                    </form>
                @endif
                
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="mt-3"
                          onsubmit="return confirm('ยืนยันการลบผู้ใช้งาน {{ $user->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash"></i> ลบผู้ใช้งาน
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        <!-- Role Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shield-alt"></i> ข้อมูลบทบาท
                </h3>
            </div>
            <div class="card-body">
                @switch($user->role ?? 'viewer')
                    @case('admin')
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-user-shield"></i> ผู้ดูแลระบบ</h6>
                            <p class="mb-0">สามารถจัดการทุกข้อมูลในระบบ รวมถึงการจัดการผู้ใช้งาน</p>
                        </div>
                        @break
                    @case('editor')
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-user-edit"></i> บรรณาธิการ</h6>
                            <p class="mb-0">สามารถเพิ่ม แก้ไข ลบข้อมูลวัฒนธรรมและชุมชนได้</p>
                        </div>
                        @break
                    @case('ip_manager')
                        <div class="alert alert-purple">
                            <h6><i class="fas fa-certificate"></i> ผู้จัดการ IP</h6>
                            <p class="mb-0">สามารถเพิ่ม แก้ไข ลบข้อมูลทรัพย์สินทางปัญญาได้</p>
                        </div>
                        @break
                    @default
                        <div class="alert alert-info">
                            <h6><i class="fas fa-eye"></i> ผู้ดู</h6>
                            <p class="mb-0">สามารถดูข้อมูลในระบบได้เท่านั้น ไม่สามารถแก้ไขได้</p>
                        </div>
                @endswitch
            </div>
        </div>
    </div>
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