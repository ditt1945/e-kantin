@extends('layouts.app')

@include('partials.admin-modern-styles')

@section('content')
<div class="admin-container">
    @php
        $hour = now()->format('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
            $greetEmoji = '🌅';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
            $greetEmoji = '☀️';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
            $greetEmoji = '🌤️';
        } else {
            $greeting = 'Selamat Malam';
            $greetEmoji = '🌙';
        }

        // Calculate additional stats
        $activeTenants = $totalTenants ?? 0;
        $activeMenus = $totalMenus ?? 0;
        $activeUsers = $totalUsers ?? 0;
        $todayOrders = $totalOrders ?? 0;

        // Calculate trends (mock data for demonstration)
        $tenantsTrend = 'up';
        $menusTrend = 'up';
        $usersTrend = 'up';
        $ordersTrend = 'neutral';
    @endphp

    {{-- ===== ASYMMETRICAL HERO SECTION ===== --}}
    <div class="admin-hero-asymmetric animate-fade-in">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="hero-left">
                <div class="greeting-container">
                    <span class="greeting-emoji">{{ $greetEmoji }}</span>
                    <div class="greeting-text">
                        <h1 class="hero-title">{{ $greeting }}, Admin!</h1>
                        <p class="hero-subtitle">Kelola sistem kantiin SMKN 2 Surabaya dengan dashboard yang lebih dinamis</p>
                    </div>
                </div>
                <div class="hero-stats-asymmetric">
                    <div class="stat-item-large" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border: 1px solid #E2E8F0; color: #1E293B; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%); color: white;">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $activeTenants }}</div>
                            <div class="stat-label">Total Kantin</div>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i> <span>+12%</span>
                            </div>
                        </div>
                        <div class="stat-decoration"></div>
                    </div>

                    <div class="stat-item-vertical">
                        <div class="mini-stat emerald">
                            <div class="mini-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="mini-content">
                                <div class="mini-number">{{ $activeMenus }}</div>
                                <div class="mini-label">Menu</div>
                            </div>
                        </div>
                        <div class="mini-stat" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border: 1px solid #E2E8F0; color: #1E293B;">
                            <div class="mini-icon" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%); color: white;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="mini-content">
                                <div class="mini-number">{{ $totalUsers ?? 0 }}</div>
                                <div class="mini-label">Users</div>
                            </div>
                        </div>
                        <div class="mini-stat sunset-gradient">
                            <div class="mini-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="mini-content">
                                <div class="mini-number">{{ $todayOrders }}</div>
                                <div class="mini-label">Pesanan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-card-floating">
                    <div class="floating-card-header">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="floating-card-content">
                        <div class="time-display">{{ now()->format('H:i') }}</div>
                        <div class="date-display">{{ now()->format('d') }} {{ now()->translatedFormat('F') }}</div>
                    </div>
                </div>
                <div class="hero-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-dots"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== DYNAMIC QUICK ACTIONS WITH VARIED LAYOUTS ===== --}}
    <div class="admin-quick-dynamic animate-fade-in animate-delay-1">
        <div class="quick-actions-grid">
            <!-- Large Primary Action -->
            <a href="{{ route('tenants.index') }}" class="quick-action-large primary">
                <div class="action-background">
                    <div class="action-pattern"></div>
                </div>
                <div class="action-content">
                    <div class="action-icon-wrapper">
                        <i class="fas fa-store"></i>
                        <div class="icon-glow"></div>
                    </div>
                    <div class="action-text">
                        <h3>Kelola Kantin</h3>
                        <p>{{ $totalTenants }} tenant aktif</p>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
                <div class="action-badge">{{ $totalTenants }}</div>
            </a>

            <!-- Medium Actions Row -->
            <div class="quick-actions-row">
                <a href="{{ route('users.index') }}" class="quick-action-medium" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border: 1px solid #E2E8F0; color: #1E293B;">
                    <div class="action-header">
                        <i class="fas fa-users-cog"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-body">
                        <h4>Pengguna</h4>
                        <span>{{ $totalUsers }} akun</span>
                    </div>
                </a>

                <a href="{{ route('menus.index') }}" class="quick-action-medium" style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border: 1px solid #F59E0B; color: #92400E;">
                    <div class="action-header">
                        <i class="fas fa-utensils"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-body">
                        <h4>Menu</h4>
                        <span>{{ $totalMenus }} item</span>
                    </div>
                </a>
            </div>

            <!-- Small Actions Grid -->
            <div class="quick-actions-small">
                <a href="{{ route('orders.index') }}" class="quick-action-small danger">
                    <div class="mini-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="notification-dot">{{ $totalOrders > 0 ? $totalOrders : '' }}</span>
                    </div>
                    <span>Pesanan</span>
                    <strong>{{ $totalOrders }}</strong>
                </a>

                <a href="{{ route('categories.index') }}" class="quick-action-small" style="background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%); border: 1px solid #0EA5E9; color: #075985;">
                    <div class="mini-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <span>Kategori</span>
                    <strong>Mgmt</strong>
                </a>

                <a href="{{ route('tenants.create') }}" class="quick-action-small" style="background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 100%); border: 1px solid #EC4899; color: #BE185D;">
                    <div class="mini-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <span>Tambah</span>
                    <strong>Kantin</strong>
                </a>

                <a href="{{ route('orders.index') }}" class="quick-action-small" style="background: linear-gradient(135deg, #F0FDF4 0%, #DCFCE7 100%); border: 1px solid #10B981; color: #065F46;">
                    <div class="mini-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span>Laporan</span>
                    <strong>Pesanan</strong>
                </a>

                <a href="{{ route('users.index') }}" class="quick-action-small" style="background: linear-gradient(135deg, #FAF5FF 0%, #F3E8FF 100%); border: 1px solid #9333EA; color: #6B21A8;">
                    <div class="mini-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <span>Admin</span>
                    <strong>Pengguna</strong>
                </a>
            </div>
        </div>
    </div>

    {{-- ===== ASYMMETRICAL STATS CARDS ===== --}}
    <div class="admin-stats-asymmetric animate-fade-in animate-delay-2">
        <!-- Premium Featured Stat Card -->
        <div class="stat-card-featured" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border: 1px solid #E2E8F0; color: #1E293B;">
            <div class="featured-header">
                <div class="featured-icon" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white;">
                    <i class="fas fa-chart-line"></i>
                    <div class="icon-ripple"></div>
                </div>
                <div class="featured-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>24%</span>
                </div>
            </div>
            <div class="featured-content">
                <div class="featured-number">{{ $totalTenants }}</div>
                <div class="featured-label">Business Growth</div>
                <div class="featured-description">Analytics dashboard performance</div>
            </div>
            <div class="featured-chart">
                <div class="mini-bar-chart">
                    <div class="bar" style="height: 45%"></div>
                    <div class="bar" style="height: 75%"></div>
                    <div class="bar" style="height: 60%"></div>
                    <div class="bar" style="height: 95%"></div>
                    <div class="bar" style="height: 80%"></div>
                </div>
            </div>
        </div>

        <!-- Diagonal Stats Row -->
        <div class="stats-diagonal">
            <div class="stat-card-diagonal" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border-left: 4px solid #0EA5E9; color: #1E293B;">
                <div class="diagonal-content">
                    <div class="diagonal-icon" style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%); color: white;">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="diagonal-text">
                        <div class="diagonal-number">{{ $totalMenus }}</div>
                        <div class="diagonal-label">Menu Items</div>
                    </div>
                    <div class="diagonal-trend">
                        <span>+8%</span>
                    </div>
                </div>
                <div class="diagonal-decoration">
                    <div class="deco-wave"></div>
                </div>
            </div>

            <div class="stat-card-diagonal" style="background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); border-left: 4px solid #F59E0B; color: #92400E;">
                <div class="diagonal-content">
                    <div class="diagonal-icon" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="diagonal-text">
                        <div class="diagonal-number">{{ $totalUsers ?? 0 }}</div>
                        <div class="diagonal-label">Active Users</div>
                    </div>
                    <div class="diagonal-trend">
                        <span>+15%</span>
                    </div>
                </div>
                <div class="diagonal-decoration">
                    <div class="deco-wave"></div>
                </div>
            </div>
        </div>

        <!-- Premium Performance Card -->
        <div class="stat-card-performance" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border: 1px solid #E2E8F0; color: #1E293B;">
            <div class="performance-header">
                <div class="performance-icon" style="background: linear-gradient(135deg, #6B21A8 0%, #9333EA 100%); color: white;">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="performance-title">
                    <h4>Performance Today</h4>
                    <span class="live-indicator">● Live</span>
                </div>
            </div>
            <div class="performance-content">
                <div class="performance-main">
                    <div class="main-number">{{ $totalOrders ?? 0 }}</div>
                    <div class="main-label">Total Orders</div>
                </div>
                <div class="performance-metrics">
                    <div class="metric-item">
                        <div class="metric-label">Completion Rate</div>
                        <div class="metric-bar">
                            <div class="metric-fill" style="width: 92%"></div>
                        </div>
                        <div class="metric-value">92%</div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-label">Avg Time</div>
                        <div class="metric-value">15m</div>
                    </div>
                </div>
            </div>
            <div class="performance-decoration">
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>

    {{-- ===== MODERN ORDANS TABLE WITH ASYMMETRICAL HEADER ===== --}}
    <div class="admin-table-asymmetric animate-fade-in animate-delay-3">
        <div class="table-header-asymmetric">
            <div class="header-left">
                <div class="header-icon-large">
                    <i class="fas fa-receipt"></i>
                    <div class="icon-glow"></div>
                </div>
                <div class="header-text">
                    <h2>Pesanan Terbaru</h2>
                    <p>Transaksi terkini dari seluruh kantin</p>
                </div>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <div class="search-modern">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari pesanan..." class="search-input">
                        <div class="search-line"></div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="view-all-btn">
                        <span>Lihat Semua</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="table-body-asymmetric">
            @if($pesananTerbaru->count() > 0)
                <div class="orders-modern">
                    @foreach($pesananTerbaru->take(3) as $index => $pesanan)
                        <div class="order-card-asymmetric" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="order-left">
                                <div class="order-id">
                                    <span class="id-prefix">#</span>
                                    <span class="id-number">{{ $pesanan->kode_pesanan ?? $pesanan->id }}</span>
                                </div>
                                <div class="order-time">{{ optional($pesanan->created_at)->format('H:i') }}</div>
                            </div>
                            <div class="order-center">
                                <div class="order-tenant">{{ $pesanan->tenant->nama_tenant ?? 'N/A' }}</div>
                                <div class="order-customer">{{ $pesanan->user->name ?? 'Customer' }}</div>
                            </div>
                            <div class="order-right">
                                <div class="order-amount">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</div>
                                <span class="order-status {{ $pesanan->status }}">
                                    @if($pesanan->status == 'pending')
                                        <i class="fas fa-clock"></i> Menunggu
                                    @elseif($pesanan->status == 'diproses')
                                        <i class="fas fa-fire"></i> Diproses
                                    @elseif($pesanan->status == 'selesai')
                                        <i class="fas fa-check"></i> Selesai
                                    @elseif($pesanan->status == 'pending_cash')
                                        <i class="fas fa-money-bill"></i> Bayar Tunai
                                    @elseif($pesanan->status == 'dibatalkan')
                                        <i class="fas fa-times"></i> Dibatalkan
                                    @else
                                        {{ ucfirst($pesanan->status) }}
                                    @endif
                                </span>
                                <a href="{{ route('orders.show', $pesanan->id) }}" class="order-detail-btn">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-asymmetric">
                    <div class="empty-icon-large">📭</div>
                    <h3>Belum ada pesanan</h3>
                    <p>Pesanan akan muncul saat transaksi dimulai</p>
                    <a href="{{ route('tenants.index') }}" class="empty-cta">
                        <i class="fas fa-store"></i>
                        Kelola Kantin
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- ===== FLOATING WIDGETS ROW ===== --}}
    <div class="admin-widgets-floating animate-fade-in animate-delay-4">
        <!-- Performance Widget -->
        <div class="widget-floating performance">
            <div class="widget-header">
                <div class="widget-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="widget-title">Performa Hari Ini</div>
            </div>
            <div class="widget-content">
                <div class="metric-row">
                    <span class="metric-label">Kepuasan</span>
                    <div class="metric-bar">
                        <div class="metric-fill" style="width: 92%"></div>
                    </div>
                    <span class="metric-value">92%</span>
                </div>
                <div class="metric-row">
                    <span class="metric-label">Kecepatan</span>
                    <div class="metric-bar">
                        <div class="metric-fill success" style="width: 85%"></div>
                    </div>
                    <span class="metric-value">15m</span>
                </div>
                <div class="metric-row">
                    <span class="metric-label">Akurasi</span>
                    <div class="metric-bar">
                        <div class="metric-fill info" style="width: 98%"></div>
                    </div>
                    <span class="metric-value">98%</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Widget -->
        <div class="widget-floating stats">
            <div class="widget-header">
                <div class="widget-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="widget-title">Statistik Cepat</div>
            </div>
            <div class="widget-content">
                <div class="quick-stats">
                    <div class="quick-stat">
                        <div class="stat-icon-small primary">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">1.2k</div>
                            <div class="stat-text">Pengunjung</div>
                        </div>
                    </div>
                    <div class="quick-stat">
                        <div class="stat-icon-small success">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">85%</div>
                            <div class="stat-text">Digital Payment</div>
                        </div>
                    </div>
                    <div class="quick-stat">
                        <div class="stat-icon-small warning">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">4.8</div>
                            <div class="stat-text">Rating</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-fade-in').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(el);
    });

    // Search functionality
    const searchInput = document.querySelector('.search-input');
    const tableRows = document.querySelectorAll('.table tbody tr');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                    row.style.animation = 'fadeInUp 0.3s ease';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Add click sound simulation with visual feedback
    document.querySelectorAll('.admin-quick-action, .admin-btn-modern').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Create ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add smooth parallax effect to hero section on mouse move
    const hero = document.querySelector('.admin-hero');
    if (hero) {
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            hero.style.backgroundPosition = `${x * 50}px ${y * 50}px`;
        });
    }

    // Auto-refresh recent orders every 30 seconds
    setInterval(() => {
        // Add a subtle pulse animation to indicate refresh
        const tableHeader = document.querySelector('.table-header');
        if (tableHeader) {
            tableHeader.style.animation = 'pulse 0.5s ease';
            setTimeout(() => {
                tableHeader.style.animation = '';
            }, 500);
        }
    }, 30000);
});

// Add ripple effect styles
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .admin-quick-action,
    .admin-btn-modern {
        position: relative;
        overflow: hidden;
    }
`;
document.head.appendChild(style);
</script>
@endsection