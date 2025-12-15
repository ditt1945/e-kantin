@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="page-title mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Keranjang</h2>
            <p class="text-muted small mb-0 d-none d-md-block">Cek kembali pesanan Anda sebelum checkout</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-home me-1"></i><span class="d-none d-sm-inline">Dashboard</span>
            </a>
            <a href="{{ route('customer.tenants') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i><span class="d-none d-sm-inline">Belanja</span>
            </a>
        </div>
    </div>

    {{-- Flash messages --}}
    <!-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif -->

    {{-- Stock warnings after auto-sync --}}
    @if(!empty($stockWarnings))
        <div class="alert alert-warning">
            <strong>Penyesuaian stok otomatis:</strong>
            <ul class="mb-0 mt-2">
                @foreach($stockWarnings as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($carts->count() > 0)
        @foreach($carts as $cart)
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-store me-2 text-primary"></i>{{ $cart->tenant?->nama_tenant ?? 'Tenant tidak ditemukan' }}
                        </h5>
                        <small class="text-muted">{{ $cart->items->count() }} item</small>
                    </div>
                </div>
                <div class="card-body p-2 p-md-3">
                    {{-- Mobile-friendly item list --}}
                    <div class="cart-items">
                        @foreach($cart->items as $item)
                            @php
                                $menu = $item->menu;
                                $availableStock = $menu?->stok ?? 0;
                            @endphp
                            <div class="cart-item d-flex align-items-start gap-2 p-2 mb-2" style="background: var(--light-gray); border-radius: 10px;">
                                <div class="flex-grow-1">
                                    <strong class="d-block" style="font-size: 0.95rem;">{{ $menu?->nama_menu ?? 'Menu tidak tersedia' }}</strong>
                                    <small class="text-muted">{{ $menu?->category?->nama_kategori ?? '-' }}</small>
                                    <div class="mt-1">
                                        <span style="color: var(--text-secondary); font-size: 0.85rem;">@ Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        <strong class="ms-2" style="color: var(--primary);">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                                    </div>
                                    @if($availableStock === 0)
                                        <small class="text-danger fw-semibold d-block mt-1">Stok habis!</small>
                                    @elseif($availableStock < $item->quantity)
                                        <small class="text-danger fw-semibold d-block mt-1">Stok: {{ $availableStock }}</small>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <form action="{{ route('customer.update_cart_item', $item) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input 
    type="number" 
    name="quantity" 
    value="{{ $item->quantity }}"
    min="1" 
    max="{{ max(1, $availableStock) }}"
    class="text-center fw-semibold"
    @if($availableStock === 0) readonly @endif
    style="
        width: 60px;
        padding: 6px 8px;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
        border: 2px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: all 0.2s ease;
    "
>

                                    </form>
                                    <form action="{{ route('customer.remove_cart_item', $item) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" style="padding: 0.25rem 0.5rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Total</span>
                            <span class="fw-bold fs-5" style="color: var(--primary);">Rp {{ number_format($cart->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                        <a href="{{ route('customer.tenants') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah
                        </a>
                        @php $tenantNameForConfirm = addslashes($cart->tenant?->nama_tenant ?? 'tenant ini'); @endphp
                        <form action="{{ route('customer.checkout', $cart) }}" method="POST" class="flex-grow-1" id="checkout-form-{{ $cart->id }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return handleCheckout(this, '{{ $tenantNameForConfirm }}')">
                                <i class="fas fa-check me-1"></i>
                                <span class="btn-text">Checkout</span>
                                <div class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h4 class="fw-bold">Keranjang Belanja Kosong</h4>
            <p class="text-muted">Mulai pesan makanan dari tenant favorit Anda</p>
            <a href="{{ route('customer.tenants') }}" class="btn btn-primary">
                <i class="fas fa-store me-2"></i>Pilih Tenant
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="quantity"]').forEach((input) => {
        input.addEventListener('change', function () {
            const form = this.closest('form');
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                const spinner = button.querySelector('.spinner-border');
                const btnText = button.querySelector('.btn-text');
                if (spinner && btnText) {
                    button.disabled = true;
                    spinner.classList.remove('d-none');
                    btnText.textContent = 'Menyimpan...';
                }
            }
            form.submit();
        });
    });
});

function handleCheckout(button, tenantName) {
    if (!confirm('Checkout pesanan dari ' + tenantName + '?')) {
        return false;
    }

    const form = button.closest('form');
    const spinner = button.querySelector('.spinner-border');
    const btnText = button.querySelector('.btn-text');

    // Show loading state
    button.disabled = true;
    if (spinner) spinner.classList.remove('d-none');
    if (btnText) btnText.textContent = 'Memproses...';

    // Submit form after small delay to ensure UI updates
    setTimeout(function() {
        form.submit();
    }, 100);

    return false; // Prevent default submit, we handle it manually
}
</script>

<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.2rem;
        }
        
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }
    }
</style>
@endpush
