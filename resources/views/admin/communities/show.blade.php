@extends('layouts.admin')

@section('title', 'รายละเอียดชุมชน: ' . $community->name)
@section('header', 'รายละเอียดชุมชน')

@section('content')
<div class="row">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Basic Info Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marked-alt"></i> {{ $community->name }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.communities.edit', $community) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> แก้ไข
                    </a>
                    @if(!$community->is_active)
                    <span class="badge badge-danger">ปิดใช้งาน</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($community->image)
                <div class="text-center mb-4">
                    <img src="{{ Storage::url($community->image) }}" 
                         alt="{{ $community->name }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 400px;">
                </div>
                @endif
                
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th style="width: 40%">ปีที่ก่อตั้ง:</th>
                                <td>{{ $community->established_year ? ($community->established_year + 543) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>จำนวนประชากร:</th>
                                <td>{{ $community->population ? number_format($community->population) . ' คน' : '-' }}</td>
                            </tr>
                            <tr>
                                <th>พื้นที่:</th>
                                <td>{{ $community->area_size ? number_format($community->area_size, 2) . ' ตร.กม.' : '-' }}</td>
                            </tr>
                            <tr>
                                <th>เวลาทำการ:</th>
                                <td>{{ $community->working_hours ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th style="width: 30%">ผู้ติดต่อ:</th>
                                <td>{{ $community->contact_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>โทรศัพท์:</th>
                                <td>
                                    @if($community->contact_phone)
                                    <a href="tel:{{ $community->contact_phone }}">{{ $community->contact_phone }}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>อีเมล:</th>
                                <td>
                                    @if($community->contact_email)
                                    <a href="mailto:{{ $community->contact_email }}">{{ $community->contact_email }}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>เว็บไซต์:</th>
                                <td>
                                    @if($community->website)
                                    <a href="{{ $community->website }}" target="_blank">{{ Str::limit($community->website, 30) }}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($community->description)
                <div class="mt-3">
                    <h5>คำอธิบาย</h5>
                    <p>{{ $community->description }}</p>
                </div>
                @endif
                
                @if($community->highlights)
                <div class="mt-3">
                    <h5>จุดเด่น/ไฮไลท์</h5>
                    <p>{{ $community->highlights }}</p>
                </div>
                @endif
                
                @if($community->address)
                <div class="mt-3">
                    <h5>ที่อยู่</h5>
                    <p>{{ $community->getDisplayAddress() }}</p>
                </div>
                @endif
                
                <!-- Social Media -->
                @if($community->facebook || $community->line_id)
                <div class="mt-3">
                    <h5>โซเชียลมีเดีย</h5>
                    @if($community->facebook)
                    <a href="{{ $community->facebook }}" target="_blank" class="btn btn-primary btn-sm mr-2">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                    @endif
                    @if($community->line_id)
                    <span class="badge badge-success">
                        <i class="fab fa-line"></i> Line: {{ $community->line_id }}
                    </span>
                    @endif
                </div>
                @endif
            </div>
        </div>
        
        <!-- Gallery -->
        @if($community->gallery_images && count($community->gallery_images) > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">รูปภาพเพิ่มเติม</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($community->gallery_images as $image)
                    <div class="col-md-4 mb-3">
                        <a href="{{ Storage::url($image) }}" target="_blank">
                            <img src="{{ Storage::url($image) }}" 
                                 class="img-fluid rounded shadow-sm">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        
        <!-- Cultural Items -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    ข้อมูลวัฒนธรรมในชุมชน ({{ $stats['total_items'] }} รายการ)
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.cultural-items.create') }}?community_id={{ $community->id }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> เพิ่มข้อมูลวัฒนธรรม
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($community->culturalItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ชื่อ</th>
                                <th>หมวดหมู่</th>
                                <th>วันที่เผยแพร่</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($community->culturalItems as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->category->name }}</span>
                                </td>
                                <td>{{ $item->publish_date->format('d/m/Y') }}</td>
                                <td>
                                    @if($item->is_featured)
                                    <span class="badge badge-warning">Featured</span>
                                    @endif
                                    @if($item->is_published)
                                    <span class="badge badge-success">เผยแพร่</span>
                                    @else
                                    <span class="badge badge-secondary">ฉบับร่าง</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.cultural-items.edit', $item) }}" 
                                       class="btn btn-xs btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-3"></i><br>
                    ยังไม่มีข้อมูลวัฒนธรรมในชุมชนนี้
                </p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">สถิติ</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="h3 mb-0">{{ $stats['total_items'] }}</div>
                        <small class="text-muted">ข้อมูลทั้งหมด</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="h3 mb-0">{{ $stats['published_items'] }}</div>
                        <small class="text-muted">เผยแพร่แล้ว</small>
                    </div>
                    <div class="col-6">
                        <div class="h3 mb-0">{{ $stats['featured_items'] }}</div>
                        <small class="text-muted">Featured</small>
                    </div>
                    <div class="col-6">
                        <div class="h3 mb-0">{{ count($stats['categories']) }}</div>
                        <small class="text-muted">หมวดหมู่</small>
                    </div>
                </div>
                
                @if(count($stats['categories']) > 0)
                <hr>
                <h6>ข้อมูลตามหมวดหมู่</h6>
                @foreach($stats['categories'] as $cat)
                <div class="d-flex justify-content-between mb-1">
                    <span>{{ $cat->category->name }}</span>
                    <strong>{{ $cat->total }}</strong>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        
        <!-- Map -->
        @if($community->hasLocation())
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ตำแหน่งบนแผนที่</h3>
            </div>
            <div class="card-body">
                <div id="map" style="height: 300px;" class="rounded"></div>
                <div class="mt-2">
                    <small class="text-muted">
                        พิกัด: {{ $community->latitude }}, {{ $community->longitude }}
                    </small>
                </div>
                <a href="{{ $community->getMapUrl() }}" target="_blank" class="btn btn-info btn-sm mt-2">
                    <i class="fas fa-external-link-alt"></i> ดูใน Google Maps
                </a>
            </div>
        </div>
        @endif
        
        <!-- Nearby Communities -->
        @if(count($nearbyCommunities) > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ชุมชนใกล้เคียง</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($nearbyCommunities as $nearby)
                    <li class="list-group-item">
                        <a href="{{ route('admin.communities.show', $nearby) }}">
                            {{ $nearby->name }}
                        </a>
                        <br>
                        <small class="text-muted">
                            ระยะห่าง {{ number_format($nearby->distance, 2) }} กม.
                        </small>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        <!-- Actions -->
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.communities.edit', $community) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> แก้ไขข้อมูล
                </a>
                
                <form action="{{ route('admin.communities.destroy', $community) }}" 
                      method="POST" 
                      onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบชุมชนนี้?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block mt-2">
                        <i class="fas fa-trash"></i> ลบชุมชน
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($community->hasLocation())
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
<script>
function initMap() {
    const location = { lat: {{ $community->latitude }}, lng: {{ $community->longitude }} };
    const map = new google.maps.Map(document.getElementById('map'), {
        center: location,
        zoom: 15
    });
    
    new google.maps.Marker({
        position: location,
        map: map,
        title: '{{ $community->name }}'
    });
}
</script>
@endpush
@endif
@endsection