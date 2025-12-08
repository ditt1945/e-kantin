@extends('layouts.app')

@section('content')
<div class="container py-3 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                </div>
            @endif

            {{-- Payment Header --}}
            <div class="mb-3 mb-md-4">
                <h2 class="payment-title">
                    <i class="fas fa-credit-card me-2" style="color: var(--primary);"></i>Pembayaran
                </h2>
                <p class="payment-subtitle d-none d-md-block">Selesaikan pembayaran untuk pesanan Anda</p>
            </div>

            {{-- Order Summary Card --}}
            <div class="card mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.08) 0%, rgba(var(--primary-rgb), 0.04) 100%); border-bottom: 2px solid var(--border-gray);">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart me-2" style="color: var(--primary);"></i>Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small style="color: var(--text-secondary);">Kode Pesanan</small>
                        <p style="font-weight: 700; font-size: 1.1rem; color: var(--text-primary);">{{ $order->kode_pesanan }}</p>
                    </div>

                    <div class="mb-3">
                        <small style="color: var(--text-secondary);">Kantin</small>
                        <p style="font-weight: 600; color: var(--text-primary);">{{ $order->tenant->nama_tenant }}</p>
                    </div>

                    <div style="background: var(--light-gray); padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                        @foreach($order->orderItems as $item)
                        <div class="d-flex justify-content-between mb-2" style="padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-gray);">
                            <span>{{ $item->quantity }}x {{ $item->menu->nama_menu }}</span>
                            <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                        </div>
                        @endforeach
                    </div>

                    {{-- Voucher Section --}}
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <small style="color: var(--text-secondary); font-weight: 600;">Voucher</small>
                            @if($payment->voucher_code)
                                <span class="badge bg-success text-uppercase">{{ $payment->voucher_code }}</span>
                            @endif
                        </div>
                        @if(!$payment->voucher_code)
                            <form action="{{ route('payment.voucher.apply', $order) }}" method="POST" class="d-flex gap-2 flex-column flex-sm-row">
                                @csrf
                                <input type="text" name="voucher_code" value="{{ old('voucher_code') }}" class="form-control" placeholder="Masukkan kode voucher">
                                <button class="btn btn-primary w-100 w-sm-auto" type="submit">
                                    <i class="fas fa-tag me-1"></i>Gunakan
                                </button>
                            </form>
                            @error('voucher_code')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        @else
                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <div class="flex-grow-1" style="background: rgba(var(--primary-rgb), 0.05); border-radius: 10px; padding: 0.75rem;">
                                    <p class="mb-0" style="font-weight: 600; color: var(--text-primary);">
                                        <i class="fas fa-badge-percent me-1"></i>Voucher diterapkan: {{ $payment->voucher_details['description'] ?? 'Diskon spesial' }}
                                    </p>
                                </div>
                                <form action="{{ route('payment.voucher.remove', $order) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger w-100" type="submit"><i class="fas fa-times me-1"></i>Batalkan</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div style="border-top: 2px solid var(--border-gray); padding-top: 1rem;">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: var(--text-secondary);">Subtotal</span>
                            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        @if($payment->discount_amount > 0)
                        <div class="d-flex justify-content-between mb-2" style="color: var(--success); font-weight: 600;">
                            <span>Potongan Voucher</span>
                            <span>- Rp {{ number_format($payment->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between" style="border-top: 1px solid var(--border-gray); padding-top: 1rem; font-weight: 700; font-size: 1.2rem;">
                            <span>Total</span>
                            <span style="color: var(--primary);">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Method Card --}}
            <div class="card mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.08) 0%, rgba(var(--primary-rgb), 0.04) 100%); border-bottom: 2px solid var(--border-gray);">
                    <h5 class="mb-0">
                        <i class="fas fa-wallet me-2" style="color: var(--primary);"></i>Metode Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    @if($payment->status === 'completed')
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Pembayaran Berhasil!</strong> Pesanan Anda telah dibayarkan.
                        </div>
                    @elseif($payment->status === 'pending_cash')
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Menunggu Pembayaran Tunai</strong>
                            <p class="mb-0 mt-2">Silakan bayar secara tunai di kantin <strong>{{ $order->tenant->nama_tenant }}</strong>. Tunjukkan kode pesanan Anda kepada penjual.</p>
                        </div>
                        <div class="text-center mt-3">
                            <div class="order-code-display">
                                <small class="text-muted d-block mb-1">Kode Pesanan:</small>
                                <span class="display-6 fw-bold" style="color: var(--primary); letter-spacing: 2px;">{{ $order->kode_pesanan }}</span>
                            </div>
                        </div>
                    @elseif($payment->status === 'failed')
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Pembayaran Gagal.</strong> Silakan coba lagi.
                        </div>
                    @else
                        {{-- Payment Method Selection --}}
                        <div class="payment-method-selection mb-4">
                            <p class="text-center mb-3" style="color: var(--text-secondary); font-size: 0.9rem;">
                                Pilih metode pembayaran yang Anda inginkan:
                            </p>
                            
                            <div class="row g-3">
                                {{-- Cashless Option --}}
                                <div class="col-12 col-md-6">
                                    <div class="payment-option" id="option-cashless" onclick="selectPaymentMethod('cashless')">
                                        <div class="payment-option-icon">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="payment-option-content">
                                            <h6 class="mb-1">Cashless</h6>
                                            <small class="text-muted">QRIS, E-Wallet, Transfer Bank</small>
                                        </div>
                                        <div class="payment-option-check">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Cash Option --}}
                                <div class="col-12 col-md-6">
                                    <div class="payment-option" id="option-cash" onclick="selectPaymentMethod('cash')">
                                        <div class="payment-option-icon cash-icon">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <div class="payment-option-content">
                                            <h6 class="mb-1">Tunai / Cash</h6>
                                            <small class="text-muted">Bayar langsung di kantin</small>
                                        </div>
                                        <div class="payment-option-check">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Cashless Payment Section --}}
                        <div id="cashless-section" class="payment-section" style="display: none;">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg" id="payNowButton">
                                    <i class="fas fa-lock me-2"></i>Bayar via Midtrans
                                </button>
                                @if($redirectUrl)
                                    <a href="{{ $redirectUrl }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">
                                        <i class="fas fa-external-link-alt me-1"></i>Buka Halaman Pembayaran
                                    </a>
                                @endif
                            </div>
                            <p class="text-center mt-2 mb-0" style="color: var(--text-secondary); font-size: 0.8rem;">
                                <i class="fas fa-shield-alt me-1"></i>Pembayaran aman melalui Midtrans
                            </p>
                        </div>

                        {{-- Cash Payment Section --}}
                        <div id="cash-section" class="payment-section" style="display: none;">
                            <div class="alert alert-info mb-3" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Petunjuk Pembayaran Tunai:</strong>
                                <ol class="mb-0 mt-2 ps-3">
                                    <li>Tekan tombol "Konfirmasi Bayar Tunai" di bawah</li>
                                    <li>Kunjungi kantin <strong>{{ $order->tenant->nama_tenant }}</strong></li>
                                    <li>Tunjukkan kode pesanan Anda</li>
                                    <li>Bayar sebesar <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong></li>
                                    <li>Penjual akan mengkonfirmasi pembayaran Anda</li>
                                </ol>
                            </div>
                            <form action="{{ route('payment.cash', $order) }}" method="POST">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" id="payCashButton">
                                        <i class="fas fa-money-bill-wave me-2"></i>Konfirmasi Bayar Tunai
                                    </button>
                                </div>
                            </form>
                            <p class="text-center mt-2 mb-0" style="color: var(--text-secondary); font-size: 0.8rem;">
                                <i class="fas fa-store me-1"></i>Pesanan akan diproses setelah pembayaran dikonfirmasi penjual
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('customer.orders') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Pesanan
                </a>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-1"></i>Dashboard
                </a>
                @if($payment->isPaid())
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Selesai dan Kembali ke Dashboard
                    </a>
                @elseif($payment->status !== 'failed')
                    <a href="{{ route('payment.verify', $order) }}" class="btn btn-primary">
                        <i class="fas fa-sync me-1"></i>Verifikasi Pembayaran
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if($payment->status !== 'completed' && $payment->status !== 'failed' && $payment->status !== 'pending_cash' && $snapToken)
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
    // Payment method selection
    function selectPaymentMethod(method) {
        // Remove active from all options
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
        
        // Hide all payment sections
        document.querySelectorAll('.payment-section').forEach(el => el.style.display = 'none');
        
        // Activate selected option and show corresponding section
        if (method === 'cashless') {
            document.getElementById('option-cashless').classList.add('active');
            document.getElementById('cashless-section').style.display = 'block';
        } else if (method === 'cash') {
            document.getElementById('option-cash').classList.add('active');
            document.getElementById('cash-section').style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('payNowButton');
        if (!payButton) return;

        const verificationUrl = "{{ route('payment.verify', $order) }}";
        const fallbackUrl = "{{ $redirectUrl ?? '' }}";

        const startPayment = () => {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function () {
                    window.location.href = verificationUrl;
                },
                onPending: function () {
                    alert('Pembayaran pending. Mohon selesaikan di halaman Midtrans.');
                },
                onError: function () {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function () {
                    if (fallbackUrl) {
                        if (confirm('Pembayaran ditutup. Buka ulang halaman pembayaran?')) {
                            window.open(fallbackUrl, '_blank');
                        }
                    }
                }
            });
        };

        payButton.addEventListener('click', function (event) {
            event.preventDefault();
            startPayment();
        });
    });
