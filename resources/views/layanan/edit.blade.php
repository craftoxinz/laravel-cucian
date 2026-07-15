@extends('layouts.app')

@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('layanan.index') }}">Layanan</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="card card-stacked">
      <!-- Top Accent Bar Kuning -->
      <div class="card-status-top bg-yellow"></div>
      
      <div class="card-header">
        <h3 class="card-title text-heading">Edit Data Layanan</h3>
      </div>
      
      <form action="{{ route('layanan.update', $layanan) }}" method="POST" autocomplete="off">
        @csrf 
        @method('PUT')
        
        <div class="card-body">
          
          <!-- Edit Nama Layanan -->
          <div class="mb-3">
            <label class="form-label required">Nama Layanan</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-shirt text-secondary fs-2"></i>
              </span>
              <input type="text" name="nama" class="form-control" value="{{ old('nama', $layanan->nama) }}" required>
            </div>
          </div>
          
          <!-- Edit Satuan Kerja -->
          <div class="mb-3">
            <label class="form-label required">Satuan Kerja</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-scale text-secondary fs-2"></i>
              </span>
              <select name="satuan" class="form-select" style="padding-left: 2.5rem;">
                <option value="kg"  {{ $layanan->satuan=='kg'  ? 'selected' : '' }}>Kilogram (kg)</option>
                <option value="pcs" {{ $layanan->satuan=='pcs' ? 'selected' : '' }}>Per Buah (pcs)</option>
              </select>
            </div>
          </div>
          
          <!-- Edit Harga Input Group -->
          <div class="mb-3">
            <label class="form-label required">Harga Satuan</label>
            <div class="input-group">
              <span class="input-group-text bg-light font-weight-medium">Rp</span>
              <input type="number" name="harga" class="form-control" value="{{ old('harga', $layanan->harga) }}" required>
            </div>
          </div>
          
          <!-- Edit Deskripsi -->
          <div class="mb-3">
            <label class="form-label">Deskripsi / Keterangan</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
          </div>
          
          <!-- Toggle Status Layanan Aktif/Tidak (Native Tabler Switch) -->
          <div class="mb-0">
            <label class="form-check form-switch m-0" style="cursor: pointer;">
              <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $layanan->is_active ? 'checked' : '' }} style="cursor: pointer;">
              <span class="form-check-label text-heading" style="cursor: pointer;">Status Layanan Aktif</span>
              <span class="form-check-description text-secondary small">Jika dinonaktifkan, layanan ini tidak akan muncul saat membuat transaksi laundry baru.</span>
            </label>
          </div>
          
        </div>
        
        <!-- Action Buttons -->
        <div class="card-footer bg-transparent d-flex gap-2 justify-content-end border-top">
          <a href="{{ route('layanan.index') }}" class="btn btn-ghost-secondary" style="border-radius: 6px;">
            Batal
          </a>
          <button type="submit" class="btn btn-warning d-flex align-items-center gap-1 text-dark" style="border-radius: 6px;">
            <i class="ti ti-refresh fs-2"></i> Perbarui Layanan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection