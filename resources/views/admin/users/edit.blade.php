@extends('layouts.admin')

@section('title', 'แก้ไขข้อมูลผู้ใช้งาน')
@section('header', 'แก้ไขข้อมูลผู้ใช้งาน')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-edit"></i> แก้ไขข้อมูล: {{ $user->name }}
                </h3>
            </div>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">ชื่อผู้ใช้งาน <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">อีเมล <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">รหัสผ่านใหม่</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                <small class="form-text text-muted">เว้นว่างไว้หากไม่ต้องการเปลี่ยนรหัสผ่าน</small>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">บทบาท <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">เลือกบทบาท</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ (Admin)</option>
                                    <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>บรรณาธิการ (Editor)</option>
                                    <option value="ip_manager" {{ old('role', $user->role) == 'ip_manager' ? 'selected' : '' }}>ผู้จัดการ IP (IP Manager)</option>
                                    <option value="viewer" {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }}>ผู้ดู (Viewer)</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>สถานะ</label>
                                <div class="form-control-plaintext">
                                    @if($user->email_verified_at)
                                        <span class="badge badge-success">ยืนยันแล้ว</span>
                                    @else
                                        <span class="badge badge-secondary">ยังไม่ยืนยัน</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($user->id === auth()->id())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            คุณกำลังแก้ไขข้อมูลของตัวเอง กรุณาระวังการเปลี่ยนแปลงบทบาท
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลง
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default ml-2">
                        <i class="fas fa-arrow-left"></i> กลับไปรายการ
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> ข้อมูลเพิ่มเติม
                </h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>วันที่สร้าง:</strong>
                    <p class="mb-1">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <strong>อัปเดตล่าสุด:</strong>
                    <p class="mb-1">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                
                @if($user->email_verified_at)
                    <div class="mb-3">
                        <strong>ยืนยันอีเมลเมื่อ:</strong>
                        <p class="mb-1">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shield-alt"></i> ข้อมูลบทบาท
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