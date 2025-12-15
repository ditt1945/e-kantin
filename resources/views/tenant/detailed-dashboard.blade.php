@extends('layouts.app')

@section('content')
<style>
    :root {
        --warning-rgb: 245, 158, 11;
        --info-rgb: 59, 130, 246;
    }

    .tenant-detailed-dashboard {
        color: var(--text-primary);
    }

    .dd-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
        color: var(--text-primary);
    }

    .dd-subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }

    .dd-back-btn {
        background: var(--light-gray);
        color: var(--text-primary);
        border: 1px solid var(--border-gray);
        padding: 0.55rem 1.1rem;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.25s ease;
    }

    .dd-back-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .dd-stat-card {
        border-radius: 14px;
        padding: 1.25rem;
        border: 1px solid var(--border-gray);
        background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.08), rgba(var(--primary-rgb), 0.02));
        box-shadow: var(--shadow-md);
        color: var(--text-primary);
        transition: all 0.25s ease;
        height: 100%;
    }

    .dd-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .dd-stat-card .dd-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .dd-label {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        color: var(--text-secondary);
        text-transform: uppercase;
    }

    .dd-value {
        font-size: 2rem;
        font-weight: 800;
        margin-top: 0.35rem;
        line-height: 1;
        color: var(--text-primary);
    }

    .dd-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--primary);
    }

    .soft-primary { background: rgba(var(--primary-rgb), 0.18); color: #fff; box-shadow: 0 10px 25px rgba(var(--primary-rgb), 0.25); }
    .soft-success { background: rgba(var(--success-rgb), 0.2); color: #fff; box-shadow: 0 10px 25px rgba(var(--success-rgb), 0.25); }
    .soft-warning { background: rgba(var(--warning-rgb), 0.2); color: #fff; box-shadow: 0 10px 25px rgba(var(--warning-rgb), 0.25); }
    .soft-info { background: rgba(var(--info-rgb), 0.2); color: #fff; box-shadow: 0 10px 25px rgba(var(--info-rgb), 0.25); }

    .accent-primary { background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.18), rgba(var(--primary-rgb), 0.08)); border-color: rgba(var(--primary-rgb), 0.22); }
    .accent-success { background: linear-gradient(135deg, rgba(var(--success-rgb), 0.18), rgba(var(--success-rgb), 0.08)); border-color: rgba(var(--success-rgb), 0.22); }
    .accent-warning { background: linear-gradient(135deg, rgba(var(--warning-rgb), 0.18), rgba(var(--warning-rgb), 0.08)); border-color: rgba(var(--warning-rgb), 0.22); }
    .accent-info { background: linear-gradient(135deg, rgba(var(--info-rgb), 0.18), rgba(var(--info-rgb), 0.08)); border-color: rgba(var(--info-rgb), 0.22); }

    .dd-panel {
        border-radius: 14px;
        border: 1px solid var(--border-gray);
        background: var(--card-bg);
        box-shadow: var(--shadow-md);
        padding: 1.5rem;
        height: 100%;
    }

    .dd-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        gap: 0.75rem;
    }

    .dd-panel-title {
        margin: 0;
        font-weight: 800;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-primary);
    }

    .dd-chip {
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.01em;
        border: 1px solid transparent;
    }

    .chip-warning { background: rgba(var(--warning-rgb), 0.16); color: var(--warning); border-color: rgba(var(--warning-rgb), 0.3); }
    .chip-primary { background: rgba(var(--primary-rgb), 0.16); color: var(--primary); border-color: rgba(var(--primary-rgb), 0.3); }

    .dd-figure {
        font-size: 2.1rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
    }

    .dd-helper {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .dd-section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .dd-quick-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .dd-quick-card {
        border-radius: 12px;
        border: 1px solid var(--border-gray);
        color: var(--text-primary);
        padding: 1rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        box-shadow: var(--shadow-md);
        transition: all 0.25s ease;
    }

    .dd-quick-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .dd-quick-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
    }

    .dd-quick-label {
        margin: 0;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .dd-header h2 { font-size: 1.5rem; }
        .dd-value { font-size: 1.6rem; }
        .dd-figure { font-size: 1.7rem; }
    }

    [data-theme="dark"] .dd-back-btn {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.12);
    }

    [data-theme="dark"] .dd-stat-card,
    [data-theme="dark"] .dd-panel,
    [data-theme="dark"] .dd-quick-card {
        border-color: rgba(255, 255, 255, 0.08);
        box-shadow: var(--shadow-md);
    }

    [data-theme="dark"] .dd-stat-card {
        background: linear-gradient(145deg, rgba(15, 23, 42, 0.92), rgba(30, 41, 59, 0.95));
    }

    [data-theme="dark"] .accent-primary { background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.32), rgba(var(--primary-rgb), 0.12)); }
    [data-theme="dark"] .accent-success { background: linear-gradient(135deg, rgba(var(--success-rgb), 0.32), rgba(var(--success-rgb), 0.12)); }
    [data-theme="dark"] .accent-warning { background: linear-gradient(135deg, rgba(var(--warning-rgb), 0.32), rgba(var(--warning-rgb), 0.12)); }
    [data-theme="dark"] .accent-info { background: linear-gradient(135deg, rgba(var(--info-rgb), 0.32), rgba(var(--info-rgb), 0.12)); }

    [data-theme="dark"] .dd-panel,
    [data-theme="dark"] .dd-quick-card {
        background: linear-gradient(145deg, rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.96));
    }

    [data-theme="dark"] .dd-chip { border-color: rgba(255, 255, 255, 0.18); }
    [data-theme="dark"] .chip-warning { color: #FBBF24; }
    [data-theme="dark"] .chip-primary { color: #60A5FA; }
    [data-theme="dark"] .dd-helper { color: var(--text-secondary); }
    [data-theme="dark"] .dd-label { color: var(--text-secondary); }
    [data-theme="dark"] .dd-quick-card { color: var(--text-primary); }
    [data-theme="dark"] .dd-quick-card .dd-quick-label { color: var(--text-primary); }
    [data-theme="dark"] .soft-primary { background: rgba(var(--primary-rgb), 0.35); }
    [data-theme="dark"] .soft-success { background: rgba(var(--success-rgb), 0.35); }
    [data-theme="dark"] .soft-warning { background: rgba(var(--warning-rgb), 0.35); }
    [data-theme="dark"] .soft-info { background: rgba(var(--info-rgb), 0.35); }
    [data-theme="dark"] .dd-quick-card:hover { box-shadow: var(--shadow-lg); }
</style>

<div class="container py-5 tenant-detailed-dashboard">
    <div class="mb-5 d-flex justify-content-between align-items-start flex-wrap gap-3 dd-header">
        <div>
            <h2><i class="fas fa-chart-line me-2" style="color: var(--primary);"></i>Dashboard Detail</h2>
            <p class="dd-subtitle">{{ $tenant->nama_tenant ?? 'Tenant' }} - Analisis lengkap performa menu dan penjualan</p>
        </div>
        <a href="{{ route('tenant.dashboard') }}" class="btn dd-back-btn">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="dd-stat-card accent-primary">
                <div class="dd-top">
                    <div>
                        <div class="dd-label">Total Menu</div>
                        <div class="dd-value">{{ $stats['total_menus'] ?? 0 }}</div>
                    </div>
                    <span class="dd-icon soft-primary"><i class="fas fa-list"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="dd-stat-card accent-success">
                <div class="dd-top">
                    <div>
                        <div class="dd-label">Menu Tersedia</div>
                        <div class="dd-value">{{ $stats['active_menus'] ?? 0 }}</div>
                    </div>
                    <span class="dd-icon soft-success"><i class="fas fa-check-circle"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="dd-stat-card accent-warning">
                <div class="dd-top">
                    <div>
                        <div class="dd-label">Habis Stok</div>
                        <div class="dd-value">{{ $stats['out_of_stock'] ?? 0 }}</div>
                    </div>
                    <span class="dd-icon soft-warning"><i class="fas fa-exclamation-circle"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="dd-stat-card accent-info">
                <div class="dd-top">
                    <div>
                        <div class="dd-label">Total Pesanan</div>
                        <div class="dd-value">{{ $stats['total_orders'] ?? 0 }}</div>
                    </div>
                    <span class="dd-icon soft-info"><i class="fas fa-shopping-cart"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="dd-panel">
                <div class="dd-panel-header">
                    <div class="dd-panel-title">
                        <i class="fas fa-sun" style="color: var(--warning);"></i>
                        Pendapatan Hari Ini
                    </div>
                    <span class="dd-chip chip-warning">TODAY</span>
                </div>
                <div class="dd-figure" style="color: var(--warning);">Rp {{ number_format($stats['today_income'] ?? 0, 0, ',', '.') }}</div>
                <p class="dd-helper">Akumulasi pendapatan dari jam 00:00 hingga sekarang</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="dd-panel">
                <div class="dd-panel-header">
                    <div class="dd-panel-title">
                        <i class="fas fa-calendar" style="color: var(--primary);"></i>
                        Pendapatan Bulan Ini
                    </div>
                    <span class="dd-chip chip-primary">MONTH</span>
                </div>
                <div class="dd-figure" style="color: var(--primary);">Rp {{ number_format($stats['monthly_income'] ?? 0, 0, ',', '.') }}</div>
                <p class="dd-helper">Akumulasi pendapatan bulan {{ \Carbon\Carbon::now()->format('F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-4">
        <div class="col-12">
            <div class="dd-section-title"><i class="fas fa-zap" style="color: var(--warning);"></i>Akses Cepat</div>
            <div class="dd-quick-grid">
                <a href="{{ route('tenant.menus.index') }}" class="dd-quick-card accent-primary">
                    <span class="dd-quick-icon soft-primary"><i class="fas fa-utensils"></i></span>
                    <span class="dd-quick-label">Kelola Menu</span>
                </a>
                <a href="{{ route('tenant.orders') }}" class="dd-quick-card accent-success">
                    <span class="dd-quick-icon soft-success"><i class="fas fa-shopping-cart"></i></span>
                    <span class="dd-quick-label">Lihat Pesanan</span>
                </a>
                <a href="{{ route('tenant.stocks.index') }}" class="dd-quick-card accent-warning">
                    <span class="dd-quick-icon soft-warning"><i class="fas fa-boxes"></i></span>
                    <span class="dd-quick-label">Stok Menu</span>
                </a>
                <a href="{{ route('tenant.reports') }}" class="dd-quick-card accent-info">
                    <span class="dd-quick-icon soft-info"><i class="fas fa-chart-bar"></i></span>
                    <span class="dd-quick-label">Laporan</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
