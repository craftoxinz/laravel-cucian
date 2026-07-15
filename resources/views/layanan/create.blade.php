@extends('layouts.app')

@section('title', 'Tambah Layanan')
@section('page-title', 'Tambah Layanan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('layanan.index') }}">Layanan</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="card card-stacked">
      <!-- Top Accent Bar Biru -->
      <div class="card-status-top bg-primary"></div>
      
      <div class="card-header">
        <h3 class="card-title text-heading">Form Layanan Baru</h3>
      </div>
      
      <form action="{{ route('layanan.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="card-body">
          
          <!-- Nama Layanan -->
          <div class="mb-3">
            <label class="form-label required">Nama Layanan</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-shirt text-secondary fs-2"></i>
              </span>
              <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                     value="{{ old('nama') }}" placeholder="Contoh: Cuci Kering + Setrika" required>
            </div>
            @error('nama')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Satuan Kerja -->
          <div class="mb-3">
            <label class="form-label required">Satuan Kerja</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-scale text-secondary fs-2"></i>
              </span>
              <select name="satuan" class="form-select @error('satuan') is-invalid @enderror" required style="padding-left: 2.5rem;">
                <option value="kg" {{ old('satuan')=='kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                <option value="pcs" {{ old('satuan')=='pcs' ? 'selected' : '' }}>Per Buah (pcs)</option>
              </select>
            </div>
            @error('satuan')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Harga Input Group -->
          <div class="mb-3">
            <label class="form-label required">Harga Satuan</label>
            <div class="input-group">
              <span class="input-group-text bg-light font-weight-medium">Rp</span>
              <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                     value="{{ old('harga') }}" placeholder="Contoh: 6000" min="0" required>
            </div>
            @error('harga')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Deskripsi Singkat -->
          <div class="mb-0">
            <label class="form-label">Deskripsi / Keterangan</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tulis rincian paket pengerjaan jika ada... (Opsional)">{{ old('deskripsi') }}</textarea>
          </div>
          
        </div>
        
        <!-- Action Buttons -->
        <div class="card-footer bg-transparent d-flex gap-2 justify-content-end border-top">
          <a href="{{ route('layanan.index') }}" class="btn btn-ghost-secondary" style="border-radius: 6px;">
            Batal
          </a>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
            <i class="ti ti-check fs-2"></i> Simpan Layanan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection