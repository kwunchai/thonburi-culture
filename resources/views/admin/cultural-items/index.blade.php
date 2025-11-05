@extends('layouts.admin')

@section('title', 'จัดการข้อมูลวัฒนธรรม')
@section('header', 'จัดการข้อมูลวัฒนธรรม')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_items'] ?? 0 }}</h3>
                <p>ข้อมูลวัฒนธรรมทั้งหมด</p>
            </div>
            <div class="icon">
                <i class="fas fa-landmark"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['published_items'] ?? 0 }}</h3>
                <p>เผยแพร่แล้ว</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['featured_items'] ?? 0 }}</h3>
                <p>ข้อมูลเด่น</p>
            </div>
            <div class="icon">
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['draft_items'] ?? 0 }}</h3>
                <p>ฉบับร่าง</p>
            </div>
            <div class="icon">
                <i class="fas fa-edit"></i>
            </div>
        </div>
    </div>
</div>

<!-- Additional Statistics -->
<div class="row mb-4">
    <div class="col-lg-6 col-12">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['communities_with_items'] }}</h3>
                <p>ชุมชนที่มีข้อมูลวัฒนธรรม</p>
            </div>
            <div class="icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $stats['categories_used'] }}</h3>
                <p>หมวดหมู่ที่ใช้งาน</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
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
        <form method="GET" action="{{ route('admin.cultural-items.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>ค้นหา</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="ชื่อข้อมูลวัฒนธรรม..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>หมวดหมู่</label>
                        <select name="category" class="form-control">
                            <option value="">ทุกหมวดหมู่</option>
                            @foreach(\App\Models\CulturalCategory::orderBy('name')->get() as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
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
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>เผยแพร่แล้ว</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>ฉบับร่าง</option>
                            <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>ข้อมูลเด่น</option>
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
            @if(request('search') || request('category') || request('status') || request('order') != 'desc')
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin.cultural-items.index') }}" class="btn btn-default">
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
            <i class="fas fa-list"></i> รายการข้อมูลวัฒนธรรม
            <small class="text-muted">({{ $items->total() ?? 0 }} รายการ)</small>
            @if(request('search'))
                <small class="text-muted">(ผลการค้นหา: "{{ request('search') }}")</small>
            @endif
        </h3>
    </div>
    <div class="col-md-6 text-right">
        <div class="btn-group">
            <a href="{{ route('admin.cultural-items.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> เพิ่มข้อมูลวัฒนธรรม
            </a>
        </div>
        <div class="btn-group ml-2">
            <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-download"></i> ส่งออกข้อมูล
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('admin.cultural-items.export', array_merge(request()->all(), ['export' => 'excel'])) }}">
                    <i class="fas fa-file-excel text-success"></i> ส่งออก Excel
                </a>
            </div>
        </div>
        <div class="btn-group ml-2">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-cogs"></i> การจัดการ
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="toggleAllFeatured()">
                    <i class="fas fa-star"></i> จัดการข้อมูลเด่น
                </a>
                <a class="dropdown-item" href="#" onclick="bulkPublish()">
                    <i class="fas fa-eye"></i> เผยแพร่ทั้งหมด
                </a>
                <a class="dropdown-item" href="#" onclick="bulkDelete()">
                    <i class="fas fa-trash text-danger"></i> ลบที่เลือก
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
@if($items->count() > 0)
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="select-all">
                                <label class="custom-control-label" for="select-all"></label>
                            </div>
                        </th>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-landmark"></i> ชื่อข้อมูลวัฒนธรรม</th>
                        <th><i class="fas fa-folder"></i> หมวดหมู่</th>
                        <th><i class="fas fa-map-marked-alt"></i> ชุมชน</th>
                        <th><i class="fas fa-eye"></i> สถานะ</th>
                        <th><i class="fas fa-calendar"></i> วันที่สร้าง</th>
                        <th class="text-center" width="180"><i class="fas fa-cogs"></i> การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr class="cultural-item-row" data-id="{{ $item->id }}">
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input item-checkbox" id="item-{{ $item->id }}" value="{{ $item->id }}">
                                <label class="custom-control-label" for="item-{{ $item->id }}"></label>
                            </div>
                        </td>
                        <td>
                            <strong class="text-primary">#{{ $item->id }}</strong>
                        </td>
                        <td>
                            <div class="media">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="mr-3 rounded" width="60" height="60" style="object-fit: cover;">
                                @else
                                    <div class="mr-3 bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">
                                        <strong>{{ $item->title }}</strong>
                                        @if($item->is_featured)
                                            <span class="badge badge-warning ml-1">
                                                <i class="fas fa-star"></i> เด่น
                                            </span>
                                        @endif
                                    </h6>
                                    @if($item->description)
                                        <p class="text-muted mb-1 small">{{ Str::limit(strip_tags($item->description), 100) }}</p>
                                    @endif
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $item->creator->name ?? 'ไม่ระบุ' }}
                                        @if($item->publish_date)
                                            | <i class="fas fa-calendar"></i> {{ $item->publish_date->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($item->category)
                                <span class="badge badge-primary" style="background-color: {{ $item->category->color ?? '#007bff' }}">
                                    @if($item->category->icon)
                                        <i class="fas {{ $item->category->icon }}"></i>
                                    @endif
                                    {{ $item->category->name }}
                                </span>
                            @else
                                <span class="text-muted">
                                    <i class="fas fa-minus-circle"></i> ไม่ระบุ
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->community)
                                <div>
                                    <strong>{{ $item->community->name }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ $item->community->district ?? 'เขตธนบุรี' }}
                                    </small>
                                </div>
                            @else
                                <span class="text-muted">
                                    <i class="fas fa-minus-circle"></i> ไม่ระบุ
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column align-items-center">
                                @if($item->is_published)
                                    <span class="badge badge-success mb-1">
                                        <i class="fas fa-eye"></i> เผยแพร่
                                    </span>
                                @else
                                    <span class="badge badge-warning mb-1">
                                        <i class="fas fa-edit"></i> ฉบับร่าง
                                    </span>
                                @endif
                                @if($item->views_count ?? 0 > 0)
                                    <small class="text-muted">
                                        <i class="fas fa-chart-line"></i> {{ number_format($item->views_count ?? 0) }} ครั้ง
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">
                                {{ $item->created_at->format('d/m/Y') }}
                                <br>
                                {{ $item->created_at->format('H:i') }} น.
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group-vertical btn-group-sm" role="group">
                                <a href="{{ route('cultural-item.show', $item->id) }}" 
                                   class="btn btn-outline-primary btn-sm mb-1"
                                   title="ดูหน้าเว็บ" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.cultural-items.edit', $item) }}" 
                                   class="btn btn-info btn-sm mb-1"
                                   title="แก้ไข">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-warning btn-sm mb-1"
                                        title="ข้อมูลเด่น"
                                        onclick="toggleFeatured({{ $item->id }}, {{ $item->is_featured ? 'false' : 'true' }})">
                                    <i class="fas fa-star{{ $item->is_featured ? ' text-white' : '-o' }}"></i>
                                </button>
                                <form action="{{ route('admin.cultural-items.destroy', $item) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            title="ลบ">
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
        
        <!-- Pagination -->
        @if($items->hasPages())
            <div class="card-footer">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <small class="text-muted">
                            แสดง {{ $items->firstItem() }} ถึง {{ $items->lastItem() }} 
                            จากทั้งหมด {{ $items->total() }} รายการ
                        </small>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation">
                            {{ $items->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">ไม่พบข้อมูลวัฒนธรรม</h5>
            @if(request('search') || request('category') || request('status') || request('community'))
                <p class="text-muted">ลองปรับเงื่อนไขการค้นหาใหม่</p>
                <a href="{{ route('admin.cultural-items.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> ล้างการค้นหา
                </a>
            @else
                <p class="text-muted">เริ่มต้นด้วยการเพิ่มข้อมูลวัฒนธรรมใหม่</p>
                <a href="{{ route('admin.cultural-items.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> เพิ่มข้อมูลใหม่
                </a>
            @endif
        </div>
    </div>
@endif

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">การจัดการหลายรายการ</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>เลือกการดำเนินการสำหรับรายการที่เลือก (<span id="selectedCount">0</span> รายการ):</p>
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action" onclick="bulkAction('publish')">
                        <i class="fas fa-eye text-success"></i> เผยแพร่ทั้งหมด
                    </button>
                    <button type="button" class="list-group-item list-group-item-action" onclick="bulkAction('unpublish')">
                        <i class="fas fa-eye-slash text-warning"></i> ยกเลิกการเผยแพร่
                    </button>
                    <button type="button" class="list-group-item list-group-item-action" onclick="bulkAction('feature')">
                        <i class="fas fa-star text-warning"></i> ตั้งเป็นข้อมูลเด่น
                    </button>
                    <button type="button" class="list-group-item list-group-item-action" onclick="bulkAction('unfeature')">
                        <i class="fas fa-star-o text-muted"></i> ยกเลิกข้อมูลเด่น
                    </button>
                    <div class="dropdown-divider"></div>
                    <button type="button" class="list-group-item list-group-item-action text-danger" onclick="bulkAction('delete')">
                        <i class="fas fa-trash"></i> ลบทั้งหมด
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.cultural-item-row:hover {
    background-color: #f8f9fa;
}

.media img {
    transition: transform 0.2s;
}

.media:hover img {
    transform: scale(1.05);
}

.badge {
    font-size: 0.75em;
}

.btn-group-vertical .btn {
    border-radius: 0.25rem !important;
    margin-bottom: 2px;
}

.table td {
    vertical-align: middle;
}

/* Custom checkbox styling */
.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #007bff;
    border-color: #007bff;
}

/* Loading animation */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .small-box h3 {
        font-size: 1.5rem;
    }
    
    .table td {
        font-size: 0.875rem;
    }
}

