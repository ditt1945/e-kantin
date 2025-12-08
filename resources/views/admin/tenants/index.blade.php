@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="page-title mb-0"><i class="fas fa-store me-2 text-primary"></i>Kelola Tenant</h2>
            <p class="text-muted mb-0 small d-none d-md-block">Pantau seluruh kantin yang terdaftar di platform</p>
        </div>
        <a href="{{ route('tenants.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i><span class="d-none d-sm-inline">Tambah Tenant</span><span class="d-sm-none">Tambah</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Desktop Table --}}
    <div class="card shadow-sm d-none d-lg-block">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Tenant</th>
                            <th>Pemilik</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Menu</th>
                            <th>Pesanan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $tenant->nama_tenant }}</div>
                                    <div class="text-muted small">{{ \Illuminate\Support\Str::limit($tenant->deskripsi, 40) }}</div>
                                </td>
                                <td>{{ $tenant->pemilik ?? '-' }}</td>
                                <td>{{ $tenant->no_telepon ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $tenant->is_active ? 'success' : 'secondary' }}">
                                        {{ $tenant->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>{{ $tenant->menus_count }}</td>
                                <td>{{ $tenant->orders_count }}</td>
                                <td class="text-end">
                                    <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tenant ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada tenant terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $tenants->links() }}
            </div>
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="d-lg-none">
        @forelse($tenants as $tenant)
            <div class="card mb-2 border-start border-3 border-{{ $tenant->is_active ? 'success' : 'secondary' }}">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $tenant->nama_tenant }}</h6>
                            <small class="text-muted">{{ $tenant->pemilik ?? '-' }}</small>
                        </div>
                        <span class="badge bg-{{ $tenant->is_active ? 'success' : 'secondary' }}">
                            {{ $tenant->is_active ? 'Aktif' : 'Off' }}
                        </span>
                    </div>
                    <div class="d-flex flex-wrap gap-3 mb-2 small text-muted">
                        <span><i class="fas fa-phone me-1"></i>{{ $tenant->no_telepon ?? '-' }}</span>
                        <span><i class="fas fa-utensils me-1"></i>{{ $tenant->menus_count }} menu</span>
                        <span><i class="fas fa-shopping-cart me-1"></i>{{ $tenant->orders_count }} pesanan</span>
                    </div>
                    <div class="d-flex gap-2 pt-2 border-top">
                        <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-store fa-3x text-muted mb-2"></i>
                <h5 class="text-muted">Belum ada tenant</h5>
                <a href="{{ route('tenants.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-1"></i>Tambah Tenant
                </a>
            </div>
        @endforelse
        <div class="mt-3">
            {{ $tenants->links() }}
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
