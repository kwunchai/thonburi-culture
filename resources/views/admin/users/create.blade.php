@extends('layouts.admin')

@section('title', 'เพิ่มผู้ใช้งานใหม่')
@section('header', 'เพิ่มผู้ใช้งานใหม่')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus"></i> ข้อมูลผู้ใช้งาน
                </h3>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">ชื่อผู้ใช้งาน <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">อีเมล <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">รหัสผ่าน <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                <small class="form-text text-muted">รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร</small>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">ยืนยันรหัสผ่าน <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">บทบาท <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">เลือกบทบาท</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ (Admin)</option>
                                    <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>บรรณาธิการ (Editor)</option>
                                    <option value="ip_manager" {{ old('role') == 'ip_manager' ? 'selected' : '' }}>ผู้จัดการ IP (IP Manager)</option>
                                    <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>ผู้ดู (Viewer)</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default ml-2">
                        <i class="fas fa-times"></i> ยกเลิก
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> ข้อมูลบทบาท
                </h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6><i class="fas fa-user-shield text-danger"></i> ผู้ดูแลระบบ (Admin)</h6>
                    <p class="text-sm text-muted">สามารถจัดการทุกข้อมูลในระบบ รวมถึงการจัดการผู้ใช้งาน</p>
                </div>
                <div class="mb-3">
                    <h6><i class="fas fa-user-edit text-warning"></i> บรรณาธิการ (Editor)</h6>
                    <p class="text-sm text-muted">สามารถเพิ่ม แก้ไข ลบข้อมูลวัฒนธรรมและชุมชนได้</p>
                </div>
                <div class="mb-3">
                    <h6><i class="fas fa-certificate text-purple"></i> ผู้จัดการ IP (IP Manager)</h6>
                    <p class="text-sm text-muted">สามารถเพิ่ม แก้ไข ลบข้อมูลทรัพย์สินทางปัญญาได้</p>
                </div>
                <div class="mb-3">
                    <h6><i class="fas fa-eye text-info"></i> ผู้ดู (Viewer)</h6>
                    <p class="text-sm text-muted">สามารถดูข้อมูลในระบบได้เท่านั้น ไม่สามารถแก้ไขได้</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection