@extends('layouts.admin')

@section('title', 'นำเข้าข้อมูลทรัพย์สินทางปัญญา')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-file-import text-primary"></i>
                    นำเข้าข้อมูลทรัพย์สินทางปัญญา
                </h1>
                <a href="{{ route('admin.ip.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> กลับ
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <strong>สำเร็จ!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            
            @if(session('import_details'))
                <hr>
                <div class="mt-2">
                    <strong>รายละเอียด:</strong>
                    <ul class="mb-0">
                        <li>นำเข้าสำเร็จ: {{ session('import_details')['success'] }} รายการ</li>
                        <li>ข้ามไป: {{ session('import_details')['skipped'] }} รายการ</li>
                        @if(count(session('import_details')['errors']) > 0)
                            <li class="text-warning">
                                <strong>ข้อผิดพลาด:</strong>
                                <ul>
                                    @foreach(array_slice(session('import_details')['errors'], 0, 5) as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    @if(count(session('import_details')['errors']) > 5)
                                        <li>... และอีก {{ count(session('import_details')['errors']) - 5 }} รายการ</li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <strong>ผิดพลาด!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            
            @if(session('import_errors'))
                <hr>
                <div class="mt-2">
                    <strong>รายละเอียดข้อผิดพลาด:</strong>
                    <ul class="mb-0">
                        @foreach(array_slice(session('import_errors'), 0, 10) as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        @if(count(session('import_errors')) > 10)
                            <li>... และอีก {{ count(session('import_errors')) - 10 }} รายการ</li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Instructions Card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i>
                        คำแนะนำการใช้งาน
                    </h5>
                </div>
                <div class="card-body">
                    <ol class="mb-3">
                        <li>ดาวน์โหลดไฟล์ Template Excel</li>
                        <li>กรอกข้อมูลตามหัวตาราง (Header Row)</li>
                        <li>บันทึกไฟล์เป็นนามสกุล .xlsx หรือ .xls</li>
                        <li>อัปโหลดไฟล์ที่นี่</li>
                    </ol>

                    <div class="alert alert-warning">
                        <strong><i class="fas fa-exclamation-triangle"></i> ข้อควรระวัง:</strong>
                        <ul class="mb-0 mt-2">
                            <li>ไฟล์ต้องมีขนาดไม่เกิน 5 MB</li>
                            <li>ข้อมูลที่มีเลขทะเบียนหรือชื่อผลงานซ้ำจะถูกข้าม</li>
                            <li>ตรวจสอบความถูกต้องของข้อมูลก่อนนำเข้า</li>
                        </ul>
                    </div>

                    <a href="{{ route('admin.ip.import.template') }}" class="btn btn-success btn-block">
                        <i class="fas fa-download"></i>
                        ดาวน์โหลดไฟล์ Template
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-upload"></i>
                        อัปโหลดไฟล์ Excel
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ip.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="file">เลือกไฟล์ Excel <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="custom-file-input @error('file') is-invalid @enderror" 
                                       id="file" 
                                       name="file" 
                                       accept=".xlsx,.xls,.csv"
                                       required>
                                <label class="custom-file-label" for="file" data-browse="เลือก">เลือกไฟล์...</label>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                รองรับไฟล์: .xlsx, .xls, .csv (ขนาดไม่เกิน 5 MB)
                            </small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="confirm" required>
                                <label class="custom-control-label" for="confirm">
                                    ฉันได้ตรวจสอบความถูกต้องของข้อมูลแล้ว
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                            <i class="fas fa-file-import"></i>
                            เริ่มนำเข้าข้อมูล
                        </button>
                    </form>

                    <!-- Progress Bar -->
                    <div id="progressContainer" class="mt-3" style="display: none;">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" 
                                 style="width: 100%">
                                กำลังนำเข้าข้อมูล...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Excel Format Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table"></i>
                        รูปแบบไฟล์ Excel
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Column</th>
                                <th>จำเป็น</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ลำดับ (lamtad)</td>
                                <td><span class="badge badge-secondary">ไม่จำเป็น</span></td>
                            </tr>
                            <tr>
                                <td>ชื่อผลงาน (chue_phon_ngan)</td>
                                <td><span class="badge badge-danger">จำเป็น</span></td>
                            </tr>
                            <tr>
                                <td>ประเภท (prapheth)</td>
                                <td><span class="badge badge-danger">จำเป็น</span></td>
                            </tr>
                            <tr>
                                <td>คำอธิบาย (kham_othbai)</td>
                                <td><span class="badge badge-warning">แนะนำ</span></td>
                            </tr>
                            <tr>
                                <td>เลขคำขอ/ทะเบียน (lekh_kham_khor)</td>
                                <td><span class="badge badge-warning">แนะนำ</span></td>
                            </tr>
                            <tr>
                                <td>วันที่ยื่นขอ (wan_thi_yuen_khor)</td>
                                <td><span class="badge badge-secondary">ไม่จำเป็น</span></td>
                            </tr>
                            <tr>
                                <td>วันที่จดทะเบียน (wan_thi_chot_thabian)</td>
                                <td><span class="badge badge-secondary">ไม่จำเป็น</span></td>
                            </tr>
                            <tr>
                                <td>วันหมดอายุ (wan_mot_ayu)</td>
                                <td><span class="badge badge-secondary">ไม่จำเป็น</span></td>
                            </tr>
                            <tr>
                                <td>สถานะ (sathana)</td>
                                <td><span class="badge badge-secondary">ไม่จำเป็น</span></td>
                            </tr>
                            <tr>
                                <td>ผู้เป็นเจ้าของ (phu_pen_chao_khong)</td>
                                <td><span class="badge badge-secondary">ไม่จำเป็น</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Update file input label
document.getElementById('file').addEventListener('change', function(e) {
    var fileName = e.target.files[0]?.name || 'เลือกไฟล์...';
    var label = e.target.nextElementSibling;
    label.textContent = fileName;
});

// Show progress bar on submit
document.getElementById('importForm').addEventListener('submit', function() {
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('progressContainer').style.display = 'block';
});
</script>
@endpush
@endsection
