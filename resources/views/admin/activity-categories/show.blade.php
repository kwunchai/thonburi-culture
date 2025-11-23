@extends('layouts.admin')

@section('title', 'รายละเอียดหมวดหมู่กิจกรรม - ' . $activityCategory->name)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-tags mr-2"></i>
                    รายละเอียดหมวดหมู่กิจกรรม
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activity-categories.index') }}">จัดการหมวดหมู่กิจกรรม</a></li>
                    <li class="breadcrumb-item active">{{ $activityCategory->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column - Category Details -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            ข้อมูลหมวดหมู่
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.activity-categories.edit', $activityCategory) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> แก้ไข
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Category Header -->
                        <div class="text-center mb-4 p-4 bg-light rounded">
                            <h3 class="mb-2">{{ $activityCategory->name }}</h3>
                            <p class="text-muted mb-0">
                                <small><code>{{ $activityCategory->slug }}</code></small>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5><i class="fas fa-align-left text-secondary mr-2"></i>คำอธิบาย</h5>
                                <p class="text-muted">
                                    {{ $activityCategory->description ?? 'ไม่มีคำอธิบาย' }}
                                </p>
                            </div>
                        </div>

                        <hr>

                        <!-- Metadata -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5><i class="fas fa-clock text-muted mr-2"></i>ข้อมูลการสร้าง</h5>
                                <small class="text-muted">
                                    <strong>สร้างเมื่อ:</strong> {{ $activityCategory->created_at->format('d/m/Y H:i') }} น.<br>
                                    <strong>อัพเดทล่าสุด:</strong> {{ $activityCategory->updated_at->format('d/m/Y H:i') }} น.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.activity-categories.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> กลับ
                        </a>
                        <a href="{{ route('admin.activity-categories.edit', $activityCategory) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> แก้ไข
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Activities List -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            กิจกรรมในหมวดหมู่นี้
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-info">{{ $activityCategory->activities_count }} กิจกรรม</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($activityCategory->activities->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ชื่อกิจกรรม</th>
                                        <th width="120">วันที่จัด</th>
                                        <th width="80">สถานะ</th>
                                        <th width="80">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activityCategory->activities as $activity)
                                    <tr>
                                        <td>
                                            <strong>{{ $activity->title }}</strong>
                                            @if($activity->location)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $activity->location }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($activity->activity_date)
                                                <small>{{ $activity->activity_date->format('d/m/Y') }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($activity->is_active)
                                                <span class="badge badge-success">เปิด</span>
                                            @else
                                                <span class="badge badge-secondary">ปิด</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.activities.show', $activity) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="ดู">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.activities.edit', $activity) }}" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="แก้ไข">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">ยังไม่มีกิจกรรมในหมวดหมู่นี้</p>
                            <a href="{{ route('admin.activities.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i>
                                เพิ่มกิจกรรมใหม่
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            สถิติ
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">กิจกรรมทั้งหมด</span>
                                        <span class="info-box-number">{{ $activityCategory->activities_count }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-eye"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">กิจกรรมเปิดใช้งาน</span>
                                        <span class="info-box-number">{{ $activityCategory->activities()->where('is_active', true)->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
