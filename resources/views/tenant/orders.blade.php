@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="orders-title mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Pesanan</h2>
            <div class="text-muted small d-none d-md-block">{{ $tenant->nama_tenant }} - Kelola pesanan masuk</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Kembali</span>
            </a>
        </div>
    </div>

    {{-- Date Filter --}}
    <form method="GET" action="{{ route('tenant.orders') }}" class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-end">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <div class="col-6 col-md-3">
                    <label class="form-label small text-muted mb-1">Dari</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label small text-muted mb-1">Sampai</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary w-100">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('tenant.orders') }}" class="btn btn-sm btn-outline-secondary w-100">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- Status filters --}}
    @php
        $currentStatus = request('status');
        $statuses = [
            'all' => ['label' => 'Semua', 'class' => 'secondary'],
            'pending' => ['label' => 'Menunggu', 'class' => 'primary'],
            'pending_cash' => ['label' => 'Tunai', 'class' => 'cash'],
            'diproses' => ['label' => 'Diproses', 'class' => 'warning'],
            'selesai' => ['label' => 'Selesai', 'class' => 'success'],
            'dibatalkan' => ['label' => 'Batal', 'class' => 'danger'],
        ];
    @endphp

    <div class="d-flex flex-wrap gap-1 mb-3">
        @foreach($statuses as $key => $s)
            @php $isActive = ($currentStatus == $key) || ($key=='all' && empty($currentStatus)); @endphp
            <a href="{{ $key == 'all' ? route('tenant.orders') : route('tenant.orders', ['status' => $key]) }}" 
               class="btn btn-sm {{ $isActive ? 'btn-' . $s['class'] : 'btn-outline-' . $s['class'] }}">
                {{ $s['label'] }}
            </a>
        @endforeach
    </div>

    @if($orders->count() > 0)
        <div class="row g-3">
            @foreach($orders as $order)
                @php
                    $borderClass = 'border-start border-4 ';
                    switch($order->status) {
                        case 'pending': $borderClass .= 'border-primary'; break;
                        case 'pending_cash': $borderClass .= 'border-info'; break;
                        case 'diproses': $borderClass .= 'border-warning'; break;
                        case 'selesai': $borderClass .= 'border-success'; break;
                        case 'dibatalkan': $borderClass .= 'border-danger'; break;
                        default: $borderClass .= 'border-secondary';
                    }

                    $badgeClass = match($order->status) {
                        'selesai' => 'success',
                        'diproses' => 'warning',
                        'pending' => 'primary',
                        'pending_cash' => 'info',
                        'dibatalkan' => 'danger',
                        default => 'secondary',
                    };
                @endphp

                <div class="col-12" id="order-{{ $order->id }}">
                    <div class="card {{ $borderClass }}">
                        <div class="card-body p-2 p-md-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between">
                                {{-- Order Info --}}
                                <div class="flex-grow-1 mb-2 mb-md-0">
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                        <h6 class="mb-0 fw-bold">{{ $order->kode_pesanan ?? '-' }}</h6>
                                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                                    </div>
                                    <div class="text-muted small mb-1">
                                        <i class="fas fa-user me-1"></i>{{ $order->user->name ?? '-' }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-clock me-1"></i>{{ optional($order->created_at)->format('d M H:i') }}
                                    </div>
                                    <div class="mt-2">
                                        <div class="order-items-container">
                                            @foreach($order->orderItems as $index => $item)
                                                <div class="order-item-badge">
                                                    <span class="item-quantity">{{ $item->quantity }}x</span>
                                                    <span class="item-name">{{ $item->menu->nama_menu ?? '-' }}</span>
                                                    <span class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Price & Actions --}}
                                <div class="d-flex flex-column align-items-start align-items-md-end">
                                    <div class="fw-bold text-primary mb-2" style="font-size: 1.1rem;">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </div>
                                    <div class="d-flex flex-wrap gap-1">
                                        @if($order->status === 'pending_cash')
                                            {{-- Cash Payment - Show Confirm Button --}}
                                            <form action="{{ route('tenant.orders.confirm_cash', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-cash text-white" title="Konfirmasi pembayaran tunai">
                                                    <i class="fas fa-money-bill-wave me-1"></i>
                                                    <span class="d-none d-md-inline">Konfirmasi Tunai</span>
                                                    <span class="d-md-none">Tunai</span>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('tenant.orders.update_status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="dibatalkan">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times d-md-none"></i>
                                                    <span class="d-none d-md-inline">Batal</span>
                                                </button>
                                            </form>
                                        @elseif($order->status !== 'selesai' && $order->status !== 'dibatalkan')
                                            <form action="{{ route('tenant.orders.update_status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="diproses">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-sync-alt d-md-none"></i>
                                                    <span class="d-none d-md-inline">Proses</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('tenant.orders.update_status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check d-md-none"></i>
                                                    <span class="d-none d-md-inline">Selesai</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('tenant.orders.update_status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="dibatalkan">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times d-md-none"></i>
                                                    <span class="d-none d-md-inline">Batal</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-{{ $badgeClass }} py-2 px-3">
                                                <i class="fas fa-{{ $order->status === 'selesai' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Info -->
        @if($orders->hasPages())
            <div class="d-flex flex-column align-items-center mt-4">
                <div class="pagination-info">
                    Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                </div>
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada pesanan</h4>
            <p class="text-muted">Belum ada customer yang memesan.</p>
        </div>
    @endif
</div>

<style>
    .orders-title {
        font-size: 1.5rem;
        font-weight: 600;
    }

    /* Pending cash visual treatment */
    .btn-cash {
        background: linear-gradient(135deg, #0ea5e9, #06b6d4);
        border-color: #0ea5e9;
        color: #fff;
        box-shadow: 0 6px 18px rgba(6, 182, 212, 0.35);
    }

    .btn-cash:hover,
    .btn-cash:focus {
        color: #fff;
        box-shadow: 0 8px 22px rgba(6, 182, 212, 0.45);
    }

    .btn-outline-cash {
        color: #0ea5e9;
        border-color: #0ea5e9;
    }

    .btn-outline-cash:hover,
    .btn-outline-cash:focus {
        background: linear-gradient(135deg, #0ea5e9, #06b6d4);
        color: #fff;
        box-shadow: 0 6px 18px rgba(6, 182, 212, 0.35);
    }

    .badge.bg-cash {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.95), rgba(6, 182, 212, 0.95));
        color: #fff;
    }

    /* Dark mode styles for cash badge and button */
    [data-theme="dark"] .badge.bg-cash {
        background: linear-gradient(135deg, #0284C7, #0369A1) !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(2, 132, 199, 0.3);
    }

    [data-theme="dark"] .btn-cash {
        background: linear-gradient(135deg, #0284C7, #0369A1) !important;
        border-color: #0284C7 !important;
        color: #ffffff !important;
        box-shadow: 0 6px 18px rgba(2, 132, 199, 0.35);
    }

    [data-theme="dark"] .btn-cash:hover,
    [data-theme="dark"] .btn-cash:focus {
        background: linear-gradient(135deg, #0369A1, #075985) !important;
        color: #ffffff !important;
        box-shadow: 0 8px 22px rgba(2, 132, 199, 0.45);
    }

    [data-theme="dark"] .border-cash {
        border-color: #0284C7 !important;
    }

    /* Dark mode for order item badges */
    [data-theme="dark"] .badge.bg-light {
        background: rgba(148, 163, 184, 0.2) !important;
        color: #f1f5f9 !important;
        border: 1px solid rgba(148, 163, 184, 0.3);
    }

    /* Improved Order Items UI */
    .order-items-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .order-item-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .order-item-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .item-quantity {
        background: var(--primary);
        color: white;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
        min-width: 28px;
        text-align: center;
    }

    .item-name {
        font-weight: 500;
        color: var(--text-primary);
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .item-price {
        font-weight: 600;
        color: var(--success);
        font-size: 0.75rem;
        background: rgba(22, 163, 74, 0.1);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
    }

    /* Dark mode for order items */
    [data-theme="dark"] .order-item-badge {
        background: linear-gradient(135deg, #334155 0%, #475569 100%);
        border-color: rgba(71, 85, 105, 0.5);
    }

    [data-theme="dark"] .order-item-badge:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    [data-theme="dark"] .item-name {
        color: #f1f5f9;
    }

    [data-theme="dark"] .item-price {
        background: rgba(22, 163, 74, 0.2);
        color: #4ADE80;
    }

    .border-cash {
        border-color: #0ea5e9 !important;
    }
    
    @media (max-width: 768px) {
        .orders-title {
            font-size: 1.25rem;
        }
        
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }
    }
    
    @media (max-width: 576px) {
        .orders-title {
            font-size: 1.1rem;
        }
        
        /* Status filter buttons more compact */
        .d-flex.flex-wrap.gap-1 .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        /* Card adjustments */
        .card-body {
            padding: 0.75rem !important;
        }
        
        /* Price styling */
        .text-primary.fw-bold {
            font-size: 1rem !important;
        }
        
        /* Order item badges */
        .badge.bg-light {
            font-size: 0.7rem !important;
        }

        /* Order items responsive */
        .order-item-badge {
            padding: 0.3rem 0.5rem !important;
            font-size: 0.7rem !important;
            gap: 0.3rem !important;
        }

        .item-quantity {
            font-size: 0.65rem !important;
            min-width: 24px !important;
            padding: 0.15rem 0.3rem !important;
        }

        .item-name {
            max-width: 100px !important;
            font-size: 0.7rem !important;
        }

        .item-price {
            font-size: 0.65rem !important;
            padding: 0.15rem 0.3rem !important;
        }
    }
    
    @media (max-width: 400px) {
        .orders-title {
            font-size: 1rem;
        }
        
        /* Even more compact on very small screens */
        .d-flex.flex-wrap.gap-1 .btn {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }
    }
</style>
@endsection