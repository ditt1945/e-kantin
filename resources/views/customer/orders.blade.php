@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="mb-4 mb-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="orders-title">
                    <i class="fas fa-history me-2" style="color: var(--primary);"></i>Riwayat Pesanan
                </h2>
                <p class="orders-subtitle d-none d-md-block">Lihat semua pesanan yang telah Anda buat</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-home me-1"></i><span class="d-none d-sm-inline">Dashboard</span>
                </a>
                <button onclick="history.back()" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Kembali</span>
                </button>
            </div>
        </div>
    </div>

@if($orders->count() > 0)
    <div class="row g-3">
        @foreach($orders as $order)
        @php
            $badgeClass = match($order->status) {
                'selesai' => 'success',
                'diproses' => 'warning',
                'pending' => 'primary',
                'pending_cash' => 'info',
                'dibatalkan' => 'danger',
                default => 'secondary',
            };
            $colorMap = [
                'success' => '#B6CEB4',
                'warning' => '#D9E9CF',
                'primary' => '#96A78D',
                'info' => '#0EA5E9',
                'danger' => '#6f7d63',
                'secondary' => '#F0F0F0',
            ];
            $borderColor = $colorMap[$badgeClass] ?? '#64748b';
            $payment = $order->payment;
        @endphp
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3 order-status-border order-border-{{ $badgeClass }}">
                        <div>
                            <h6 class="mb-1 fw-bold">{{ $order->kode_pesanan ?? '-' }}</h6>
                            <small class="text-muted">{{ $order->tenant->nama_tenant ?? '-' }} • {{ optional($order->created_at)->format('d M Y H:i') }}</small>
                        </div>
                        <span class="badge bg-{{ $badgeClass }}">
                            <i class="fas fa-check me-1"></i>{{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        @foreach($order->orderItems as $it)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted">{{ $it->quantity }}x {{ $it->menu->nama_menu ?? '-' }}</span>
                                <strong>Rp {{ number_format($it->subtotal, 0, ',', '.') }}</strong>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <small class="text-muted">Total</small>
                            <div class="fs-5 fw-bold text-primary">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</div>
                            @if($payment)
                                <small class="d-block text-muted">
                                    Invoice: {{ $payment->invoice_number }}
                                    @if($payment->isPaid())
                                        <span class="badge bg-success ms-2">Lunas</span>
                                    @elseif($payment->isFailed())
                                        <span class="badge bg-danger ms-2">Gagal</span>
                                    @elseif($payment->status === 'pending_cash')
                                        <span class="badge bg-info ms-2">Menunggu Pembayaran Tunai</span>
                                    @else
                                        <span class="badge bg-warning text-dark ms-2">Menunggu Pembayaran</span>
                                    @endif
                                </small>
                                @if($payment->payment_method === 'cash')
                                    <small class="d-block text-info">
                                        <i class="fas fa-money-bill-wave me-1"></i>Metode: Tunai
                                    </small>
                                @elseif($payment->payment_method === 'midtrans')
                                    <small class="d-block text-info">
                                        <i class="fas fa-credit-card me-1"></i>Metode: Cashless
                                    </small>
                                @endif
                            @endif
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            @if($payment)
                                @if($payment->isPaid())
                                    {{-- Already paid - show success badge and invoice download --}}
                                    <span class="badge bg-success py-2 px-3 d-flex align-items-center">
                                        <i class="fas fa-check-circle me-1"></i>Lunas
                                        @if($payment->payment_method === 'cash')
                                            <i class="fas fa-money-bill-wave ms-1"></i>
                                        @endif
                                    </span>
                                    <a href="{{ route('payment.invoice', $payment) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-invoice me-1"></i>Unduh Invoice
                                    </a>
                                @elseif($payment->isFailed())
                                    {{-- Payment failed --}}
                                    <span class="badge bg-danger py-2 px-3 d-flex align-items-center">
                                        <i class="fas fa-times-circle me-1"></i>Gagal
                                    </span>
                                @elseif($payment->status === 'pending_cash')
                                    {{-- Cash payment pending --}}
                                    <span class="badge bg-info py-2 px-3">
                                        <i class="fas fa-money-bill-wave me-1"></i>Bayar Tunai di Kantin
                                    </span>
                                    <a href="{{ route('payment.show', $order) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-qrcode me-1"></i>Lihat Kode Pesanan
                                    </a>
                                @else
                                    {{-- Payment pending - show pay button --}}
                                    <a href="{{ route('payment.show', $order) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-credit-card me-1"></i>Bayar Sekarang
                                    </a>
                                    <a href="{{ route('payment.verify', $order) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-sync-alt me-1"></i>Cek Status
                                    </a>
                                @endif
                            @else
                                {{-- No payment record --}}
                                <span class="badge bg-secondary py-2 px-3">Belum ada pembayaran</span>
                            @endif

                            @if(($order->status === 'pending' || $order->status === 'pending_cash') && (!$payment || !$payment->isPaid()))
                                <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Batalkan pesanan ini?')">
                                        <i class="fas fa-times me-1"></i>Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($orders->hasPages())
        <div class="pagination-info">
            Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
        </div>
        <div class="d-flex justify-content-center mb-4">
            {{ $orders->links() }}
        </div>
    @endif
@else
<div class="text-center py-5">
    <i class="fas fa-history fa-4x text-muted mb-3"></i>
    <h4 class="text-muted">Belum ada riwayat pesanan</h4>
    <p class="text-muted">Mulai pesan dari tenant untuk melihat riwayat pesanan di sini.</p>
    <a href="{{ route('customer.tenants') }}" class="btn btn-primary">
        <i class="fas fa-store me-2"></i>Telusuri Tenant
    </a>
</div>
@endif

@endsection

@push('styles')
<style>
    .orders-title {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 0.3rem;
    }
    .orders-subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }
    .order-status-border {
        border-left: 4px solid #dee2e6;
        padding-left: 1rem;
    }
    .order-border-success { border-left-color: #198754 !important; }
    .order-border-warning { border-left-color: #ffc107 !important; }
    .order-border-primary { border-left-color: #0d6efd !important; }
    .order-border-info { border-left-color: #0dcaf0 !important; }
    .order-border-danger { border-left-color: #dc3545 !important; }
    .order-border-secondary { border-left-color: #6c757d !important; }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .container.py-5 {
            padding-top: 1rem !important;
            padding-bottom: 1.5rem !important;
        }
        .orders-title {
            font-size: 1.4rem;
        }
        .card-body {
            padding: 1rem !important;
        }
        .order-status-border {
            padding-left: 0.75rem;
            border-left-width: 4px;
        }
        .order-status-border h6 {
            font-size: 0.9rem !important;
        }
        .order-status-border small {
            font-size: 0.75rem !important;
        }
        .order-status-border .badge {
            font-size: 0.7rem !important;
            padding: 0.25rem 0.5rem !important;
        }
        .d-flex.justify-content-between.align-items-center.flex-wrap.gap-3 {
            gap: 0.75rem !important;
        }
        .d-flex.flex-wrap.gap-2 {
            gap: 0.5rem !important;
            width: 100%;
        }
        .d-flex.flex-wrap.gap-2 .btn,
        .d-flex.flex-wrap.gap-2 .badge {
            font-size: 0.75rem !important;
            padding: 0.4rem 0.6rem !important;
        }
        .d-flex.flex-wrap.gap-2 .btn i,
        .d-flex.flex-wrap.gap-2 .badge i {
            font-size: 0.7rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .orders-title {
            font-size: 1.25rem;
        }
        .orders-title i {
            font-size: 1rem;
        }
        .d-flex.flex-wrap.gap-2 {
            flex-direction: column;
        }
        .d-flex.flex-wrap.gap-2 .btn,
        .d-flex.flex-wrap.gap-2 .badge {
            width: 100%;
            justify-content: center;
        }
    }

    </style>
@endpush
