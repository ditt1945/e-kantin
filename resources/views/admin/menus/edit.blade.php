@extends('layouts.app')

@section('title', 'Edit Menu - e-Kantin Admin')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-utensils me-2 text-primary"></i>Edit Menu
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Update menu information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('menus.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Back</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <form method="POST" action="{{ route('menus.update', $menu) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if($menu->gambar)
                            <div class="mb-4">
                                <label class="form-label fw-bold">Current Image</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $menu->gambar) }}"
                                         alt="{{ $menu->nama_menu }}"
                                         class="rounded"
                                         style="height: 100px; object-fit: cover;">
                                    <div>
                                        <small class="text-muted d-block">Current image</small>
                                        <small class="text-muted">Upload new image to replace</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="nama_menu" class="form-label fw-bold">Menu Name</label>
                                    <input type="text"
                                           id="nama_menu"
                                           name="nama_menu"
                                           class="form-control @error('nama_menu') is-invalid @enderror"
                                           value="{{ old('nama_menu', $menu->nama_menu) }}"
                                           placeholder="Enter menu name"
                                           required>
                                    @error('nama_menu')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="harga" class="form-label fw-bold">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number"
                                               id="harga"
                                               name="harga"
                                               class="form-control @error('harga') is-invalid @enderror"
                                               value="{{ old('harga', $menu->harga) }}"
                                               placeholder="0"
                                               min="0"
                                               step="100"
                                               required>
                                    </div>
                                    @error('harga')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="tenant_id" class="form-label fw-bold">Tenant</label>
                                    <select id="tenant_id"
                                            name="tenant_id"
                                            class="form-select @error('tenant_id') is-invalid @enderror"
                                            required>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id', $menu->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                                {{ $tenant->nama_tenant }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tenant_id')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="category_id" class="form-label fw-bold">Category</label>
                                    <select id="category_id"
                                            name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror"
                                            required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="stok" class="form-label fw-bold">Stock</label>
                                    <input type="number"
                                           id="stok"
                                           name="stok"
                                           class="form-control @error('stok') is-invalid @enderror"
                                           value="{{ old('stok', $menu->stok) }}"
                                           placeholder="0"
                                           min="0"
                                           required>
                                    @error('stok')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="unit" class="form-label fw-bold">Unit</label>
                                    <input type="text"
                                           id="unit"
                                           name="unit"
                                           class="form-control @error('unit') is-invalid @enderror"
                                           value="{{ old('unit', $menu->unit ?? 'pcs') }}"
                                           placeholder="e.g., pcs, kg, liters">
                                    @error('unit')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Availability</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_available" id="is_available" {{ old('is_available', $menu->is_available) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_available">
                                            Available
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Description</label>
                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Enter menu description (optional)">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label fw-bold">Menu Image</label>
                            <input type="file"
                                   id="gambar"
                                   name="gambar"
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   accept="image/*">
                            <div class="form-text">Leave empty to keep current image</div>
                            @error('gambar')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{-- Delete Button --}}
                                <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-1"></i>Delete Menu
                                </button>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Menu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Info Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2"></i>Menu Details
                    </h6>
                    <div class="mb-3">
                        <small class="text-muted">Menu ID</small>
                        <div class="fw-bold">#{{ $menu->id }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Tenant</small>
                        <div class="fw-bold">{{ $menu->tenant->nama_tenant ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Category</small>
                        <div class="fw-bold">{{ $menu->category->nama_kategori ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Created</small>
                        <div class="fw-bold">{{ $menu->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Last Updated</small>
                        <div class="fw-bold">{{ $menu->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="card border-0 shadow-sm mt-3" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-chart-line me-2"></i>Performance
                    </h6>
                    <div class="mb-3">
                        <small class="text-muted">Current Stock</small>
                        <div class="fw-bold {{ $menu->stok <= 5 ? 'text-warning' : 'text-success' }}">
                            {{ $menu->stok }} {{ $menu->unit ?? 'pcs' }}
                        </div>
                    </div>
                    <div>
                        <small class="text-muted">Status</small>
                        <div class="fw-bold">
                            <span class="badge {{ $menu->is_available ? 'bg-success' : 'bg-danger' }}">
                                {{ $menu->is_available ? 'Available' : 'Not Available' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the menu <strong>{{ $menu->nama_menu }}</strong>?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>This action cannot be undone and may affect existing orders.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection