@extends('layouts.admin')

@section('title', 'แดชบอร์ด')
@section('header', 'แดชบอร์ด')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_items'] }}</h3>
                <p>ข้อมูลวัฒนธรรม</p>
            </div>
            <div class="icon">
                <i class="fas fa-landmark"></i>
            </div>
            <a href="{{ route('admin.cultural-items.index') }}" class="small-box-footer">
                ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_categories'] }}</h3>
                <p>หมวดหมู่</p>
            </div>
            <div class="icon">
                <i class="fas fa-list"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['total_communities'] }}</h3>
                <p>ชุมชน</p>
            </div>
            <div class="icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>ผู้ใช้งาน</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ข้อมูลวัฒนธรรมล่าสุด</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>หมวดหมู่</th>
                            <th>ชุมชน</th>
                            <th>วันที่เผยแพร่</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['recent_items'] as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->community->name }}</td>
                            <td>{{ $item->publish_date->format('d/m/Y') }}</td>
                            <td>
                                @if($item->is_published)
                                    <span class="badge badge-success">เผยแพร่</span>
                                @else
                                    <span class="badge badge-warning">ฉบับร่าง</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection