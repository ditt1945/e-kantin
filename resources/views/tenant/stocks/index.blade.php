@extends('layouts.app')

@section('title', 'Management Stok - e-Kantin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-boxes me-2"></i>Management Stok - {{ $tenant->nama_tenant }}
                    </h4>
                    <div>
                        <button onclick="history.back()" class="btn btn-sm me-2" style="background: var(--light-gray); border: none; color: var(--text-primary); padding: 0.5rem 1rem; border-radius: 8px;">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </button>
                        <a href="{{ route('tenant.menus.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px;">
                            <i class="fas fa-plus me-1"></i>Tambah Menu
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Summary Cards --}}
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $menus->where('stok', '>', 10)->count() }}</h3>
                                    <small class="opacity-75">Stok Aman</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-dark h-100">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $menus->where('stok', '>', 0)->where('stok', '<=', 10)->count() }}</h3>
                                    <small class="opacity-75">Hampir Habis</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-danger text-white h-100">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $menus->where('stok', 0)->count() }}</h3>
                                    <small class="opacity-75">Stok Habis</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $menus->sum('stok') }}</h3>
                                    <small class="opacity-75">Total Stok</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($menus->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Menu</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menus as $menu)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($menu->gambar)
                                                <img src="{{ asset('storage/' . $menu->gambar) }}" 
                                                     alt="{{ $menu->nama_menu }}" 
                                                     class="rounded me-3" 
                                                     width="45" height="45" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 45px; height: 45px;">
                                                    <i class="fas fa-utensils text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong class="d-block">{{ $menu->nama_menu }}</strong>
                                                @if($menu->deskripsi)
                                                    <small class="text-muted">{{ Str::limit($menu->deskripsi, 40) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($menu->category)
                                            <span class="badge bg-info">{{ $menu->category->nama_kategori }}</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $menu->stok > 10 ? 'success' : ($menu->stok > 0 ? 'warning' : 'danger') }} fs-6">
                                            {{ $menu->stok }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($menu->stok > 10)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Tersedia
                                            </span>
                                        @elseif($menu->stok > 0)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation me-1"></i>Hampir Habis
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Habis
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            {{-- Tombol Edit Stok --}}
                                            <button type="button" class="btn btn-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editStockModal{{ $menu->id }}"
                                                    title="Edit Stok">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('tenant.menus.show', $menu) }}" class="btn btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>

                                        {{-- Modal Edit Stok --}}
                                        <div class="modal fade" id="editStockModal{{ $menu->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <form action="{{ route('tenant.stocks.update', $menu) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">
                                                                <i class="fas fa-edit me-1"></i>Edit Stok
                                                            </h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <h6 class="mb-3">{{ $menu->nama_menu }}</h6>
                                                            
                                                            @if($menu->gambar)
                                                                <img src="{{ asset('storage/' . $menu->gambar) }}" 
                                                                     alt="{{ $menu->nama_menu }}" 
                                                                     class="rounded mb-3" 
                                                                     width="80" style="object-fit: cover;">
                                                            @endif
                                                            
                                                            <div class="mb-3">
                                                                <label for="stock{{ $menu->id }}" class="form-label small">
                                                                    <strong>Stok Tersedia</strong>
                                                                </label>
                                                                <input type="number" class="form-control form-control-lg text-center" 
                                                                       id="stock{{ $menu->id }}" name="stock" 
                                                                       value="{{ $menu->stok }}" min="0" required
                                                                       style="font-size: 1.2rem; font-weight: bold;">
                                                                <div class="form-text small">
                                                                    Stok saat ini: <strong>{{ $menu->stok }} pcs</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i>Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-save me-1"></i>Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5>Belum ada menu</h5>
                        <p class="text-muted">Anda belum memiliki menu untuk dikelola stoknya.</p>
                        <a href="{{ route('tenant.menus.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Menu Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if(session('success'))
<script>
    // Auto close alert setelah 3 detik
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
</script>
@endif
@endsection