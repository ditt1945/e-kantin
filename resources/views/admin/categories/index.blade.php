@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0"><i class="fas fa-tags me-2 text-primary"></i>Kategori Menu</h2>
            <p class="text-muted small mb-0 d-none d-md-block">Kelola kategori untuk menu makanan dan minuman</p>
        </div>
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

    <div class="row g-3">
        {{-- Add Category Form --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <h5 class="fw-bold mb-3"><i class="fas fa-plus me-2 text-success"></i>Tambah Kategori</h5>
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Nama Kategori</label>
                            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Categories List --}}
        <div class="col-lg-7">
            <div class="card shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Kategori</h5>
                            <small class="text-muted">Total {{ $categories->total() }} kategori</small>
                        </div>
                    </div>

                    {{-- Desktop Table --}}
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Menu</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $category->nama_kategori }}</div>
                                                <div class="text-muted small">{{ Str::limit($category->deskripsi, 30) ?? '-' }}</div>
                                            </td>
                                            <td><span class="badge bg-primary">{{ $category->menus_count }}</span></td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">Belum ada kategori</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="d-md-none">
                        @forelse($categories as $category)
                            <div class="card mb-2 border-start border-3 border-primary">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $category->nama_kategori }}</h6>
                                            <small class="text-muted">{{ Str::limit($category->deskripsi, 40) ?? '-' }}</small>
                                        </div>
                                        <span class="badge bg-primary">{{ $category->menus_count }} menu</span>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary flex-grow-1" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
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
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-tags fa-2x mb-2"></i>
                                <p class="mb-0">Belum ada kategori</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modals --}}
    @foreach($categories as $category)
        <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Kategori</label>
                                <input type="text" name="nama_kategori" value="{{ $category->nama_kategori }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="form-control">{{ $category->deskripsi }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
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
