@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="card card-stacked">
      <!-- Top Accent Bar Biru -->
      <div class="card-status-top bg-primary"></div>
      
      <div class="card-header">
        <h3 class="card-title text-heading">Form User Baru</h3>
      </div>
      
      <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="card-body">
          
          <!-- Input Nama -->
          <div class="mb-3">
            <label class="form-label required">Nama Lengkap</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-user text-secondary fs-2"></i>
              </span>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name') }}" placeholder="Contoh: Azi Saputra" required>
            </div>
            @error('name')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Email -->
          <div class="mb-3">
            <label class="form-label required">Alamat Email</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-mail text-secondary fs-2"></i>
              </span>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email') }}" placeholder="email@laundryku.com" required>
            </div>
            @error('email')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Role Dropdown -->
          <div class="mb-3">
            <label class="form-label required">Hak Akses (Role)</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-user-shield text-secondary fs-2"></i>
              </span>
              <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required style="padding-left: 2.5rem;">
                <option value="">-- Pilih Role --</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id')==$role->id ? 'selected' : '' }}>{{ $role->label }}</option>
                @endforeach
              </select>
            </div>
            @error('role_id')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Password -->
          <div class="mb-3">
            <label class="form-label required">Password</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-lock text-secondary fs-2"></i>
              </span>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
            </div>
            @error('password')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          
          <!-- Input Konfirmasi Password -->
          <div class="mb-0">
            <label class="form-label required">Konfirmasi Password</label>
            <div class="input-icon">
              <span class="input-icon-addon">
                <i class="ti ti-circle-check text-secondary fs-2"></i>
              </span>
              <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
          </div>
          
        </div>
        
        <!-- Action Buttons -->
        <div class="card-footer bg-transparent d-flex gap-2 justify-content-end border-top">
          <a href="{{ route('users.index') }}" class="btn btn-ghost-secondary" style="border-radius: 6px;">
            Batal
          </a>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
            <i class="ti ti-check fs-2"></i> Simpan User
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection