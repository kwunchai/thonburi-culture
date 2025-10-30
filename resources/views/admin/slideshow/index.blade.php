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
<!-- Debug: Featured items count = {{ $featuredItems->count() }} -->
<!-- Debug: Featured items IDs = {{ $featuredItems->pluck('id')->implode(', ') }} -->
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
                            data-id="{{ $item->id }}"
                            data-action="remove">
                        <i class="fas fa-star-half-alt"></i> ยกเลิก Slideshow
                    </button>
                    <form action="{{ route('admin.slideshow.destroy', $item->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลวัฒนธรรมนี้ออกจากระบบทั้งหมด? (ไม่สามารถกู้คืนได้)')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> ลบข้อมูลทั้งหมด
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
                            data-id="{{ $item->id }}"
                            data-action="add">
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
console.log('Script is loading...');

// ตรวจสอบว่า jQuery โหลดแล้วหรือไม่
if (typeof jQuery === 'undefined') {
    console.error('jQuery is not loaded!');
    alert('jQuery ไม่ถูกโหลด กรุณาตรวจสอบ');
} else {
    console.log('jQuery is loaded successfully');
}

// ใช้ vanilla JavaScript ก่อน
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    
    // ค้นหา toggle buttons
    var toggleButtons = document.querySelectorAll('.toggle-featured');
    console.log('Found toggle buttons:', toggleButtons.length);
    
    // เพิ่ม event listener ให้ทุกปุ่ม
    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // ป้องกัน double click
            if (this.disabled) return;
            
            var id = this.getAttribute('data-id');
            var action = this.getAttribute('data-action');
            console.log('Button clicked, ID:', id, 'Action:', action);
            
            // Disable button ทันที
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังประมวลผล...';
            
            // ทำ AJAX request
            fetch('{{ url("admin/slideshow") }}/' + id + '/toggle-featured', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({action: action})
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    // แทนที่จะ reload ให้อัปเดต UI โดยตรง
                    if (data.is_featured) {
                        // ถ้าเปลี่ยนเป็น featured ให้ reload แบบ hard refresh
                        window.location.href = window.location.href + '?t=' + new Date().getTime();
                    } else {
                        // ถ้ายกเลิก featured ให้ลบ card ออกจาก DOM
                        var cardElement = document.querySelector('#sortable-slideshow [data-id="' + id + '"]');
                        if (cardElement) {
                            cardElement.remove();
                        }
                        
                        // อัปเดตจำนวน slideshow
                        var slideshowCount = document.querySelectorAll('#sortable-slideshow [data-id]').length;
                        var countElement = document.querySelector('h3');
                        if (countElement) {
                            countElement.innerHTML = '<i class="fas fa-images"></i> Slideshow ปัจจุบัน ' + slideshowCount + '/4';
                        }
                        
                        // เพิ่มรายการกลับเข้าตารางข้อมูลวัฒนธรรม
                        console.log('Calling addItemToAvailableTable with:', data.item_data);
                        addItemToAvailableTable(data.item_data);
                        
                        // แสดง/ซ่อน alert "ยังไม่มี Slideshow"
                        var noSlideshowAlert = document.querySelector('.alert-warning');
                        if (noSlideshowAlert) {
                            noSlideshowAlert.style.display = slideshowCount === 0 ? 'block' : 'none';
                        }
                        
                        // ทำ hard refresh เพื่อให้แน่ใจ
                        setTimeout(function() {
                            window.location.href = window.location.href.split('?')[0] + '?refreshed=' + new Date().getTime();
                        }, 1000);
                    }
                } else {
                    // Re-enable button if failed
                    this.disabled = false;
                    this.innerHTML = action === 'add' ? '<i class="fas fa-star"></i> เพิ่มเป็น Slide' : '<i class="fas fa-star-half-alt"></i> ยกเลิก';
                    alert(data.message || 'เกิดข้อผิดพลาด');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Re-enable button if error
                this.disabled = false;
                this.innerHTML = action === 'add' ? '<i class="fas fa-star"></i> เพิ่มเป็น Slide' : '<i class="fas fa-star-half-alt"></i> ยกเลิก';
                alert('Error occurred: ' + error.message);
            });
        });
    });
});