@media (max-width: 992px) {
    .btn-group-vertical {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .btn-group-vertical .btn {
        margin-right: 2px;
        margin-bottom: 2px;
        flex: 1;
        min-width: 35px;
    }
    
    .media {
        flex-direction: column;
        text-align: center;
    }
    
    .media img,
    .media .bg-light {
        margin: 0 auto 10px auto;
    }
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.75rem;
    }
    
    .table th,
    .table td {
        padding: 0.5rem 0.25rem;
    }
    
    /* Hide some columns on mobile */
    .table th:nth-child(4),
    .table td:nth-child(4),
    .table th:nth-child(7),
    .table td:nth-child(7) {
        display: none;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }
    
    .badge {
        font-size: 0.6rem;
        padding: 0.2em 0.4em;
    }
}

@media (max-width: 576px) {
    .card-header h3 {
        font-size: 1rem;
    }
    
    .row.mb-4 {
        margin-bottom: 1rem !important;
    }
    
    .col-lg-3 {
        margin-bottom: 1rem;
    }
    
    /* Stack search form vertically */
    .form-group {
        margin-bottom: 1rem;
    }
    
    /* Hide more columns on very small screens */
    .table th:nth-child(3),
    .table td:nth-child(3) {
        display: none;
    }
    
    .media-body h6 {
        font-size: 0.9rem;
    }
    
    .media-body p {
        font-size: 0.8rem;
    }
}

