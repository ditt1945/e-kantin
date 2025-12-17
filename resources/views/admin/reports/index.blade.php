@extends('layouts.app')

@section('title', 'Laporan & Analitik - Admin e-Kantin')

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-bar me-2 text-primary"></i>Laporan & Analitik
            </h1>
            <p class="text-muted small mb-0 d-none d-md-block">Dashboard analitik komprehensif untuk e-Kantin</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                <span class="d-none d-sm-inline">Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                               value="{{ $startDate->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-semibold">Tanggal Akhir</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                               value="{{ $endDate->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i>Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 bg-primary text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-3">
                    <div class="fs-4 fw-bold">{{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                    <small>Total Pendapatan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 bg-success text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-3">
                    <div class="fs-4 fw-bold">{{ $stats['total_orders'] }}</div>
                    <small>Total Pesanan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 bg-info text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-3">
                    <div class="fs-4 fw-bold">{{ $stats['active_tenants'] }}</div>
                    <small>Tenant Aktif</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 bg-warning text-dark" style="border-radius: 10px;">
                <div class="card-body text-center py-3">
                    <div class="fs-4 fw-bold">{{ $stats['total_customers'] }}</div>
                    <small>Total Pelanggan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 bg-secondary text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-3">
                    <div class="fs-4 fw-bold">{{ $stats['total_menus'] }}</div>
                    <small>Total Menu</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 bg-danger text-white" style="border-radius: 10px;">
                <div class="card-body text-center py-3">
                    <div class="fs-4 fw-bold">Rp {{ number_format($stats['avg_order_value'], 0, ',', '.') }}</div>
                    <small>Rata-rata Order</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics Row -->
    <div class="row g-3 mb-4">
        <!-- Daily Sales Trend -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2 text-primary"></i>Tren Penjualan Harian
                    </h6>
                </div>
                <div class="card-body">
                    @if($dailySales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th class="text-end">Jumlah Order</th>
                                        <th class="text-end">Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dailySales as $sale)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                                        <td class="text-end">{{ $sale->orders }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($sale->revenue, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada data penjualan pada periode ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2 text-success"></i>Distribusi Status Order
                    </h6>
                </div>
                <div class="card-body">
                    @if($orderStatuses->count() > 0)
                        @foreach($orderStatuses as $status)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge bg-{{ match($status->status) {
                                    'selesai' => 'success',
                                    'diproses' => 'warning',
                                    'pending' => 'primary',
                                    'pending_cash' => 'info',
                                    'dibatalkan' => 'danger',
                                    default => 'secondary'
                                } }} me-2">
                                    {{ ucfirst($status->status) }}
                                </span>
                            </div>
                            <div class="text-end">
                                <strong class="fs-6">{{ $status->count }}</strong>
                                <div class="small text-muted">{{ round(($status->count / $stats['total_orders']) * 100, 1) }}%</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-pie fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada data order</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers Row -->
    <div class="row g-3 mb-4">
        <!-- Top Tenants -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-store me-2 text-warning"></i>10 Tenant Terbaik
                    </h6>
                </div>
                <div class="card-body">
                    @if($topTenants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Tenant</th>
                                        <th class="text-end">Order</th>
                                        <th class="text-end">Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topTenants as $index => $tenant)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">#{{ $index + 1 }}</span>
                                        </td>
                                        <td>{{ $tenant->nama_tenant }}</td>
                                        <td class="text-end">{{ $tenant->orders_count }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($tenant->orders_sum_total_harga ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-store fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada data tenant</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Menus -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-utensils me-2 text-info"></i>10 Menu Terlaris
                    </h6>
                </div>
                <div class="card-body">
                    @if($topMenus->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Menu</th>
                                        <th class="text-end">Terjual</th>
                                        <th class="text-end">Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topMenus as $index => $menu)
                                    <tr>
                                        <td>
                                            <span class="badge bg-success">#{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div>{{ $menu->nama_menu }}</div>
                                            <small class="text-muted">{{ $menu->category->nama_kategori ?? '-' }}</small>
                                        </td>
                                        <td class="text-end">{{ $menu->total_sold }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($menu->revenue ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-utensils fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada data menu</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods & Categories Row -->
    <div class="row g-3 mb-4">
        <!-- Payment Methods -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    @if($paymentMethods->count() > 0)
                        @foreach($paymentMethods as $method)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                            <div>
                                <i class="fas fa-{{ $method->payment_method === 'cash' ? 'money-bill-wave' : 'credit-card' }} me-2"></i>
                                <strong>{{ ucfirst($method->payment_method) }}</strong>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $method->count }} transaksi</div>
                                <div class="small text-muted">Rp {{ number_format($method->total ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-credit-card fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada data pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Category Performance -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-tags me-2 text-secondary"></i>Performa Kategori
                    </h6>
                </div>
                <div class="card-body">
                    @if($categoryPerformance->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-end">Menu Aktif</th>
                                        <th class="text-end">Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoryPerformance as $category)
                                    <tr>
                                        <td>{{ $category->nama_kategori }}</td>
                                        <td class="text-end">{{ $category->menus_count ?? 0 }}</td>
                                        <td class="text-end fw-bold">{{ $category->total_sold ?? 0 }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tags fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada data kategori</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Comparison -->
    <div class="card">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-bold">
                <i class="fas fa-calendar-alt me-2 text-danger"></i>Perbandingan Pendapatan Bulanan
            </h6>
        </div>
        <div class="card-body">
            @if($monthlyRevenue->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th class="text-end">Pendapatan</th>
                                <th class="text-end">Growth</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $prevRevenue = 0; @endphp
                            @foreach($monthlyRevenue as $revenue)
                                @php
                                    $month = DateTime::createFromFormat('!m', $revenue->month)->format('F');
                                    $growth = $prevRevenue > 0 ? (($revenue->revenue - $prevRevenue) / $prevRevenue) * 100 : 0;
                                    $prevRevenue = $revenue->revenue;
                                @endphp
                            <tr>
                                <td>{{ $month }} {{ $revenue->year }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($revenue->revenue, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    @if($growth > 0)
                                        <span class="text-success fw-bold">
                                            <i class="fas fa-arrow-up me-1"></i>+{{ number_format($growth, 1) }}%
                                        </span>
                                    @elseif($growth < 0)
                                        <span class="text-danger fw-bold">
                                            <i class="fas fa-arrow-down me-1"></i>{{ number_format($growth, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-alt fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">Tidak ada data pendapatan bulanan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: none;
    }
    .card-header {
        border-bottom: 1px solid #dee2e6;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    .fs-4 {
        font-size: 1.5rem !important;
    }
    .fs-6 {
        font-size: 1rem !important;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }
        .card-body {
            padding: 0.75rem !important;
        }
        .table-responsive {
            font-size: 0.8rem;
        }
        .btn {
            font-size: 0.85rem;
        }
        .fs-4 {
            font-size: 1.25rem !important;
        }
    }

    @media (max-width: 576px) {
        .row.g-3 > .col-lg-2 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .table-responsive {
            font-size: 0.75rem;
        }
        .badge {
            font-size: 0.7rem;
            padding: 0.3em 0.6em;
        }
    }
</style>
@endpush