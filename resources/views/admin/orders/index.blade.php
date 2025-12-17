@extends('layouts.app')

@push('styles')
@include('partials.admin-professional-styles')
@endpush

@push('styles')
@include('partials.admin-minimalis-styles')
@endpush

@section('content')
<div class="admin-container">
    <!-- Professional Admin Header - Inside content area -->
    <div class="admin-header" style="background: var(--bg-primary); border-bottom: 1px solid var(--border); padding: 1rem; margin-bottom: 2rem; border-radius: var(--radius-lg);">
        <div class="admin-header-left">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                <img src="{{ asset('favicon-192.png') }}" alt="SMKN 2 Surabaya" style="width: 40px; height: 40px; border-radius: var(--radius-md);">
                <h1 class="admin-title">
                    <i class="fas fa-shopping-cart"></i>
                    Semua Pesanan
                </h1>
            </div>
            <p class="admin-subtitle">
                <i class="far fa-calendar-alt"></i>
                {{ now()->translatedFormat('l, d F Y') }} • Monitoring Status Pesanan Lintas Tenant SMKN 2 Surabaya
            </p>
        </div>
        <div class="admin-header-right">
            <a href="{{ route('orders.export') }}" class="btn btn-outline-primary">
                <i class="fas fa-download me-1"></i>
                Export
            </a>
        </div>
    </div>
    @php
        // Status badges configuration
        $statusConfig = [
            'pending' => ['label' => 'Menunggu', 'icon' => 'clock', 'class' => 'pending'],
            'diproses' => ['label' => 'Diproses', 'icon' => 'fire', 'class' => 'active'],
            'selesai' => ['label' => 'Selesai', 'icon' => 'check', 'class' => 'completed'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'icon' => 'times', 'class' => 'cancelled'],
            'pending_cash' => ['label' => 'Bayar Tunai', 'icon' => 'money-bill', 'class' => 'active']
        ];
    @endphp

    {{-- ===== FILTERS ===== --}}
    <div class="admin-filter">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            Filter Pesanan
        </div>
        <form method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-md);">
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">
                        <i class="fas fa-search"></i> Cari Pesanan
                    </label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Kode, tenant, customer, atau menu">
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Tenant</label>
                    <select name="tenant_id" class="form-control">
                        <option value="">Semua Tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" @selected(request('tenant_id') == $tenant->id)>{{ $tenant->nama_tenant }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        @foreach($statusConfig as $value => $config)
                            <option value="{{ $value }}" @selected(request('status') == $value)>{{ $config['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="admin-action-bar" style="margin-top: var(--space-md);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i>
                    Filter
                </button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo me-1"></i>
                    Reset
                </a>
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>
                    Cetak
                </button>
                <a href="{{ route('orders.export') }}" class="btn btn-warning">
                    <i class="fas fa-download me-1"></i>
                    Export
                </a>
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
    <div class="admin-table-container">
        <div class="admin-table-header">
            <div class="admin-table-title">
                <i class="fas fa-list"></i>
                Data Pesanan
            </div>
            <div class="admin-table-search">
                <input type="text" placeholder="Cari pesanan..." id="orderSearch">
                <i class="fas fa-search"></i>
            </div>
        </div>

        @if($orders->count() > 0)
            <table class="admin-table" id="ordersTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tenant</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="order-row" data-status="{{ $order->status }}" data-tenant="{{ $order->tenant->nama_tenant ?? '' }}" data-customer="{{ $order->user->name ?? '' }}" data-code="{{ $order->kode_pesanan ?? $order->id }}">
                            <td>
                                <strong>{{ $order->kode_pesanan ?? $order->id }}</strong>
                            </td>
                            <td>{{ $order->tenant->nama_tenant ?? '-' }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>{{ optional($order->created_at)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'diproses' ? 'warning' : ($order->status == 'dibatalkan' ? 'danger' : 'neutral')) }}">
                                    {{ $statusConfig[$order->status]['label'] }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: var(--space-xs); justify-content: flex-end;">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status == 'pending')
                                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-sm btn-success" title="Proses">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if(in_array($order->status, ['pending', 'diproses']))
                                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="dibatalkan">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Batalkan">
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

            @if($orders->hasPages())
                <div style="padding: var(--space-lg);">
                    <div class="pagination-info">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                        (Halaman {{ $orders->currentPage() }} dari {{ $orders->lastPage() }})
                    </div>
                    <div style="display: flex; justify-content: center;">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-title">Belum Ada Pesanan</div>
                <div class="empty-state-text">Tidak ada pesanan yang sesuai dengan filter yang dipilih</div>
                                    <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    <i class="fas fa-times me-1"></i>Hapus Filter
                </a>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
