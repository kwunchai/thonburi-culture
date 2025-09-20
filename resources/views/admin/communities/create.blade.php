@extends('layouts.admin')

@section('title', 'เพิ่มชุมชนใหม่')
@section('header', 'เพิ่มชุมชนใหม่')

@section('content')
<form action="{{ route('admin.communities.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลพื้นฐาน</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>ชื่อชุมชน <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>คำอธิบาย</label>
                        <textarea name="description" rows="4" 
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>จุดเด่น/ไฮไลท์ของชุมชน</label>
                        <textarea name="highlights" rows="3" 
                                  class="form-control @error('highlights') is-invalid @enderror"
                                  placeholder="เช่น แหล่งทำเครื่องปั้นดินเผา, ชุมชนริมน้ำ, วัดสำคัญ">{{ old('highlights') }}</textarea>
                        @error('highlights')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ปีที่ก่อตั้ง (พ.ศ.)</label>
                                <input type="number" name="established_year" 
                                       class="form-control @error('established_year') is-invalid @enderror" 
                                       value="{{ old('established_year') }}"
                                       min="1000" max="{{ date('Y') + 543 }}"
                                       placeholder="เช่น 2500">
                                @error('established_year')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>จำนวนประชากร (คน)</label>
                                <input type="number" name="population" 
                                       class="form-control @error('population') is-invalid @enderror" 
                                       value="{{ old('population') }}"
                                       min="0">
                                @error('population')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>พื้นที่ (ตร.กม.)</label>
                                <input type="number" name="area_size" 
                                       class="form-control @error('area_size') is-invalid @enderror" 
                                       value="{{ old('area_size') }}"
                                       min="0" step="0.01">
                                @error('area_size')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลติดต่อ</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>ที่อยู่</label>
                        <textarea name="address" rows="2" 
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ชื่อผู้ติดต่อ/ประธานชุมชน</label>
                                <input type="text" name="contact_name" 
                                       class="form-control @error('contact_name') is-invalid @enderror" 
                                       value="{{ old('contact_name') }}">
                                @error('contact_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>เบอร์โทรศัพท์</label>
                                <input type="text" name="contact_phone" 
                                       class="form-control @error('contact_phone') is-invalid @enderror" 
                                       value="{{ old('contact_phone') }}"
                                       placeholder="0X-XXX-XXXX">
                                @error('contact_phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>อีเมล</label>
                                <input type="email" name="contact_email" 
                                       class="form-control @error('contact_email') is-invalid @enderror" 
                                       value="{{ old('contact_email') }}">
                                @error('contact_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>เวลาทำการ/เวลาที่สะดวกติดต่อ</label>
                                <input type="text" name="working_hours" 
                                       class="form-control @error('working_hours') is-invalid @enderror" 
                                       value="{{ old('working_hours') }}"
                                       placeholder="เช่น จ-ศ 09:00-17:00">
                                @error('working_hours')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>เว็บไซต์</label>
                                <input type="url" name="website" 
                                       class="form-control @error('website') is-invalid @enderror" 
                                       value="{{ old('website') }}"
                                       placeholder="https://">
                                @error('website')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" name="facebook" 
                                       class="form-control @error('facebook') is-invalid @enderror" 
                                       value="{{ old('facebook') }}"
                                       placeholder="facebook.com/...">
                                @error('facebook')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Line ID</label>
                                <input type="text" name="line_id" 
                                       class="form-control @error('line_id') is-invalid @enderror" 
                                       value="{{ old('line_id') }}"
                                       placeholder="@...">
                                @error('line_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Images -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">รูปภาพ</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>รูปภาพหลัก</label>
                        <div class="custom-file">
                            <input type="file" name="image" 
                                   class="custom-file-input @error('image') is-invalid @enderror" 
                                   id="mainImage"
                                   accept="image/*">
                            <label class="custom-file-label" for="mainImage">เลือกรูปภาพ</label>
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <small class="text-muted">รองรับ: JPG, PNG, GIF (ไม่เกิน 4MB)</small>
                        <div id="mainImagePreview" class="mt-3"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>รูปภาพเพิ่มเติม (Gallery)</label>
                        <div class="custom-file">
                            <input type="file" name="gallery_images[]" 
                                   class="custom-file-input @error('gallery_images.*') is-invalid @enderror" 
                                   id="galleryImages"
                                   accept="image/*"
                                   multiple>
                            <label class="custom-file-label" for="galleryImages">เลือกหลายรูป</label>
                            @error('gallery_images.*')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <small class="text-muted">เลือกได้หลายรูป (แต่ละรูปไม่เกิน 2MB)</small>
                        <div id="galleryPreview" class="mt-3 row"></div>
                    </div>
                </div>
            </div>
            
            <!-- Location -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ตำแหน่งบนแผนที่</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>ละติจูด (Latitude)</label>
                        <input type="number" name="latitude" 
                               class="form-control @error('latitude') is-invalid @enderror" 
                               value="{{ old('latitude') }}"
                               step="0.000001"
                               min="-90" max="90"
                               id="latitude">
                        @error('latitude')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>ลองจิจูด (Longitude)</label>
                        <input type="number" name="longitude" 
                               class="form-control @error('longitude') is-invalid @enderror" 
                               value="{{ old('longitude') }}"
                               step="0.000001"
                               min="-180" max="180"
                               id="longitude">
                        @error('longitude')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="button" class="btn btn-info btn-sm" onclick="getCurrentLocation()">
                        <i class="fas fa-map-marker-alt"></i> ใช้ตำแหน่งปัจจุบัน
                    </button>
                    
                    <div id="map" style="height: 300px; margin-top: 15px;" class="border rounded"></div>
                </div>
            </div>
            
            <!-- Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ตั้งค่า</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active" 
                                   class="custom-control-input" 
                                   id="isActive"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="isActive">
                                เปิดใช้งาน
                            </label>
                        </div>
                        <small class="text-muted">หากปิดใช้งาน ชุมชนนี้จะไม่แสดงในหน้าเว็บไซต์</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> บันทึกข้อมูล
            </button>
            <a href="{{ route('admin.communities.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> ยกเลิก
            </a>
        </div>
    </div>
</form>

@push('scripts')
<!-- Include Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

<script>
// Image preview
document.getElementById('mainImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('mainImagePreview').innerHTML = 
                '<img src="' + e.target.result + '" class="img-fluid rounded">';
        }
        reader.readAsDataURL(file);
        
        // Update label
        e.target.nextElementSibling.textContent = file.name;
    }
});

// Gallery preview
document.getElementById('galleryImages').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.getElementById('galleryPreview');
    preview.innerHTML = '';
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML += 
                '<div class="col-4 mb-2">' +
                '<img src="' + e.target.result + '" class="img-fluid rounded">' +
                '</div>';
        }
        reader.readAsDataURL(file);
    }
    
    // Update label
    e.target.nextElementSibling.textContent = files.length + ' ไฟล์ที่เลือก';
});

