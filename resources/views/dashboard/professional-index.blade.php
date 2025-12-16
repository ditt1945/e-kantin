@extends('layouts.app')

@push('styles')
@include('partials.admin-professional-styles')
@endpush

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <div class="admin-header-left">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                <img src="{{ asset('favicon-192.png') }}" alt="SMKN 2 Surabaya" style="width: 48px; height: 48px; border-radius: var(--radius-lg);">
                <h1 class="admin-title">
                    <i class="fas fa-shield-alt"></i>
                    Dashboard Admin
                </h1>
            </div>
            <p class="admin-subtitle">
                <i class="far fa-calendar-alt"></i>
                {{ now()->translatedFormat('l, d F Y') }} • Kelola Kantin SMKN 2 Surabaya
            </p>
        </div>
        <div class="admin-header-right">
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Kantin
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline">
                <i class="fas fa-tags"></i>
                Kategori
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="admin-stats-overview">
        <!-- Total Kantin -->
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalTenants }}</div>
                <div class="stat-label">Total Kantin</div>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Aktif</span>
                </div>
            </div>
        </div>

        <!-- Total Menu -->
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalMenus }}</div>
                <div class="stat-label">Total Menu</div>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Tersedia</span>
                </div>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Terdaftar</span>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalOrders ?? 0 }}</div>
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Transaksi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Dashboard -->
    <div class="admin-management">
        <h2 class="section-manajemen">Manajemen Sistem</h2>

        <div class="management-grid">
            <!-- Kelola Kantin -->
            <a href="{{ route('tenants.index') }}" class="management-card">
                <div class="card-icon primary">
                    <i class="fas fa-store"></i>
                </div>
                <div class="card-content">
                    <h3>Kelola Kantin</h3>
                    <p>Tambah, edit, dan kelola data kantin</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Kelola Pengguna -->
            <a href="{{ route('users.index') }}" class="management-card">
                <div class="card-icon success">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="card-content">
                    <h3>Kelola Pengguna</h3>
                    <p>Atur role dan akses pengguna sistem</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Kategori Menu -->
            <a href="{{ route('categories.index') }}" class="management-card">
                <div class="card-icon warning">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="card-content">
                    <h3>Kategori Menu</h3>
                    <p>Atur kategori makanan & minuman</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Semua Menu -->
            <a href="{{ route('menus.index') }}" class="management-card">
                <div class="card-icon info">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="card-content">
                    <h3>Semua Menu</h3>
                    <p>Monitor semua menu dari kantin</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Semua Pesanan -->
            <a href="{{ route('orders.index') }}" class="management-card">
                <div class="card-icon danger">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-content">
                    <h3>Semua Pesanan</h3>
                    <p>Monitor dan kelola semua transaksi</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Laporan -->
            <a href="#" class="management-card">
                <div class="card-icon secondary">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="card-content">
                    <h3>Laporan</h3>
                    <p>Lihat laporan penjualan & analitik</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="admin-recent-orders">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-clock"></i>
                Pesanan Terbaru
            </h2>
            <div class="view-all">
                <a href="{{ route('orders.index') }}">Lihat Semua</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>

        @if($pesananTerbaru->count() > 0)
            <div class="orders-table">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Kantin</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesananTerbaru as $pesanan)
                            <tr>
                                <td class="order-id">#{{ $pesanan->id }}</td>
                                <td class="tenant-name">{{ $pesanan->tenant->nama_tenant ?? 'N/A' }}</td>
                                <td class="order-total">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge {{ $pesanan->status }}">
                                        {{ ucfirst($pesanan->status) }}
                                    </span>
                                </td>
                                <td class="order-time">{{ $pesanan->created_at->format('d M H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4>Belum ada pesanan</h4>
                <p>Pesanan akan muncul di sini ketika ada transaksi</p>
            </div>
        @endif
    </div>
</div>
@endsection