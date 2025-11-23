@extends('layouts.admin')

@section('title', 'เพิ่มหมวดหมู่กิจกรรมใหม่')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-plus mr-2"></i>
                    เพิ่มหมวดหมู่กิจกรรมใหม่
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activity-categories.index') }}">จัดการหมวดหมู่กิจกรรม</a></li>
                    <li class="breadcrumb-item active">เพิ่มหมวดหมู่ใหม่</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit mr-1"></i>
                            ข้อมูลหมวดหมู่กิจกรรม
                        </h3>
                    </div>

                    <form method="POST" action="{{ route('admin.activity-categories.store') }}">
                        @csrf
                        
                        <div class="card-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="เช่น เทศกาลและงานประเพณี" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">คำอธิบาย</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="5" 
                                          placeholder="ระบุรายละเอียดของหมวดหมู่">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">สามารถใส่รายละเอียดได้สูงสุด 500 ตัวอักษร</small>
                            </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                บันทึกหมวดหมู่
                            </button>
                            <a href="{{ route('admin.activity-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>
                                ยกเลิก
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Panel -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            คำแนะนำ
                        </h3>
                    </div>
                    <div class="card-body">
                        <p><strong>ชื่อหมวดหมู่:</strong> ใช้ชื่อที่สื่อความหมายชัดเจน เช่น "เทศกาลและงานประเพณี"</p>
                        
                        <p><strong>คำอธิบาย:</strong> อธิบายรายละเอียดของหมวดหมู่เพื่อให้ผู้ใช้เข้าใจประเภทของกิจกรรมได้ดียิ่งขึ้น</p>
                        
                        <p class="mb-0"><strong>หมายเหตุ:</strong> ชื่อหมวดหมู่จะถูกแปลงเป็น slug อัตโนมัติเพื่อใช้ใน URL</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection