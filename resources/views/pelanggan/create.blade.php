@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="card card-stacked">
      <!-- Top Accent Bar untuk konsistensi visual -->
      <div class="card-status-top bg-primary"></div>
      
      <div class="card-header">
        <h3 class="card-title text-heading">Form Pelanggan Baru</h3>
      </div>
      
      <form action="{{ route('pelanggan.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="card-body">
          
          <!-- Input Nama Pelanggan -->
          <div class="mb-3">
            <label class="form-label required">Nama Pelanggan</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-user text-secondary fs-2"></i>
              </span>
              <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                     value="{{ old('nama') }}" placeholder="Nama lengkap pelanggan" required>
            </div>
            @error('nama')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Nomor Telepon -->
          <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-phone text-secondary fs-2"></i>
              </span>
              <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                     value="{{ old('telepon') }}" placeholder="Contoh: 081234567890">
            </div>
            @error('telepon')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Alamat -->
          <div class="mb-0">
            <label class="form-label">Alamat Lengkap</label>
            <div class="input-icon align-items-start">
              <span class="input-icon-addon pt-2">
                <i class="ti ti-map-pin text-secondary fs-2"></i>
              </span>
              <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                        rows="3" placeholder="Alamat lengkap rumah pelanggan">{{ old('alamat') }}</textarea>
            </div>
            @error('alamat')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
        </div>
        
        <!-- Footer Form dengan Button Aksi -->
        <div class="card-footer bg-transparent d-flex gap-2 justify-content-end border-top">
          <a href="{{ route('pelanggan.index') }}" class="btn btn-ghost-secondary" style="border-radius: 6px;">
            Batal
          </a>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
            <i class="ti ti-check fs-2"></i> Simpan Pelanggan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection