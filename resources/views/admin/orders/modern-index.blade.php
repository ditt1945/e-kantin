@extends('layouts.app')

@include('partials.admin-modern-styles')

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

        // Status badges configuration
        $statusConfig = [
            'pending' => ['label' => 'Menunggu', 'icon' => 'clock', 'class' => 'pending'],
            'diproses' => ['label' => 'Diproses', 'icon' => 'fire', 'class' => 'active'],
            'selesai' => ['label' => 'Selesai', 'icon' => 'check', 'class' => 'completed'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'icon' => 'times', 'class' => 'cancelled'],
            'pending_cash' => ['label' => 'Bayar Tunai', 'icon' => 'money-bill', 'class' => 'active']
        ];
    @endphp

    {{-- ===== PAGE HEADER ===== --}}
    <div class="admin-hero" style="background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 50%, #60A5FA 100%); padding: var(--space-6); margin-bottom: var(--space-6); border-radius: var(--radius-2xl);">
        <div class="content" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--space-4);">
            <div>
                <h1 class="hero-title" style="font-size: 2rem; margin-bottom: var(--space-2);">
                    <i class="fas fa-clipboard-list" style="color: #FBBF24;"></i> Semua Pesanan
                </h1>
                <p class="hero-subtitle">{{ $greeting }}, Admin! Monitoring status pesanan lintas tenant</p>
            </div>
            <div class="time-badge">
                <i class="fas fa-shopping-cart"></i>
                {{ $orders->count() }} Total Pesanan
            </div>
        </div>
    </div>

    {{-- ===== FILTERS ===== --}}
    <div class="admin-form-modern animate-fade-in">
        <div class="form-title">
            <i class="fas fa-filter"></i>
            Filter Pesanan
        </div>
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tenant</label>
                <select name="tenant_id" class="form-select">
                    <option value="">Semua Tenant</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" @selected(request('tenant_id') == $tenant->id)>{{ $tenant->nama_tenant }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach($statusConfig as $value => $config)
                        <option value="{{ $value }}" @selected(request('status') == $value)>{{ $config['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-12">
                <div class="d-flex gap-2">
                    <button type="submit" class="admin-btn-modern primary">
                        <i class="fas fa-filter"></i>
                        Terapkan Filter
                    </button>
                    <a href="{{ route('orders.index') }}" class="admin-btn-modern outline">
                        <i class="fas fa-redo"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== STATISTICS CARDS ===== --}}
    <div class="admin-stats-modern animate-fade-in animate-delay-1">
        @foreach($statusConfig as $status => $config)
            @php
                $count = $orders->where('status', $status)->count();
                $total = $orders->where('status', $status)->sum('total_harga');
            @endphp
            @if($count > 0)
            <div class="admin-stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: {{ $status == 'pending' ? 'var(--gradient-warning)' : ($status == 'diproses' ? 'var(--gradient-primary)' : ($status == 'selesai' ? 'var(--gradient-success)' : 'var(--gradient-danger)')) }};">
                        <i class="fas fa-{{ $config['icon'] }}"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i>
                        {{ round(($count / $orders->count()) * 100) }}%
                    </div>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $count }}</div>
                    <div class="stat-label">{{ $config['label'] }}</div>
                    <div class="stat-description">Total Rp {{ number_format($total, 0, ',', '.') }}</div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    {{-- ===== ORDERS TABLE ===== --}}
    <div class="admin-table-modern animate-fade-in animate-delay-2">
        <div class="table-header">
            <div class="table-title">
                <div class="title-icon">
                    <i class="fas fa-list"></i>
                </div>
                Data Pesanan
            </div>
            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari kode pesanan, tenant, pelanggan..." id="orderSearch">
                </div>
                <button class="admin-btn-modern success" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Cetak
                </button>
                <a href="{{ route('orders.export') }}" class="admin-btn-modern info">
                    <i class="fas fa-download"></i>
                    Export
                </a>
            </div>
        </div>
        <div class="table-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="ordersTable">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Tenant</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="order-row" data-status="{{ $order->status }}" data-tenant="{{ $order->tenant->nama_tenant ?? '' }}" data-customer="{{ $order->user->name ?? '' }}" data-code="{{ $order->kode_pesanan ?? $order->id }}">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="order-code-icon" style="width: 32px; height: 32px; background: var(--gradient-primary); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700;">
                                                {{ substr($order->kode_pesanan ?? $order->id, -3) }}
                                            </div>
                                            <div>
                                                <strong style="color: var(--admin-primary);">#{{ $order->kode_pesanan ?? $order->id }}</strong>
                                                <br>
                                                <small style="color: var(--text-secondary);">{{ optional($order->created_at)->format('H:i:s') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="tenant-avatar" style="width: 36px; height: 36px; background: var(--gradient-success); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-store"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $order->tenant->nama_tenant ?? 'N/A' }}</strong>
                                                <br>
                                                <small style="color: var(--text-secondary);">{{ $order->tenant->category->nama_kategori ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="customer-avatar" style="width: 36px; height: 36px; background: var(--gradient-warning); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                                {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $order->user->name ?? 'Customer' }}</strong>
                                                <br>
                                                <small style="color: var(--text-secondary);">{{ $order->user->role ?? 'customer' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ optional($order->created_at)->format('d M Y') }}</strong>
                                            <br>
                                            <small style="color: var(--text-secondary);">{{ optional($order->created_at)->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 1.1rem; font-weight: 800; color: var(--admin-success);">
                                            Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="admin-badge-modern {{ $order->status }}">
                                            <i class="fas fa-{{ $statusConfig[$order->status]['icon'] }} fa-xs"></i>
                                            {{ $statusConfig[$order->status]['label'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('orders.show', $order->id) }}" class="admin-btn-modern info sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($order->status == 'pending')
                                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="diproses">
                                                    <button type="submit" class="admin-btn-modern success sm" title="Proses" onclick="return confirm('Proses pesanan ini?')">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if(in_array($order->status, ['pending', 'diproses']))
                                                <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="dibatalkan">
                                                    <button type="submit" class="admin-btn-modern danger sm" title="Batalkan" onclick="return confirm('Batalkan pesanan ini?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($orders->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $orders->firstItem() }} hingga {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                        </small>
                    </div>
                    <div>
                        {{ $orders->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                @endif
            @else
                <div class="admin-empty-modern">
                    <span class="empty-icon">📋</span>
                    <h4 class="empty-title">Belum Ada Pesanan</h4>
                    <p class="empty-text">Tidak ada pesanan yang sesuai dengan filter yang dipilih</p>
                    <a href="{{ route('orders.index') }}" class="empty-action">
                        <i class="fas fa-redo"></i>
                        Hapus Filter
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time search functionality
    const searchInput = document.getElementById('orderSearch');
    const tableRows = document.querySelectorAll('#ordersTable tbody .order-row');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                    row.style.animation = 'fadeInUp 0.3s ease';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show/hide empty state based on search results
            const emptyState = document.querySelector('.admin-empty-modern');
            const tableContainer = document.querySelector('.table-responsive');

            if (visibleCount === 0 && searchTerm) {
                if (emptyState) {
                    emptyState.style.display = 'block';
                } else {
                    const noResults = document.createElement('div');
                    noResults.className = 'admin-empty-modern';
                    noResults.innerHTML = `
                        <span class="empty-icon">🔍</span>
                        <h4 class="empty-title">Tidak Ada Hasil</h4>
                        <p class="empty-text">Tidak ada pesanan yang cocok dengan pencarian "${searchTerm}"</p>
                    `;
                    tableContainer.parentNode.insertBefore(noResults, tableContainer.nextSibling);
                }
                tableContainer.style.display = 'none';
            } else {
                if (emptyState && emptyState.style.display === 'block') {
                    emptyState.style.display = 'none';
                }
                tableContainer.style.display = 'block';
            }
        });
    }

    // Auto-refresh orders every 30 seconds
    let refreshInterval;
    function startAutoRefresh() {
        refreshInterval = setInterval(() => {
            // Add subtle animation to indicate refresh
            const tableHeader = document.querySelector('.table-header .title-icon');
            if (tableHeader) {
                tableHeader.style.animation = 'spin 1s ease';
                setTimeout(() => {
                    tableHeader.style.animation = '';
                    // In production, you would fetch new data here
                    console.log('Auto-refreshing orders...');
                }, 1000);
            }
        }, 30000);
    }

    // Stop auto-refresh when page is not visible
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(refreshInterval);
        } else {
            startAutoRefresh();
        }
    });

    // Start auto-refresh
    startAutoRefresh();

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        // Ctrl/Cmd + F focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }

        // Escape clear search
        if (e.key === 'Escape' && searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }
    });

    // Add hover effects to action buttons
    document.querySelectorAll('.btn-group .admin-btn-modern').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll to table when searching
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            if (this.value.length > 2) {
                const table = document.querySelector('.admin-table-modern');
                if (table) {
                    table.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }
        });
    }

    // Add loading state for form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('btn-outline-secondary')) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
                submitBtn.disabled = true;

                // Reset after 5 seconds (in case of errors)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });

    // Add tooltips for better UX
    document.querySelectorAll('[title]').forEach(element => {
        element.style.position = 'relative';
        element.style.cursor = 'help';
    });

    // Initialize print functionality
    window.addEventListener('beforeprint', () => {
        // Hide unnecessary elements when printing
        document.querySelectorAll('.btn-group, .table-actions, .admin-form-modern').forEach(el => {
            el.style.display = 'none';
        });
    });

    window.addEventListener('afterprint', () => {
        // Show hidden elements after printing
        document.querySelectorAll('.btn-group, .table-actions, .admin-form-modern').forEach(el => {
            el.style.display = '';
        });
    });
});

// Add custom animations
const style = document.createElement('style');
style.textContent = `
    .order-row {
        transition: all 0.2s ease;
    }

    .order-row:hover {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(59, 130, 246, 0.02) 100%) !important;
        transform: scale(1.005);
    }

    .btn-group {
        display: flex;
        gap: 0.25rem;
        border-radius: 8px;
        overflow: hidden;
    }

    .btn-group .admin-btn-modern {
        border-radius: 0;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-group .admin-btn-modern:last-child {
        border-right: none;
    }

    .order-code-icon,
    .tenant-avatar,
    .customer-avatar {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .order-row:hover .order-code-icon,
    .order-row:hover .tenant-avatar,
    .order-row:hover .customer-avatar {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
`;
document.head.appendChild(style);
</script>
@endsection