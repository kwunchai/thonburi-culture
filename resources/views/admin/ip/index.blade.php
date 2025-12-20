@extends('layouts.admin')

@section('title', 'จัดการทรัพย์สินทางปัญญา')
@section('header', 'จัดการทรัพย์สินทางปัญญา')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_items'] }}</h3>
                <p>ทรัพย์สินทางปัญญาทั้งหมด</p>
            </div>
            <div class="icon">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['active_items'] }}</h3>
                <p>สถานะใช้งาน</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['registered_items'] }}</h3>
                <p>ลงทะเบียนแล้ว</p>
            </div>
            <div class="icon">
                <i class="fas fa-certificate"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending_items'] }}</h3>
                <p>รอการอนุมัติ</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
</div>

<!-- Type Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $stats['copyright_items'] }}</h3>
                <p>ลิขสิทธิ์</p>
            </div>
            <div class="icon">
                <i class="fas fa-copyright"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-teal">
            <div class="inner">
                <h3>{{ $stats['patent_items'] }}</h3>
                <p>สิทธิบัตร</p>
            </div>
            <div class="icon">
                <i class="fas fa-lightbulb"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ $stats['trademark_items'] }}</h3>
                <p>เครื่องหมายการค้า</p>
            </div>
            <div class="icon">
                <i class="fas fa-trademark"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-indigo">
            <div class="inner">
                <h3>{{ $stats['local_wisdom_items'] }}</h3>
                <p>ภูมิปัญญาท้องถิ่น</p>
            </div>
            <div class="icon">
                <i class="fas fa-leaf"></i>
            </div>
        </div>
    </div>
</div>

