<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | ฐานข้อมูลเขตธนบุรี</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        
        /* Additional AdminLTE color classes for IP statistics */
        .small-box.bg-purple { background-color: #6f42c1 !important; }
        .small-box.bg-teal { background-color: #20c997 !important; }
        .small-box.bg-orange { background-color: #fd7e14 !important; }
        .small-box.bg-indigo { background-color: #6610f2 !important; }
        .small-box.bg-purple .icon, .small-box.bg-teal .icon, 
        .small-box.bg-orange .icon, .small-box.bg-indigo .icon { 
            color: rgba(255,255,255,.15); 
        }
        
        /* Purple badge and alert styles */
        .badge-purple { 
            background-color: #6f42c1 !important; 
            color: white !important; 
        }
        .alert-purple { 
            background-color: #e2d8f0 !important; 
            border-color: #b794d1 !important; 
            color: #553c9a !important; 
        }
        .text-purple { color: #6f42c1 !important; }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-link">
                        <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-text font-weight-light ml-3">ฐานข้อมูลเขตธนบุรี</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block ml-3">
                        {{ auth()->user()->name ?? 'User' }}
                        <br>
                        <small class="badge badge-info">
                            {{ auth()->user()->role ?? 'editor' }}
                        </small>
                    </a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                    {{-- Dashboard - all users can access --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>แดชบอร์ด</p>
                        </a>
                    </li>

                    {{-- Slideshow Management - admin and editor only --}}
                    @can('manage-slideshow')
                    <li class="nav-item">
                        <a href="{{ route('admin.slideshow.index') }}" 
                            class="nav-link {{ request()->routeIs('admin.slideshow.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>
                                Hero Slideshow
                            @php
                            $featuredCount = \App\Models\CulturalItem::where('is_featured', true)->count();
                            @endphp
                            <span class="badge badge-warning right">{{ $featuredCount }}</span>
                            </p>
                        </a>
                    </li>
                    @endcan
                    
                    {{-- Communities - admin and editor only --}}
                    @can('manage-communities')
                    <li class="nav-item">
                        <a href="{{ route('admin.communities.index') }}" 
                        class="nav-link {{ request()->routeIs('admin.communities.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>
                                จัดการชุมชน
                                @php
                                $communityCount = \App\Models\Community::count();
                                @endphp
                                <span class="badge badge-info right">{{ $communityCount }}</span>
                            </p>
                        </a>
                    </li>
                    @endcan
                    
                    {{-- Cultural Items - admin and editor only --}}
                    @can('manage-cultural-items')
                    <li class="nav-item">
                        <a href="{{ route('admin.cultural-items.index') }}" class="nav-link {{ request()->routeIs('admin.cultural-items.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-landmark"></i>
                            <p>ข้อมูลวัฒนธรรม</p>
                        </a>
                    </li>
                    @endcan

                    {{-- Activities - admin and editor only --}}
                    @can('manage-activities')
                    <li class="nav-item">
                        <a href="{{ route('admin.activities.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>
                                จัดการกิจกรรม
                                @php
                                $activityCount = \App\Models\Activity::count();
                                @endphp
                                <span class="badge badge-success right">{{ $activityCount }}</span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.activity-categories.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.activity-categories.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>
                                หมวดหมู่กิจกรรม
                                @php
                                $categoryCount = \App\Models\ActivityCategory::count();
                                @endphp
                                <span class="badge badge-info right">{{ $categoryCount }}</span>
                            </p>
                        </a>
                    </li>
                    @endcan

                    {{-- Research - admin and editor only (placeholder) --}}
                    @can('manage-research')
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link {{ request()->routeIs('admin.research.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>ข้อมูลงานวิจัย</p>
                        </a>
                    </li>
                    @endcan

                    {{-- Intellectual Property - admin and ip_manager only --}}
                    @can('manage-ip')
                    <li class="nav-item">
                        <a href="{{ route('admin.ip.index') }}" 
                            class="nav-link {{ request()->routeIs('admin.ip.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-certificate"></i>
                            <p>
                                ทรัพย์สินทางปัญญา
                                @php
                                $ipCount = \App\Models\IntellectualProperty::count();
                                @endphp
                                <span class="badge badge-primary right">{{ $ipCount }}</span>
                            </p>
                        </a>
                    </li>
                    @endcan

                    {{-- Innovations - admin and editor only (placeholder) --}}
                    @can('manage-innovations')
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link {{ request()->routeIs('admin.innovations.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <p>ข้อมูลนวัตกรรม</p>
                        </a>
                    </li>
                    @endcan

                    {{-- User Management - admin only --}}
                    @can('manage-users')
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" 
                            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                จัดการสิทธิ์ผู้ใช้งาน
                                @php
                                $userCount = \App\Models\User::count();
                                @endphp
                                <span class="badge badge-primary right">{{ $userCount }}</span>
                            </p>
                        </a>
                    </li>
                    @endcan
                                        
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>@yield('header')</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                {{-- Centralized Flash Messages --}}
                @include('admin.partials.flash')
                
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} ฐานข้อมูลเขตธนบุรี.</strong>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
// Remove hold-transition class after page loads to prevent dark overlay
$(document).ready(function() {
    // Remove hold-transition class immediately
    $('body').removeClass('hold-transition');
    
    // Safety fallback: remove any stuck modal backdrops
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
    
    // Initialize AdminLTE properly
    if (typeof AdminLTE !== 'undefined') {
        AdminLTE.Layout && AdminLTE.Layout.activate();
    }
});

// Additional safety on window load
$(window).on('load', function() {
    $('body').removeClass('hold-transition');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
});
</script>

@stack('scripts')
</body>
</html>