$(document).ready(function() {
    console.log('Document ready fired');
    
    // ตรวจสอบจำนวน toggle button
    var toggleButtons = $('.toggle-featured');
    console.log('Found toggle buttons:', toggleButtons.length);
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
});

// ฟังก์ชันเพิ่มรายการกลับเข้าตารางข้อมูลวัฒนธรรม
function addItemToAvailableTable(itemData) {
    console.log('Adding item to table:', itemData);
    
    if (!itemData) {
        console.log('No item data provided');
        return;
    }
    
    // หา table body
    var tableBody = document.querySelector('.table tbody');
    if (!tableBody) {
        console.log('Table body not found');
        return;
    }
    
    // ลบ "ไม่มีข้อมูล" row หากมี
    var noDataRow = document.querySelector('#no-items-row');
    if (noDataRow) {
        noDataRow.remove();
    }
    
    // หรือลบ alert "ไม่มีข้อมูล" หากมี
    var noDataAlert = document.querySelector('.alert-info');
    if (noDataAlert && noDataAlert.textContent.includes('ไม่มีข้อมูลที่สามารถเพิ่มเป็น Slideshow ได้')) {
        noDataAlert.remove();
        
        // สร้างตารางใหม่หากไม่มี
        var tableContainer = document.querySelector('.table-responsive');
        if (!tableContainer) {
            var newTableHTML = `
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
                        <tbody></tbody>
                    </table>
                </div>
            `;
            
            // แทรกหลังจาก header
            var headerRow = document.querySelector('.row.align-items-center.mb-3');
            if (headerRow) {
                headerRow.insertAdjacentHTML('afterend', newTableHTML);
                tableBody = document.querySelector('.table tbody');
            }
        }
    }
    
    if (!tableBody) {
        console.log('Still no table body after creating');
        return;
    }
    
    // สร้าง row ใหม่
    var newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="text-center">${itemData.id}</td>
        <td class="text-center">
            ${itemData.image ? 
                `<img src="${itemData.image_url}" style="width: 60px; height: 45px;" class="img-thumbnail">` : 
                '<span class="text-muted">ไม่มีรูป</span>'
            }
        </td>
        <td><strong>${itemData.title}</strong></td>
        <td>${itemData.category_name}</td>
        <td>${itemData.community_name}</td>
        <td>${itemData.publish_date}</td>
        <td class="text-center">
            <button class="btn btn-success btn-sm toggle-featured" 
                    data-id="${itemData.id}"
                    data-action="add">
                <i class="fas fa-star"></i> เพิ่มเป็น Slide
            </button>
        </td>
    `;
    
    // เพิ่ม event listener ให้ปุ่มใหม่
    var newButton = newRow.querySelector('.toggle-featured');
    if (newButton) {
        newButton.addEventListener('click', handleToggleClick);
    }
    
    // เพิ่ม row เข้าตาราง
    tableBody.appendChild(newRow);
    console.log('Item added to table successfully');
}

// ฟังก์ชันจัดการ click ที่ใช้ร่วมกัน
function handleToggleClick(e) {
    e.preventDefault();
    
    // ป้องกัน double click
    if (this.disabled) return;
    
    var id = this.getAttribute('data-id');
    var action = this.getAttribute('data-action');
    console.log('Button clicked, ID:', id, 'Action:', action);
    
    // Disable button ทันที
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังประมวลผล...';
    
    var self = this;
    
    // ทำ AJAX request
    fetch('{{ url("admin/slideshow") }}/' + id + '/toggle-featured', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({action: action})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.is_featured) {
            // ลบ row ออกจากตาราง
            self.closest('tr').remove();
            // reload เพื่อแสดงใน slideshow section
            window.location.href = window.location.href + '?t=' + new Date().getTime();
        } else if (data.success && !data.is_featured) {
            // กรณีการยกเลิก featured - ไม่ควรเกิดขึ้นในตารางนี้
            console.log('Unexpected: item was unfeatured');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        self.disabled = false;
        self.innerHTML = '<i class="fas fa-star"></i> เพิ่มเป็น Slide';
    });
}
</script>
@endpush
@endsection