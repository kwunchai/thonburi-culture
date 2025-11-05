@extends('layouts.admin')

@section('title', 'แก้ไขข้อมูลวัฒนธรรม')
@section('header', 'แก้ไขข้อมูลวัฒนธรรม')

@section('content')
<div class="card">
    <form action="{{ route('admin.cultural-items.update', $culturalItem) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>ชื่อ *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title', $culturalItem->title) }}" required>
                @error('title')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>หมวดหมู่ *</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">-- เลือก --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $culturalItem->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>ชุมชน *</label>
                        <select name="community_id" class="form-control @error('community_id') is-invalid @enderror" required>
                            <option value="">-- เลือก --</option>
                            @foreach($communities as $community)
                                <option value="{{ $community->id }}" 
                                    {{ old('community_id', $culturalItem->community_id) == $community->id ? 'selected' : '' }}>
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

            <div class="form-group">
                <label>รายละเอียด *</label>
                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $culturalItem->description) }}</textarea>
                @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Google Maps Location Picker -->
            <div class="form-group">
                <label>ตำแหน่งที่ตั้ง</label>
                <p class="text-muted small">คลิกและลากหมุดบนแผนที่เพื่อระบุตำแหน่งที่ตั้งของข้อมูลวัฒนธรรม</p>
                <div class="row">
                    <div class="col-md-6">
                        <label for="latitude">ละติจูด</label>
                        <input type="number" step="any" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" 
                               value="{{ old('latitude', $culturalItem->latitude ?? config('maps.default_coordinates.latitude')) }}" readonly>
                        @error('latitude')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="longitude">ลองจิจูด</label>
                        <input type="number" step="any" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" 
                               value="{{ old('longitude', $culturalItem->longitude ?? config('maps.default_coordinates.longitude')) }}" readonly>
                        @error('longitude')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-3">
                    <div id="map-picker" style="height: 400px; border: 1px solid #ddd; border-radius: 0.25rem;"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>รูปภาพ</label>
                        @if($culturalItem->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($culturalItem->image) }}" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>วันที่เผยแพร่ *</label>
                        <input type="date" name="publish_date" class="form-control @error('publish_date') is-invalid @enderror" 
                               value="{{ old('publish_date', $culturalItem->publish_date->format('Y-m-d')) }}" required>
                        @error('publish_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" 
                           {{ old('is_published', $culturalItem->is_published) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_published">เผยแพร่ทันที</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="{{ route('admin.cultural-items.index') }}" class="btn btn-default">ยกเลิก</a>
        </div>
    </form>
</div>

@push('scripts')
<!-- Google Maps JavaScript API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('maps.api_key') }}&callback=initMapPicker&libraries=places"></script>

<script>
let map;
let marker;
let geocoder;

function initMapPicker() {
    // ตำแหน่งเริ่มต้น - ใช้พิกัดจากข้อมูลหรือค่าเริ่มต้น
    const savedLat = parseFloat(document.getElementById('latitude').value);
    const savedLng = parseFloat(document.getElementById('longitude').value);
    
    const defaultPosition = {
        lat: !isNaN(savedLat) ? savedLat : {{ config('maps.default_coordinates.latitude') }},
        lng: !isNaN(savedLng) ? savedLng : {{ config('maps.default_coordinates.longitude') }}
    };

    // สร้างแผนที่
    map = new google.maps.Map(document.getElementById('map-picker'), {
        zoom: {{ config('maps.map_defaults.zoom') }},
        center: defaultPosition,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // สร้าง Geocoder
    geocoder = new google.maps.Geocoder();

    // สร้างหมุดที่สามารถลากได้
    marker = new google.maps.Marker({
        position: defaultPosition,
        map: map,
        draggable: true,
        title: 'ลากหมุดเพื่อเลือกตำแหน่ง',
        animation: google.maps.Animation.DROP
    });

    // อัปเดตพิกัดเมื่อลากหมุด
    marker.addListener('dragend', function() {
        const position = marker.getPosition();
        updateCoordinates(position.lat(), position.lng());
    });

    // อัปเดตหมุดเมื่อคลิกบนแผนที่
    map.addListener('click', function(event) {
        const position = event.latLng;
        marker.setPosition(position);
        updateCoordinates(position.lat(), position.lng());
    });

    // อัปเดตแผนที่เมื่อกรอกพิกัดด้วยตนเอง
    document.getElementById('latitude').addEventListener('change', function() {
        updateMapFromCoordinates();
    });

    document.getElementById('longitude').addEventListener('change', function() {
        updateMapFromCoordinates();
    });
}

function updateCoordinates(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
}

function updateMapFromCoordinates() {
    const lat = parseFloat(document.getElementById('latitude').value);
    const lng = parseFloat(document.getElementById('longitude').value);
    
    if (!isNaN(lat) && !isNaN(lng)) {
        const position = new google.maps.LatLng(lat, lng);
        marker.setPosition(position);
        map.setCenter(position);
    }
}

// จัดการกรณีที่ API ไม่โหลด
window.addEventListener('load', function() {
    if (typeof google === 'undefined') {
        document.getElementById('map-picker').innerHTML = 
            '<div class="alert alert-warning text-center p-4">' +
            '<i class="fas fa-exclamation-triangle"></i> ' +
            'ไม่สามารถโหลด Google Maps API ได้<br>' +
            '<small>กรุณาตรวจสอบการตั้งค่า API Key</small>' +
            '</div>';
    }
});
</script>
@endpush
@endsection