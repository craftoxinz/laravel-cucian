@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('page-actions')
<a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
  <i class="ti ti-plus fs-2"></i> Tambah User
</a>
@endsection

@section('content')
<div class="card">
  <!-- ===== SECTION TABEL DATA USER ===== -->
  <div class="table-responsive">
    <table class="table table-vcenter table-hover card-table text-nowrap">
      <thead>
        <tr>
          <th class="w-1 text-center">#</th>
          <th>Foto</th>
          <th>Nama Lengkap</th>
          <th>Alamat Email</th>
          <th>Hak Akses (Role)</th>
          <th>Status Akun</th>
          <th class="w-1 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $i => $user)
        <tr>
          <!-- No Urut -->
          <td class="text-center text-secondary small">{{ $users->firstItem() + $i }}</td>

          <!-- Foto Profil / Avatar -->
          <td>
            @if(!empty($user->gambar))
              <img src="{{ asset('storage/' . $user->gambar) }}"
                   alt="{{ $user->name }}"
                   class="avatar avatar-sm object-cover"
                   style="border-radius: 6px; width: 36px; height: 36px;">
            @else
              <!-- Fallback: Menggunakan Inisial Nama Jika Gambar Kosong -->
              <div class="avatar avatar-sm bg-primary-lt text-primary font-weight-bold" style="border-radius: 6px; width: 36px; height: 36px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
            @endif
          </td>

          <!-- Nama User -->
          <td>
            <div>
              <div class="font-weight-medium text-heading">{{ $user->name }}</div>
              @if($user->id === auth()->id())
                <span class="badge bg-green-lt text-green rounded-pill" style="font-size: 9px; padding: 1px 6px;">Anda</span>
              @endif
            </div>
          </td>

          <!-- Email -->
          <td class="text-secondary small">
            <div class="d-flex align-items-center gap-1">
              <i class="ti ti-mail text-muted fs-3"></i>
              {{ $user->email }}
            </div>
          </td>

          <!-- Role Badge (Admin Purple, Kasir Blue) -->
          <td>
            <span class="badge {{ $user->role->name === 'admin' ? 'bg-purple' : 'bg-blue' }}-lt rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-user-shield me-1 fs-3"></i> {{ $user->role->label }}
            </span>
          </td>

          <!-- Status Aktif / Nonaktif -->
          <td>
            @if($user->is_active)
            <span class="badge bg-success-lt text-success rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-circle-check me-0.5 fs-3"></i> Aktif
            </span>
            @else
            <span class="badge bg-secondary-lt text-secondary rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-circle-x me-0.5 fs-3"></i> Nonaktif
            </span>
            @endif
          </td>

          <!-- Tombol Aksi -->
          <td class="text-center">
            <div class="d-flex align-items-center justify-content-center gap-2">
              <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Ubah User" style="border-radius: 6px;">
                <i class="ti ti-edit fs-2"></i>
              </a>
              @if($user->id !== auth()->id())
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline form-delete-user">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete-user" title="Hapus User" style="border-radius: 6px;" data-nama="{{ $user->name }}">
                        <i class="ti ti-trash fs-2"></i>
                    </button>
                </form>
                @endif
            </div>
          </td>
        </tr>
        @empty
        <!-- Tampilan Interaktif Saat Data User Kosong -->
        <tr>
          <td colspan="7" class="text-center py-5">
            <div class="empty">
              <div class="empty-icon">
                <div class="avatar avatar-md bg-muted-lt" style="border-radius: 10px;">
                  <i class="ti ti-user-cog fs-1 text-secondary"></i>
                </div>
              </div>
              <p class="empty-title text-heading mt-2">Tidak ada data pengguna</p>
              <p class="empty-subtitle text-secondary mb-0">Klik tombol "Tambah User" di pojok kanan atas untuk mendaftarkan akun kasir atau pengelola baru.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- ===== SECTION PAGINATION ===== -->
  @if($users->hasPages())
  <div class="card-footer d-flex align-items-center justify-content-between border-top">
    <p class="m-0 text-secondary small">Menampilkan data halaman ini</p>
    <div>
      {{ $users->links() }}
    </div>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.btn-delete-user').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const form = btn.closest('form.form-delete-user');
      const nama = btn.dataset.nama;

      Swal.fire({
        title: 'Hapus User?',
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
      confirmButtonColor: '#2fb344', // warna success Tabler
      timer: 2500,
      timerProgressBar: true,
    });
  @endif
});
</script>
@endpush