// Map
let map;
let marker;

function initMap() {
    // Default center (Bangkok)
    const defaultLocation = { lat: 13.7563, lng: 100.5018 };
    
    map = new google.maps.Map(document.getElementById('map'), {
        center: defaultLocation,
        zoom: 12
    });
    
    // Click on map to set location
    map.addListener('click', function(event) {
        setMarker(event.latLng);
    });
    
    // Existing communities markers
    @if(isset($existingCommunities))
        @foreach($existingCommunities as $community)
            new google.maps.Marker({
                position: { lat: {{ $community->latitude }}, lng: {{ $community->longitude }} },
                map: map,
                title: '{{ $community->name }}',
                icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            });
        @endforeach
    @endif
}

function setMarker(location) {
    if (marker) {
        marker.setMap(null);
    }
    
    marker = new google.maps.Marker({
        position: location,
        map: map,
        draggable: true
    });
    
    document.getElementById('latitude').value = location.lat();
    document.getElementById('longitude').value = location.lng();
    
    // Update when marker is dragged
    marker.addListener('dragend', function(event) {
        document.getElementById('latitude').value = event.latLng.lat();
        document.getElementById('longitude').value = event.latLng.lng();
    });
}

function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            map.setCenter(pos);
            setMarker(new google.maps.LatLng(pos.lat, pos.lng));
        });
    } else {
        alert('Browser ของคุณไม่รองรับ Geolocation');
    }
}

// Convert พ.ศ. to ค.ศ. before submit
document.querySelector('form').addEventListener('submit', function(e) {
    const yearInput = document.querySelector('input[name="established_year"]');
    if (yearInput.value && yearInput.value > 2400) {
        yearInput.value = yearInput.value - 543;
    }
});
</script>
@endpush
@endsection