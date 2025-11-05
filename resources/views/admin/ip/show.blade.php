@extends('layouts.admin')

@section('title', 'รายละเอียดทรัพย์สินทางปัญญา')
@section('header', 'รายละเอียดทรัพย์สินทางปัญญา')

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
                    <a href="{{ route('admin.ip.index') }}">ทรัพย์สินทางปัญญา</a>
                </li>
                <li class="breadcrumb-item active">รายละเอียด</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Information Card -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shield-alt"></i> ข้อมูลพื้นฐาน
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-primary">{{ $ip->title }}</h4>
                        <p class="text-muted mb-3">
                            เลขที่ลงทะเบียน: 
                            @if($ip->registration_number)
                                <span class="badge badge-secondary">{{ $ip->registration_number }}</span>
                            @else
                                <span class="text-muted">ยังไม่มี</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <strong>ประเภท:</strong>
                        <span class="badge 
                            @switch($ip->type)
                                @case('copyright') badge-info @break
                                @case('patent') badge-success @break
                                @case('trademark') badge-warning @break
                                @case('local_wisdom') badge-primary @break
                                @case('trade_secret') badge-dark @break
                                @default badge-secondary
                            @endswitch
                        ">
                            {{ $ip->type_label }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>สถานะ:</strong>
                        <span class="badge 
                            @switch($ip->status)
                                @case('active') badge-success @break
                                @case('registered') badge-primary @break
                                @case('pending') badge-warning @break
                                @case('expired') badge-danger @break
                                @case('draft') badge-secondary @break
                                @default badge-light
                            @endswitch
                        ">
                            {{ $ip->status_label }}
                        </span>
                    </div>
                </div>
                
                @if($ip->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>คำอธิบาย:</strong>
                            <p class="mt-2">{{ $ip->description }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>วันที่ลงทะเบียน:</strong>
                        <p>
                            @if($ip->registration_date)
                                {{ $ip->registration_date->format('d/m/Y') }}
                            @else
                                <span class="text-muted">ยังไม่มี</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>วันหมดอายุ:</strong>
                        <p>
                            @if($ip->expiry_date)
                                {{ $ip->expiry_date->format('d/m/Y') }}
                                @if($ip->is_expired)
                                    <span class="badge badge-danger ml-2">หมดอายุแล้ว</span>
                                @endif
                            @else
                                <span class="text-muted">ไม่มีกำหนด</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Information -->
    <div class="col-lg-4">
        <!-- File Information -->
        @if($ip->certificate_path)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file"></i> เอกสารประกอบ
                </h3>
            </div>
            <div class="card-body text-center">
                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                <p class="mb-3">มีเอกสารแนบ</p>
                <a href="{{ asset('storage/' . $ip->certificate_path) }}" target="_blank" 
                   class="btn btn-primary btn-block">
                    <i class="fas fa-download"></i> ดาวน์โหลด / ดูไฟล์
                </a>
            </div>
        </div>
        @endif
        
        <!-- Metadata -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> ข้อมูลเพิ่มเติม
                </h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>เจ้าของ:</strong>
                    <p class="mb-1">{{ $ip->owner->name ?? 'ไม่ระบุ' }}</p>
                </div>
                
                <div class="mb-3">
                    <strong>ผู้สร้าง:</strong>
                    <p class="mb-1">{{ $ip->creator->name ?? 'ไม่ระบุ' }}</p>
                </div>
                
                <div class="mb-3">
                    <strong>วันที่สร้าง:</strong>
                    <p class="mb-1">{{ $ip->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <strong>อัปเดตล่าสุด:</strong>
                    <p class="mb-1">{{ $ip->updated_at->format('d/m/Y H:i') }}</p>
                    @if($ip->updater)
                        <small class="text-muted">โดย {{ $ip->updater->name }}</small>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cogs"></i> การจัดการ
                </h3>
            </div>
            <div class="card-body">
                @if($ip->status === 'draft')
                    <button class="btn btn-success btn-block mb-2" onclick="changeStatus('registered')">
                        <i class="fas fa-check"></i> ลงทะเบียน
                    </button>
                @endif
                
                @if($ip->status === 'active' && !$ip->is_expired)
                    <button class="btn btn-warning btn-block mb-2" onclick="changeStatus('expired')">
                        <i class="fas fa-clock"></i> ทำให้หมดอายุ
                    </button>
                @endif
                
                @if(in_array($ip->status, ['active', 'registered']))
                    <button class="btn btn-danger btn-block mb-2" onclick="changeStatus('revoked')">
                        <i class="fas fa-ban"></i> เพิกถอน
                    </button>
                @endif
                
                <a href="{{ route('admin.ip.edit', $ip) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> แก้ไขข้อมูล
                </a>
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

@section('scripts')
<script>
function changeStatus(newStatus) {
    if (confirm('ยืนยันการเปลี่ยนสถานะ?')) {
        // สร้าง form สำหรับส่งข้อมูล
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.ip.update", $ip) }}';
        
        // เพิ่ม CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // เพิ่ม method PUT
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);
        
        // เพิ่ม status field
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = newStatus;
        form.appendChild(statusField);
        
        // ส่งข้อมูล
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
