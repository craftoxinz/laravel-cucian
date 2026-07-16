@extends('layouts.app')

@section('title', 'Layanan & Harga')
@section('page-title', 'Layanan & Harga')

@section('page-actions')
<a href="{{ route('layanan.create') }}" class="btn btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
  <i class="ti ti-plus fs-2"></i> Tambah Layanan
</a>
@endsection

@section('content')
<div class="card">
  <!-- ===== SECTION TABEL DATA LAYANAN ===== -->
  <div class="table-responsive">
    <table class="table table-vcenter table-hover card-table text-nowrap">
      <thead>
        <tr>
          <th class="w-1 text-center">#</th>
          <th>Nama Layanan</th>
          <th>Satuan</th>
          <th>Harga Satuan</th>
          <th>Deskripsi Singkat</th>
          <th>Status</th>
          <th class="w-1 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($layanan as $i => $l)
        <tr>
          <!-- No Urut -->
          <td class="text-center text-secondary small">{{ $layanan->firstItem() + $i }}</td>

          <!-- Nama Layanan dengan Visual Icon Bulat -->
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar avatar-xs bg-primary-lt text-primary font-weight-bold" style="border-radius: 6px;">
                <i class="ti ti-shirt fs-3"></i>
              </div>
              <div class="font-weight-medium text-heading">{{ $l->nama }}</div>
            </div>
          </td>

          <!-- Satuan Kerja -->
          <td>
            <span class="badge bg-blue-lt text-blue rounded-pill px-2.5 py-1 font-weight-medium text-lowercase">
              per {{ $l->satuan }}
            </span>
          </td>

          <!-- Harga Formatted -->
          <td class="font-weight-medium text-heading">
            {{ $l->harga_formatted }}
          </td>

          <!-- Deskripsi -->
          <td class="text-secondary small text-truncate" style="max-width: 280px;">
            {{ Str::limit($l->deskripsi, 50) ?? '-' }}
          </td>

          <!-- Status Aktif / Nonaktif -->
          <td>
            @if($l->is_active)
            <span class="badge bg-success-lt text-success rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-circle-check me-1 fs-3"></i> Aktif
            </span>
            @else
            <span class="badge bg-secondary-lt text-secondary rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-circle-x me-1 fs-3"></i> Nonaktif
            </span>
            @endif
          </td>

          <!-- Tombol Aksi Kerja -->
          <td class="text-center">
            <div class="d-flex align-items-center justify-content-center gap-2">
              <a href="{{ route('layanan.edit', $l) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Ubah Layanan" style="border-radius: 6px;">
                <i class="ti ti-edit fs-2"></i>
              </a>
                <form action="{{ route('layanan.destroy', $l) }}" method="POST" class="d-inline form-delete-layanan">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete-layanan" title="Hapus Data" style="border-radius: 6px;" data-nama="{{ $l->nama }}">
                        <i class="ti ti-trash fs-2"></i>
                    </button>
                </form>
            </div>
          </td>
        </tr>
        @empty
        <!-- Tampilan Interaktif Data Layanan Kosong -->
        <tr>
          <td colspan="7" class="text-center py-5">
            <div class="empty">
              <div class="empty-icon">
                <div class="avatar avatar-md bg-muted-lt" style="border-radius: 10px;">
                  <i class="ti ti-hanger fs-1 text-secondary"></i>
                </div>
              </div>
              <p class="empty-title text-heading mt-2">Belum ada jenis layanan</p>
              <p class="empty-subtitle text-secondary mb-0">Tekan tombol "Tambah Layanan" untuk menambahkan jenis paket laundry baru.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- ===== SECTION PAGINATION ===== -->
  @if($layanan->hasPages())
  <div class="card-footer d-flex align-items-center justify-content-between border-top">
    <p class="m-0 text-secondary small">Menampilkan data halaman ini</p>
    <div>
      {{ $layanan->links() }}
    </div>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.btn-delete-layanan').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const form = btn.closest('form.form-delete-layanan');
      const nama = btn.dataset.nama;

      Swal.fire({
        title: 'Hapus layanan?',
        html: `Yakin ingin menghapus <b>${nama}</b>?<br>Data yang sudah dihapus tidak dapat dikembalikan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d63939',
        cancelButtonColor: '#626976',
        reverseButtons: true,
        focusCancel: true,
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  @if(session('success'))
    Swal.fire({
      title: 'Berhasil!',
      text: @json(session('success')),
      icon: 'success',
      confirmButtonText: 'OK',
      confirmButtonColor: '#2fb344',
      timer: 2500,
      timerProgressBar: true,
    });
  @endif
});
</script>
@endpush
