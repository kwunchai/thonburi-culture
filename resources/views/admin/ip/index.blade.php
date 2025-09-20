@extends('adminlte::page')
@section('title','ข้อมูลทรัพย์สินทางปัญญา')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1>ทรัพย์สินทางปัญญา</h1>
    <a href="{{ route('admin.ip.create') }}" class="btn btn-primary">+ เพิ่มข้อมูล</a>
  </div>
@endsection

@section('content')
<form class="mb-3">
  <div class="input-group">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="ค้นหาชื่อ/เลขที่คำขอ">
    <button class="btn btn-outline-secondary">ค้นหา</button>
  </div>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>เลขที่คำขอ</th><th>ชื่อเรื่อง</th><th>ประเภท</th><th>สถานะ</th><th>ปี</th><th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $it)
          <tr>
            <td>{{ $it->application_no }}</td>
            <td class="fw-semibold">{{ $it->title }}</td>
            <td>{{ $it->type }}</td>
            <td>{{ $it->status }}</td>
            <td>{{ $it->budget_year }}</td>
            <td class="text-end">
              <a href="{{ route('admin.ip.edit',$it) }}" class="btn btn-sm btn-warning">แก้ไข</a>
              <form action="{{ route('admin.ip.destroy',$it) }}" method="post" class="d-inline"
                    onsubmit="return confirm('ยืนยันลบข้อมูลนี้?')">
                @csrf @method('delete')
                <button class="btn btn-sm btn-danger">ลบ</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $items->links() }}</div>
</div>
@endsection
