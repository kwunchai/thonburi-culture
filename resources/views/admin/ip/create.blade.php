@extends('adminlte::page')
@section('title','เพิ่ม IP')

@section('content_header') <h1>เพิ่มข้อมูลทรัพย์สินทางปัญญา</h1> @endsection

@section('content')
<form method="post" action="{{ route('admin.ip.store') }}" enctype="multipart/form-data" class="card card-body">
@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">ชื่องานสร้างสรรค์ *</label>
    <input name="title" class="form-control" required value="{{ old('title') }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">เลขที่คำขอ</label>
    <input name="application_no" class="form-control" value="{{ old('application_no') }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">ประเภทผลงาน *</label>
    <select name="type" class="form-select" required>
      @foreach([\App\Enums\IpType::INVENTION_PATENT->value, \App\Enums\IpType::PETTY_PATENT->value, \App\Enums\IpType::DESIGN_PATENT->value, \App\Enums\IpType::COPYRIGHT->value, \App\Enums\IpType::TRADEMARK->value, \App\Enums\IpType::GI->value, \App\Enums\IpType::TK->value] as $t)
        <option value="{{ $t }}" @selected(old('type')===$t)>{{ $t }}</option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3">
    <label class="form-label">สถานะ</label>
    <select name="status" class="form-select">
      <option value="">—</option>
      @foreach([\App\Enums\IpStatus::DRAFT->value, \App\Enums\IpStatus::SUBMITTED->value, \App\Enums\IpStatus::UNDER_REVIEW->value, \App\Enums\IpStatus::REGISTERED->value, \App\Enums\IpStatus::REJECTED->value, \App\Enums\IpStatus::EXPIRED->value] as $s)
        <option value="{{ $s }}" @selected(old('status')===$s)>{{ $s }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">ปีงบประมาณ</label>
    <input name="budget_year" type="number" class="form-control" value="{{ old('budget_year') }}" placeholder="เช่น 2568">
  </div>
  <div class="col-md-3">
    <label class="form-label">แหล่งทุน</label>
    <input name="funding_source" class="form-control" value="{{ old('funding_source') }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">ผู้ยื่น</label>
    <input name="submitter_name" class="form-control" value="{{ old('submitter_name') }}">
  </div>

  <div class="col-md-6">
    <label class="form-label">ผู้ขอ</label>
    <input name="applicant_name" class="form-control" value="{{ old('applicant_name') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">คณะ</label>
    <input name="faculty" class="form-control" value="{{ old('faculty') }}">
  </div>
  <div class="col-12">
    <label class="form-label">ชื่องานวิจัย</label>
    <input name="research_title" class="form-control" value="{{ old('research_title') }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">เลขใบรับรอง</label>
    <input name="certificate_no" class="form-control" value="{{ old('certificate_no') }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">ไฟล์ใบรับรอง (pdf/jpg/png)</label>
    <input type="file" name="certificate" class="form-control">
  </div>
  <div class="col-12">
    <label class="form-label">หมายเหตุ</label>
    <textarea name="remark" class="form-control" rows="3">{{ old('remark') }}</textarea>
  </div>
</div>

<div class="mt-3 d-flex gap-2">
  <button class="btn btn-primary">บันทึก</button>
  <a href="{{ route('admin.ip.index') }}" class="btn btn-secondary">ยกเลิก</a>
</div>
</form>
@endsection
