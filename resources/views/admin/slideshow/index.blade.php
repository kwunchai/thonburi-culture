@extends('layouts.admin')

@section('title', 'จัดการ Hero Slideshow')
@section('header', 'จัดการ Hero Slideshow')

@section('content')
<!-- Featured Items Section -->
<div class="row align-items-center mb-3">
    <div class="col-md-6">
        <h3 class="mb-0">
            <i class="fas fa-images"></i> Slideshow ปัจจุบัน 
            <span class="badge badge-light">{{ $featuredItems->count() }}/4</span>
        </h3>
    </div>
    <div class="col-md-6 text-right">
        @if($featuredItems->count() < 4)
        <a href="{{ route('admin.slideshow.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> เพิ่ม Slideshow
        </a>
        @endif
    </div>
</div>

<!-- Featured Slideshow Items -->
@if($featuredItems->count() > 0)
<div class="row mb-4" id="sortable-slideshow">
    @foreach($featuredItems as $item)
    <div class="col-md-3 mb-4" data-id="{{ $item->id }}">
        <div class="card h-100 shadow-sm">
            <div class="position-relative">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" 
                         class="card-img-top" 
                         style="height: 150px; object-fit: cover;"
                         alt="{{ $item->title }}">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" 
                         style="height: 150px;">
                        <i class="fas fa-image fa-3x text-white-50"></i>
                    </div>
                @endif
                
                <!-- Order Badge -->
                <span class="position-absolute top-0 left-0 m-2 badge badge-warning" style="font-size: 1rem;">
                    #{{ $item->featured_order ?? $loop->iteration }}
                </span>
                
                <!-- Featured Badge -->
                <span class="position-absolute top-0 right-0 m-2 badge badge-success">
                    <i class="fas fa-star"></i> Featured
                </span>
            </div>
            
            <div class="card-body p-3">
                <h6 class="card-title font-weight-bold text-truncate">{{ $item->title }}</h6>
                <p class="small text-muted mb-2">
                    <i class="fas fa-folder"></i> {{ $item->category->name }}<br>
                    <i class="fas fa-map-marker-alt"></i> {{ $item->community->name }}<br>
                    <i class="fas fa-calendar"></i> {{ $item->publish_date->format('d/m/Y') }}
                </p>
                <p class="card-text small" style="height: 60px; overflow: hidden;">
                    {{ Str::limit($item->description, 100) }}
                </p>
            </div>
            
            <div class="card-footer bg-white">
                <div class="btn-group btn-group-sm w-100" role="group">
                    <a href="{{ route('admin.slideshow.edit', $item->id) }}" 
                       class="btn btn-info">
                        <i class="fas fa-edit"></i> แก้ไข
                    </a>
                    <button type="button" 
                            class="btn btn-warning toggle-featured" 
                            data-id="{{ $item->id }}">
                        <i class="fas fa-star-half-alt"></i> ยกเลิก
                    </button>
                    <form action="{{ route('admin.slideshow.destroy', $item->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบ Slideshow นี้?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> ลบ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="alert alert-info mb-4">
    <i class="fas fa-info-circle"></i> 
    <strong>เคล็ดลับ:</strong> คุณสามารถลากเพื่อจัดเรียงลำดับ Slideshow ได้
</div>
@else
<div class="alert alert-warning mb-4">
    <i class="fas fa-exclamation-triangle"></i> 
    ยังไม่มี Slideshow กรุณาเพิ่มข้อมูล
</div>
@endif

<!-- Available Items Section -->
<div class="row align-items-center mb-3">
    <div class="col-md-12">
        <h3 class="mb-0">
            <i class="fas fa-list"></i> ข้อมูลวัฒนธรรมที่สามารถเพิ่มเป็น Slideshow
        </h3>
    </div>
</div>

<!-- Available Items Table -->
@if($availableItems->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="bg-light">
            <tr>
                <th style="width: 50px">ID</th>
                <th style="width: 100px">รูปภาพ</th>
                <th>ชื่อ</th>
                <th>หมวดหมู่</th>
                <th>ชุมชน</th>
                <th>วันที่เผยแพร่</th>
                <th style="width: 120px" class="text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($availableItems as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" 
                             style="width: 80px; height: 60px; object-fit: cover;"
                             class="img-thumbnail">
                    @else
                        <span class="text-muted">ไม่มีรูป</span>
                    @endif
                </td>
                <td><strong>{{ $item->title }}</strong></td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->community->name }}</td>
                <td>{{ $item->publish_date->format('d/m/Y') }}</td>
                <td class="text-center">
                    @if($featuredItems->count() < 4)
                    <button class="btn btn-success btn-sm toggle-featured" 
                            data-id="{{ $item->id }}">
                        <i class="fas fa-star"></i> เพิ่มเป็น Slide
                    </button>
                    @else
                    <button class="btn btn-secondary btn-sm" disabled>
                        <i class="fas fa-ban"></i> เต็มแล้ว
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> 
    ไม่มีข้อมูลที่สามารถเพิ่มเป็น Slideshow ได้
</div>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Sortable for reordering
    var el = document.getElementById('sortable-slideshow');
    if (el) {
        var sortable = Sortable.create(el, {
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function (evt) {
                var items = [];
                $('#sortable-slideshow > div').each(function(index) {
                    items.push({
                        id: $(this).data('id'),
                        order: index + 1
                    });
                });
                
                // Update order via AJAX
                $.ajax({
                    url: '{{ route("admin.slideshow.update-order") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: items
                    },
                    success: function(response) {
                        toastr.success('อัปเดตลำดับเรียบร้อยแล้ว');
                    },
                    error: function() {
                        toastr.error('เกิดข้อผิดพลาด');
                    }
                });
            }
        });
    }
    
    // Toggle Featured Status
    $('.toggle-featured').click(function() {
        var btn = $(this);
        var id = btn.data('id');
        
        console.log('Clicking toggle for ID:', id);
        
        $.ajax({
            url: '{{ url("admin/slideshow") }}/' + id + '/toggle-featured',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> กำลังประมวลผล...');
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.success) {
                    if (response.message) {
                        alert(response.message);
                    }
                    location.reload();
                } else {
                    alert(response.message || 'เกิดข้อผิดพลาด');
                    btn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                console.log('Error:', xhr);
                var response = xhr.responseJSON;
                alert(response?.message || 'เกิดข้อผิดพลาด');
                btn.prop('disabled', false);
            },
            complete: function() {
                btn.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush
@endsection