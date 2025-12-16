<!-- @extends('layouts.app')

@include('partials.admin-minimalis-styles')

@section('content')
<div class="admin-container">
    @php
        $hour = now()->format('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }
    @endphp

    {{-- ===== PAGE HEADER ===== --}}
    <div class="admin-hero">
        <div class="content">
            <div style="display: flex; align-items: center; gap: var(--space-md);">
                <img src="{{ asset('favicon-192.png') }}" alt="SMKN 2 Surabaya" style="width: 48px; height: 48px; border-radius: var(--radius-md);">
                <div>
                    <h1 class="hero-title">Kelola Kategori</h1>
                    <p class="hero-subtitle">{{ $greeting }}, Admin. Kelola kategori untuk mengelompokkan menu.</p>
                </div>
            </div>
            <div class="time-badge">
                <i class="fas fa-tags"></i>
                {{ $categories->count() }} Total
            </div>
        </div>
    </div>

    {{-- ===== STATISTICS ===== --}}
    <div class="admin-stats">
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $categories->where('is_active', 1)->count() }}</div>
            <div class="admin-stat-label">Aktif</div>
            <div class="admin-stat-change">Kategori yang aktif</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $categories->where('is_active', 0)->count() }}</div>
            <div class="admin-stat-label">Nonaktif</div>
            <div class="admin-stat-change negative">Kategori yang nonaktif</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $categories->sum('menus_count') }}</div>
            <div class="admin-stat-label">Total Menu</div>
            <div class="admin-stat-change">Semua kategori</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $categories->avg('menus_count') ? number_format($categories->avg('menus_count'), 1) : 0 }}</div>
            <div class="admin-stat-label">Rata-rata Menu</div>
            <div class="admin-stat-change">Per kategori</div>
        </div>
    </div>

    {{-- ===== FILTERS ===== --}}
    <div class="admin-filter">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            Filter Kategori
        </div>
        <form method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-md);">
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Cari Kategori</label>
                    <input type="text" name="search" class="form-control" placeholder="Masukkan nama kategori..." value="{{ request('search') }}">
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="admin-action-bar" style="margin-top: var(--space-md);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i>
                    Reset
                </a>
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Cetak
                </button>
                <a href="{{ route('categories.export') }}" class="btn btn-warning">
                    <i class="fas fa-download"></i>
                    Export
                </a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="fas fa-plus"></i>
                    Tambah Kategori
                </button>
            </div>
        </form>
    </div>

    {{-- ===== CATEGORIES TABLE ===== --}}
    <div class="admin-table-container">
        <div class="admin-table-header">
            <div class="admin-table-title">
                <i class="fas fa-tags"></i>
                Data Kategori
            </div>
            <div class="admin-table-search">
                <input type="text" placeholder="Cari nama kategori..." id="categorySearch">
                <i class="fas fa-search"></i>
            </div>
        </div>

        @if($categories->count() > 0)
            <table class="admin-table" id="categoriesTable">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Menu</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="category-row" data-name="{{ $category->nama_kategori }}">
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                    <div class="avatar" style="background: var(--info);">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $category->nama_kategori }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($category->deskripsi)
                                    <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                        {{ Str::limit($category->deskripsi, 80) }}
                                    </span>
                                @else
                                    <span style="color: var(--text-muted); font-style: italic;">Tidak ada deskripsi</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                    <span class="badge badge-primary">{{ $category->menus_count }}</span>
                                    <span style="color: var(--text-secondary); font-size: 0.75rem;">menu</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $category->is_active ? 'success' : 'neutral' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: var(--space-xs); justify-content: flex-end;">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="editCategory({{ $category->id }}, '{{ $category->nama_kategori }}', '{{ $category->deskripsi ?? '' }}', {{ $category->is_active }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori {{ $category->nama_kategori }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($categories->hasPages())
                <div style="padding: var(--space-lg); display: flex; justify-content: center;">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-title">Belum Ada Kategori</div>
                <div class="empty-state-text">Tambah kategori pertama untuk memulai</div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">Tambah Kategori</button>
            </div>
        @endif
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="createIsActive" checked>
                            <label class="form-check-label" for="createIsActive">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Ubah Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" id="editNama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" id="editDeskripsi"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive">
                            <label class="form-check-label" for="editIsActive">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time search functionality
    const searchInput = document.getElementById('categorySearch');
    const tableRows = document.querySelectorAll('#categoriesTable tbody .category-row');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

// Edit category function
function editCategory(id, nama, deskripsi, isActive) {
    document.getElementById('editId').value = id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editDeskripsi').value = deskripsi;
    document.getElementById('editIsActive').checked = isActive === 1;
    document.getElementById('editForm').action = `/categories/${id}`;

    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
}
</script>
@endsection -->