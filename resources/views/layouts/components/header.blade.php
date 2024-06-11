@php
    $user = auth()->user();
    $name = "Administrator";

    if ($user->tipe == "konselor") {
        $name = $user->konselor->nama_konselor;
    } else if ($user->tipe == "siswa") {
        $name = $user->siswa->nama_lengkap;
    } else if ($user->tipe == "orangtua") {
        $name = $user->orangtua->nama;
    } else if ($user->tipe == "kepala_sekolah") {
        $name = $user->kepala_sekolah->nama;
    }
@endphp

<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('home') }}" class="logo logo-dark">
            <span class="logo-sm">
                {{-- <img src="/assets/images/logo-sm.png" alt="" height="22"> --}}
                Konsultasi
            </span>
            <span class="logo-lg">
                {{-- <img src="/assets/images/logo-dark.png" alt="" height="22"> --}}
                Konsultasi
            </span>
        </a>
        <a href="{{ route('home') }}" class="logo logo-light">
            <span class="logo-sm">
                {{-- <img src="/assets/images/logo-sm.png" alt="" height="22"> --}}
                Konsultasi
            </span>
            <span class="logo-lg">
                {{-- <img src="/assets/images/logo-light.png" alt="" height="22"> --}}
                Konsultasi
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link menu-link @if($title == 'Halaman Utama') active @endif"> <i class="ph-gauge"></i>
                        <span data-key="t-dashboards">Dashboard</span> </a>
                </li>
                @if ($user->tipe == "admin")
                    <li class="nav-item">
                        <a href="{{ route('verifikasi-siswa') }}" class="nav-link menu-link @if($title == 'Verifikasi Siswa') active @endif"> <i class="ph-check-circle"></i>
                            <span data-key="t-verifikasi">Verifikasi Siswa</span> </a>
                    </li>
                @endif

                @if ($user->tipe == "admin" || $user->tipe == "konselor")
                    <li class="menu-title"><span data-key="t-master-data">Master Data</span></li>
                    @if ($user->tipe == "admin")
                        <li class="nav-item">
                            <a href="{{ route('pengguna') }}" class="nav-link menu-link @if($title == 'Pengguna') active @endif"> <i class="ph-user"></i>
                                <span data-key="t-pengguna">Pengguna</span> </a>
                        </li>
                        @if ($user->tipe == "admin")
                            <li class="nav-item">
                                <a href="{{ route('kepala-sekolah') }}" class="nav-link menu-link @if($title == 'Kepala Sekolah') active @endif"> <i class="ph-user-circle-gear"></i>
                                    <span data-key="t-kepala-sekolah">Kepala Sekolah</span> </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('konselor') }}" class="nav-link menu-link @if($title == 'Konselor') active @endif"> <i class="ph-user-circle"></i>
                                <span data-key="t-konselor">Konselor</span> </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('siswa') }}" class="nav-link menu-link @if($title == 'Siswa') active @endif"> <i class="ph-graduation-cap"></i>
                            <span data-key="t-siswa">Siswa</span> </a>
                    </li>
                @endif

                <li class="menu-title"><span data-key="t-bimbingan">Bimbingan dan Konseling</span></li>
                @if ($user->tipe != "kepala_sekolah")
                    @if ($user->tipe != "orangtua")
                        <li class="nav-item">
                            <a href="{{ route('data-bk') }}" class="nav-link menu-link @if($title == 'Data Bk') active @endif"> <i class="ph-folder-open"></i>
                                <span data-key="t-data">Data BK</span> </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('history-bk') }}" class="nav-link menu-link @if($title == 'History Bk') active @endif"> <i class="ph-repeat-thin"></i>
                            <span data-key="t-history">History BK</span> </a>
                    </li>
                @endif
                @if ($user->tipe == "admin" || $user->tipe == "kepala_sekolah")
                    <li class="nav-item">
                        <a href="#laporan" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="laporan">
                            <i class="ph-book-bookmark-light"></i> <span data-key="t-laporan">Laporan BK</span>
                        </a>
                        <div class="collapse menu-dropdown @if ($title == 'Laporan Periode' || $title == 'Laporan Siswa' || $title == 'Laporan Jenis') show @endif" id="laporan">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('laporan-periode') }}" class="nav-link @if($title == 'Laporan Periode') active @endif" data-key="t-periode">Periode</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('laporan-siswa') }}" class="nav-link @if($title == 'Laporan Siswa') active @endif" data-key="t-siswa">Siswa</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('laporan-jenis') }}" class="nav-link @if($title == 'Laporan Jenis') active @endif" data-key="t-jenis">Jenis</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if ($user->tipe != "orangtua" && $user->tipe != "kepala_sekolah")
                    <li class="menu-title"><span data-key="t-bimbingan">Komunikasi</span></li>
                    <li class="nav-item">
                        <a href="{{ route('list-chat') }}" class="nav-link menu-link @if($title == 'Chat') active @endif"> <i class="ph-chats-circle-light"></i>
                            <span data-key="t-chat">Chat</span> </a>
                    </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('home') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/logo-dark.png" alt="" height="22">
                        </span>
                    </a>

                    <a href="{{ route('home') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/logo-light.png" alt="" height="22">
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bi bi-arrows-fullscreen fs-lg'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle mode-layout"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-sun align-middle fs-3xl"></i>
                    </button>
                    <div class="dropdown-menu p-2 dropdown-menu-end" id="light-dark-mode">
                        <a href="#!" class="dropdown-item" data-mode="light"><i
                                class="bi bi-sun align-middle me-2"></i> Default (light mode)</a>
                        <a href="#!" class="dropdown-item" data-mode="dark"><i
                                class="bi bi-moon align-middle me-2"></i> Dark</a>
                        <a href="#!" class="dropdown-item" data-mode="auto"><i
                                class="bi bi-moon-stars align-middle me-2"></i> Auto (system default)</a>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="/assets/images/users/32/avatar-1.jpg" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">{{ strtoupper($user->tipe) }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Selamat Datang {{ $name }}!</h6>
                        <a class="dropdown-item" href="@if ($user->tipe != 'kepala_sekolah') {{ route('profile') }} @else {{ route('kepala-sekolah') }} @endif"><i
                                class="mdi mdi-account-circle text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i
                                class="mdi mdi-logout text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
