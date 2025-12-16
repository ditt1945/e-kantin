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
                    <h1 class="hero-title">Kelola Tenant</h1>
                    <p class="hero-subtitle">{{ $greeting }}, Admin. Pantau seluruh kantin yang terdaftar di platform.</p>
                </div>
            </div>
            <div class="time-badge">
                <i class="fas fa-store"></i>
                {{ $tenants->count() }} Total
            </div>
        </div>
    </div>

    {{-- ===== STATISTICS ===== --}}
    <div class="admin-stats">
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $tenants->where('is_active', 1)->count() }}</div>
            <div class="admin-stat-label">Aktif</div>
            <div class="admin-stat-change">Tenants yang aktif</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $tenants->where('is_active', 0)->count() }}</div>
            <div class="admin-stat-label">Nonaktif</div>
            <div class="admin-stat-change negative">Tenants yang nonaktif</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $tenants->sum('menus_count') }}</div>
            <div class="admin-stat-label">Total Menu</div>
            <div class="admin-stat-change">Semua tenant</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $tenants->sum('orders_count') }}</div>
            <div class="admin-stat-label">Total Pesanan</div>
            <div class="admin-stat-change">Semua tenant</div>
        </div>
    </div>

    {{-- ===== FILTERS ===== --}}
    <div class="admin-filter">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            Filter Tenant
        </div>
        <form method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-md);">
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Cari Tenant</label>
                    <input type="text" name="search" class="form-control" placeholder="Masukkan nama tenant..." value="{{ request('search') }}">
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
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i>
                    Reset
                </a>
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Cetak
                </button>
                <a href="{{ route('tenants.export') }}" class="btn btn-warning">
                    <i class="fas fa-download"></i>
                    Export
                </a>
                <a href="{{ route('tenants.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    Tambah Tenant
                </a>
            </div>
        </form>
    </div>

    {{-- ===== TENANTS TABLE ===== --}}
    <div class="admin-table-container">
        <div class="admin-table-header">
            <div class="admin-table-title">
                <i class="fas fa-store"></i>
                Data Tenant
            </div>
            <div class="admin-table-search">
                <input type="text" placeholder="Cari nama, pemilik..." id="tenantSearch">
                <i class="fas fa-search"></i>
            </div>
        </div>

        @if($tenants->count() > 0)
            <table class="admin-table" id="tenantsTable">
                <thead>
                    <tr>
                        <th>Nama Tenant</th>
                        <th>Pemilik</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Menu</th>
                        <th>Pesanan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $tenant)
                        <tr class="tenant-row" data-name="{{ $tenant->nama_tenant }}" data-owner="{{ $tenant->pemilik ?? '' }}">
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                    <div class="avatar" style="background: var(--success);">
                                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $tenant->nama_tenant }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $tenant->pemilik ?? '-' }}</td>
                            <td>{{ $tenant->no_telepon ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $tenant->is_active ? 'success' : 'neutral' }}">
                                    {{ $tenant->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                    <span class="badge badge-primary">{{ $tenant->menus_count }}</span>
                                    <span style="color: var(--text-secondary); font-size: 0.75rem;">menu</span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                    <span class="badge badge-neutral">{{ $tenant->orders_count }}</span>
                                    <span style="color: var(--text-secondary); font-size: 0.75rem;">pesanan</span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; gap: var(--space-xs); justify-content: flex-end;">
                                    <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus tenant {{ $tenant->nama_tenant }}?')">
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

            @if($tenants->hasPages())
                <div style="padding: var(--space-lg); display: flex; justify-content: center;">
                    {{ $tenants->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🏪</div>
                <div class="empty-state-title">Belum Ada Tenant</div>
                <div class="empty-state-text">Tambah tenant pertama untuk memulai</div>
                <a href="{{ route('tenants.create') }}" class="btn btn-primary">Tambah Tenant</a>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time search functionality
    const searchInput = document.getElementById('tenantSearch');
    const tableRows = document.querySelectorAll('#tenantsTable tbody .tenant-row');

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