/* Print styles */
@media print {
    .btn,
    .pagination,
    .card-header .dropdown,
    .custom-control {
        display: none !important;
    }
    
    .table {
        font-size: 0.8rem;
    }
    
    .badge {
        border: 1px solid #000;
        color: #000 !important;
        background: transparent !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Select All Checkbox
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedCount();
    toggleBulkActions();
});

// Individual checkbox change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('item-checkbox')) {
        updateSelectAllState();
        updateSelectedCount();
        toggleBulkActions();
    }
});

function updateSelectAllState() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const selectAll = document.getElementById('select-all');
    const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
    
    if (checkedCount === 0) {
        selectAll.indeterminate = false;
        selectAll.checked = false;
    } else if (checkedCount === checkboxes.length) {
        selectAll.indeterminate = false;
        selectAll.checked = true;
    } else {
        selectAll.indeterminate = true;
        selectAll.checked = false;
    }
}

function updateSelectedCount() {
    const count = document.querySelectorAll('.item-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = count;
}

function toggleBulkActions() {
    const count = document.querySelectorAll('.item-checkbox:checked').length;
    const bulkButton = document.getElementById('bulkActionButton');
    
    if (count > 0) {
        if (!bulkButton) {
            addBulkActionButton();
        }
    } else {
        if (bulkButton) {
            bulkButton.remove();
        }
    }
}

function addBulkActionButton() {
    const headerRow = document.querySelector('.table thead tr');
    const actionsCell = headerRow.querySelector('th:last-child');
    actionsCell.innerHTML = `
        <button type="button" class="btn btn-sm btn-warning" id="bulkActionButton" data-toggle="modal" data-target="#bulkActionModal">
            <i class="fas fa-tasks"></i> จัดการ (<span id="headerSelectedCount">0</span>)
        </button>
    `;
    updateSelectedCount();
}

// Toggle Featured Status
function toggleFeatured(itemId, isFeatured) {
    fetch(`/admin/cultural-items/${itemId}/toggle-featured`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ is_featured: isFeatured })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('เกิดข้อผิดพลาด: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
    });
}

