@extends('layouts.app')

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
                    <h1 class="hero-title">Kelola Menu</h1>
                    <p class="hero-subtitle">{{ $greeting }}, Admin. Pantau seluruh menu yang tersedia di platform.</p>
                </div>
            </div>
            <div class="time-badge">
                <i class="fas fa-utensils"></i>
                {{ $menus->count() }} Total
            </div>
        </div>
    </div>

    {{-- ===== STATISTICS ===== --}}
    <div class="admin-stats">
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $menus->where('is_available', 1)->count() }}</div>
            <div class="admin-stat-label">Tersedia</div>
            <div class="admin-stat-change">Menu yang aktif</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $menus->where('is_available', 0)->count() }}</div>
            <div class="admin-stat-label">Tidak Tersedia</div>
            <div class="admin-stat-change negative">Menu yang nonaktif</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $menus->avg('harga') ? number_format($menus->avg('harga'), 0, ',', '.') : 0 }}</div>
            <div class="admin-stat-label">Rata-rata Harga</div>
            <div class="admin-stat-change">Dalam rupiah</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $tenants->count() }}</div>
            <div class="admin-stat-label">Tenant</div>
            <div class="admin-stat-change">Total penyedia menu</div>
        </div>
    </div>

    {{-- ===== FILTERS ===== --}}
    <div class="admin-filter">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            Filter Menu
        </div>
        <form method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-md);">
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Nama Menu</label>
                    <input type="text" name="search" class="form-control" placeholder="Masukkan nama menu..." value="{{ request('search') }}">
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Tenant</label>
                    <select name="tenant_id" class="form-control">
                        <option value="">Semua Tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>{{ $tenant->nama_tenant }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Kategori</label>
                    <select name="category_id" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
            </div>
            <div class="admin-action-bar" style="margin-top: var(--space-md);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i>
                    Reset
                </a>
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Cetak
                </button>
                <a href="{{ route('menus.export') }}" class="btn btn-warning">
                    <i class="fas fa-download"></i>
                    Export
                </a>
                <a href="{{ route('menus.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    Tambah Menu
                </a>
            </div>
        </form>
    </div>

    {{-- ===== MENUS TABLE ===== --}}
    <div class="admin-table-container">
        <div class="admin-table-header">
            <div class="admin-table-title">
                <i class="fas fa-utensils"></i>
                Data Menu
            </div>
            <div class="admin-table-search">
                <input type="text" placeholder="Cari nama, tenant..." id="menuSearch">
                <i class="fas fa-search"></i>
            </div>
        </div>

        @if($menus->count() > 0)
            <table class="admin-table" id="menusTable">
                <thead>
                    <tr>
                        <th>Nama Menu</th>
                        <th>Tenant</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                        <tr class="menu-row" data-name="{{ $menu->nama_menu }}" data-tenant="{{ $menu->tenant->nama_tenant ?? '' }}" data-category="{{ $menu->category->nama_kategori ?? '' }}">
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                    <div class="avatar" style="background: var(--warning);">
                                        {{ strtoupper(substr($menu->nama_menu, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $menu->nama_menu }}</strong>
                                        @if($menu->deskripsi)
                                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px;">
                                                {{ Str::limit($menu->deskripsi, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $menu->tenant->nama_tenant ?? '-' }}</td>
                            <td>{{ $menu->category->nama_kategori ?? '-' }}</td>
                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $menu->is_available ? 'success' : 'neutral' }}">
                                    {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: var(--space-xs); justify-content: flex-end;">
                                    <a href="{{ route('menus.edit', $menu) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus menu {{ $menu->nama_menu }}?')">
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

            @if($menus->hasPages())
                <div style="padding: var(--space-lg); display: flex; justify-content: center;">
                    {{ $menus->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🍽️</div>
                <div class="empty-state-title">Belum Ada Menu</div>
                <div class="empty-state-text">Tambah menu pertama untuk memulai</div>
                <a href="{{ route('menus.create') }}" class="btn btn-primary">Tambah Menu</a>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time search functionality
    const searchInput = document.getElementById('menuSearch');
    const tableRows = document.querySelectorAll('#menusTable tbody .menu-row');

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
</script>
@endsection