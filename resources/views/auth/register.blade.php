<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Daftar Pelanggan — LaundryKu</title>
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
      <div class="text-center mb-4">
        <a href="#" class="navbar-brand navbar-brand-autodark d-flex flex-column align-items-center gap-1 text-decoration-none">
          <div class="avatar avatar-md bg-primary text-white mb-2" style="border-radius: 12px; width: 52px; height: 52px;">
            <i class="ti ti-wash fs-1"></i>
          </div>
          <span class="fw-bold fs-2 text-dark tracking-tight">Cucian.id</span>
        </a>
        <p class="text-secondary small mt-1">Daftar sebagai pelanggan untuk memesan layanan dan memantau status cucian.</p>
      </div>

      <div class="card card-md card-stacked">
        <div class="card-status-top bg-primary"></div>
        <div class="card-body">
          <h2 class="h2 text-center mb-4 text-heading">Buat Akun Pelanggan</h2>

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

          <form action="{{ route('pelanggan.register.post') }}" method="POST" autocomplete="off">
            @csrf

            <div class="mb-3">
              <label class="form-label required">Nama</label>
              <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap" required>
              @error('nama')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label required">Email</label>
              <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" required>
              @error('email')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label required">Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
              @error('password')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label required">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Telepon</label>
              <input type="text" name="telepon" value="{{ old('telepon') }}" class="form-control" placeholder="081234567890">
            </div>

            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control" placeholder="Jl. Contoh No. 1">
            </div>

            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100 py-2 fs-3" style="border-radius: 8px;">
                <i class="ti ti-user-plus me-2 fs-2"></i> Daftar Sekarang
              </button>
            </div>
          </form>

          <div class="text-center mt-4">
            <p class="text-secondary small mb-2">Sudah punya akun?</p>
            <a href="{{ route('pelanggan.login') }}" class="btn btn-outline-primary w-100 py-2" style="border-radius: 8px;">
              <i class="ti ti-login me-2"></i> Masuk</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
