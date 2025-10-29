@extends('layouts.admin')

@section('title', 'เพิ่มทรัพย์สินทางปัญญา')
@section('header', 'เพิ่มทรัพย์สินทางปัญญา')

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
                <li class="breadcrumb-item active">เพิ่มข้อมูลใหม่</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Form -->
<form action="{{ route('admin.ip.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-plus"></i> เพิ่มข้อมูลทรัพย์สินทางปัญญาใหม่
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
                               value="{{ old('title') }}" required>
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
                                <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- คำอธิบาย -->
                <div class="col-12">
                    <div class="form-group">
                        <label for="description">คำอธิบาย</label>
                        <textarea id="description" name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
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
                               value="{{ old('registration_number') }}">
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
                               value="{{ old('registration_date') }}">
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
                                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
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
                               value="{{ old('expiry_date') }}">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- เอกสารแนบ -->
                <div class="col-12">
                    <div class="form-group">
                        <label for="certificate">เอกสารประกอบ</label>
                        <div class="custom-file">
                            <input type="file" id="certificate" name="certificate" 
                                   class="custom-file-input @error('certificate') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <label class="custom-file-label" for="certificate">เลือกไฟล์...</label>
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
                        <i class="fas fa-save"></i> บันทึกข้อมูล
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
