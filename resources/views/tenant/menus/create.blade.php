@extends('layouts.app')

@section('title', 'Tambah Menu - e-Kantin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Tambah Menu Baru - {{ $tenant->nama_tenant }}
                    </h4>
                    <button onclick="history.back()" class="btn btn-sm me-2" style="background: var(--light-gray); border: none; color: var(--text-primary); padding: 0.5rem 1rem; border-radius: 8px;">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('tenant.menus.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_menu" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" 
                                           id="nama_menu" name="nama_menu" 
                                           value="{{ old('nama_menu') }}" 
                                           placeholder="Contoh: Nasi Goreng Special" required>
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
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                      id="deskripsi" name="deskripsi" rows="3" 
                                      placeholder="Deskripsi singkat tentang menu...">{{ old('deskripsi') }}</textarea>
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
                                               id="harga" name="harga" value="{{ old('harga') }}" 
                                               min="0" step="500" placeholder="15000" required>
                                    </div>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" name="stok" value="{{ old('stok', 0) }}" 
                                           min="0" placeholder="0" required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Menu</label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">
                                Format: JPG, PNG, GIF (Maksimal 2MB). Ukuran disarankan: 500x500px.
                            </div>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PO Configuration -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-file-invoice-dollar me-2"></i>Konfigurasi Pre-Order (PO)
                                    <small class="text-muted ms-2">Untuk makanan berat yang perlu persiapan khusus</small>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_po_based" name="is_po_based" value="1"
                                        {{ old('is_po_based') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_po_based">
                                        <strong>Aktifkan Pre-Order (PO)</strong>
                                    </label>
                                    <div class="form-text">
                                        Menu memerlukan pre-order dengan minimum quantity dan lead time.
                                    </div>
                                </div>

                                <div id="po_settings" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="po_minimum_quantity" class="form-label">Minimum Quantity</label>
                                                <input type="number" class="form-control @error('po_minimum_quantity') is-invalid @enderror"
                                                       id="po_minimum_quantity" name="po_minimum_quantity"
                                                       value="{{ old('po_minimum_quantity', 10) }}"
                                                       min="1" placeholder="10">
                                                <div class="form-text">
                                                    Minimum pemesanan untuk bisa memproses menu.
                                                </div>
                                                @error('po_minimum_quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="po_lead_time_days" class="form-label">Lead Time (hari)</label>
                                                <input type="number" class="form-control @error('po_lead_time_days') is-invalid @enderror"
                                                       id="po_lead_time_days" name="po_lead_time_days"
                                                       value="{{ old('po_lead_time_days', 3) }}"
                                                       min="1" max="30" placeholder="3">
                                                <div class="form-text">
                                                    Waktu yang dibutuhkan untuk persiapan menu.
                                                </div>
                                                @error('po_lead_time_days')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi PO</h6>
                                        <ul class="mb-0 small">
                                            <li>Customer harus memesan minimum quantity untuk bisa checkout</li>
                                            <li>Lead time akan memberitahukan customer kapan menu tersedia</li>
                                            <li>PO cocok untuk makanan berat yang perlu persiapan khusus</li>
                                            <li>Contoh: Nasi Kotak, Katering, Makanan spesial</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1"
                                {{ old('is_available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                <strong>Tersedia untuk dipesan</strong>
                            </label>
                            <div class="form-text">
                                Jika tidak dicentang, menu tidak akan muncul untuk customer.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tenant.menus.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isPoBased = document.getElementById('is_po_based');
    const poSettings = document.getElementById('po_settings');
    const isAvailable = document.getElementById('is_available');

    function togglePoSettings() {
        if (isPoBased.checked) {
            poSettings.style.display = 'block';
            // Make required fields
            document.getElementById('po_minimum_quantity').required = true;
            document.getElementById('po_lead_time_days').required = true;
        } else {
            poSettings.style.display = 'none';
            // Remove required fields
            document.getElementById('po_minimum_quantity').required = false;
            document.getElementById('po_lead_time_days').required = false;
        }
    }

    function toggleAvailability() {
        if (isPoBased.checked) {
            // If PO-based, automatically check availability
            isAvailable.checked = true;
            isAvailable.disabled = true;
        } else {
            isAvailable.disabled = false;
        }
    }

    isPoBased.addEventListener('change', function() {
        togglePoSettings();
        toggleAvailability();
    });

    // Initialize on page load
    togglePoSettings();
    toggleAvailability();
});
</script>
@endsection