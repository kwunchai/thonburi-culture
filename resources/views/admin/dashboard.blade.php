@extends('layouts.admin')

@section('title', 'แดชบอร์ด')
@section('header', 'แดชบอร์ด - สรุปข้อมูลทั้งหมด')

@section('content')
<!-- สถิติทั่วไป -->
<div class="row mb-4">
    <div class="col-lg-2 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $generalStats['communities'] }}</h3>
                <p>ข้อมูลชุมชน</p>
            </div>
            <div class="icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <a href="{{ route('admin.communities.index') }}" class="small-box-footer">
                ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-2 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $generalStats['cultural_items'] }}</h3>
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
    
    <div class="col-lg-2 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $generalStats['intellectual_properties'] }}</h3>
                <p>ทรัพย์สินทางปัญญา</p>
            </div>
            <div class="icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <a href="{{ route('admin.ip.index') }}" class="small-box-footer">
                ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-2 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $generalStats['research_data'] }}</h3>
                <p>ข้อมูลงานวิจัย</p>
            </div>
            <div class="icon">
                <i class="fas fa-microscope"></i>
            </div>
            <div class="small-box-footer">
                <span class="text-white-50">เร็วๆ นี้</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-2 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $generalStats['innovations'] }}</h3>
                <p>ข้อมูลนวัตกรรม</p>
            </div>
            <div class="icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div class="small-box-footer">
                <span class="text-white-50">เร็วๆ นี้</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-2 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $generalStats['communities'] + $generalStats['cultural_items'] + $generalStats['intellectual_properties'] }}</h3>
                <p>ข้อมูลทั้งหมด</p>
            </div>
            <div class="icon">
                <i class="fas fa-database"></i>
            </div>
        </div>
    </div>
</div>

<!-- กราฟและสถิติ -->
<div class="row">
    <!-- กราฟข้อมูลรายเดือน -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    สถิติข้อมูลรายเดือน (12 เดือนที่ผ่านมา)
                </h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- กราฟวงกลม -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    สัดส่วนข้อมูลวัฒนธรรมตามหมวดหมู่
                </h3>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" width="300" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- กราฟสถิติข้อมูลรวม -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-1"></i>
                    สถิติข้อมูลรวมทั้งหมด
                </h3>
            </div>
            <div class="card-body">
                <canvas id="totalDataChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- กราฟเปรียบเทียบรายปี -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-area mr-1"></i>
                    เปรียบเทียบข้อมูลรายไตรมาส
                </h3>
            </div>
            <div class="card-body">
                <canvas id="quarterlyChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ข้อมูลล่าสุด -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock mr-1"></i>
                    ข้อมูลที่เพิ่มล่าสุด
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- ข้อมูลวัฒนธรรมล่าสุด -->
                    <div class="col-lg-4">
                        <h5><i class="fas fa-landmark text-success"></i> ข้อมูลวัฒนธรรมล่าสุด</h5>
                        <ul class="list-unstyled">
                            @foreach($recentData['cultural_items'] as $item)
                            <li class="mb-2">
                                <a href="{{ route('admin.cultural-items.show', $item) }}" class="text-decoration-none">
                                    <strong>{{ Str::limit($item->title, 30) }}</strong>
                                </a>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-tag"></i> {{ $item->category->name ?? '-' }} | 
                                    <i class="fas fa-clock"></i> {{ $item->created_at->diffForHumans() }}
                                </small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- ชุมชนล่าสุด -->
                    <div class="col-lg-4">
                        <h5><i class="fas fa-map-marked-alt text-info"></i> ชุมชนล่าสุด</h5>
                        <ul class="list-unstyled">
                            @foreach($recentData['communities'] as $community)
                            <li class="mb-2">
                                <a href="{{ route('admin.communities.show', $community) }}" class="text-decoration-none">
                                    <strong>{{ Str::limit($community->name, 30) }}</strong>
                                </a>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $community->created_at->diffForHumans() }}
                                </small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- ทรัพย์สินทางปัญญาล่าสุด -->
                    <div class="col-lg-4">
                        <h5><i class="fas fa-shield-alt text-warning"></i> ทรัพย์สินทางปัญญาล่าสุด</h5>
                        <ul class="list-unstyled">
                            @foreach($recentData['ip_items'] as $ip)
                            <li class="mb-2">
                                <a href="{{ route('admin.ip.show', $ip) }}" class="text-decoration-none">
                                    <strong>{{ Str::limit($ip->title, 30) }}</strong>
                                </a>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-tag"></i> {{ $ip->type ?? '-' }} | 
                                    <i class="fas fa-clock"></i> {{ $ip->created_at->diffForHumans() }}
                                </small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// กราฟข้อมูลรายเดือน
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($culturalStats['monthly_data']['months']) !!},
        datasets: [
            {
                label: 'ข้อมูลวัฒนธรรม',
                data: {!! json_encode($culturalStats['monthly_data']['data']) !!},
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            },
            {
                label: 'ข้อมูลชุมชน',
                data: {!! json_encode($communityStats['monthly_data']['data']) !!},
                borderColor: '#17a2b8',
                backgroundColor: 'rgba(23, 162, 184, 0.1)',
                tension: 0.4
            },
            {
                label: 'ทรัพย์สินทางปัญญา',
                data: {!! json_encode($ipStats['monthly_data']['data']) !!},
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.4
            },
            {
                label: 'ข้อมูลงานวิจัย',
                data: {!! json_encode($researchStats['monthly_data']['data']) !!},
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4
            },
            {
                label: 'ข้อมูลนวัตกรรม',
                data: {!! json_encode($innovationStats['monthly_data']['data']) !!},
                borderColor: '#6f42c1',
                backgroundColor: 'rgba(111, 66, 193, 0.1)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'แนวโน้มการเพิ่มข้อมูลรายเดือน'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// กราฟวงกลมหมวดหมู่
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($culturalStats['by_category']->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($culturalStats['by_category']->pluck('count')) !!},
            backgroundColor: [
                '#FF6384',
                '#36A2EB', 
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40',
                '#FF6384',
                '#C9CBCF'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// กราฟแท่งสถิติข้อมูลรวม
const totalDataCtx = document.getElementById('totalDataChart').getContext('2d');
const totalDataChart = new Chart(totalDataCtx, {
    type: 'bar',
    data: {
        labels: ['ชุมชน', 'วัฒนธรรม', 'ทรัพย์สินฯ', 'งานวิจัย', 'นวัตกรรม'],
        datasets: [{
            label: 'จำนวนข้อมูล',
            data: [
                {{ $generalStats['communities'] }},
                {{ $generalStats['cultural_items'] }},
                {{ $generalStats['intellectual_properties'] }},
                {{ $generalStats['research_data'] }},
                {{ $generalStats['innovations'] }}
            ],
            backgroundColor: [
                'rgba(23, 162, 184, 0.8)',   // สีฟ้า - ชุมชน
                'rgba(40, 167, 69, 0.8)',    // สีเขียว - วัฒนธรรม
                'rgba(255, 193, 7, 0.8)',    // สีเหลือง - IP
                'rgba(220, 53, 69, 0.8)',    // สีแดง - งานวิจัย
                'rgba(111, 66, 193, 0.8)'    // สีม่วง - นวัตกรรม
            ],
            borderColor: [
                '#17a2b8',
                '#28a745', 
                '#ffc107',
                '#dc3545',
                '#6f42c1'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'จำนวนข้อมูลในแต่ละหมวดหมู่'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// กราฟพื้นที่เปรียบเทียบรายไตรมาส
const quarterlyCtx = document.getElementById('quarterlyChart').getContext('2d');

// สร้างข้อมูลไตรมาสจากข้อมูลรายเดือน
const monthlyData = {!! json_encode($culturalStats['monthly_data']['data']) !!};
const communityMonthlyData = {!! json_encode($communityStats['monthly_data']['data']) !!};
const ipMonthlyData = {!! json_encode($ipStats['monthly_data']['data']) !!};
const researchMonthlyData = {!! json_encode($researchStats['monthly_data']['data']) !!};
const innovationMonthlyData = {!! json_encode($innovationStats['monthly_data']['data']) !!};

// แบ่งข้อมูลเป็นไตรมาส (Q1, Q2, Q3, Q4)
const quarters = ['Q1', 'Q2', 'Q3', 'Q4'];
const culturalQuarterly = [
    monthlyData.slice(0, 3).reduce((a, b) => a + b, 0),   // Q1
    monthlyData.slice(3, 6).reduce((a, b) => a + b, 0),   // Q2  
    monthlyData.slice(6, 9).reduce((a, b) => a + b, 0),   // Q3
    monthlyData.slice(9, 12).reduce((a, b) => a + b, 0)   // Q4
];
const communityQuarterly = [
    communityMonthlyData.slice(0, 3).reduce((a, b) => a + b, 0),
    communityMonthlyData.slice(3, 6).reduce((a, b) => a + b, 0),
    communityMonthlyData.slice(6, 9).reduce((a, b) => a + b, 0),
    communityMonthlyData.slice(9, 12).reduce((a, b) => a + b, 0)
];
const ipQuarterly = [
    ipMonthlyData.slice(0, 3).reduce((a, b) => a + b, 0),
    ipMonthlyData.slice(3, 6).reduce((a, b) => a + b, 0),
    ipMonthlyData.slice(6, 9).reduce((a, b) => a + b, 0),
    ipMonthlyData.slice(9, 12).reduce((a, b) => a + b, 0)
];
const researchQuarterly = [
    researchMonthlyData.slice(0, 3).reduce((a, b) => a + b, 0),
    researchMonthlyData.slice(3, 6).reduce((a, b) => a + b, 0),
    researchMonthlyData.slice(6, 9).reduce((a, b) => a + b, 0),
    researchMonthlyData.slice(9, 12).reduce((a, b) => a + b, 0)
];
const innovationQuarterly = [
    innovationMonthlyData.slice(0, 3).reduce((a, b) => a + b, 0),
    innovationMonthlyData.slice(3, 6).reduce((a, b) => a + b, 0),
    innovationMonthlyData.slice(6, 9).reduce((a, b) => a + b, 0),
    innovationMonthlyData.slice(9, 12).reduce((a, b) => a + b, 0)
];

const quarterlyChart = new Chart(quarterlyCtx, {
    type: 'radar',
    data: {
        labels: quarters,
        datasets: [
            {
                label: 'ข้อมูลวัฒนธรรม',
                data: culturalQuarterly,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#28a745'
            },
            {
                label: 'ข้อมูลชุมชน',
                data: communityQuarterly,
                borderColor: '#17a2b8',
                backgroundColor: 'rgba(23, 162, 184, 0.2)',
                pointBackgroundColor: '#17a2b8',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#17a2b8'
            },
            {
                label: 'ทรัพย์สินทางปัญญา',
                data: ipQuarterly,
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.2)',
                pointBackgroundColor: '#ffc107',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#ffc107'
            },
            {
                label: 'ข้อมูลงานวิจัย',
                data: researchQuarterly,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                pointBackgroundColor: '#dc3545',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#dc3545'
            },
            {
                label: 'ข้อมูลนวัตกรรม',
                data: innovationQuarterly,
                borderColor: '#6f42c1',
                backgroundColor: 'rgba(111, 66, 193, 0.2)',
                pointBackgroundColor: '#6f42c1',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#6f42c1'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'การเปรียบเทียบข้อมูลรายไตรมาส'
            }
        },
        scales: {
            r: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endpush