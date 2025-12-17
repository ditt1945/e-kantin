@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #2563EB;
        --success: #22C55E;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #06B6D4;
        --card-bg: #fff;
        --border-gray: #E5E7EB;
        --text-primary: #1F2937;
        --text-secondary: #6B7280;
    }
    [data-theme="dark"] {
        --card-bg: #1F2937;
        --border-gray: #374151;
        --text-primary: #F3F4F6;
        --text-secondary: #D1D5DB;
    }
    
    .tenant-dashboard { padding: 1.5rem 0 2rem; }
    
    /* ===== WELCOME HERO ===== */
    .welcome-hero {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
        border-radius: 20px;
        padding: 2rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .welcome-hero::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: conic-gradient(from 180deg, #22C55E, #10B981, #22C55E);
        border-radius: 50%;
        opacity: 0.1;
    }
    .welcome-hero::after {
        content: '';
        position: absolute;
        bottom: 15px;
        right: 25px;
        font-size: 4rem;
        opacity: 0.05;
    }
    .welcome-hero .content { position: relative; z-index: 1; }
    .welcome-hero .store-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #22C55E, #16A34A);
        padding: 0.45rem 0.9rem;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    .welcome-hero h1 {
        font-size: 1.65rem;
        font-weight: 800;
        margin-bottom: 0.4rem;
        line-height: 1.2;
    }
    .welcome-hero .subtitle { color: #94A3B8; font-size: 0.9rem; margin-bottom: 1rem; }
    .welcome-hero .time-info {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 0.5rem 0.9rem;
        border-radius: 10px;
        font-size: 0.8rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .welcome-hero .time-info i { color: #FBBF24; }
    
    /* ===== STAT CARDS ===== */
    .stat-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-gray);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .stat-card .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
        margin-bottom: 1rem;
    }
    .stat-card .card-label { font-size: 0.8rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; margin-bottom: 0.35rem; }
    .stat-card .card-value { font-size: 2rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 0.5rem; }
    .stat-card .card-trend {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
    }
    .stat-card .card-trend.up { background: #DCFCE7; color: #16A34A; }
    .stat-card .card-trend.hot { background: #FEF3C7; color: #D97706; }
    [data-theme="dark"] .stat-card .card-trend.up { background: rgba(22, 163, 74, 0.2); color: #4ADE80; }
    [data-theme="dark"] .stat-card .card-trend.hot { background: rgba(245, 158, 11, 0.2); color: #FBBF24; }
    
    /* ===== QUICK ACTIONS ===== */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 0.5rem;
        background: var(--card-bg);
        border: 2px solid var(--border-gray);
        border-radius: 14px;
        text-decoration: none;
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.8rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
    }
    .quick-btn:hover { transform: translateY(-4px); border-color: transparent; color: #fff; }
    .quick-btn .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #fff;
    }
    .quick-btn.green:hover { background: linear-gradient(135deg, #22C55E, #16A34A); }
    .quick-btn.blue:hover { background: linear-gradient(135deg, #3B82F6, #2563EB); }
    .quick-btn.orange:hover { background: linear-gradient(135deg, #F59E0B, #D97706); }
    .quick-btn.purple:hover { background: linear-gradient(135deg, #8B5CF6, #7C3AED); }
    .quick-btn.cyan:hover { background: linear-gradient(135deg, #06B6D4, #0891B2); }
    .quick-btn.pink:hover { background: linear-gradient(135deg, #EC4899, #DB2777); }
    .quick-btn .badge-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #EF4444;
        color: #fff;
        font-size: 0.6rem;
        padding: 0.2rem 0.4rem;
        border-radius: 6px;
        font-weight: 700;
    }
    
    /* ===== MAIN GRID ===== */
    .main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 992px) { .main-grid { grid-template-columns: 1fr; } }
    
    .card-box {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border-gray);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .card-box:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.06); }
    
    .card-header {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-gray);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: var(--text-primary);
    }
    .card-header .header-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }
    .card-header .header-link {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .card-body { padding: 1.25rem; }
    
    /* ===== ORDER ITEMS ===== */
    .order-item {
        display: flex;
        align-items: center;
        padding: 0.9rem;
        border-radius: 12px;
        margin-bottom: 0.6rem;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .order-item:last-child { margin-bottom: 0; }
    .order-item.pending { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); border-left-color: #F59E0B; }
    .order-item.diproses { background: linear-gradient(135deg, #EFF6FF, #DBEAFE); border-left-color: #3B82F6; }
    .order-item.selesai { background: linear-gradient(135deg, #F0FDF4, #DCFCE7); border-left-color: #22C55E; }
    
    [data-theme="dark"] .order-item.pending { background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(251, 191, 36, 0.06)); }
    [data-theme="dark"] .order-item.diproses { background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(96, 165, 250, 0.06)); }
    [data-theme="dark"] .order-item.selesai { background: linear-gradient(135deg, rgba(34, 197, 94, 0.12), rgba(74, 222, 128, 0.06)); }
    
    .order-item:hover { transform: translateX(4px); }
    .order-item .order-emoji { font-size: 1.25rem; margin-right: 0.75rem; flex-shrink: 0; }
    .order-item .order-info { flex: 1; min-width: 0; }
    .order-item .order-code { font-weight: 700; color: var(--text-primary); font-size: 0.88rem; }
    .order-item .order-customer { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }
    .order-item .order-end { text-align: right; white-space: nowrap; }
    .order-item .order-amount { font-weight: 700; color: var(--text-primary); font-size: 0.88rem; margin-bottom: 3px; }
    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        padding: 0.2rem 0.5rem;
        border-radius: 5px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-tag.pending { background: #FEF3C7; color: #92400E; }
    .status-tag.diproses { background: #DBEAFE; color: #1E40AF; }
    .status-tag.selesai { background: #DCFCE7; color: #166534; }
    [data-theme="dark"] .status-tag.pending { background: rgba(245, 158, 11, 0.2); color: #FBBF24; }
    [data-theme="dark"] .status-tag.diproses { background: rgba(59, 130, 246, 0.2); color: #60A5FA; }
    [data-theme="dark"] .status-tag.selesai { background: rgba(34, 197, 94, 0.2); color: #4ADE80; }
    
    /* ===== MENU STATUS ===== */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .menu-item {
        text-align: center;
        padding: 1rem 0.5rem;
        border-radius: 12px;
        transition: all 0.3s;
    }
    .menu-item:hover { transform: translateY(-3px); }
    .menu-item.total { background: linear-gradient(135deg, #EFF6FF, #DBEAFE); }
    .menu-item.active { background: linear-gradient(135deg, #F0FDF4, #DCFCE7); }
    .menu-item.empty { background: linear-gradient(135deg, #FEF2F2, #FECACA); }
    [data-theme="dark"] .menu-item.total { background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.1)); }
    [data-theme="dark"] .menu-item.active { background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(22, 163, 74, 0.1)); }
    [data-theme="dark"] .menu-item.empty { background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.1)); }
    
    .menu-item .mi-value { font-size: 1.5rem; font-weight: 800; line-height: 1; }
    .menu-item.total .mi-value { color: #2563EB; }
    .menu-item.active .mi-value { color: #16A34A; }
    .menu-item.empty .mi-value { color: #DC2626; }
    .menu-item .mi-label { font-size: 0.65rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; margin-top: 3px; }
    
    /* ===== TIPS ===== */
    .tip-item {
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
        padding: 0.9rem;
        border-radius: 12px;
        margin-bottom: 0.6rem;
        transition: all 0.3s;
    }
    .tip-item:last-child { margin-bottom: 0; }
    .tip-item:hover { transform: translateX(3px); }
    .tip-item.green { background: linear-gradient(135deg, #F0FDF4, #DCFCE7); }
    .tip-item.blue { background: linear-gradient(135deg, #EFF6FF, #DBEAFE); }
    .tip-item.amber { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); }
    [data-theme="dark"] .tip-item.green { background: linear-gradient(135deg, rgba(34, 197, 94, 0.12), rgba(22, 163, 74, 0.06)); }
    [data-theme="dark"] .tip-item.blue { background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(37, 99, 235, 0.06)); }
    [data-theme="dark"] .tip-item.amber { background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(217, 119, 6, 0.06)); }
    
    .tip-item .tip-emoji { font-size: 1.3rem; flex-shrink: 0; }
    .tip-item .tip-text { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); line-height: 1.35; }
    
    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
    }
    .empty-state .empty-icon { font-size: 2.5rem; margin-bottom: 0.5rem; opacity: 0.5; }
    .empty-state .empty-text { color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 0.75rem; }
    .empty-state .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.55rem 1.1rem;
        background: linear-gradient(135deg, #22C55E, #16A34A);
        color: #fff;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    .empty-state .empty-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(34, 197, 94, 0.3); color: #fff; }
    
    /* ===== MOBILE RESPONSIVENESS ===== */
    @media (max-width: 768px) {
        .tenant-dashboard { padding: 1rem 0 1.5rem; }
        
        .welcome-hero {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .welcome-hero h1 { font-size: 1.25rem; }
        .welcome-hero .subtitle { font-size: 0.8rem; }
        
        .stat-cards {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .stat-card {
            padding: 1rem;
        }
        .stat-card .card-value { font-size: 1.5rem; }
        
        .quick-actions {
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
        }
        .quick-btn {
            padding: 0.75rem 0.25rem;
            font-size: 0.7rem;
        }
        .quick-btn .btn-icon {
            width: 32px;
            height: 32px;
        }
        
        .main-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .card-box {
            margin-bottom: 1rem;
        }
        .card-header {
            padding: 1rem;
        }
        .card-body {
            padding: 1rem;
        }
        
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
        }
        .menu-item {
            padding: 0.75rem 0.25rem;
        }
        .menu-item .mi-value { font-size: 1.2rem; }
        .menu-item .mi-label { font-size: 0.6rem; }
        
        .order-item {
            padding: 0.75rem;
        }
        .order-item .order-emoji { font-size: 1.1rem; }
        .order-item .order-code { font-size: 0.8rem; }
        .order-item .order-customer { font-size: 0.7rem; }
        .order-item .order-amount { font-size: 0.8rem; }
        
        .status-tag { font-size: 0.6rem; padding: 0.15rem 0.4rem; }
        
        .tip-item {
            padding: 0.75rem;
        }
        .tip-item .tip-emoji { font-size: 1.1rem; }
        .tip-item .tip-text { font-size: 0.75rem; }
    }
    
    @media (max-width: 480px) {
        .stat-cards {
            grid-template-columns: 1fr;
        }
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="container tenant-dashboard">
    @php
        $hour = now()->format('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
            $greetEmoji = '☀️';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
            $greetEmoji = '🌤️';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
            $greetEmoji = '🌅';
        } else {
            $greeting = 'Selamat Malam';
            $greetEmoji = '🌙';
        }
        
        $recentOrders = $tenant->orders()->with('user')->latest()->take(5)->get();
        $pendingCount = $tenant->orders()->where('status', 'pending')->count();
        $activeMenus = $tenant->menus()->where('is_available', true)->count();
        $outOfStock = $tenant->menus()->where('stok', 0)->count();
        $foodIcons = ['fa-utensils', 'fa-hamburger', 'fa-pizza-slice', 'fa-bowl-food', 'fa-leaf', 'fa-bowl-rice', 'fa-mug-hot', 'fa-drumstick-bite'];
    @endphp

    {{-- ===== WELCOME HERO ===== --}}
    <div class="welcome-hero animate-in">
        <div class="content">
            <div class="store-badge">
                <i class="fas fa-store"></i>
                {{ $tenant->nama_tenant }}
            </div>
            <h1>{{ $greeting }}, {{ Auth::user()->name }}!</h1>
            <p class="subtitle">{{ $tenant->deskripsi ? Str::limit($tenant->deskripsi, 50) : 'Kelola kantin Anda' }}</p>
            <div class="time-info">
                <i class="fas fa-calendar-alt"></i>
                {{ now()->translatedFormat('l, d F') }}
            </div>
        </div>
    </div>

    {{-- ===== STATS ===== --}}
    <div class="stat-cards animate-in delay-1">
        <div class="stat-card">
            <div class="card-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="card-label">Pesanan Hari Ini</div>
            <div class="card-value">{{ $totalOrdersToday }}</div>
            @if($pendingCount > 0)
            <span class="card-trend hot"><i class="fas fa-bell fa-xs"></i> {{ $pendingCount }} baru</span>
            @endif
        </div>
        <div class="stat-card">
            <div class="card-icon" style="background: linear-gradient(135deg, #22C55E, #16A34A);">
                <i class="fas fa-coins"></i>
            </div>
            <div class="card-label">Pendapatan Hari Ini</div>
            <div class="card-value" style="font-size: 1.5rem;">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
            <span class="card-trend up"><i class="fas fa-arrow-up fa-xs"></i> Mantap!</span>
        </div>
        <div class="stat-card">
            <div class="card-icon" style="background: linear-gradient(135deg, #3B82F6, #2563EB);">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="card-label">Total Menu</div>
            <div class="card-value">{{ $totalMenus }}</div>
            <span class="card-trend up">{{ $activeMenus }} aktif</span>
        </div>
    </div>

    {{-- ===== QUICK ACTIONS ===== --}}
    <div class="quick-actions animate-in delay-1">
        <a href="{{ route('tenant.orders') }}" class="quick-btn green">
            <span class="btn-icon" style="background: linear-gradient(135deg, #22C55E, #16A34A);"><i class="fas fa-shopping-bag"></i></span>
            <span>Pesanan</span>
            @if($pendingCount > 0)
            <span class="badge-count">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('tenant.menus.index') }}" class="quick-btn blue">
            <span class="btn-icon" style="background: linear-gradient(135deg, #3B82F6, #2563EB);"><i class="fas fa-utensils"></i></span>
            <span>Menu</span>
        </a>
        <a href="{{ route('tenant.stocks.index') }}" class="quick-btn orange">
            <span class="btn-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);"><i class="fas fa-boxes"></i></span>
            <span>Stok</span>
        </a>
        <a href="{{ route('tenant.reports') }}" class="quick-btn purple">
            <span class="btn-icon" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED);"><i class="fas fa-chart-line"></i></span>
            <span>Laporan</span>
        </a>
        <a href="{{ route('tenant.detailed_dashboard') }}" class="quick-btn cyan">
            <span class="btn-icon" style="background: linear-gradient(135deg, #06B6D4, #0891B2);"><i class="fas fa-chart-bar"></i></span>
            <span>Analytics</span>
        </a>
        <a href="{{ route('tenant.settings') }}" class="quick-btn pink">
            <span class="btn-icon" style="background: linear-gradient(135deg, #EC4899, #DB2777);"><i class="fas fa-cog"></i></span>
            <span>Setelan</span>
        </a>
    </div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="main-grid animate-in delay-2">
        {{-- Recent Orders --}}
        <div class="card-box">
            <div class="card-header">
                <h5>
                    <span class="header-icon" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A); color: #D97706;">
                        <i class="fas fa-clock"></i>
                    </span>
                    Pesanan Terbaru
                </h5>
                <a href="{{ route('tenant.orders') }}" class="header-link">Lihat Semua →</a>
            </div>
            <div class="card-body">
                @if($recentOrders->count() > 0)
                    @foreach($recentOrders->take(4) as $index => $order)
                        <div class="order-item {{ $order->status }}">
                            <span class="order-emoji" style="width: 36px; height: 36px; background: linear-gradient(135deg, #3B82F6, #2563EB); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center;"><i class="fas {{ $foodIcons[$index % count($foodIcons)] }}"></i></span>
                            <div class="order-info">
                                <div class="order-code">{{ $order->kode_pesanan }}</div>
                                <div class="order-customer">{{ $order->user->name ?? 'Customer' }} • {{ $order->created_at->format('H:i') }}</div>
                            </div>
                            <div class="order-end">
                                <div class="order-amount">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                                <span class="status-tag {{ $order->status }}">
                                    @if($order->status == 'pending')
                                        Baru
                                    @elseif($order->status == 'diproses')
                                        Proses
                                    @else
                                        Selesai
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p class="empty-text">Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Menu & Tips --}}
        <div>
            {{-- Menu Status --}}
            <div class="card-box" style="margin-bottom: 1.25rem;">
                <div class="card-header">
                    <h5>
                        <span class="header-icon" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE); color: #2563EB;">
                            <i class="fas fa-utensils"></i>
                        </span>
                        Status Menu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="menu-grid">
                        <div class="menu-item total">
                            <div class="mi-value">{{ $totalMenus }}</div>
                            <div class="mi-label">Total</div>
                        </div>
                        <div class="menu-item active">
                            <div class="mi-value">{{ $activeMenus }}</div>
                            <div class="mi-label">Tersedia</div>
                        </div>
                        <div class="menu-item empty">
                            <div class="mi-value">{{ $outOfStock }}</div>
                            <div class="mi-label">Habis</div>
                        </div>
                    </div>
                    <a href="{{ route('tenant.menus.create') }}" class="btn btn-primary w-100" style="border-radius: 10px; padding: 0.5rem;">
                        <i class="fas fa-plus me-1"></i>Tambah Menu
                    </a>
                </div>
            </div>

            {{-- Tips --}}
            <div class="card-box">
                <div class="card-header">
                    <h5>
                        <span class="header-icon" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A); color: #D97706;">
                            <i class="fas fa-lightbulb"></i>
                        </span>
                        Tips Sukses
                    </h5>
                </div>
                <div class="card-body" style="padding: 1rem;">
                    <div class="tip-item green">
                        <span class="tip-emoji"><i class="fas fa-camera" style="color: #16A34A;"></i></span>
                        <span class="tip-text">Upload foto menu menarik untuk tingkatkan penjualan</span>
                    </div>
                    <div class="tip-item blue">
                        <span class="tip-emoji"><i class="fas fa-bolt" style="color: #2563EB;"></i></span>
                        <span class="tip-text">Proses pesanan cepat untuk rating lebih baik</span>
                    </div>
                    <div class="tip-item amber">
                        <span class="tip-emoji"><i class="fas fa-chart-bar" style="color: #D97706;"></i></span>
                        <span class="tip-text">Pantau laporan untuk tahu menu favorit pelanggan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

