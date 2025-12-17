@extends('layouts.app')

@section('title', 'Create Category - e-Kantin Admin')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-tags me-2 text-primary"></i>Create Category
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Add new menu category</p>
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
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-bold">Category Name</label>
                            <input type="text"
                                   id="nama_kategori"
                                   name="nama_kategori"
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   value="{{ old('nama_kategori') }}"
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
                                      placeholder="Enter category description (optional)">{{ old('deskripsi') }}</textarea>
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
                                   value="{{ old('icon') }}"
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
                                   value="{{ old('color', '#007bff') }}"
                                   style="height: 38px;">
                            @error('color')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Category
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
                        <i class="fas fa-info-circle me-2"></i>Category Information
                    </h6>
                    <div class="small text-muted">
                        <p class="mb-2">Categories help organize menu items for better navigation and user experience.</p>
                        <ul class="mb-0">
                            <li>Use clear, descriptive names</li>
                            <li>Icons help users identify categories quickly</li>
                            <li>Colors can help differentiate categories</li>
                        </ul>
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
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white mb-2" style="width: 60px; height: 60px;">
                            <i class="fas fa-tag fa-lg"></i>
                        </div>
                        <div class="fw-bold" id="preview-name">Category Name</div>
                        <div class="small text-muted" id="preview-desc">Category description</div>
                    </div>
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
    const previewIcon = document.querySelector('#preview-name').previousElementSibling.querySelector('i');

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
        const previewCircle = document.querySelector('.d-inline-flex.rounded-circle');
        previewCircle.style.backgroundColor = this.value;
    });
});
</script>
@endsection