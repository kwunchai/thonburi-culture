@extends('layouts.admin')

@section('title', 'รายละเอียดกิจกรรม')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-eye mr-2"></i>
                    รายละเอียดกิจกรรม
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">จัดการกิจกรรม</a></li>
                    <li class="breadcrumb-item active">รายละเอียดกิจกรรม</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            {{ $activity->title }}
                        </h3>
                        <div class="card-tools">
                            <span class="badge {{ $activity->is_active ? 'badge-success' : 'badge-secondary' }}">
                                <i class="fas fa-{{ $activity->is_active ? 'eye' : 'eye-slash' }} mr-1"></i>
                                {{ $activity->is_active ? 'เปิดการแสดงผล' : 'ปิดการแสดงผล' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($activity->description)
                        <div class="mb-4">
                            <h5><i class="fas fa-file-text text-info mr-2"></i>คำอธิบายกิจกรรม</h5>
                            <p class="text-muted">{{ $activity->description }}</p>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-tag text-warning mr-2"></i>หมวดหมู่กิจกรรม</h5>
                                <p>
                                    @if($activity->category)
                                        <span class="badge badge-primary">{{ $activity->category->name }}</span>
                                    @else
                                        <span class="text-muted">ไม่ได้ระบุหมวดหมู่</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-calendar text-primary mr-2"></i>วันที่กิจกรรม</h5>
                                <p>
                                    @if($activity->activity_date)
                                        {{ $activity->formatted_date }}
                                    @else
                                        <span class="text-muted">ไม่ได้ระบุ</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-map-marker-alt text-danger mr-2"></i>สถานที่</h5>
                                <p>
                                    @if($activity->location)
                                        {{ $activity->location }}
                                    @else
                                        <span class="text-muted">ไม่ได้ระบุ</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-map-marker-alt text-danger mr-2"></i>สถานที่</h5>
                                <p>
                                    @if($activity->location)
                                        {{ $activity->location }}
                                    @else
                                        <span class="text-muted">ไม่ได้ระบุ</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5><i class="fas fa-user text-success mr-2"></i>ผู้สร้าง</h5>
                                <p>{{ $activity->creator ? $activity->creator->name : 'ไม่ทราบ' }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">วันที่สร้าง</h6>
                                <p>{{ $activity->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">แก้ไขล่าสุด</h6>
                                <p>{{ $activity->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Main Image -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-image mr-1"></i>
                            รูปภาพหลักกิจกรรม
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($activity->image)
                            <img src="{{ Storage::url($activity->image) }}" 
                                 alt="{{ $activity->title }}" 
                                 class="img-fluid w-100" 
                                 style="max-height: 300px; object-fit: cover; cursor: pointer;"
                                 onclick="openImageModal('{{ Storage::url($activity->image) }}', '{{ $activity->title }} - รูปภาพหลัก')">
                            <div class="p-3">
                                <small class="text-muted">คลิกที่รูปภาพเพื่อดูขนาดใหญ่</small>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="height: 200px; background-color: #f8f9fa;">
                                <div class="text-center">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">ไม่มีรูปภาพหลัก</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Images Gallery -->
                @if($activity->images && count($activity->images) > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-images mr-1"></i>
                            รูปภาพเพิ่มเติม ({{ count($activity->images) }} รูป)
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($activity->images as $index => $imagePath)
                            <div class="col-6 mb-3">
                                <div class="image-thumbnail">
                                    <img src="{{ Storage::url($imagePath) }}" 
                                         alt="{{ $activity->title }} - รูปที่ {{ $index + 1 }}" 
                                         class="img-fluid rounded shadow-sm"
                                         style="width: 100%; height: 80px; object-fit: cover; cursor: pointer;"
                                         onclick="openImageModal('{{ Storage::url($imagePath) }}', '{{ $activity->title }} - รูปที่ {{ $index + 1 }}')">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <small class="text-muted">คลิกที่รูปภาพเพื่อดูขนาดใหญ่</small>
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tools mr-1"></i>
                            การจัดการ
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.activities.edit', $activity) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit mr-2"></i>
                                แก้ไขกิจกรรม
                            </a>
                            
                            <form method="POST" action="{{ route('admin.activities.toggle-status', $activity) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn {{ $activity->is_active ? 'btn-secondary' : 'btn-success' }} btn-block">
                                    <i class="fas fa-{{ $activity->is_active ? 'eye-slash' : 'eye' }} mr-2"></i>
                                    {{ $activity->is_active ? 'ปิดการแสดงผล' : 'เปิดการแสดงผล' }}
                                </button>
                            </form>

                            <button type="button" 
                                    class="btn btn-danger btn-block" 
                                    onclick="confirmDelete('{{ $activity->id }}', '{{ $activity->title }}')">
                                <i class="fas fa-trash mr-2"></i>
                                ลบกิจกรรม
                            </button>

                            <hr>

                            <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-arrow-left mr-2"></i>
                                กลับไปรายการ
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Frontend Preview -->
                @if($activity->is_active)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-external-link-alt mr-1"></i>
                            ดูตัวอย่าง
                        </h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('activities') }}" target="_blank" class="btn btn-info btn-block">
                            <i class="fas fa-globe mr-2"></i>
                            ดูในหน้าเว็บไซต์
                        </a>
                        <small class="text-muted d-block mt-2">เปิดในแท็บใหม่</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">รูปภาพกิจกรรม</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                    ยืนยันการลบ
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>คุณต้องการลบกิจกรรม "<span id="activityName"></span>" ใช่หรือไม่?</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    <small>การดำเนินการนี้ไม่สามารถย้อนกลับได้ และจะลบรูปภาพที่เกี่ยวข้องด้วย</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i>
                        ลบกิจกรรม
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalTitle').innerText = title;
    $('#imageModal').modal('show');
}

function confirmDelete(activityId, activityName) {
    document.getElementById('activityName').innerText = activityName;
    document.getElementById('deleteForm').action = `/admin/activities/${activityId}`;
    $('#deleteModal').modal('show');
}
</script>
@endpush