@extends('layouts.app')

@section('title', 'Edit Category - e-Kantin Admin')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-tags me-2 text-primary"></i>Edit Category
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Update category information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Back</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-bold">Category Name</label>
                            <input type="text"
                                   id="nama_kategori"
                                   name="nama_kategori"
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   value="{{ old('nama_kategori', $category->nama_kategori) }}"
                                   placeholder="Enter category name"
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Description</label>
                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Enter category description (optional)">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="form-label fw-bold">Icon (Optional)</label>
                            <input type="text"
                                   id="icon"
                                   name="icon"
                                   class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', $category->icon) }}"
                                   placeholder="e.g., fas fa-pizza-slice">
                            <div class="form-text">Font Awesome icon class name</div>
                            @error('icon')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="color" class="form-label fw-bold">Color (Optional)</label>
                            <input type="color"
                                   id="color"
                                   name="color"
                                   class="form-control form-control-color @error('color') is-invalid @enderror"
                                   value="{{ old('color', $category->color ?? '#007bff') }}"
                                   style="height: 38px;">
                            @error('color')
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
                                    <i class="fas fa-trash me-1"></i>Delete Category
                                </button>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Category
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
                        <i class="fas fa-info-circle me-2"></i>Category Details
                    </h6>
                    <div class="mb-3">
                        <small class="text-muted">Category ID</small>
                        <div class="fw-bold">#{{ $category->id }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Created</small>
                        <div class="fw-bold">{{ $category->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Last Updated</small>
                        <div class="fw-bold">{{ $category->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card border-0 shadow-sm mt-3" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-eye me-2"></i>Preview
                    </h6>
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white mb-2" id="preview-circle" style="width: 60px; height: 60px; background-color: {{ $category->color ?? '#007bff' }};">
                            <i class="{{ $category->icon ?? 'fas fa-tag' }} fa-lg"></i>
                        </div>
                        <div class="fw-bold" id="preview-name">{{ $category->nama_kategori }}</div>
                        <div class="small text-muted" id="preview-desc">{{ $category->deskripsi ?: 'Category description' }}</div>
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
                    <p>Are you sure you want to delete the category <strong>{{ $category->nama_kategori }}</strong>?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>This action cannot be undone and may affect menu items using this category.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('nama_kategori');
    const descInput = document.getElementById('deskripsi');
    const iconInput = document.getElementById('icon');
    const colorInput = document.getElementById('color');
    const previewName = document.getElementById('preview-name');
    const previewDesc = document.getElementById('preview-desc');
    const previewIcon = document.querySelector('#preview-circle i');
    const previewCircle = document.getElementById('preview-circle');

    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Category Name';
    });

    descInput.addEventListener('input', function() {
        previewDesc.textContent = this.value || 'Category description';
    });

    iconInput.addEventListener('input', function() {
        if (this.value && this.value.trim() !== '') {
            previewIcon.className = this.value + ' fa-lg';
        } else {
            previewIcon.className = 'fas fa-tag fa-lg';
        }
    });

    colorInput.addEventListener('input', function() {
        previewCircle.style.backgroundColor = this.value;
    });
});
</script>
@endsection