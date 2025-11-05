@extends('layouts.admin')

@section('title', 'จัดการข้อมูลวัฒนธรรม')
@section('header', 'จัดการข้อมูลวัฒนธรรม')

@section('content')
<div class="container-fluid">
    <h1>จัดการข้อมูลวัฒนธรรม</h1>
    
    <div class="card">
        <div class="card-body">
            <p>หน้านี้กำลังอยู่ในระหว่างการพัฒนา</p>
            <p>จำนวนข้อมูลวัฒนธรรมทั้งหมด: {{ $items ? $items->total() : 0 }} รายการ</p>
            
            @if(isset($items) && $items->count() > 0)
                <h3>รายการข้อมูลวัฒนธรรม</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ชื่อ</th>
                                <th>หมวดหมู่</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->category->name ?? 'ไม่ระบุ' }}</td>
                                <td>
                                    @if($item->is_published)
                                        <span class="badge badge-success">เผยแพร่</span>
                                    @else
                                        <span class="badge badge-warning">ฉบับร่าง</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($items->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $items->links() }}
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                    <h4>ไม่พบข้อมูลวัฒนธรรม</h4>
                    <p>ยังไม่มีข้อมูลวัฒนธรรมในระบบ</p>
                    <a href="{{ route('admin.cultural-items.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> เพิ่มข้อมูลใหม่
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection