@extends('layouts.app')

@section('title', 'Menu Saya - e-Kantin')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-utensils me-2 text-primary"></i>Menu Saya
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">{{ $tenant->nama_tenant }} - Kelola menu kantin anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Kembali</span>
            </a>
            <a href="{{ route('tenant.menus.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i><span class="d-none d-sm-inline">Tambah Menu</span><span class="d-sm-none">Tambah</span>
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-2 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-primary text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-2 py-md-3">
                    <div class="stat-number">{{ $menus->count() }}</div>
                    <small class="opacity-75">Total Menu</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-success text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-2 py-md-3">
                    <div class="stat-number">{{ $menus->where('is_available', true)->where('stok', '>', 0)->count() }}</div>
                    <small class="opacity-75">Tersedia</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-warning text-dark" style="border-radius: 10px;">
                <div class="card-body text-center py-2 py-md-3">
                    <div class="stat-number">{{ $menus->where('stok', '>', 0)->where('stok', '<=', 10)->count() }}</div>
                    <small class="opacity-75">Menipis</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-danger text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-2 py-md-3">
                    <div class="stat-number">{{ $menus->where('stok', 0)->count() }}</div>
                    <small class="opacity-75">Habis</small>
                </div>
            </div>
        </div>
    </div>

    @if($menus->count() > 0)
    {{-- Menu Cards Grid --}}
    <div class="row g-2 g-md-3">
        @foreach($menus as $menu)
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex gap-2">
                        {{-- Image --}}
                        <div class="flex-shrink-0">
                            @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}"
                                     alt="{{ $menu->nama_menu }}"
                                     class="rounded menu-image"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="menu-image-placeholder rounded d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px; background: var(--light-gray);">
                                    <i class="fas fa-utensils text-muted"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="text-truncate pe-2">
                                    <h6 class="mb-0 fw-bold text-truncate">{{ $menu->nama_menu }}</h6>
                                    @if($menu->category)
                                        <small class="text-muted">{{ $menu->category->nama_kategori }}</small>
                                    @endif
                                </div>
                                @if($menu->is_available && $menu->stok > 0)
                                    <span class="badge bg-success flex-shrink-0"><i class="fas fa-check"></i></span>
                                @elseif($menu->stok == 0)
                                    <span class="badge bg-danger flex-shrink-0"><i class="fas fa-times"></i></span>
                                @else
                                    <span class="badge bg-warning flex-shrink-0"><i class="fas fa-exclamation"></i></span>
                                @endif
                            </div>
                            
                            @if($menu->deskripsi)
                                <small class="text-muted d-none d-md-block text-truncate">{{ Str::limit($menu->deskripsi, 50) }}</small>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <div class="fw-bold text-primary">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                    <small class="text-muted">Stok: {{ $menu->stok }}</small>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('tenant.menus.edit', $menu) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tenant.menus.destroy', $menu) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus menu {{ $menu->nama_menu }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @else
    {{-- Empty State --}}
    <div class="text-center py-5 bg-light rounded">
        <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Belum Ada Menu</h5>
        <p class="text-muted mb-3">Mulai dengan menambahkan menu pertama</p>
        <a href="{{ route('tenant.menus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Tambah Menu
        </a>
    </div>
    @endif
</div>

<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .stat-number {
        font-size: 1.75rem;
        font-weight: 800;
    }
    
    .menu-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }
    
    .menu-image-placeholder {
        width: 70px;
        height: 70px;
        background: var(--light-gray, #f8f9fa);
    }
    
    .min-width-0 {
        min-width: 0;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.2rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }
        
        .menu-image, .menu-image-placeholder {
            width: 60px;
            height: 60px;
        }
    }
    
    @media (max-width: 400px) {
        .stat-number {
            font-size: 1.25rem;
        }
        
        .menu-image, .menu-image-placeholder {
            width: 50px;
            height: 50px;
        }
    }
</style>
@endsection
