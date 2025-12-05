@extends('layouts.admin')

@section('title', 'แก้ไขข้อมูลชุมชน')
@section('header', 'แก้ไขข้อมูลชุมชน')

@section('content')
<form action="{{ route('admin.communities.update', $community->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
                               value="{{ old('name', $community->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>คำอธิบาย</label>
                        <textarea name="description" rows="4" 
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $community->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>จุดเด่น/ไฮไลท์ของชุมชน</label>
                        <textarea name="highlights" rows="3" 
                                  class="form-control @error('highlights') is-invalid @enderror">{{ old('highlights', $community->highlights) }}</textarea>
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
                                       value="{{ old('established_year', $community->established_year) }}">
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
                                       value="{{ old('population', $community->population) }}">
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
                                       value="{{ old('area_size', $community->area_size) }}">
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
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address', $community->address) }}</textarea>
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
                                       value="{{ old('contact_name', $community->contact_name) }}">
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
                                       value="{{ old('contact_phone', $community->contact_phone) }}">
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
                                       value="{{ old('contact_email', $community->contact_email) }}">
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
                                       value="{{ old('working_hours', $community->working_hours) }}">
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
                                       value="{{ old('website', $community->website) }}">
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
                                       value="{{ old('facebook', $community->facebook) }}">
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
                                       value="{{ old('line_id', $community->line_id) }}">
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
                        <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="mainImage">
                        @if($community->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$community->image) }}" class="img-fluid rounded">
                            </div>
                        @endif
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>รูปภาพเพิ่มเติม (Gallery)</label>
                        <input type="file" name="gallery_images[]" multiple>
                        @if($community->gallery_images)
                            <div class="row mt-2">
                                @foreach($community->gallery_images as $img)
                                    <div class="col-4 mb-2">
                                        <img src="{{ asset('storage/'.$img) }}" class="img-fluid rounded">
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
                        <input type="number" 
                               step="0.000001" 
                               name="latitude" 
                               id="latitude"
                               class="form-control"
                               value="{{ old('latitude', $community->latitude) }}"
                               placeholder="เช่น 13.7563">
                    </div>
                    <div class="form-group">
                        <label>ลองจิจูด (Longitude)</label>
                        <input type="number" 
                               step="0.000001" 
                               name="longitude" 
                               id="longitude"
                               class="form-control"
                               value="{{ old('longitude', $community->longitude) }}"
                               placeholder="เช่น 100.5018">
                    </div>
                    
                    <button type="button" class="btn btn-info btn-sm mb-3" onclick="getCurrentLocation(this)">
                        <i class="fas fa-map-marker-alt"></i> ใช้ตำแหน่งปัจจุบัน
                    </button>
                    
                    <div id="map" style="height: 300px;" class="border rounded"></div>
                </div>
            </div>

            <!-- Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ตั้งค่า</h3>
                </div>
                <div class="card-body">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $community->is_active) ? 'checked' : '' }}> เปิดใช้งาน
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card mt-3">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> อัปเดตข้อมูล
            </button>
            <a href="{{ route('admin.communities.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> ยกเลิก
            </a>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.api_key') }}&callback=initMap" async defer></script>
<script>
// Map
let map;
let marker;
let mapLoaded = false;

function initMap() {
    console.log('initMap called (edit page)');
    // Use existing coordinates or default to Bangkok
    const existingLat = parseFloat(document.getElementById('latitude').value) || 13.7563;
    const existingLng = parseFloat(document.getElementById('longitude').value) || 100.5018;
    const defaultLocation = { lat: existingLat, lng: existingLng };
    
    try {
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: existingLat && existingLng ? 15 : 12
        });
        
        mapLoaded = true;
        console.log('Map initialized successfully');
        
        // Set existing marker if coordinates exist
        if (document.getElementById('latitude').value && document.getElementById('longitude').value) {
            setMarker(new google.maps.LatLng(existingLat, existingLng));
        }
    } catch (error) {
        console.error('Error initializing map:', error);
        mapLoaded = false;
    }
    
    // Click on map to set location
    map.addListener('click', function(event) {
        setMarker(event.latLng);
    });
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

function getCurrentLocation(button) {
    console.log('getCurrentLocation called');
    
    if (!button) {
        console.error('Button element not found');
        return;
    }
    
    const originalHTML = button.innerHTML;
    
    // แสดง loading
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังค้นหาตำแหน่ง...';
    
    console.log('Checking geolocation support...');
    
    if (navigator.geolocation) {
        console.log('Geolocation is supported');
        navigator.geolocation.getCurrentPosition(
            function(position) {
                console.log('Position received:', position);
                
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                console.log('Coordinates:', pos);
                
                // อัปเดตค่า input
                document.getElementById('latitude').value = pos.lat;
                document.getElementById('longitude').value = pos.lng;
                
                console.log('Input fields updated');
                
                // อัปเดตแผนที่
                if (mapLoaded && map && typeof google !== 'undefined') {
                    try {
                        map.setCenter(pos);
                        map.setZoom(15);
                        setMarker(new google.maps.LatLng(pos.lat, pos.lng));
                        console.log('Map updated');
                    } catch (mapError) {
                        console.error('Error updating map:', mapError);
                    }
                } else {
                    console.warn('Map not loaded or Google Maps API not available');
                    console.log('mapLoaded:', mapLoaded);
                    console.log('map:', map);
                    console.log('google:', typeof google);
                }
                
                // แสดงข้อความสำเร็จ
                button.innerHTML = '<i class="fas fa-check"></i> ใช้ตำแหน่งปัจจุบันสำเร็จ';
                button.classList.remove('btn-info');
                button.classList.add('btn-success');
                
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-info');
                    button.disabled = false;
                }, 2000);
            },
            function(error) {
                console.error('Geolocation error:', error);
                
                let errorMessage = 'ไม่สามารถรับตำแหน่งได้';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'กรุณาอนุญาตการเข้าถึงตำแหน่งในเบราว์เซอร์';
                        console.error('Permission denied');
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'ไม่สามารถระบุตำแหน่งได้';
                        console.error('Position unavailable');
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'หมดเวลาในการรับตำแหน่ง';
                        console.error('Timeout');
                        break;
                }
                
                alert(errorMessage);
                
                button.innerHTML = originalHTML;
                button.disabled = false;
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        alert('เบราว์เซอร์ของคุณไม่รองรับการระบุตำแหน่ง (Geolocation)');
        button.innerHTML = originalHTML;
        button.disabled = false;
    }
}
</script>
@endpush
