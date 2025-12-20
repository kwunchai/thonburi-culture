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
                                <input type="text" name="established_year" 
                                       class="form-control @error('established_year') is-invalid @enderror" 
                                       value="{{ old('established_year') }}"
                                       placeholder="เช่น 2510">
                                <small class="form-text text-muted">ระบุปี พ.ศ. (ค.ศ. + 543) เช่น 2510</small>
                                @error('established_year')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>จำนวนประชากร (คน)</label>
                                <input type="text" name="population" 
                                       class="form-control @error('population') is-invalid @enderror" 
                                       value="{{ old('population') }}"
                                       placeholder="เช่น 1,500-1,800 หรือ ประมาณ 2,000 คน">
                                <small class="form-text text-muted">สามารถระบุเป็นข้อความหรือช่วงได้</small>
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
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
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
                    
                    <button type="button" class="btn btn-info btn-sm" onclick="getCurrentLocation(this)">
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.api_key') }}&callback=initMap" async defer></script>

<script>
// Map
let map;
let marker;
let mapLoaded = false;

function initMap() {
    console.log('initMap called');
    // Default center (Bangkok)
    const defaultLocation = { lat: 13.7563, lng: 100.5018 };
    
    try {
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 12
        });
        
        mapLoaded = true;
        console.log('Map initialized successfully');
        
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
    } catch (error) {
        console.error('Error initializing map:', error);
        mapLoaded = false;
    }
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