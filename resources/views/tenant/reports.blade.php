@extends('layouts.app')

@section('content')
<div class="container py-3 py-md-5">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="reports-title mb-0">
                <i class="fas fa-chart-bar me-2 text-primary"></i>Laporan Penjualan
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">{{ $tenant->nama_tenant ?? 'Tenant' }} - Analisis penjualan dan performa menu</p>
        </div>
        <a href="{{ route('tenant.dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
    </div>

    {{-- Today's Sales Card --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-coins me-2 text-success"></i>Penjualan Hari Ini
                        </h5>
                        <span class="badge bg-success-subtle text-success">Hari Ini</span>
                    </div>
                    <div class="sales-amount text-success mb-3">
                        Rp {{ number_format($reports['daily_sales']->sum('total') ?? 0, 0, ',', '.') }}
                    </div>
                    @if(!empty($reports['daily_sales']) && $reports['daily_sales']->count())
                        <div class="bg-light rounded p-2 p-md-3">
                            @foreach($reports['daily_sales'] as $row)
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</small>
                                    <strong>Rp {{ number_format($row->total, 0, ',', '.') }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-light rounded p-3 text-center">
                            <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                            <small class="text-muted">Tidak ada penjualan hari ini</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Top Menu Sales --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 p-md-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-fire me-2 text-warning"></i>Menu Terlaris
                    </h5>
                    @if(!empty($reports['top_menus']) && $reports['top_menus']->count())
                        <div class="d-flex flex-column gap-2">
                            @foreach($reports['top_menus'] as $index => $menu)
                                <div class="bg-light rounded p-2 p-md-3 d-flex justify-content-between align-items-center border-start border-3 border-primary">
                                    <div>
                                        <div class="fw-semibold">#{{ $index + 1 }} {{ $menu->nama_menu ?? '-' }}</div>
                                        <small class="text-muted">{{ $menu->category->nama_kategori ?? '-' }}</small>
                                    </div>
                                    <span class="badge bg-primary">{{ $menu->total_sold ?? 0 }}x</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-light rounded p-3 text-center">
                            <i class="fas fa-chart-line fa-2x text-muted mb-2 d-block"></i>
                            <small class="text-muted">Belum ada data menu terlaris</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Monthly Income --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-3 p-md-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-chart-line me-2 text-primary"></i>Pendapatan Bulanan
            </h5>
            @if(!empty($reports['monthly_income']) && $reports['monthly_income']->count())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">Bulan</th>
                                <th class="fw-bold text-end">Total Pendapatan</th>
                                <th class="fw-bold text-end d-none d-sm-table-cell">Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $prevTotal = 0; @endphp
                            @foreach($reports['monthly_income'] as $row)
                                @php
                                    $currentTotal = $row->total;
                                    $trend = $prevTotal > 0 ? (($currentTotal - $prevTotal) / $prevTotal) * 100 : 0;
                                    $prevTotal = $currentTotal;
                                @endphp
                                <tr>
                                    <td class="fw-medium">{{ \DateTime::createFromFormat('!m', $row->month)->format('F Y') }}</td>
                                    <td class="text-end fw-semibold">Rp {{ number_format($currentTotal, 0, ',', '.') }}</td>
                                    <td class="text-end d-none d-sm-table-cell">
                                        @if($trend > 0)
                                            <span class="text-success fw-semibold"><i class="fas fa-arrow-up me-1"></i>+{{ number_format($trend, 1) }}%</span>
                                        @elseif($trend < 0)
                                            <span class="text-danger fw-semibold"><i class="fas fa-arrow-down me-1"></i>{{ number_format($trend, 1) }}%</span>
                                        @else
                                            <span class="text-muted">— Baru</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-light rounded p-4 text-center">
                    <i class="fas fa-calendar-alt fa-3x text-muted mb-2 d-block"></i>
                    <p class="text-muted mb-0">Tidak ada data pendapatan bulanan</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .reports-title {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .sales-amount {
        font-size: 1.75rem;
        font-weight: 800;
    }
    
    @media (max-width: 768px) {
        .reports-title {
            font-size: 1.25rem;
        }
        
        .sales-amount {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .reports-title {
            font-size: 1.1rem;
        }
        
        .sales-amount {
            font-size: 1.25rem;
        }
        
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }
        
        .card-body {
            padding: 0.75rem !important;
        }
        
        .table td, .table th {
            padding: 0.5rem;
            font-size: 0.85rem;
        }
    }
</style>
@endsection

