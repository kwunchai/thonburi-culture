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

<!-- Search and Filter Section -->
<div class="mb-4">
    <form method="GET" action="{{ route('admin.cultural-items.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="ค้นหาชื่อข้อมูลวัฒนธรรม..." 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-control" onchange="this.form.submit()">
                        <option value="">เรียงตามหมวดหมู่</option>
                        @foreach(\App\Models\CulturalCategory::orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order" class="form-control" onchange="this.form.submit()">
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>ใหม่→เก่า</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>เก่า→ใหม่</option>
                    </select>
                </div>
                @if(request('search') || request('category') || request('order') != 'desc')
                <div class="col-md-3">
                    <a href="{{ route('admin.cultural-items.index') }}" class="btn btn-default btn-block">
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
                    <i class="fas fa-list"></i> รายการข้อมูลวัฒนธรรม
                </h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('admin.cultural-items.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> เพิ่มข้อมูลใหม่
                </a>
                <a href="{{ route('admin.cultural-items.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export CSV
                </a>
            </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px">ID</th>
                        <th>ชื่อ</th>
                        <th>หมวดหมู่</th>
                        <th>ชุมชน</th>
                        <th>สถานะ</th>
                        <th style="width: 150px" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><strong>{{ $item->title }}</strong></td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->community->name }}</td>
                        <td>
                            @if($item->is_published)
                                <span class="badge badge-success">เผยแพร่</span>
                            @else
                                <span class="badge badge-warning">ฉบับร่าง</span>
                            @endif
                        </td>
                        <td class="text-center">
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

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $items->links() }}
    </div>

@endsection