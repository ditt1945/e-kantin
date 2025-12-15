@extends('layouts.app')

@include('partials.admin-styles')

@section('content')
<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="admin-page-title">
                    <i class="fas fa-store me-2"></i>Kelola Tenant
                </h1>
                <p class="admin-page-subtitle">Pantau seluruh kantin yang terdaftar di platform</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="admin-action-bar justify-content-md-end">
                    <a href="{{ route('tenant:check') }}" class="admin-action-btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                        <span>Cek Data</span>
                    </a>
                    <a href="{{ route('tenants.create') }}" class="admin-action-btn btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Tenant</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            <i class="fas fa-times-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Desktop Table -->
    <div class="admin-data-table d-none d-lg-block">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Nama Tenant</th>
                    <th>Pemilik</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Menu</th>
                    <th>Pesanan</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $tenant->nama_tenant }}</div>
                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($tenant->deskripsi, 40) }}</small>
                        </td>
                        <td>{{ $tenant->pemilik ?? '-' }}</td>
                        <td>{{ $tenant->no_telepon ?? '-' }}</td>
                        <td>
                            <span class="admin-status-badge {{ $tenant->is_active ? 'admin-status-active' : 'admin-status-inactive' }}">
                                <span class="badge" style="width: 6px; height: 6px;"></span>
                                {{ $tenant->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary rounded-pill">{{ $tenant->menus_count }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info rounded-pill">{{ $tenant->orders_count }}</span>
                        </td>
                        <td>
                            <div class="admin-table-action">
                                <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tenant ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="admin-empty-state">
                                <div class="admin-empty-state-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <h5 class="admin-empty-state-title">Belum ada tenant</h5>
                                <p class="admin-empty-state-text">Tambah tenant pertama untuk memulai</p>
                                <a href="{{ route('tenants.create') }}" class="admin-action-btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                    Tambah Tenant
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-3">
            {{ $tenants->links() }}
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="d-lg-none">
        @forelse($tenants as $tenant)
            <div class="admin-mobile-card border-start border-3 border-{{ $tenant->is_active ? 'success' : 'secondary' }}">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $tenant->nama_tenant }}</h6>
                        <small class="text-muted">{{ $tenant->pemilik ?? '-' }}</small>
                    </div>
                    <span class="admin-status-badge {{ $tenant->is_active ? 'admin-status-active' : 'admin-status-inactive' }}">
                        {{ $tenant->is_active ? 'Aktif' : 'Off' }}
                    </span>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-3 small">
                    <span class="text-muted">
                        <i class="fas fa-phone me-1"></i>{{ $tenant->no_telepon ?? '-' }}
                    </span>
                    <span class="text-muted">
                        <i class="fas fa-utensils me-1"></i>{{ $tenant->menus_count }} menu
                    </span>
                    <span class="text-muted">
                        <i class="fas fa-shopping-cart me-1"></i>{{ $tenant->orders_count }} pesanan
                    </span>
                </div>

                <div class="admin-table-action">
                    <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="admin-empty-state">
                <div class="admin-empty-state-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h5 class="admin-empty-state-title">Belum ada tenant</h5>
                <p class="admin-empty-state-text">Tambah tenant pertama untuk memulai</p>
                <a href="{{ route('tenants.create') }}" class="admin-action-btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Tenant
                </a>
            </div>
        @endforelse

        <div class="admin-pagination mt-3">
            {{ $tenants->links() }}
        </div>
    </div>
</div>

<style>
    /* Fix badge dots */
    .admin-status-badge .badge {
        display: inline-block;
        border-radius: 50%;
        background: currentColor;
    }
</style>
@endsection