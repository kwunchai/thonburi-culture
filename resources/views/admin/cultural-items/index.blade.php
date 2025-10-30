@extends('layouts.admin')

@section('title', 'จัดการข้อมูลวัฒนธรรม')
@section('header', 'จัดการข้อมูลวัฒนธรรม')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_items'] }}</h3>
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
                <h3>{{ $stats['published_items'] }}</h3>
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
                <h3>{{ $stats['featured_items'] }}</h3>
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
                <h3>{{ $stats['draft_items'] }}</h3>
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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">รายการข้อมูลวัฒนธรรม</h3>
        <div class="card-tools">
            <a href="{{ route('admin.cultural-items.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> เพิ่มข้อมูลใหม่
            </a>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th>ชื่อ</th>
                    <th>หมวดหมู่</th>
                    <th>ชุมชน</th>
                    <th>สถานะ</th>
                    <th style="width: 150px">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->community->name }}</td>
                    <td>
                        @if($item->is_published)
                            <span class="badge badge-success">เผยแพร่</span>
                        @else
                            <span class="badge badge-warning">ฉบับร่าง</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.cultural-items.edit', $item) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.cultural-items.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('คุณแน่ใจหรือไม่?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">ไม่มีข้อมูล</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $items->links() }}
    </div>
</div>
@endsection