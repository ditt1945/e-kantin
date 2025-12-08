@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-store me-2 text-primary"></i>Pilih Tenant
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Jelajahi berbagai pilihan kantin dan pesan makanan favorit Anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-home me-1"></i><span class="d-none d-sm-inline">Dashboard</span>
            </a>
            <a href="{{ route('customer.cart') }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
    </div>

    @if($tenants->count() > 0)
    <div class="row g-4">
        @foreach($tenants as $tenant)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                <div class="hero-strip" style="height: 150px; background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%); display: flex; align-items: center; justify-content: center; border-radius: 14px 14px 0 0;">
                    <i class="fas fa-store fa-4x" style="color: rgba(255,255,255,0.9); text-shadow: 0 2px 8px rgba(0,0,0,0.2);"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title clamp-1" style="font-weight: 700; color: var(--text-primary); font-size: 1.1rem;">{{ $tenant->nama_tenant }}</h5>
                    <p class="card-text clamp-2" style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem;">
                        {{ Str::limit($tenant->deskripsi ?? 'Kantin pilihan Anda', 60) }}
                    </p>
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                        <span class="badge bg-primary" style="font-size: 0.8rem;">
                            <i class="fas fa-utensils me-1"></i>{{ $tenant->menus_count }} Menu
                        </span>
                        <span class="badge bg-success" style="font-size: 0.8rem;">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                    </div>
                </div>
                <div class="card-footer" style="background: transparent; border-top: 1px solid var(--border-gray); padding: 1rem;">
                    <a href="{{ route('customer.menus', $tenant) }}" class="btn btn-primary w-100">
                        <i class="fas fa-arrow-right me-2"></i>Lihat Menu
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
        <h4 class="text-muted fw-semibold">Belum ada kantin tersedia</h4>
        <p class="text-muted">Silakan coba lagi nanti</p>
    </div>
    @endif
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