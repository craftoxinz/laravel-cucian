@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="card card-stacked">
      <!-- Top Accent Bar Kuning -->
      <div class="card-status-top bg-yellow"></div>
      
      <div class="card-header">
        <h3 class="card-title text-heading">Edit Pengaturan User</h3>
      </div>
      
      <form action="{{ route('users.update', $user) }}" method="POST" autocomplete="off">
        @csrf 
        @method('PUT')
        
        <div class="card-body">
          
          <!-- Edit Nama -->
          <div class="mb-3">
            <label class="form-label required">Nama Lengkap</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-user text-secondary fs-2"></i>
              </span>
              <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
          </div>
          
          <!-- Edit Email -->
          <div class="mb-3">
            <label class="form-label required">Alamat Email</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-mail text-secondary fs-2"></i>
              </span>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
          </div>
          
          <!-- Edit Role -->
          <div class="mb-3">
            <label class="form-label required">Hak Akses (Role)</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-user-shield text-secondary fs-2"></i>
              </span>
              <select name="role_id" class="form-select" required style="padding-left: 2.5rem;">
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id==$role->id ? 'selected' : '' }}>{{ $role->label }}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          <!-- Password Baru (Opsional) -->
          <div class="mb-3">
            <label class="form-label">Password Baru <span class="text-secondary small">(Kosongkan jika tidak ingin diubah)</span></label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-lock text-secondary fs-2"></i>
              </span>
              <input type="password" name="password" class="form-control" placeholder="••••••••">
            </div>
          </div>
          
          <!-- Konfirmasi Password Baru -->
          <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-circle-check text-secondary fs-2"></i>
              </span>
              <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
          </div>
          
          <!-- Status Switch Aktif/Nonaktif -->
          <div class="mb-0">
            <label class="form-check form-switch m-0" style="cursor: pointer;">
              <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $user->is_active ? 'checked' : '' }} style="cursor: pointer;">
              <span class="form-check-label text-heading" style="cursor: pointer;">Status Pengguna Aktif</span>
              <span class="form-check-description text-secondary small">Jika dinonaktifkan, user ini tidak akan bisa login ke dalam aplikasi LaundryKu.</span>
            </label>
          </div>
          
        </div>
        
        <!-- Action Buttons -->
        <div class="card-footer bg-transparent d-flex gap-2 justify-content-end border-top">
          <a href="{{ route('users.index') }}" class="btn btn-ghost-secondary" style="border-radius: 6px;">
            Batal
          </a>
          <button type="submit" class="btn btn-warning d-flex align-items-center gap-1 text-dark" style="border-radius: 6px;">
            <i class="ti ti-refresh fs-2"></i> Perbarui Akun
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection