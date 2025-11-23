@extends('layouts.admin')

@section('title', 'แก้ไขหมวดหมู่กิจกรรม - ' . $activityCategory->name)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-edit mr-2"></i>
                    แก้ไขหมวดหมู่กิจกรรม
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activity-categories.index') }}">จัดการหมวดหมู่กิจกรรม</a></li>
                    <li class="breadcrumb-item active">แก้ไข: {{ $activityCategory->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit mr-1"></i>
                            แก้ไขข้อมูลหมวดหมู่กิจกรรม
                        </h3>
                    </div>

                    <form method="POST" action="{{ route('admin.activity-categories.update', $activityCategory) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $activityCategory->name) }}" 
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
                                          placeholder="คำอธิบายเกี่ยวกับหมวดหมู่นี้">{{ old('description', $activityCategory->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">คำอธิบายสั้น ๆ เกี่ยวกับหมวดหมู่ (ไม่เกิน 500 ตัวอักษร)</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save mr-1"></i>
                                บันทึกการแก้ไข
                            </button>
                            <a href="{{ route('admin.activity-categories.show', $activityCategory) }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i>
                                ยกเลิก
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