<!-- Additional Statistics -->
<div class="row mb-4">
    <div class="col-lg-4 col-12">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $stats['with_registration'] }}</h3>
                <p>มีเลขทะเบียน</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['expired_items'] }}</h3>
                <p>หมดอายุแล้ว</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3>{{ $stats['expiring_soon'] }}</h3>
                <p>ใกล้หมดอายุ (30 วัน)</p>
            </div>
            <div class="icon">
                <i class="fas fa-bell"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-search"></i> ค้นหาและกรองข้อมูล
        </h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.ip.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>ค้นหา</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="ชื่อ, เลขทะเบียน..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>ประเภท</label>
                        <select name="type" class="form-control">
                            <option value="">ทุกประเภท</option>
                            @foreach(\App\Enums\IpType::cases() as $type)
                                <option value="{{ $type->value }}" {{ request('type') == $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>สถานะ</label>
                        <select name="status" class="form-control">
                            <option value="">ทุกสถานะ</option>
                            @foreach(\App\Enums\IpStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>เรียงลำดับ</label>
                        <select name="order" class="form-control">
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>ใหม่→เก่า</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>เก่า→ใหม่</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="fas fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @if(request('search') || request('type') || request('status') || request('order') != 'desc')
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin.ip.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> ล้างการค้นหา
                        </a>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Header Section -->
<div class="row align-items-center mb-3">
    <div class="col-md-6">
        <h3 class="mb-0">
            <i class="fas fa-shield-alt"></i> รายการทรัพย์สินทางปัญญา
            @if(request('search'))
                <small class="text-muted">(ผลการค้นหา: "{{ request('search') }}")</small>
            @endif
        </h3>
    </div>
    <div class="col-md-6 text-right">
        <div class="btn-group">
            <a href="{{ route('admin.ip.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> เพิ่มทรัพย์สินใหม่
            </a>
        </div>
        <div class="btn-group ml-2">
            <a href="{{ route('admin.ip.import.form') }}" class="btn btn-success">
                <i class="fas fa-file-import"></i> นำเข้าจาก Excel
            </a>
        </div>
        <div class="btn-group ml-2">
            <button type="button" class="btn btn-outline-danger" id="bulkDeleteBtn" style="display:none;" onclick="event.preventDefault(); confirmBulkDelete(); return false;">
                <i class="fas fa-trash-alt"></i> ลบรายการที่เลือก (<span id="selectedCount">0</span>)
            </button>
        </div>
        <div class="btn-group ml-2">
            <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-download"></i> ส่งออกข้อมูล
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('admin.ip.export', array_merge(request()->all(), ['export' => 'excel'])) }}">
                    <i class="fas fa-file-excel text-success"></i> ส่งออก Excel
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
@if($items->count() > 0)
    <form id="bulkDeleteForm" action="{{ route('admin.ip.bulk-destroy') }}" method="POST">
        @csrf
        <!-- Hidden submit button for bulk delete -->
        <button type="submit" id="bulkDeleteSubmit" style="display: none;"></button>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="30">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="selectAll">
                                    <label class="custom-control-label" for="selectAll"></label>
                                </div>
                            </th>
                            <th><i class="fas fa-id-card"></i> เลขทะเบียน</th>
                            <th><i class="fas fa-file-alt"></i> ชื่อเรื่อง</th>
                            <th><i class="fas fa-tag"></i> ประเภท</th>
                            <th><i class="fas fa-info-circle"></i> สถานะ</th>
                            <th><i class="fas fa-calendar"></i> วันที่ลงทะเบียน</th>
                            <th class="text-center" width="150"><i class="fas fa-cogs"></i> การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input row-checkbox" 
                                               id="check{{ $item->ip_id }}" 
                                               name="selected_ids[]" 
                                               value="{{ $item->ip_id }}">
                                        <label class="custom-control-label" for="check{{ $item->ip_id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ $item->registration_number ?: 'ยังไม่มี' }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $item->title }}</strong>
                                    @if($item->description)
                                        <br>
                                        <small class="text-muted">
                                            {{ Str::limit($item->description, 80) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($item->type)
                                            @case('copyright') badge-info @break
                                            @case('invention_patent') badge-success @break
                                            @case('trademark') badge-warning @break
                                            @case('tk') badge-primary @break
                                            @case('petty_patent') badge-success @break
                                            @case('design_patent') badge-success @break
                                            @case('gi') badge-info @break
                                            @default badge-secondary
                                        @endswitch
                                    ">
                                        {{ $item->type_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($item->status)
                                            @case('registered') badge-success @break
                                            @case('submitted') badge-warning @break
                                            @case('under_review') badge-info @break
                                            @case('expired') badge-danger @break
                                            @case('draft') badge-secondary @break
                                            @case('rejected') badge-danger @break
                                            @default badge-light
                                        @endswitch
                                    ">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->registration_date)
                                        {{ $item->registration_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.ip.show', $item) }}" 
                                           class="btn btn-sm btn-info" title="ดูรายละเอียด">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.ip.edit', $item) }}" 
                                           class="btn btn-sm btn-warning" title="แก้ไข">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.ip.destroy', $item) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('ยืนยันการลบข้อมูลนี้?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="ลบ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">ไม่พบข้อมูลทรัพย์สินทางปัญญา</h5>
                @if(request('search') || request('type') || request('status'))
                    <p class="text-muted">ลองปรับเงื่อนไขการค้นหาใหม่</p>
                    <a href="{{ route('admin.ip.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> ล้างการค้นหา
                    </a>
                @else
                    <p class="text-muted">เริ่มต้นด้วยการเพิ่มทรัพย์สินทางปัญญาใหม่</p>
                    <a href="{{ route('admin.ip.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> เพิ่มทรัพย์สินใหม่
                    </a>
                @endif
            </div>
        </div>
    @endif

<!-- Pagination -->
@if($items->hasPages())
    <div class="card mt-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        แสดง {{ $items->firstItem() }} ถึง {{ $items->lastItem() }} จากทั้งหมด {{ $items->total() }} รายการ
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end mb-0">
                            {{-- Previous Page Link --}}
                            @if ($items->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">« ก่อนหน้า</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $items->previousPageUrl() }}">« ก่อนหน้า</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                                @if ($page == $items->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($items->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $items->nextPageUrl() }}">ถัดไป »</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">ถัดไป »</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Flash messages now centralized in layout --}}
@endsection

@push('scripts')
<script>
console.log('IP Bulk Delete Scripts Loaded');
console.log('Form exists:', document.getElementById('bulkDeleteForm') !== null);
console.log('Button exists:', document.getElementById('bulkDeleteBtn') !== null);

// Select All Functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkDeleteButton();
});

// Individual Checkbox Change
document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        updateBulkDeleteButton();
        updateSelectAllState();
    });
});

