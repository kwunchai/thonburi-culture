@extends('layouts.admin')

@section('title', 'แก้ไขทรัพย์สินทางปัญญา')
@section('header', 'แก้ไขทรัพย์สินทางปัญญา')

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
                <li class="breadcrumb-item active">แก้ไขข้อมูล</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form -->
<form action="{{ route('admin.ip.update', $ip->ip_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> แก้ไขข้อมูลทรัพย์สินทางปัญญา
            </h3>
        </div>
        
        <div class="card-body">
            <div class="row">
                <!-- ชื่อเรื่อง -->
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">ชื่อเรื่อง <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $ip->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- ประเภท -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="type">ประเภท <span class="text-danger">*</span></label>
                        <select id="type" name="type" 
                                class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">-- เลือกประเภท --</option>
                            @foreach(\App\Models\IntellectualProperty::TYPES as $key => $value)
                                <option value="{{ $key }}" {{ old('type', $ip->type) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
      <option value="">—</option>
      @foreach([\App\Enums\IpStatus::DRAFT->value, \App\Enums\IpStatus::SUBMITTED->value, \App\Enums\IpStatus::UNDER_REVIEW->value, \App\Enums\IpStatus::REGISTERED->value, \App\Enums\IpStatus::REJECTED->value, \App\Enums\IpStatus::EXPIRED->value] as $s)
        <option value="{{ $s }}" @selected(old('status', $ip->status)===$s)>{{ $s }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">ปีงบประมาณ</label>
    <input name="budget_year" type="number" class="form-control" value="{{ old('budget_year', $ip->budget_year) }}" placeholder="เช่น 2568">
  </div>
  <div class="col-md-3">
    <label class="form-label">แหล่งทุน</label>
    <input name="funding_source" class="form-control" value="{{ old('funding_source', $ip->funding_source) }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">ผู้ยื่น</label>
    <input name="submitter_name" class="form-control" value="{{ old('submitter_name', $ip->submitter_name) }}">
  </div>

                
                <!-- คำอธิบาย -->
                <div class="col-12">
                    <div class="form-group">
                        <label for="description">คำอธิบาย</label>
                        <textarea id="description" name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $ip->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- เลขที่ลงทะเบียน -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="registration_number">เลขที่ลงทะเบียน</label>
                        <input type="text" id="registration_number" name="registration_number" 
                               class="form-control @error('registration_number') is-invalid @enderror" 
                               value="{{ old('registration_number', $ip->registration_number) }}">
                        @error('registration_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- วันที่ลงทะเบียน -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="registration_date">วันที่ลงทะเบียน</label>
                        <input type="date" id="registration_date" name="registration_date" 
                               class="form-control @error('registration_date') is-invalid @enderror" 
                               value="{{ old('registration_date', $ip->registration_date?->format('Y-m-d')) }}">
                        @error('registration_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- สถานะ -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">สถานะ</label>
                        <select id="status" name="status" 
                                class="form-control @error('status') is-invalid @enderror">
                            <option value="">-- เลือกสถานะ --</option>
                            @foreach(\App\Models\IntellectualProperty::STATUSES as $key => $value)
                                <option value="{{ $key }}" {{ old('status', $ip->status) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- วันหมดอายุ -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="expiry_date">วันหมดอายุ</label>
                        <input type="date" id="expiry_date" name="expiry_date" 
                               class="form-control @error('expiry_date') is-invalid @enderror" 
                               value="{{ old('expiry_date', $ip->expiry_date?->format('Y-m-d')) }}">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- เอกสารแนบ -->
                <div class="col-12">
                    <div class="form-group">
                        <label for="certificate">เอกสารประกอบ</label>
                        
                        @if($ip->certificate_path)
                            <div class="mb-2">
                                <small class="text-muted">ไฟล์ปัจจุบัน:</small>
                                <a href="{{ asset('storage/' . $ip->certificate_path) }}" target="_blank" class="text-primary">
                                    <i class="fas fa-file"></i> ดูไฟล์
                                </a>
                            </div>
                        @endif
                        
                        <div class="custom-file">
                            <input type="file" id="certificate" name="certificate" 
                                   class="custom-file-input @error('certificate') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <label class="custom-file-label" for="certificate">
                                {{ $ip->certificate_path ? 'เปลี่ยนไฟล์...' : 'เลือกไฟล์...' }}
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            รองรับไฟล์: PDF, DOC, DOCX, JPG, JPEG, PNG (ขนาดไม่เกิน 10MB)
                        </small>
                        @error('certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> บันทึกการแก้ไข
                    </button>
                    <a href="{{ route('admin.ip.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@if($errors->any())
    <div class="alert alert-danger mt-3">
        <h5><i class="icon fas fa-ban"></i> เกิดข้อผิดพลาด!</h5>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
});
</script>
@endsection
