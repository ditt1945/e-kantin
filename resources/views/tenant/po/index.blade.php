@extends('layouts.app')

@section('title', 'Purchase Order Management - e-Kantin')

@section('content')
<div class="container py-3 py-md-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Purchase Order
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">
                {{ $tenant->nama_tenant }} - Kelola stok makanan berat
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.reports') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-chart-bar me-1"></i>
                <span class="d-none d-sm-inline">Laporan</span>
            </a>
            <a href="{{ route('tenant.po.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>
                <span class="d-none d-sm-inline">PO Baru</span>
            </a>
        </div>
    </div>

    <!-- PO Status Summary -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-warning text-dark">
                <div class="card-body text-center py-3">
                    <div class="stat-number">{{ $purchaseOrders->where('status', 'pending')->count() }}</div>
                    <small class="opacity-75">Menunggu</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body text-center py-3">
                    <div class="stat-number">{{ $purchaseOrders->where('status', 'confirmed')->count() }}</div>
                    <small class="opacity-75">Dikonfirmasi</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body text-center py-3">
                    <div class="stat-number">{{ $purchaseOrders->where('status', 'delivered')->count() }}</div>
                    <small class="opacity-75">Terkirim</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 bg-danger text-white">
                <div class="card-body text-center py-3">
                    <div class="stat-number">{{ $purchaseOrders->where('status', 'cancelled')->count() }}</div>
                    <small class="opacity-75">Dibatalkan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tenant.po.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Terkirim</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_range" class="form-label fw-semibold">Periode</label>
                        <select name="date_range" id="date_range" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Waktu</option>
                            <option value="7" {{ request('date_range') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="30" {{ request('date_range') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                            <option value="90" {{ request('date_range') == '90' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="search" class="form-label fw-semibold">Cari</label>
                        <input type="text" name="search" id="search" class="form-control"
                               value="{{ request('search') }}" placeholder="PO Number atau Supplier">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- PO List -->
    @if($purchaseOrders->count() > 0)
    <div class="row g-3">
        @foreach($purchaseOrders as $po)
        @php
            $statusInfo = $po->getStatusLabel();
        @endphp
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <h6 class="mb-0 fw-bold text-primary">{{ $po->po_number }}</h6>
                                <span class="badge bg-{{ $statusInfo['color'] }}">{{ $statusInfo['text'] }}</span>
                            </div>
                            <div class="small text-muted mb-1">
                                <i class="fas fa-user me-1"></i>{{ $po->supplier_name }}
                                @if($po->supplier_contact)
                                    <span class="ms-2">• {{ $po->supplier_contact }}</span>
                                @endif
                            </div>
                            <div class="small text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Order: {{ $po->order_date->format('d M Y') }}
                                @if($po->expected_delivery_date)
                                    <span class="ms-3">• Expected: {{ $po->expected_delivery_date->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold fs-5 text-primary">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</div>
                            <div class="small text-muted">{{ $po->items->count() }} items</div>
                        </div>
                    </div>

                    <!-- PO Items Preview -->
                    <div class="bg-light p-2 rounded mb-3">
                        <div class="row g-2">
                            @foreach($po->items->take(3) as $item)
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="fw-semibold">{{ $item->item_name }}</small>
                                        @if($item->menu)
                                            <span class="badge bg-light text-dark ms-1">{{ $item->menu->category->nama_kategori ?? 'Uncategorized' }}</span>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">{{ $item->quantity }} @ Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                                        <div class="small fw-bold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if($po->items->count() > 3)
                            <div class="col-12">
                                <small class="text-muted text-center">... dan {{ $po->items->count() - 3 }} item lainnya</small>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Delivery Progress -->
                    @if($po->status === 'delivered')
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">Delivery Progress</small>
                            <small class="text-muted">{{ $po->items->sum('received_quantity') }} / {{ $po->items->sum('quantity') }}</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            @php
                                $totalQty = $po->items->sum('quantity');
                                $receivedQty = $po->items->sum('received_quantity');
                                $percentage = $totalQty > 0 ? ($receivedQty / $totalQty) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{ $percentage }}%"
                                 aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Created by {{ $po->creator->name ?? 'System' }} • {{ $po->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('tenant.po.show', $po) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            @if($po->isModifiable())
                                <a href="{{ route('tenant.po.edit', $po) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            @endif
                            @if($po->status === 'pending')
                                <form action="{{ route('tenant.po.confirm', $po) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi PO ini?')">
                                        <i class="fas fa-check me-1"></i>Confirm
                                    </button>
                                </form>
                            @elseif($po->status === 'confirmed')
                                <a href="{{ route('tenant.po.receive', $po) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-check-double me-1"></i>Receive
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-5 bg-light rounded">
        <i class="fas fa-file-invoice-dollar fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">Belum Ada Purchase Order</h5>
        <p class="text-muted mb-3">Mulai dengan membuat PO untuk makanan berat</p>
        <a href="{{ route('tenant.po.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Buat PO Baru
        </a>
    </div>
    @endif
</div>

<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.25rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .container {
            padding-left: 12px;
            padding-right: 12px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.1rem;
        }

        .stat-number {
            font-size: 1.25rem;
        }
    }
</style>
@endsection