</script>
@endif

@endsection

@push('styles')
<style>
    .payment-title {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 0.3rem;
    }
    .payment-subtitle {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }
    
    /* Payment Method Selection Styles */
    .payment-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 2px solid var(--border-gray);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
    }
    
    .payment-option:hover {
        border-color: var(--primary);
        background: rgba(var(--primary-rgb), 0.02);
    }
    
    .payment-option.active {
        border-color: var(--primary);
        background: rgba(var(--primary-rgb), 0.05);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
    }
    
    .payment-option-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: #fff;
        border-radius: 12px;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    
    .payment-option-icon.cash-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .payment-option-content {
        flex-grow: 1;
    }
    
    .payment-option-content h6 {
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }
    
    .payment-option-content small {
        font-size: 0.8rem;
    }
    
    .payment-option-check {
        font-size: 1.3rem;
        color: var(--primary);
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.3s ease;
    }
    
    .payment-option.active .payment-option-check {
        opacity: 1;
        transform: scale(1);
    }
    
    .payment-section {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .order-code-display {
        background: rgba(var(--primary-rgb), 0.05);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px dashed var(--primary);
    }
    
    @media (max-width: 768px) {
        .payment-title {
            font-size: 1.5rem;
        }
        .card-header h5 {
            font-size: 0.95rem;
        }
        .card-body {
            padding: 1rem !important;
        }
        .btn-lg {
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
        }
        .d-flex.flex-wrap.gap-2 {
            gap: 0.5rem !important;
        }
        .d-flex.flex-wrap.gap-2 .btn {
            flex: 1 1 auto;
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
        }
        .payment-option {
            padding: 0.75rem;
            gap: 0.75rem;
        }
        .payment-option-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        .payment-option-content h6 {
            font-size: 0.9rem;
        }
        .payment-option-check {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 576px) {
        .payment-title {
            font-size: 1.3rem;
        }
        .payment-title i {
            font-size: 1.1rem;
        }
        .d-flex.flex-wrap.gap-2 {
            flex-direction: column;
        }
        .d-flex.flex-wrap.gap-2 .btn {
            width: 100%;
        }
        .form-control {
            font-size: 0.9rem;
        }
        .order-code-display .display-6 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

