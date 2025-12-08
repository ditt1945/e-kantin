@extends('layouts.app')

@section('title', 'Edit Menu - e-Kantin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Menu - {{ $menu->nama_menu }}
                    </h4>
                    <button onclick="history.back()" class="btn btn-sm" style="background: var(--light-gray); border: none; color: var(--text-primary); padding: 0.5rem 1rem; border-radius: 8px;">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('tenant.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Preview Gambar --}}
                        @if($menu->gambar)
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Gambar Saat Ini</label>
                                <div>
                                    <img src="{{ asset('storage/' . $menu->gambar) }}" 
                                         alt="{{ $menu->nama_menu }}" 
                                         class="rounded" 
                                         width="150" style="object-fit: cover;">
                                    <div class="form-text mt-2">
                                        <a href="{{ asset('storage/' . $menu->gambar) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Lihat Full Size
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_menu" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" 
                                           id="nama_menu" name="nama_menu" 
                                           value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                                    @error('nama_menu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Menu</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                               id="harga" name="harga" 
                                               value="{{ old('harga', $menu->harga) }}" 
                                               min="0" step="500" required>
                                    </div>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" name="stok" 
                                           value="{{ old('stok', $menu->stok) }}" 
                                           min="0" required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">
                                Gambar Menu 
                                @if($menu->gambar)
                                    <span class="text-muted">(Kosongkan jika tidak ingin mengubah)</span>
                                @endif
                            </label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" name="gambar" accept="image/*">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" 
                                {{ old('is_available', $menu->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                <strong>Tersedia untuk dipesan</strong>
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tenant.menus.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Menu
                                </button>
                                <a href="{{ route('tenant.menus.index') }}" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-list me-1"></i>Lihat Semua Menu
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection