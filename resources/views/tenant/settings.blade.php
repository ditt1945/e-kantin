@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-cog me-2 text-primary"></i>Pengaturan Tenant
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">{{ $tenant->nama_tenant ?? 'Tenant' }} - Kelola informasi dan konfigurasi</p>
        </div>
        <a href="{{ route('tenant.dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
    </div>

    {{-- Tenant Info Display Card --}}
    <div class="card mb-3 border-0 bg-primary text-white" style="border-radius: 12px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-shrink-0">
                    <i class="fas fa-store fa-2x opacity-75"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-0 fw-bold">{{ $tenant->nama_tenant }}</h5>
                    <small class="opacity-75">ID: {{ $tenant->id }}</small>
                </div>
                <div class="flex-shrink-0">
                    <span class="badge bg-white text-primary">
                        <i class="fas fa-circle me-1 {{ $tenant->is_active ? 'text-success' : 'text-danger' }}" style="font-size: 0.5rem;"></i>
                        {{ $tenant->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Settings Form --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-3 p-md-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-edit me-2 text-primary"></i>Edit Informasi Tenant
            </h5>

            <form action="{{ route('tenant.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-store me-1 text-primary"></i>Nama Tenant
                    </label>
                    <input type="text" name="nama_tenant" value="{{ old('nama_tenant', $tenant->nama_tenant ?? '') }}" 
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-align-left me-1 text-primary"></i>Deskripsi Tenant
                    </label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $tenant->deskripsi ?? '') }}</textarea>
                    <small class="text-muted">Deskripsi singkat tentang tenant Anda</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-phone me-1 text-primary"></i>Nomor Telepon
                    </label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $tenant->no_telepon ?? '') }}" 
                           class="form-control" placeholder="Contoh: 081234567890">
                </div>

                <div class="mb-4 p-3 bg-light rounded border-start border-4 border-warning">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                               {{ old('is_active', $tenant->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            <strong>Aktifkan Tenant</strong>
                            <div class="small text-muted">Jika tidak dicentang, tenant tidak akan terlihat oleh customer</div>
                        </label>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                    <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Info Section --}}
    <div class="row g-2 mt-2">
        <div class="col-md-6">
            <div class="card border-0 bg-light" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1 text-primary"></i>Informasi Umum</h6>
                    <div class="small text-muted">
                        <div class="mb-1"><strong>ID:</strong> {{ $tenant->id }}</div>
                        <div class="mb-1"><strong>Terdaftar:</strong> {{ optional($tenant->created_at)->format('d M Y H:i') }}</div>
                        <div><strong>Update:</strong> {{ optional($tenant->updated_at)->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 bg-light" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-2"><i class="fas fa-question-circle me-1 text-warning"></i>Bantuan</h6>
                    <small class="text-muted">
                        Pastikan informasi tenant benar. Nama dan deskripsi akan ditampilkan kepada customer. Nonaktifkan tenant jika tidak menerima pesanan sementara.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.2rem;
        }
        
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }
    }
</style>
@endsection