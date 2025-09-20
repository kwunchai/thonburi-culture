@extends('layouts.admin')

@section('title', 'เพิ่ม Slideshow')
@section('header', 'เพิ่ม Slideshow ใหม่')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus-circle"></i> เพิ่มข้อมูล Slideshow
        </h3>
    </div>
    
    <form action="{{ route('admin.slideshow.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <!-- Title -->
                    <div class="form-group">
                        <label>หัวข้อ <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" 
                               placeholder="ใส่หัวข้อที่น่าสนใจสำหรับ Slideshow"
                               required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label>รายละเอียด <span class="text-danger">*</span></label>
                        <textarea name="description" rows="6" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="ใส่รายละเอียดที่จะแสดงใน Slideshow (ควรกระชับและน่าสนใจ)"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            แนะนำ: ใช้ข้อความสั้นๆ กระชับ ประมาณ 100-200 ตัวอักษร
                        </small>
                    </div>

                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>หมวดหมู่ <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- เลือกหมวดหมู่ --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Community -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ชุมชน <span class="text-danger">*</span></label>
                                <select name="community_id" class="form-control @error('community_id') is-invalid @enderror" required>
                                    <option value="">-- เลือกชุมชน --</option>
                                    @foreach($communities as $community)
                                        <option value="{{ $community->id }}" {{ old('community_id') == $community->id ? 'selected' : '' }}>
                                            {{ $community->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('community_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Image Upload -->
                    <div class="form-group">
                        <label>รูปภาพ Slideshow <span class="text-danger">*</span></label>
                        <div class="custom-file mb-3">
                            <input type="file" name="image" 
                                   class="custom-file-input @error('image') is-invalid @enderror" 
                                   id="imageInput"
                                   accept="image/*" 
                                   required>
                            <label class="custom-file-label" for="imageInput">เลือกรูปภาพ</label>
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="text-center mb-3" style="display: none;">
                            <img src="" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </div>
                        
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            รองรับไฟล์: JPG, PNG, GIF (ไม่เกิน 4MB)<br>
                            แนะนำขนาด: 1920x1080 pixels หรือ 16:9 ratio
                        </small>
                    </div>

                    <!-- Publish Date -->
                    <div class="form-group">
                        <label>วันที่เผยแพร่ <span class="text-danger">*</span></label>
                        <input type="date" name="publish_date" 
                               class="form-control @error('publish_date') is-invalid @enderror" 
                               value="{{ old('publish_date', date('Y-m-d')) }}" 
                               required>
                        @error('publish_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Featured Settings -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-star"></i> ตั้งค่า Slideshow
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Is Featured -->
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-lg">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_featured" 
                                           name="is_featured" 
                                           value="1" 
                                           {{ old('is_featured', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_featured">
                                        แสดงใน Hero Slideshow
                                    </label>
                                </div>
                                <small class="text-muted">
                                    ปัจจุบันมี {{ $featuredCount }}/4 รายการ
                                </small>
                            </div>

                            <!-- Featured Order -->
                            <div class="form-group" id="featuredOrderGroup">
                                <label>ลำดับการแสดง</label>
                                <select name="featured_order" class="form-control">
                                    <option value="">อัตโนมัติ (ต่อท้าย)</option>
                                    <option value="1" {{ old('featured_order') == 1 ? 'selected' : '' }}>1 (แรก)</option>
                                    <option value="2" {{ old('featured_order') == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('featured_order') == 3 ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ old('featured_order') == 4 ? 'selected' : '' }}>4 (สุดท้าย)</option>
                                </select>
                            </div>

                            <!-- Is Published -->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_published" 
                                           name="is_published" 
                                           value="1" 
                                           {{ old('is_published', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_published">
                                        เผยแพร่ทันที
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> บันทึก Slideshow
            </button>
            <a href="{{ route('admin.slideshow.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> ยกเลิก
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Image preview
    $('#imageInput').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview img').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(file);
            
            // Update label
            $('.custom-file-label').text(file.name);
        }
    });
    
    // Toggle featured order based on checkbox
    $('#is_featured').change(function() {
        if ($(this).is(':checked')) {
            $('#featuredOrderGroup').show();
        } else {
            $('#featuredOrderGroup').hide();
        }
    }).trigger('change');
});
</script>
@endpush
@endsection