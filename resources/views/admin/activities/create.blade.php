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
                                           accept="image/jpeg,image/png,image/jpg,image/gif"
                                           required>
                                    <label class="custom-file-label" for="image">เลือกรูปภาพหลัก...</label>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> รองรับไฟล์: JPG, PNG, GIF
                                </small>
                            </div>

                            <!-- Main Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="position-relative">
                                    <img id="previewImg" src="#" alt="Preview" class="img-fluid rounded border">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute" 
                                            style="top: 10px; right: 10px;" 
                                            id="removeMainImage"
                                            title="ลบรูปภาพ">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
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
                                           accept="image/jpeg,image/png,image/jpg,image/gif"
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
                                    <i class="fas fa-info-circle"></i> สามารถเลือกรูปภาพได้หลายรูปพร้อมกัน
                                </small>
                            </div>

                            <!-- Additional Images Preview -->
                            <div id="additionalImagesPreview" class="mt-3 row">
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
    max-height: 300px;
    width: 100%;
    object-fit: contain;
    background: #f8f9fa;
}

#imagePreview {
    border: 2px dashed #dee2e6;
    padding: 10px;
    border-radius: 8px;
}

.additional-image-item {
    position: relative;
    margin-bottom: 15px;
}

.additional-image-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #dee2e6;
}

.remove-image-btn {
    position: absolute;
    top: 5px;
    right: 20px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: all 0.3s;
}

.remove-image-btn:hover {
    background: #c82333;
    transform: scale(1.1);
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let additionalImageFiles = [];

    // Main image file input change handler
    $('#image').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Validate image type
            if (!file.type.match('image.*')) {
                alert('กรุณาเลือกไฟล์รูปภาพเท่านั้น');
                this.value = '';
                return;
            }

            // Update label
            const fileName = file.name;
            $(this).next('.custom-file-label').html(fileName);
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').slideDown(300);
            }
            reader.readAsDataURL(file);
        } else {
            $(this).next('.custom-file-label').html('เลือกรูปภาพหลัก...');
            $('#imagePreview').slideUp(300);
        }
    });

    // Remove main image button
    $('#removeMainImage').on('click', function() {
        $('#image').val('');
        $('#image').next('.custom-file-label').html('เลือกรูปภาพหลัก...');
        $('#imagePreview').slideUp(300);
    });

    // Additional images file input change handler
    $('#additional_images').on('change', function(event) {
        const files = Array.from(event.target.files);
        
        if (files.length > 0) {
            // Validate all files are images
            const invalidFiles = files.filter(f => !f.type.match('image.*'));
            if (invalidFiles.length > 0) {
                alert('บางไฟล์ไม่ใช่รูปภาพ กรุณาเลือกเฉพาะไฟล์รูปภาพ');
                this.value = '';
                return;
            }

            $(this).next('.custom-file-label').html(files.length + ' ไฟล์ถูกเลือก');
            
            // Store files
            additionalImageFiles = files;
            
            // Update preview
            updateAdditionalImagesPreview();
        } else {
            $(this).next('.custom-file-label').html('เลือกรูปภาพหลายรูป...');
            additionalImageFiles = [];
            $('#additionalImagesPreview').empty();
        }
    });

    function updateAdditionalImagesPreview() {
        const previewContainer = $('#additionalImagesPreview');
        previewContainer.empty();
        
        let loadedCount = 0;
        
        additionalImageFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const colDiv = $('<div class=\"col-md-4 col-sm-6 additional-image-item\" data-index=\"' + index + '\"></div>');
                const imgDiv = $(`
                    <div class=\"position-relative\">
                        <img src=\"${e.target.result}\" alt=\"รูปที่ ${index + 1}\" class=\"img-fluid\">
                        <button type=\"button\" class=\"btn btn-danger btn-sm remove-image-btn\" data-index=\"${index}\" title=\"ลบรูปภาพ\">
                            <i class=\"fas fa-times\"></i>
                        </button>
                        <div class=\"text-center mt-2 small text-muted\">${file.name}</div>
                    </div>
                `);
                colDiv.append(imgDiv);
                previewContainer.append(colDiv);
                
                loadedCount++;
                if (loadedCount === additionalImageFiles.length) {
                    // Attach remove handlers after all images loaded
                    attachRemoveHandlers();
                }
            }
            reader.readAsDataURL(file);
        });
    }

    function attachRemoveHandlers() {
        $('.remove-image-btn').off('click').on('click', function() {
            const index = parseInt($(this).data('index'));
            removeAdditionalImage(index);
        });
    }

    function removeAdditionalImage(index) {
        // Remove from array
        additionalImageFiles = Array.from(additionalImageFiles).filter((_, i) => i !== index);
        
        // Update file input with remaining files
        const dt = new DataTransfer();
        additionalImageFiles.forEach(file => {
            dt.items.add(file);
        });
        document.getElementById('additional_images').files = dt.files;
        
        // Update label and preview
        if (additionalImageFiles.length > 0) {
            $('#additional_images').next('.custom-file-label').html(additionalImageFiles.length + ' ไฟล์ถูกเลือก');
            updateAdditionalImagesPreview();
        } else {
            $('#additional_images').next('.custom-file-label').html('เลือกรูปภาพหลายรูป...');
            $('#additionalImagesPreview').empty();
        }
    }

    // Form validation
    $('#activityForm').on('submit', function(e) {
        let isValid = true;
        
        // Reset previous error states
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback:not(.d-block)').remove();
        
        // Validate required fields
        const title = $('#title').val().trim();
        const image = $('#image')[0].files.length;
        
        if (!title) {
            $('#title').addClass('is-invalid');
            if (!$('#title').next('.invalid-feedback').length) {
                $('#title').after('<div class=\"invalid-feedback\">กรุณากรอกชื่อกิจกรรม</div>');
            }
            isValid = false;
        }
        
        if (!image) {
            $('#image').addClass('is-invalid');
            const group = $('#image').closest('.form-group');
            if (!group.find('.invalid-feedback.d-block').length) {
                group.append('<div class=\"invalid-feedback d-block\">กรุณาเลือกรูปภาพหลัก</div>');
            }
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            $('html, body').animate({
                scrollTop: $('.is-invalid:first').offset().top - 100
            }, 300);
            return false;
        }
    });
});
</script>
@endpush