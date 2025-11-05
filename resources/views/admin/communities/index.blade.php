@extends('layouts.admin')

@section('title', 'จัดการข้อมูลชุมชน')
@section('header', 'จัดการข้อมูลชุมชน')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total'] }}</h3>
                <p>ชุมชนทั้งหมด</p>
            </div>
            <div class="icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['with_location'] }}</h3>
                <p>มีพิกัด GPS</p>
            </div>
            <div class="icon">
                <i class="fas fa-map-pin"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['with_items'] }}</h3>
                <p>มีข้อมูลวัฒนธรรม</p>
            </div>
            <div class="icon">
                <i class="fas fa-landmark"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['total_items'] }}</h3>
                <p>ข้อมูลวัฒนธรรมรวม</p>
            </div>
            <div class="icon">
                <i class="fas fa-database"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="mb-4">
    <form method="GET" action="{{ route('admin.communities.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="ค้นหาชื่อชุมชน..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-control" onchange="this.form.submit()">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                            เรียงตามชื่อ
                        </option>
                        <option value="items_count" {{ request('sort') == 'items_count' ? 'selected' : '' }}>
                            เรียงตามจำนวนข้อมูล
                        </option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>
                            เรียงตามวันที่สร้าง
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order" class="form-control" onchange="this.form.submit()">
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>น้อย→มาก</option>
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>มาก→น้อย</option>
                    </select>
                </div>
                @if(request('search') || request('sort') != 'name' || request('order') != 'asc')
                <div class="col-md-3">
                    <a href="{{ route('admin.communities.index') }}" class="btn btn-default btn-block">
                        <i class="fas fa-times"></i> ล้างการค้นหา
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Header Section -->
    <div class="row align-items-center mb-3">
        <div class="col-md-6">
            <h3 class="mb-0">
                <i class="fas fa-list"></i> รายการชุมชนในเขตธนบุรี
            </h3>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group">
                <a href="{{ route('admin.communities.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> เพิ่มชุมชนใหม่
                </a>
            </div>
            <div class="btn-group ml-2">
                <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-download"></i> ส่งออกข้อมูล
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('admin.communities.export', array_merge(request()->all(), ['export' => 'excel'])) }}">
                        <i class="fas fa-file-excel text-success"></i> ส่งออก Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 50px">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th style="width: 60px">ID</th>
                        <th style="width: 100px">รูปภาพ</th>
                        <th>ชื่อชุมชน</th>
                        <th>คำอธิบาย</th>
                        <th style="width: 100px" class="text-center">ข้อมูลวัฒนธรรม</th>
                        <th style="width: 80px" class="text-center">พิกัด</th>
                        <th style="width: 80px" class="text-center">สถานะ</th>
                        <th style="width: 180px" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($communities as $community)
                    <tr>
                        <td>
                            <input type="checkbox" class="community-checkbox" value="{{ $community->id }}">
                        </td>
                        <td>{{ $community->id }}</td>
                        <td>
                            @if($community->image)
                                <img src="{{ Storage::url($community->image) }}" 
                                     alt="{{ $community->name }}"
                                     class="img-thumbnail"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $community->name }}</strong>
                            @if($community->established_year)
                                <br><small class="text-muted">ก่อตั้งปี {{ $community->established_year + 543 }}</small>
                            @endif
                        </td>
                        <td>
                            {{ Str::limit($community->description, 100) }}
                        </td>
                        <td class="text-center">
                            @if($community->cultural_items_count > 0)
                                <span class="badge badge-info">{{ $community->cultural_items_count }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($community->hasLocation())
                                <a href="{{ $community->getMapUrl() }}" target="_blank" 
                                   class="btn btn-sm btn-outline-success"
                                   title="ดูบน Google Maps">
                                    <i class="fas fa-map-marked-alt"></i>
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input toggle-active" 
                                       id="active-{{ $community->id }}"
                                       data-id="{{ $community->id }}"
                                       {{ $community->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="active-{{ $community->id }}"></label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.communities.show', $community) }}" 
                                   class="btn btn-sm btn-info" title="ดูรายละเอียด">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.communities.edit', $community) }}" 
                                   class="btn btn-sm btn-warning" title="แก้ไข">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.communities.destroy', $community) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบชุมชน {{ $community->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="ลบ">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">ไม่พบข้อมูลชุมชน</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                แสดง {{ $communities->firstItem() ?? 0 }} - {{ $communities->lastItem() ?? 0 }} 
                จากทั้งหมด {{ $communities->total() }} รายการ
            </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="mt-3" id="bulk-actions" style="display: none;">
        <div class="alert alert-info">
            <span id="selected-count">0</span> รายการที่เลือก
            <button class="btn btn-danger btn-sm ml-3" id="bulk-delete">
                <i class="fas fa-trash"></i> ลบที่เลือก
            </button>
        </div>
    </div>

@push('scripts')
<script>
$(document).ready(function() {
    // Select all checkbox
    $('#select-all').change(function() {
        $('.community-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });
    
    // Individual checkbox
    $('.community-checkbox').change(function() {
        updateBulkActions();
    });
    
    // Update bulk actions visibility
    function updateBulkActions() {
        const checkedCount = $('.community-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#bulk-actions').show();
            $('#selected-count').text(checkedCount);
        } else {
            $('#bulk-actions').hide();
        }
    }
    
    // Bulk delete
    $('#bulk-delete').click(function() {
        const selectedIds = [];
        $('.community-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length > 0) {
            if (confirm('คุณแน่ใจหรือไม่ที่จะลบชุมชน ' + selectedIds.length + ' รายการ?')) {
                $.post('{{ route("admin.communities.bulk-delete") }}', {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE',
                    community_ids: selectedIds
                }).done(function(response) {
                    location.reload();
                });
            }
        }
    });
    
    // Toggle active status
    $('.toggle-active').change(function() {
        const id = $(this).data('id');
        const checkbox = $(this);
        
        $.post('{{ route("admin.communities.index") }}/' + id + '/toggle-active', {
            _token: '{{ csrf_token() }}'
        }).done(function(response) {
            if (response.success) {
                toastr.success(response.message);
            }
        }).fail(function() {
            checkbox.prop('checked', !checkbox.prop('checked'));
            toastr.error('เกิดข้อผิดพลาด');
        });
    });
});
</script>
@endpush
@endsection