// Bulk Actions
function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                             .map(checkbox => checkbox.value);
    
    if (selectedIds.length === 0) {
        alert('กรุณาเลือกรายการที่ต้องการดำเนินการ');
        return;
    }
    
    let confirmMessage = '';
    switch (action) {
        case 'delete':
            confirmMessage = `คุณแน่ใจหรือไม่ว่าต้องการลบรายการที่เลือก ${selectedIds.length} รายการ?`;
            break;
        case 'publish':
            confirmMessage = `เผยแพร่รายการที่เลือก ${selectedIds.length} รายการ?`;
            break;
        case 'unpublish':
            confirmMessage = `ยกเลิกการเผยแพร่รายการที่เลือก ${selectedIds.length} รายการ?`;
            break;
        case 'feature':
            confirmMessage = `ตั้งรายการที่เลือก ${selectedIds.length} รายการเป็นข้อมูลเด่น?`;
            break;
        case 'unfeature':
            confirmMessage = `ยกเลิกข้อมูลเด่นของรายการที่เลือก ${selectedIds.length} รายการ?`;
            break;
        default:
            return;
    }
    
    if (confirm(confirmMessage)) {
        // Add loading state
        document.body.classList.add('loading');
        
        fetch('/admin/cultural-items/bulk-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                action: action,
                ids: selectedIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('เกิดข้อผิดพลาด: ' + data.message);
                document.body.classList.remove('loading');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
            document.body.classList.remove('loading');
        });
    }
    
    // Close modal
    $('#bulkActionModal').modal('hide');
}

// Auto-refresh every 5 minutes
setInterval(function() {
    const lastActivity = localStorage.getItem('lastActivity');
    const now = Date.now();
    
    if (!lastActivity || (now - lastActivity > 300000)) { // 5 minutes
        location.reload();
    }
}, 300000);

// Track user activity
document.addEventListener('click', function() {
    localStorage.setItem('lastActivity', Date.now());
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedCount();
    updateSelectAllState();
});
</script>
@endpush

@endsection