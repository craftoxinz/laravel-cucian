<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <title>Login — LaundryKu</title>

  <!-- CSS Utama Tabler & Font Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

  <style>
    @import url("https://rsms.me/inter/inter.css");
    :root {
      --tblr-primary: #0054a6;
      --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }
    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
</head>
<body class="antialiased d-flex flex-column bg-light">
<div class="page page-center">
  <div class="container container-tight py-4">

    <!-- Header Logo & Nama Aplikasi -->
    <div class="text-center mb-4">
      <a href="#" class="navbar-brand navbar-brand-autodark d-flex flex-column align-items-center gap-1 text-decoration-none">
        <div class="avatar avatar-md bg-primary text-white mb-2" style="border-radius: 12px; width: 52px; height: 52px;">
          <i class="ti ti-wash fs-1"></i>
        </div>
        <span class="fw-bold fs-2 text-dark tracking-tight">Cucian.id</span>
      </a>
      <p class="text-secondary small mt-1">Sistem Manajemen Laundry Modern</p>
    </div>

    <!-- Kotak Login Card -->
    <div class="card card-md card-stacked">
      <!-- Top Accent Bar untuk kesan premium -->
      <div class="card-status-top bg-primary"></div>

      <div class="card-body">
        <h2 class="h2 text-center mb-4 text-heading">Masuk ke Akun Anda</h2>

        {{-- Alert error umum menggunakan style Tabler Alert yang bersih --}}
        @if ($errors->any())
        <div class="alert alert-important alert-danger alert-dismissible mb-3" role="alert">
          <div class="d-flex align-items-center">
            <div>
              <i class="ti ti-alert-circle me-2 fs-2 alert-icon"></i>
            </div>
            <div>
              @foreach ($errors->all() as $error)
                <p class="mb-0 small">{{ $error }}</p>
              @endforeach
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
          @csrf

          <!-- Input Email dengan Icon -->
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-mail text-secondary fs-2"></i>
              </span>
              <input type="email" name="email"
                     class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email') }}"
                     placeholder="email@laundry.com"
                     autofocus>
            </div>
            @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <!-- Input Password dengan Icon -->
          <div class="mb-3">
            <label class="form-label required">Password</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-lock text-secondary fs-2"></i>
              </span>
              <input type="password" name="password"
                     class="form-control @error('password') is-invalid @enderror"
                     placeholder="••••••••">
            </div>
            @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <!-- Checkbox Remember Me -->
          <div class="mb-3">
            <label class="form-check">
              <input type="checkbox" name="remember" class="form-check-input" style="cursor: pointer;"/>
              <span class="form-check-label text-secondary small" style="cursor: pointer;">Ingat saya di perangkat ini</span>
            </label>
          </div>

          <!-- Button Submit Masuk -->
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100 py-2 fs-3" style="border-radius: 8px;">
              <i class="ti ti-login me-2 fs-2"></i> Masuk Sekarang
            </button>
          </div>
        </form>

      </div>
    </div>

  </div>
</div>

<!-- Tabler Core JS -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
