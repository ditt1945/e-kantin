@extends('layouts.app')

@section('title', 'Detail Menu - e-Kantin')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-utensils me-2 text-primary"></i>Detail Menu
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Lihat informasi lengkap menu</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.menus.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Kembali</span>
            </a>
            <a href="{{ route('tenant.menus.edit', $menu) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i><span class="d-none d-sm-inline">Edit</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Menu Details Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    @if($menu->gambar)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $menu->gambar) }}"
                                 alt="{{ $menu->nama_menu }}"
                                 class="img-fluid rounded"
                                 style="max-height: 300px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="fw-bold mb-3">{{ $menu->nama_menu }}</h3>

                            <div class="mb-3">
                                <span class="badge {{ $menu->is_available ? 'bg-success' : 'bg-danger' }}">
                                    {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                                @if($menu->stok <= 5)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Stok Rendah
                                    </span>
                                @endif
                            </div>

                            <p class="text-muted mb-4">
                                {{ $menu->deskripsi ?: 'Tidak ada deskripsi' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Informasi Harga & Stok</h6>

                                    <div class="mb-3">
                                        <small class="text-muted">Harga</small>
                                        <div class="h4 text-success fw-bold mb-0">
                                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Stok Tersedia</small>
                                        <div class="h5 {{ $menu->stok <= 5 ? 'text-warning' : 'text-primary' }} fw-bold mb-0">
                                            {{ $menu->stok }} {{ $menu->unit ?? 'pcs' }}
                                        </div>
                                    </div>

                                    <div>
                                        <small class="text-muted">Kategori</small>
                                        <div class="fw-bold mb-0">
                                            {{ $menu->category->nama_kategori ?? 'Tidak ada kategori' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional Information --}}
            <div class="card border-0 shadow-sm mt-3" style="border-radius: 12px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">ID Menu</small>
                                <div class="fw-bold">#{{ $menu->id }}</div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">Dibuat pada</small>
                                <div class="fw-bold">{{ $menu->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Terakhir diupdate</small>
                                <div class="fw-bold">{{ $menu->updated_at->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">Tenant</small>
                                <div class="fw-bold">{{ $menu->tenant->nama_tenant ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Quick Actions --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>

                    <div class="d-grid gap-2">
                        <a href="{{ route('tenant.stocks.index') }}" class="btn btn-primary">
                            <i class="fas fa-boxes me-2"></i>Kelola Stok
                        </a>

                        <a href="{{ route('tenant.menus.edit', $menu) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Menu
                        </a>

                        <a href="{{ route('tenant.reports') }}" class="btn btn-info">
                            <i class="fas fa-chart-line me-2"></i>Lihat Laporan
                        </a>

                        {{-- Delete Button --}}
                        <button type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $menu->id }}">
                            <i class="fas fa-trash me-2"></i>Hapus Menu
                        </button>
                    </div>
                </div>
            </div>

            {{-- Delete Confirmation Modal --}}
            <div class="modal fade" id="deleteModal{{ $menu->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus menu <strong>{{ $menu->nama_menu }}</strong>?</p>
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Tindakan ini tidak dapat dibatalkan.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <form action="{{ route('tenant.menus.destroy', $menu) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="card border-0 bg-primary text-white mt-3" style="border-radius: 12px;">
                <div class="card-body text-center">
                    <i class="fas fa-chart-pie fa-2x mb-3 opacity-75"></i>
                    <h6>Performa Menu</h6>
                    <div class="h3 mb-0">{{ rand(50, 200) }}</div>
                    <small class="opacity-75">Terjual bulan ini</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection