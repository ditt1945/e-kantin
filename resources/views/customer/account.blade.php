@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="mb-5 d-flex justify-content-between align-items-center">
        <div>
            <h2 style="font-weight: 800; font-size: 2rem; margin-bottom: 0.3rem;">
                <i class="fas fa-user me-2" style="color: var(--primary);"></i>Profil Saya
            </h2>
            <p style="color: var(--text-secondary); font-size: 0.95rem;">Kelola informasi akun Anda</p>
        </div>
        <button onclick="history.back()" class="btn btn-sm" style="background: var(--light-gray); border: none; color: var(--text-primary); padding: 0.5rem 1rem; border-radius: 8px;">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </button>
    </div>

    <div class="row g-4">
        {{-- Account Info Card --}}
        <div class="col-lg-4">
            <div class="card" style="border: none; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border-radius: 12px;">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                    <h6 style="font-weight: 700; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">INFORMASI AKUN</h6>
                    <div style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 1rem;">
                        <small style="opacity: 0.8;">Nama Pengguna</small>
                        <div style="font-weight: 600; font-size: 1.1rem; margin-bottom: 1rem;">{{ $user->name ?? 'N/A' }}</div>
                        
                        <small style="opacity: 0.8;">Email Terdaftar</small>
                        <div style="font-weight: 500; font-size: 0.95rem; word-break: break-all; margin-bottom: 1rem; opacity: 0.95;">{{ $user->email ?? 'N/A' }}</div>

                        <small style="opacity: 0.8;">Status Akun</small>
                        <div style="font-weight: 600; margin-top: 0.3rem;">
                            <span class="badge bg-white text-primary" style="padding: 0.4rem 0.8rem;">✓ Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Info --}}
            <div class="card mt-3" style="border: none; background: var(--light-gray); border-radius: 12px;">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 1rem; color: var(--text-primary);">📋 Info</h6>
                    <div style="font-size: 0.9rem;">
                        <div class="mb-2" style="color: var(--text-secondary);">
                            <strong>Bergabung:</strong> {{ optional($user->created_at)->format('d M Y') ?? 'N/A' }}
                        </div>
                        <div style="color: var(--text-secondary);">
                            <strong>Role:</strong> <span class="badge bg-primary">{{ ucfirst($user->role ?? 'customer') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Forms Column --}}
        <div class="col-lg-8">
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert" style="background: rgba(var(--success-rgb), 0.1); border-left: 4px solid var(--success); color: var(--success); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-check-circle me-2"></i>Berhasil</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert" style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid var(--danger); color: var(--danger); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-exclamation-circle me-2"></i>Gagal</strong> {{ session('error') }}
                </div>
            @endif

            {{-- Edit Profile Card --}}
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; margin-bottom: 1.5rem; color: var(--text-primary);">
                        <i class="fas fa-edit me-2" style="color: var(--primary);"></i>Edit Profil
                    </h5>

                    <form action="{{ route('customer.account.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block; font-size: 0.95rem;">
                                <i class="fas fa-user-tag me-2" style="color: var(--primary);"></i>Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" 
                                   style="border: 1px solid var(--border-gray); border-radius: 8px; padding: 0.75rem; font-size: 0.95rem;" required>
                            @error('name') 
                                <small style="color: var(--danger); margin-top: 0.3rem; display: block;">
                                    <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                </small> 
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block; font-size: 0.95rem;">
                                <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" 
                                   style="border: 1px solid var(--border-gray); border-radius: 8px; padding: 0.75rem; font-size: 0.95rem;" required>
                            @error('email') 
                                <small style="color: var(--danger); margin-top: 0.3rem; display: block;">
                                    <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                </small> 
                            @enderror
                        </div>

                        <button type="submit" class="btn" 
                                style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none; border-radius: 8px; padding: 0.75rem 2rem; font-weight: 600; width: 100%; transition: all 0.3s ease;">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan Profil
                        </button>
                    </form>
                </div>
            </div>

            {{-- Change Password Card --}}
            <div class="card mt-4" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; margin-bottom: 1.5rem; color: var(--text-primary); border-left: 4px solid var(--warning); padding-left: 1rem;">
                        <i class="fas fa-lock me-2" style="color: var(--warning);"></i>Ubah Password
                    </h5>

                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">
                        Masukkan password baru Anda di bawah ini. Abaikan jika tidak ingin mengubah.
                    </p>

                    <form action="{{ route('customer.account.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block; font-size: 0.95rem;">
                                <i class="fas fa-key me-2" style="color: var(--warning);"></i>Password Baru
                            </label>
                            <input type="password" name="password" class="form-control" 
                                   style="border: 1px solid var(--border-gray); border-radius: 8px; padding: 0.75rem; font-size: 0.95rem;" 
                                   placeholder="Biarkan kosong jika tidak mengubah">
                            @error('password') 
                                <small style="color: var(--danger); margin-top: 0.3rem; display: block;">
                                    <i class="fas fa-times-circle me-1"></i>{{ $message }}
                                </small> 
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block; font-size: 0.95rem;">
                                <i class="fas fa-check-circle me-2" style="color: var(--warning);"></i>Konfirmasi Password Baru
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   style="border: 1px solid var(--border-gray); border-radius: 8px; padding: 0.75rem; font-size: 0.95rem;" 
                                   placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="btn" 
                            style="background: linear-gradient(135deg, var(--warning) 0%, var(--primary) 100%); color: #362c28; border: none; border-radius: 8px; padding: 0.75rem 2rem; font-weight: 600; width: 100%; transition: all 0.3s ease;">
                            <i class="fas fa-save me-2"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
