@extends('layouts.admin')

@section('title', 'แก้ไขกิจกรรม')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-edit mr-2"></i>
                    แก้ไขกิจกรรม: {{ $activity->title }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">จัดการกิจกรรม</a></li>
                    <li class="breadcrumb-item active">แก้ไขกิจกรรม</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.activities.update', $activity) }}" method="POST" enctype="multipart/form-data" id="activityForm">
            @csrf
            @method('PUT')
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
                                       value="{{ old('title', $activity->title) }}" 
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
                                          placeholder="ระบุรายละเอียดของกิจกรรม">{{ old('description', $activity->description) }}</textarea>
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
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $activity->category_id) == $category->id ? 'selected' : '' }}>
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
                                       value="{{ old('activity_date', $activity->activity_date ? $activity->activity_date->format('Y-m-d') : '') }}">
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
                                       value="{{ old('location', $activity->location) }}" 
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
                            <!-- Current Main Image -->
                            @if($activity->image)
                            <div class="mb-3">
                                <label class="font-weight-bold">รูปภาพหลักปัจจุบัน:</label>
                                <div class="text-center">
                                    <img src="{{ Storage::url($activity->image) }}" 
                                         alt="{{ $activity->title }}" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="image">เปลี่ยนรูปภาพหลัก</label>
                                <div class="custom-file">
                                    <input type="file" 
                                           class="custom-file-input @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*">
                                    <label class="custom-file-label" for="image">เลือกรูปภาพหลักใหม่...</label>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    รองรับไฟล์: JPG, PNG, GIF (ขนาดไม่เกิน 2MB)<br>
                                    หากไม่เลือกรูปใหม่ จะใช้รูปเดิม
                                </small>
                            </div>

                            <!-- New Main Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <label class="font-weight-bold">รูปภาพหลักใหม่:</label>
                                <img id="previewImg" src="#" alt="Preview" class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Images Management -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-images mr-1"></i>
                                รูปภาพเพิ่มเติม
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Current Additional Images -->
                            @if($activity->images && count($activity->images) > 0)
                            <div class="mb-3">
                                <label class="font-weight-bold">รูปภาพเพิ่มเติมปัจจุบัน:</label>
                                <div class="row" id="currentAdditionalImages">
                                    @foreach($activity->images as $index => $imagePath)
                                    <div class="col-6 mb-2" data-image-index="{{ $index }}">
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($imagePath) }}" 
                                                 alt="Additional Image {{ $index + 1 }}" 
                                                 class="img-fluid rounded" 
                                                 style="width: 100%; height: 80px; object-fit: cover;">
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger position-absolute" 
                                                    style="top: -5px; right: -5px; width: 20px; height: 20px; padding: 0; border-radius: 50%;" 
                                                    onclick="removeExistingImage({{ $index }})">
                                                ×
                                            </button>
                                            <input type="hidden" name="existing_images[{{ $index }}]" value="{{ $imagePath }}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Add New Additional Images -->
                            <div class="form-group">
                                <label for="additional_images">เพิ่มรูปภาพเพิ่มเติม</label>
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

                            <!-- New Additional Images Preview -->
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
                                           {{ old('is_active', $activity->is_active) ? 'checked' : '' }}>
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

                    <!-- Activity Info -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info mr-1"></i>
                                ข้อมูลเพิ่มเติม
                            </h3>
                        </div>
                        <div class="card-body">
                            <small class="text-muted">
                                <strong>สร้างโดย:</strong> {{ $activity->creator ? $activity->creator->name : 'ไม่ทราบ' }}<br>
                                <strong>สร้างเมื่อ:</strong> {{ $activity->created_at->format('d/m/Y H:i') }}<br>
                                <strong>แก้ไขล่าสุด:</strong> {{ $activity->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save mr-2"></i>
                                    บันทึกการแก้ไข
                                </button>
                                <a href="{{ route('admin.activities.show', $activity) }}" class="btn btn-info btn-block">
                                    <i class="fas fa-eye mr-2"></i>
                                    ดูรายละเอียด
                                </a>
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
            $(this).next('.custom-file-label').html('เลือกรูปภาพหลักใหม่...');
            $('#imagePreview').hide();
        }
    });

    // Additional images file input change handler
    $('#additional_images').on('change', function(event) {
        const files = Array.from(event.target.files);
        
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

    // Remove existing image function
    window.removeExistingImage = function(index) {
        if (confirm('คุณต้องการลบรูปภาพนี้หรือไม่?')) {
            $(`[data-image-index="${index}"]`).fadeOut(300, function() {
                $(this).remove();
            });
            
            // Mark for deletion by removing the hidden input
            $(`input[name="existing_images[${index}]"]`).remove();
        }
    };

    // Remove new additional image function
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
        
        // Check required fields
        const title = $('#title').val().trim();
        if (!title) {
            isValid = false;
            $('#title').addClass('is-invalid');
        } else {
            $('#title').removeClass('is-invalid');
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