<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title', 'Dashboard') — Cucian.id</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        :root {
            --tblr-primary: #0054a6;
        }

        .navbar-vertical .nav-link.active {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 6px;
        }

        .navbar-vertical .nav-link:hover {
            background: rgba(255, 255, 255, 0.04);
            border-radius: 6px;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased">
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/demo-theme.min.js"></script>

<div class="wrapper">

    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <h1 class="navbar-brand navbar-brand-autodark m-0">
                <a href="{{ route('kurir.dashboard.index') }}"
                   class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="avatar avatar-sm bg-primary text-white" style="border-radius: 8px;">
                        <i class="ti ti-wash fs-3"></i>
                    </div>
                    <span class="fw-bold fs-3 text-white tracking-tight">Cucian.id</span>
                </a>
            </h1>

            <div class="navbar-nav flex-row d-lg-none">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                       aria-label="Open user menu">
                        <div class="avatar avatar-sm fw-bold text-white bg-primary">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <div class="dropdown-header">
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="ti ti-logout me-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kurir.dashboard.*') ? 'active' : '' }}"
                           href="{{ route('kurir.dashboard.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-layout-dashboard fs-2"></i></span>
                            <span class="nav-link-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kurir.orders.*') ? 'active' : '' }}"
                           href="{{ route('kurir.orders.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-receipt fs-2"></i></span>
                            <span class="nav-link-title">Order / Transaksi</span>
                        </a>
                    </li>

                </ul>

                <div class="mt-auto pb-3 d-none d-lg-block">
                    <div class="border-top border-white-10 mx-3 mb-3"></div>

                    <div class="d-flex justify-content-start px-3 mb-3">
                        <a href="?theme=dark" class="nav-link p-0 hide-theme-dark text-white-50"
                           title="Aktifkan Mode Gelap" data-bs-toggle="tooltip" data-bs-placement="right">
                            <i class="ti ti-moon fs-2 me-2"></i> <small>Mode Gelap</small>
                        </a>
                        <a href="?theme=light" class="nav-link p-0 hide-theme-light text-white-50"
                           title="Aktifkan Mode Terang" data-bs-toggle="tooltip" data-bs-placement="right">
                            <i class="ti ti-sun fs-2 me-2"></i> <small>Mode Terang</small>
                        </a>
                    </div>

                    <div class="nav-item dropdown px-3">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0 align-items-center gap-2"
                           data-bs-toggle="dropdown">
                            <div class="avatar avatar-sm text-white fw-bold" style="background:var(--tblr-primary)">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-white fw-medium small text-truncate"
                                     style="max-width: 130px;">{{ auth()->user()->name }}</div>
                                <div class="mt-1 small text-white-50"
                                     style="font-size: 11px;">{{ auth()->user()->role->label }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <div class="dropdown-header">
                                <div class="fw-semibold text-heading">{{ auth()->user()->name }}</div>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="ti ti-logout me-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </aside>

    <div class="page-wrapper">

        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        @hasSection('breadcrumb')
                            <div class="mb-1">
                                <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    @yield('breadcrumb')
                                </ol>
                            </div>
                        @endif
                        <h2 class="page-title text-heading">
                            @yield('page-title', 'Dashboard')
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        @yield('page-actions')
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">

                @if(session('success'))
                    <div class="alert alert-important alert-success alert-dismissible mb-3" role="alert">
                        <div class="d-flex align-items-center">
                            <div><i class="ti ti-circle-check me-2 fs-2 alert-icon"></i></div>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-important alert-danger alert-dismissible mb-3" role="alert">
                        <div class="d-flex align-items-center">
                            <div><i class="ti ti-alert-circle me-2 fs-2 alert-icon"></i></div>
                            <div>{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Cucian.id &copy; {{ date('Y') }}
                            </li>
                            <li class="list-inline-item text-secondary">
                                Sistem Manajemen Laundry
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>
