@extends('layouts.admin')

@section('title', 'เพิ่มกิจกรรมใหม่')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-plus mr-2"></i>
                    เพิ่มกิจกรรมใหม่
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">จัดการกิจกรรม</a></li>
                    <li class="breadcrumb-item active">เพิ่มกิจกรรมใหม่</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" id="activityForm">
            @csrf
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-1"></i>
                                ข้อมูลกิจกรรม
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title" class="required">ชื่อกิจกรรม</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="ระบุชื่อกิจกรรม" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">คำอธิบายกิจกรรม</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="ระบุรายละเอียดของกิจกรรม">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">สามารถใส่รายละเอียดได้สูงสุด 1000 ตัวอักษร</small>
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label for="category_id">หมวดหมู่กิจกรรม</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" 
                                        id="category_id" 
                                        name="category_id">
                                    <option value="">-- เลือกหมวดหมู่ --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">เลือกหมวดหมู่ที่เหมาะสมกับกิจกรรมนี้</small>
                            </div>

                            <!-- Activity Date -->
                            <div class="form-group">
                                <label for="activity_date">วันที่จัดกิจกรรม</label>
                                <input type="date" 
                                       class="form-control @error('activity_date') is-invalid @enderror" 
                                       id="activity_date" 
                                       name="activity_date" 
                                       value="{{ old('activity_date') }}">
                                @error('activity_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div class="form-group">
                                <label for="location">สถานที่จัดงาน</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location') }}" 
                                       placeholder="เช่น หอประชุมเขตธนบุรี">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <!-- Main Image Upload -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-image mr-1"></i>
                                รูปภาพหลักกิจกรรม
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="image" class="required">อัพโลดรูปภาพหลัก</label>
                                <div class="custom-file">
                                    <input type="file" 
                                           class="custom-file-input @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           required>
                                    <label class="custom-file-label" for="image">เลือกรูปภาพหลัก...</label>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    รองรับไฟล์: JPG, PNG, GIF (ขนาดไม่เกิน 2MB)
                                </small>
                            </div>

                            <!-- Main Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="previewImg" src="#" alt="Preview" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Images Upload -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-images mr-1"></i>
                                รูปภาพเพิ่มเติม (ไม่จำกัด)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="additional_images">อัพโลดรูปภาพเพิ่มเติม</label>
                                <div class="custom-file">
                                    <input type="file" 
                                           class="custom-file-input @error('additional_images') is-invalid @enderror" 
                                           id="additional_images" 
                                           name="additional_images[]" 
                                           accept="image/*"
                                           multiple>
                                    <label class="custom-file-label" for="additional_images">เลือกรูปภาพหลายรูป...</label>
                                </div>
                                @error('additional_images')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('additional_images.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    สามารถเลือกรูปภาพได้หลายรูปพร้อมกัน แต่ละรูปไม่เกิน 2MB
                                </small>
                            </div>

                            <!-- Additional Images Preview -->
                            <div id="additionalImagesPreview" class="mt-3">
                                <!-- Preview images will be shown here -->
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-cog mr-1"></i>
                                ตั้งค่า
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">
                                        เปิดการแสดงผล
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    เลือกเพื่อให้กิจกรรมแสดงผลในหน้าเว็บไซต์
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save mr-2"></i>
                                    บันทึกกิจกรรม
                                </button>
                                <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    กลับไปรายการ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<style>
.required:after {
    content: ' *';
    color: red;
}

#imagePreview img {
    max-height: 200px;
    width: 100%;
    object-fit: cover;
}

.additional-image-item {
    position: relative;
    display: inline-block;
    margin: 5px;
}

.additional-image-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}

.remove-image-btn {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let additionalImages = [];

    // Main image file input change handler
    $('#image').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Update label
            const fileName = file.name;
            $(this).next('.custom-file-label').html(fileName);
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $(this).next('.custom-file-label').html('เลือกรูปภาพหลัก...');
            $('#imagePreview').hide();
        }
    });

    // Additional images file input change handler
    $('#additional_images').on('change', function(event) {
        const files = Array.from(event.target.files);
        const fileNames = files.map(file => file.name).join(', ');
        
        if (files.length > 0) {
            $(this).next('.custom-file-label').html(files.length + ' รูปถูกเลือก');
            
            // Add to additionalImages array
            files.forEach(file => {
                additionalImages.push(file);
            });
            
            // Update preview
            updateAdditionalImagesPreview();
        } else {
            $(this).next('.custom-file-label').html('เลือกรูปภาพหลายรูป...');
        }
    });

    function updateAdditionalImagesPreview() {
        const previewContainer = $('#additionalImagesPreview');
        previewContainer.empty();
        
        additionalImages.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageItem = $(`
                    <div class="additional-image-item" data-index="${index}">
                        <img src="${e.target.result}" alt="Additional Image ${index + 1}">
                        <button type="button" class="remove-image-btn" onclick="removeAdditionalImage(${index})">
                            ×
                        </button>
                    </div>
                `);
                previewContainer.append(imageItem);
            }
            reader.readAsDataURL(file);
        });
    }

    // Make removeAdditionalImage function global
    window.removeAdditionalImage = function(index) {
        additionalImages.splice(index, 1);
        updateAdditionalImagesPreview();
        
        // Update file input
        const dt = new DataTransfer();
        additionalImages.forEach(file => {
            dt.items.add(file);
        });
        document.getElementById('additional_images').files = dt.files;
        
        // Update label
        if (additionalImages.length > 0) {
            $('#additional_images').next('.custom-file-label').html(additionalImages.length + ' รูปถูกเลือก');
        } else {
            $('#additional_images').next('.custom-file-label').html('เลือกรูปภาพหลายรูป...');
        }
    };

    // Form validation
    $('#activityForm').on('submit', function(e) {
        let isValid = true;
        
        // Reset previous error states
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        // Validate required fields
        const title = $('#title').val().trim();
        const image = $('#image')[0].files.length;
        
        if (!title) {
            $('#title').addClass('is-invalid');
            $('#title').after('<div class="invalid-feedback">กรุณากรอกชื่อกิจกรรม</div>');
            isValid = false;
        }
        
        if (!image) {
            $('#image').addClass('is-invalid');
            if (!$('#image').next().next('.invalid-feedback').length) {
                $('#image').closest('.form-group').append('<div class="invalid-feedback d-block">กรุณาเลือกรูปภาพหลัก</div>');
            }
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            $('html, body').animate({
                scrollTop: $('.is-invalid:first').offset().top - 100
            }, 300);
        }
    });
        }
    });

    // Form validation
    $('#activityForm').on('submit', function(e) {
        let isValid = true;
        
        // Check required fields
        const title = $('#title').val().trim();
        if (!title) {
            isValid = false;
            $('#title').addClass('is-invalid');
        } else {
            $('#title').removeClass('is-invalid');
        }
        
        const image = $('#image')[0].files.length;
        if (!image) {
            isValid = false;
            $('#image').addClass('is-invalid');
            if (!$('#image').next().next('.invalid-feedback').length) {
                $('<div class="invalid-feedback d-block">กรุณาเลือกรูปภาพ</div>').insertAfter($('#image').parent());
            }
        } else {
            $('#image').removeClass('is-invalid');
            $('#image').parent().next('.invalid-feedback').remove();
        }
        
        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });
});
</script>
@endpush