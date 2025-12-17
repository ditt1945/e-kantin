@extends('layouts.app')

@section('title', 'Create Menu - e-Kantin Admin')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-utensils me-2 text-primary"></i>Create Menu
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Add new menu item</p>
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
                    <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="nama_menu" class="form-label fw-bold">Menu Name</label>
                                    <input type="text"
                                           id="nama_menu"
                                           name="nama_menu"
                                           class="form-control @error('nama_menu') is-invalid @enderror"
                                           value="{{ old('nama_menu') }}"
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
                                               value="{{ old('harga') }}"
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
                                        <option value="">Select Tenant</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
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
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                           value="{{ old('stok') }}"
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
                                           value="{{ old('unit', 'pcs') }}"
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
                                        <input class="form-check-input" type="checkbox" name="is_available" id="is_available" checked>
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
                                      placeholder="Enter menu description (optional)">{{ old('deskripsi') }}</textarea>
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
                            <div class="form-text">Allowed formats: JPEG, PNG, JPG, GIF (Max 2MB)</div>
                            @error('gambar')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Menu
                            </button>
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
                        <i class="fas fa-info-circle me-2"></i>Menu Information
                    </h6>
                    <div class="small text-muted">
                        <p class="mb-2">Add detailed information about the menu item to help customers make informed choices.</p>
                        <ul class="mb-0">
                            <li>High-quality images increase sales</li>
                            <li>Detailed descriptions build trust</li>
                            <li>Proper pricing is crucial</li>
                            <li>Stock management prevents overselling</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="card border-0 shadow-sm mt-3" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-lightbulb me-2"></i>Tips
                    </h6>
                    <div class="small text-muted">
                        <ul class="mb-0">
                            <li>Use appealing, descriptive names</li>
                            <li>Include ingredients in description</li>
                            <li>Set competitive pricing</li>
                            <li>Keep stock levels accurate</li>
                            <li>Upload appetizing photos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection