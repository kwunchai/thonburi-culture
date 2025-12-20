@extends('layouts.admin')

@section('title', 'จัดการกิจกรรม')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-images mr-2"></i>
                    จัดการกิจกรรม
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">จัดการกิจกรรม</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        {{-- Flash messages now centralized in layout --}}

        <!-- Main row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-1"></i>
                            รายการกิจกรรม
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.activities.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i>
                                เพิ่มกิจกรรมใหม่
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($activities->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="80">รูปภาพ</th>
                                        <th>ชื่อกิจกรรม</th>
                                        <th width="130">หมวดหมู่</th>
                                        <th width="120">วันที่กิจกรรม</th>
                                        <th width="120">สถานที่</th>
                                        <th width="80">สถานะ</th>
                                        <th width="150">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                    <tr>
                                        <td>
                                            @if($activity->image)
                                                <div class="position-relative">
                                                    <img src="{{ Storage::url($activity->image) }}" 
                                                         alt="{{ $activity->title }}" 
                                                         class="img-thumbnail"
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                    @if($activity->images && count($activity->images) > 0)
                                                        <span class="badge badge-info position-absolute" 
                                                              style="top: -5px; right: -5px; font-size: 10px;">
                                                            +{{ count($activity->images) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px; border-radius: 4px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                    @if($activity->images && count($activity->images) > 0)
                                                        <span class="badge badge-info position-absolute" 
                                                              style="top: -5px; right: -5px; font-size: 10px;">
                                                            {{ count($activity->images) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $activity->title }}</strong>
                                            @if($activity->description)
                                                <br>
                                                <small class="text-muted">{{ Str::limit($activity->description, 60) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($activity->category)
                                                <span class="badge badge-primary">
                                                    {{ $activity->category->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($activity->activity_date)
                                                <i class="fas fa-calendar text-info mr-1"></i>
                                                {{ $activity->formatted_date }}
                                            @else
                                                <span class="text-muted">ไม่ระบุ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($activity->location)
                                                <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                                {{ Str::limit($activity->location, 20) }}
                                            @else
                                                <span class="text-muted">ไม่ระบุ</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.activities.toggle-status', $activity) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $activity->is_active ? 'btn-success' : 'btn-secondary' }}" 
                                                        title="{{ $activity->is_active ? 'คลิกเพื่อปิด' : 'คลิกเพื่อเปิด' }}">
                                                    <i class="fas fa-{{ $activity->is_active ? 'eye' : 'eye-slash' }}"></i>
                                                    {{ $activity->is_active ? 'เปิด' : 'ปิด' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.activities.show', $activity) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="ดูรายละเอียด">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.activities.edit', $activity) }}" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="แก้ไข">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="confirmDelete({{ $activity->id }}, '{{ $activity->title }}')" 
                                                        title="ลบ">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    แสดง {{ $activities->firstItem() }} ถึง {{ $activities->lastItem() }} 
                                    จากทั้งหมด {{ $activities->total() }} รายการ
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                {{ $activities->links() }}
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">ยังไม่มีกิจกรรม</h5>
                            <p class="text-muted">เริ่มต้นเพิ่มกิจกรรมแรกของคุณ</p>
                            <a href="{{ route('admin.activities.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i>
                                เพิ่มกิจกรรมใหม่
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                    <i class="fas fa-warning mr-1"></i>
                    <small>การดำเนินการนี้ไม่สามารถย้อนกลับได้</small>
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
function confirmDelete(activityId, activityName) {
    document.getElementById('activityName').innerText = activityName;
    document.getElementById('deleteForm').action = `/admin/activities/${activityId}`;
    $('#deleteModal').modal('show');
}

// Auto close alerts after 5 seconds
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);
</script>
@endpush