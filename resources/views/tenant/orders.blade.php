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
                    <a href="{{ route('tenant.orders') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
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
            'pending_cash' => ['label' => 'Tunai', 'class' => 'info'],
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
                                        @foreach($order->orderItems as $item)
                                            <span class="badge bg-light text-dark me-1 mb-1" style="font-size: 0.75rem;">
                                                {{ $item->quantity }}x {{ $item->menu->nama_menu ?? '-' }}
                                            </span>
                                        @endforeach
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
                                                <button type="submit" class="btn btn-sm btn-info text-white" title="Konfirmasi pembayaran tunai">
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
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
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