// Update Bulk Delete Button Visibility
function updateBulkDeleteButton() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCount = document.getElementById('selectedCount');
    
    if (checkedBoxes.length > 0) {
        bulkDeleteBtn.style.display = 'inline-block';
        selectedCount.textContent = checkedBoxes.length;
    } else {
        bulkDeleteBtn.style.display = 'none';
    }
}

// Update Select All Checkbox State
function updateSelectAllState() {
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    if (checkedCheckboxes.length === 0) {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
    } else if (checkedCheckboxes.length === allCheckboxes.length) {
        selectAllCheckbox.checked = true;
        selectAllCheckbox.indeterminate = false;
    } else {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = true;
    }
}

// Confirm Bulk Delete
function confirmBulkDelete() {
    console.log('confirmBulkDelete called');
    
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    console.log('Checked boxes:', checkedBoxes.length);
    
    if (checkedBoxes.length === 0) {
        alert('กรุณาเลือกรายการที่ต้องการลบ');
        return false;
    }
    
    const form = document.getElementById('bulkDeleteForm');
    console.log('Form element:', form);
    console.log('Form action:', form ? form.action : 'FORM NOT FOUND');
    console.log('Form method:', form ? form.method : 'FORM NOT FOUND');
    
    if (!form) {
        console.error('Bulk delete form not found!');
        alert('เกิดข้อผิดพลาด: ไม่พบฟอร์มลบข้อมูล');
        return false;
    }
    
    const count = checkedBoxes.length;
    const message = `คุณแน่ใจหรือไม่ที่จะลบทรัพย์สินทางปัญญา ${count} รายการ?\n\nการดำเนินการนี้ไม่สามารถย้อนกลับได้`;
    
    if (confirm(message)) {
        console.log('User confirmed, submitting form via fetch...');
        
        // Get CSRF token
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        // Get selected IDs
        const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);
        console.log('Selected IDs:', selectedIds);
        console.log('CSRF Token:', csrfToken);
        console.log('Form action URL:', form.action);
        
        // Create form data
        const formData = new FormData();
        formData.append('_token', csrfToken);
        selectedIds.forEach(id => {
            formData.append('selected_ids[]', id);
        });
        
        // Show loading state
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const originalText = bulkDeleteBtn.innerHTML;
        bulkDeleteBtn.disabled = true;
        bulkDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังลบ...';
        
        // Submit via fetch
        fetch(form.action, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response received:', response);
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            // Check if we got redirected (302/303)
            if (response.redirected) {
                console.log('Redirected to:', response.url);
                window.location.href = response.url;
                return;
            }
            
            // Parse JSON response
            return response.json().then(data => {
                console.log('Response data:', data);
                
                if (response.ok && data.success) {
                    // Success - reload page to show updated list
                    window.location.href = "{{ route('admin.ip.index') }}";
                } else {
                    // Error
                    bulkDeleteBtn.disabled = false;
                    bulkDeleteBtn.innerHTML = originalText;
                    alert(data.message || 'เกิดข้อผิดพลาด: ' + response.statusText);
                }
            });
        })
        .catch(error => {
            console.error('Fetch error:', error);
            bulkDeleteBtn.disabled = false;
            bulkDeleteBtn.innerHTML = originalText;
            alert('เกิดข้อผิดพลาดในการลบข้อมูล: ' + error.message);
        });
        
        return true;
    }
    
    console.log('User cancelled');
    return false;
}
</script>
@endpush
