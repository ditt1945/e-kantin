@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="mb-5 d-flex justify-content-between align-items-center">
        <div>
            <h2 style="font-weight: 800; font-size: 2rem; margin-bottom: 0.3rem;">
                <i class="fas fa-chart-line me-2" style="color: var(--primary);"></i>Dashboard Detail
            </h2>
            <p style="color: var(--text-secondary); font-size: 0.95rem;">{{ $tenant->nama_tenant ?? 'Tenant' }} - Analisis lengkap performa menu dan penjualan</p>
        </div>
        <a href="{{ route('tenant.dashboard') }}" class="btn btn-sm" style="background: var(--light-gray); border: none; color: var(--text-primary); padding: 0.5rem 1rem; border-radius: 8px;">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    {{-- Stat Cards Grid --}}
    <div class="row g-3 mb-4">
        {{-- Total Menu --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Total Menu</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $stats['total_menus'] ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-list" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Menu --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%); color: #362c28; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Menu Tersedia</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $stats['active_menus'] ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-check-circle" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Out of Stock --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, var(--warning) 0%, var(--primary) 100%); color: #362c28; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Habis Stok</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $stats['out_of_stock'] ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-exclamation-circle" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-md-3 col-sm-6">
            <div class="card" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); color: white; overflow: hidden;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <small style="opacity: 0.9; font-size: 0.85rem;">Total Pesanan</small>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800;">{{ $stats['total_orders'] ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-shopping-cart" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Income Cards --}}
    <div class="row g-3">
        {{-- Today's Income --}}
        <div class="col-md-6">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 style="font-weight: 700; color: var(--text-primary); margin: 0;">
                            <i class="fas fa-sun me-2" style="color: var(--warning);"></i>Pendapatan Hari Ini
                        </h5>
                        <span style="background: rgba(245, 158, 11, 0.1); color: var(--warning); padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">TODAY</span>
                    </div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--warning); margin-bottom: 0.5rem;">
                        Rp {{ number_format($stats['today_income'] ?? 0, 0, ',', '.') }}
                    </div>
                    <small style="color: var(--text-secondary);">Akumulasi pendapatan dari jam 00:00 hingga sekarang</small>
                </div>
            </div>
        </div>

        {{-- Monthly Income --}}
        <div class="col-md-6">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 style="font-weight: 700; color: var(--text-primary); margin: 0;">
                            <i class="fas fa-calendar me-2" style="color: var(--primary);"></i>Pendapatan Bulan Ini
                        </h5>
                        <span style="background: rgba(var(--primary-rgb), 0.1); color: var(--primary); padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">MONTH</span>
                    </div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">
                        Rp {{ number_format($stats['monthly_income'] ?? 0, 0, ',', '.') }}
                    </div>
                    <small style="color: var(--text-secondary);">Akumulasi pendapatan bulan {{ \Carbon\Carbon::now()->format('F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row g-3 mt-4">
        <div class="col-12">
            <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                <i class="fas fa-zap me-2" style="color: var(--warning);"></i>Akses Cepat
            </h5>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('tenant.menus.index') }}" class="btn" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none; border-radius: 8px; padding: 1rem; text-align: center; text-decoration: none; transition: all 0.3s ease; font-weight: 600;">
                    <i class="fas fa-utensils" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                    Kelola Menu
                </a>
                <a href="{{ route('tenant.orders') }}" class="btn" style="background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%); color: #362c28; border: none; border-radius: 8px; padding: 1rem; text-align: center; text-decoration: none; transition: all 0.3s ease; font-weight: 600;">
                    <i class="fas fa-shopping-cart" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                    Lihat Pesanan
                </a>
                <a href="{{ route('tenant.stocks.index') }}" class="btn" style="background: linear-gradient(135deg, var(--warning) 0%, var(--primary) 100%); color: #362c28; border: none; border-radius: 8px; padding: 1rem; text-align: center; text-decoration: none; transition: all 0.3s ease; font-weight: 600;">
                    <i class="fas fa-boxes" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                    Stok Menu
                </a>
                <a href="{{ route('tenant.reports') }}" class="btn" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff5b2; border: none; border-radius: 8px; padding: 1rem; text-align: center; text-decoration: none; transition: all 0.3s ease; font-weight: 600;">
                    <i class="fas fa-chart-bar" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem;"></i>
                    Laporan
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
