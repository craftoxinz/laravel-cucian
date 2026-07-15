@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="card card-stacked">
      <!-- Top Accent Bar berwarna kuning/oranye khas edit/warning -->
      <div class="card-status-top bg-yellow"></div>
      
      <div class="card-header">
        <h3 class="card-title text-heading">Edit Data Pelanggan</h3>
      </div>
      
      <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST" autocomplete="off">
        @csrf 
        @method('PUT')
        
        <div class="card-body">
          
          <!-- Input Edit Nama Pelanggan -->
          <div class="mb-3">
            <label class="form-label required">Nama Pelanggan</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-user text-secondary fs-2"></i>
              </span>
              <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                     value="{{ old('nama', $pelanggan->nama) }}" required>
            </div>
            @error('nama')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Edit Nomor Telepon -->
          <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-phone text-secondary fs-2"></i>
              </span>
              <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                     value="{{ old('telepon', $pelanggan->telepon) }}">
            </div>
            @error('telepon')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Edit Alamat -->
          <div class="mb-0">
            <label class="form-label">Alamat Lengkap</label>
            <div class="input-icon align-items-start">
              <span class="input-icon-addon pt-2">
                <i class="ti ti-map-pin text-secondary fs-2"></i>
              </span>
              <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                        rows="3">{{ old('alamat', $pelanggan->alamat) }}</textarea>
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
          <button type="submit" class="btn btn-warning d-flex align-items-center gap-1 text-dark" style="border-radius: 6px;">
            <i class="ti ti-refresh fs-2"></i> Perbarui Data
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection