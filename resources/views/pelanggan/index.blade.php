@extends('layouts.app')

@section('title', 'Pelanggan')
@section('page-title', 'Manajemen Pelanggan')

@section('page-actions')
<a href="{{ route('pelanggan.create') }}" class="btn btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
  <i class="ti ti-plus fs-2"></i> Tambah Pelanggan
</a>
@endsection

@section('content')
<div class="card">
  <!-- ===== SECTION FILTER BAR ===== -->
  <div class="card-header border-0 pb-2">
    <form method="GET" class="w-100">
      <div class="row g-2 align-items-center">
        <!-- Input Search Pelanggan -->
        <div class="col-12 col-md-5 col-lg-6">
          <div class="input-icon">
            <span class="input-icon-addon">
              <i class="ti ti-search text-secondary fs-2"></i>
            </span>
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau nomor telepon..." value="{{ request('search') }}">
          </div>
        </div>
        
        <!-- Tombol Cari & Reset -->
        <div class="col-12 col-md-auto ms-auto d-flex gap-2">
          <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1 flex-fill" style="border-radius: 6px;">
            <i class="ti ti-search fs-2"></i> Cari
          </button>
          @if(request('search'))
          <a href="{{ route('pelanggan.index') }}" class="btn btn-ghost-secondary px-3">
            Reset
          </a>
          @endif
        </div>
      </div>
    </form>
  </div>

  <!-- ===== SECTION TABEL DATA ===== -->
  <div class="table-responsive">
    <table class="table table-vcenter table-hover card-table text-nowrap">
      <thead>
        <tr>
          <th class="w-1 text-center">#</th>
          <th>Nama Pelanggan</th>
          <th>Nomor Telepon</th>
          <th>Alamat Lengkap</th>
          <th class="text-center">Total Riwayat Order</th>
          <th class="w-1 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pelanggan as $i => $p)
        <tr>
          <!-- No Urut -->
          <td class="text-center text-secondary small">{{ $pelanggan->firstItem() + $i }}</td>
          
          <!-- Nama Pelanggan dengan Inisial Icon -->
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar avatar-xs bg-primary-lt text-primary font-weight-bold" style="border-radius: 6px;">
                {{ strtoupper(substr($p->nama, 0, 1)) }}
              </div>
              <div class="font-weight-medium text-heading">{{ $p->nama }}</div>
            </div>
          </td>
          
          <!-- Nomor Telepon -->
          <td class="text-secondary small">
            @if($p->telepon)
            <div class="d-flex align-items-center gap-1">
              <i class="ti ti-phone text-muted fs-3"></i>
              {{ $p->telepon }}
            </div>
            @else
            <span class="text-muted">-</span>
            @endif
          </td>
          
          <!-- Alamat (Dibatasi Karakter secara Estetis) -->
          <td class="text-secondary small text-truncate" style="max-width: 250px;">
            @if($p->alamat)
            <div class="d-flex align-items-center gap-1">
              <i class="ti ti-map-pin text-muted fs-3"></i>
              {{ Str::limit($p->alamat, 40) }}
            </div>
            @else
            <span class="text-muted">-</span>
            @endif
          </td>
          
          <!-- Status Total Order Badge -->
          <td class="text-center">
            <span class="badge bg-blue-lt text-blue rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-receipt me-1 fs-3"></i> {{ $p->orders_count }} Order
            </span>
          </td>
          
          <!-- Tombol Aksi -->
          <td class="text-center">
            <div class="d-flex align-items-center justify-content-center gap-2">
              <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Ubah Data" style="border-radius: 6px;">
                <i class="ti ti-edit fs-2"></i>
              </a>
              <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus pelanggan {{ $p->nama }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus Data" style="border-radius: 6px;">
                  <i class="ti ti-trash fs-2"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <!-- Tampilan interaktif ketika data kosong -->
        <tr>
          <td colspan="6" class="text-center py-5">
            <div class="empty">
              <div class="empty-icon">
                <div class="avatar avatar-md bg-muted-lt" style="border-radius: 10px;">
                  <i class="ti ti-users fs-1 text-secondary"></i>
                </div>
              </div>
              <p class="empty-title text-heading mt-2">Belum ada pelanggan terdaftar</p>
              <p class="empty-subtitle text-secondary mb-0">Klik tombol "Tambah Pelanggan" di pojok kanan atas untuk memasukkan data baru.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- ===== SECTION PAGINATION ===== -->
  @if($pelanggan->hasPages())
  <div class="card-footer d-flex align-items-center justify-content-between border-top">
    <p class="m-0 text-secondary small">Menampilkan data halaman ini</p>
    <div>
      {{ $pelanggan->links() }}
    </div>
  </div>
  @endif
</div>
@endsection