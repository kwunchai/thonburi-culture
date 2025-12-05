@extends('layouts.admin')

@section('title', 'จัดการหมวดหมู่กิจกรรม')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-tags mr-2"></i>
                    จัดการหมวดหมู่กิจกรรม
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">จัดการหมวดหมู่กิจกรรม</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-check"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-times"></i>
            {{ session('error') }}
        </div>
        @endif

        <!-- Main row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-1"></i>
                            รายการหมวดหมู่กิจกรรม
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.activity-categories.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i>
                                เพิ่มหมวดหมู่ใหม่
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>ชื่อหมวดหมู่</th>
                                        <th>คำอธิบาย</th>
                                        <th width="100">จำนวนกิจกรรม</th>
                                        <th width="120">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr data-category-id="{{ $category->id }}">
                                        <td>
                                            <span class="text-muted">{{ $category->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $category->slug }}</small>
                                        </td>
                                        <td>
                                            {{ Str::limit($category->description, 80) }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $category->activities_count }} กิจกรรม
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.activity-categories.show', $category) }}" 
                                                   class="btn btn-info btn-sm" title="ดูรายละเอียด">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.activity-categories.edit', $category) }}" 
                                                   class="btn btn-warning btn-sm" title="แก้ไข">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($category->activities_count == 0)
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="confirmDelete('{{ $category->id }}', '{{ $category->name }}')" 
                                                        title="ลบ">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
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
                                    แสดง {{ $categories->firstItem() }} ถึง {{ $categories->lastItem() }} 
                                    จากทั้งหมด {{ $categories->total() }} รายการ
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                {{ $categories->links() }}
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">ยังไม่มีหมวดหมู่กิจกรรม</h5>
                            <p class="text-muted">เริ่มต้นเพิ่มหมวดหมู่แรกของคุณ</p>
                            <a href="{{ route('admin.activity-categories.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i>
                                เพิ่มหมวดหมู่ใหม่
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
                <p>คุณต้องการลบหมวดหมู่ "<span id="categoryName"></span>" ใช่หรือไม่?</p>
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
                        ลบหมวดหมู่
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(categoryId, categoryName) {
    document.getElementById('categoryName').innerText = categoryName;
    document.getElementById('deleteForm').action = `/admin/activity-categories/${categoryId}`;
    $('#deleteModal').modal('show');
}

// Auto close alerts after 5 seconds
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);
</script>
@endpush