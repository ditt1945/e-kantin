@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-2">
            <div>
                <h2 class="page-title mb-0">
                    <i class="fas fa-utensils me-2 text-primary"></i>Menu
                </h2>
                <p class="text-muted small mb-0">{{ $tenant->nama_tenant }}</p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                @php
                    $cartCount = 0;
                    if (auth()->check()) {
                        $userCarts = \App\Models\Cart::where('user_id', auth()->id())->get();
                        foreach ($userCarts as $cart) {
                            $cartCount += $cart->items->count();
                        }
                    }
                @endphp

                <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-home"></i>
                    <span class="d-none d-sm-inline ms-1">Dashboard</span>
                </a>

                <a href="{{ route('customer.cart') }}" class="btn btn-primary btn-sm position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="d-none d-sm-inline ms-1">Keranjang</span>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('customer.tenants') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-store"></i>
                    <span class="d-none d-sm-inline ms-1">Tenant</span>
                </a>
            </div>
        </div>
    </div>

    @if($menus->count() > 0)
        <div class="row g-4">
            @foreach($menus as $menu)
                <div class="col-md-6 col-lg-4">
                    <div class="menu-card card h-100">
                        <div class="hero-strip">
                            @if($menu->gambar)
                                <img
                                    src="{{ asset('storage/' . $menu->gambar) }}"
                                    alt="{{ $menu->nama_menu }}"
                                    class="menu-image"
                                    onerror="this.parentElement.querySelector('.image-placeholder').style.display='flex'; this.style.display='none';"
                                >
                            @endif

                            <div class="image-placeholder" style="display: {{ $menu->gambar ? 'none' : 'flex' }};">
                                <i class="fas fa-image fa-3x"></i>
                            </div>

                            @if(!$menu->is_available)
                                <div class="overlay-unavailable">
                                    <span>Habis</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="card-title clamp-1">{{ $menu->nama_menu }}</h5>
                            <p class="card-text clamp-2">{{ Str::limit($menu->deskripsi ?? 'Menu spesial dari ' . $tenant->nama_tenant, 50) }}</p>

                            <div class="d-flex justify-content-between align-items-start mb-2 p-2 price-block">
                                <div>
                                    <small class="text-muted d-block">Harga</small>
                                    <strong class="price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</strong>
                                </div>
                                <div class="text-end">
                                    <span class="badge mb-1 {{ $menu->is_available ? 'bg-success' : 'bg-danger' }}" style="font-size:0.7rem;">
                                        {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                                    </span>
                                    @if($menu->is_available)
                                        <small class="d-block text-muted" style="font-size:0.75rem;">Stok: {{ $menu->stok }}</small>
                                    @endif
                                </div>
                            </div>

                            @if($menu->is_available)
                                <form action="{{ route('customer.add_to_cart', ['tenant' => $tenant, 'menu' => $menu]) }}" method="POST" class="mt-2">
                                    @csrf
                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <label class="form-label mb-0" style="font-size: 0.8rem; font-weight: 600; white-space: nowrap;">Qty:</label>

                                            <!-- Inline CSS untuk input (sesuai permintaan) -->
                                            <input
                                                type="number"
                                                name="quantity"
                                                value="1"
                                                min="1"
                                                max="{{ $menu->stok }}"
                                                required
                                                style="width:60px; padding:6px 8px; text-align:center; font-weight:600; font-size:0.9rem; border:2px solid #ddd; border-radius:8px; outline:none; transition:all 0.2s ease;"
                                            >
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm flex-grow-1">
                                            <i class="fas fa-cart-plus me-1"></i>Tambah
                                        </button>
                                    </div>

                                    @error('quantity')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </form>
                            @else
                                <button class="btn btn-secondary w-100" disabled style="opacity: 0.6;">
                                    <i class="fas fa-times me-1"></i>Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card mt-5 checkout-cta width-fit mx-auto" style="max-width: 100%;">
            <div class="card-body text-center py-4">
                <h5 class="card-title">Siap untuk Checkout?</h5>
                <p>Lihat keranjang Anda dan selesaikan pemesanan</p>
                <a href="{{ route('customer.cart') }}" class="btn btn-light" style="font-weight:600;">
                    <i class="fas fa-arrow-right me-2"></i>Ke Keranjang
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-utensils fa-4x icon-empty"></i>
            <h4 style="font-weight:700;">Belum ada menu</h4>
            <p class="text-muted">Tenant {{ $tenant->nama_tenant }} belum menambahkan menu.</p>
            <a href="{{ route('customer.tenants') }}" class="btn btn-primary mt-3">
                <i class="fas fa-arrow-left me-1"></i>Lihat Tenant Lain
            </a>
        </div>
    @endif
</div>

<style>
    /* Page title */
    .page-title { font-size: 1.5rem; font-weight: 700; }

    /* Menu card */
    .menu-card {
        border: 1px solid var(--border-gray);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .hero-strip {
        height: 200px;
        background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.06) 0%, rgba(var(--success-rgb), 0.06) 100%);
        display:flex;
        align-items:center;
        justify-content:center;
        position:relative;
        overflow:hidden;
    }

    .menu-image {
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
    }

    .image-placeholder {
        position:absolute;
        top:0; left:0; right:0; bottom:0;
        align-items:center;
        justify-content:center;
        color:var(--primary);
        opacity:0.35;
        display:flex;
    }

    .overlay-unavailable {
        position:absolute;
        top:0; left:0; right:0; bottom:0;
        display:flex;
        align-items:center;
        justify-content:center;
        background:rgba(0,0,0,0.6);
    }
    .overlay-unavailable span {
        color:#fff;
        font-weight:700;
    }

    .card-title { font-weight:700; color:var(--text-primary); margin-bottom:.5rem; font-size:1rem; }
    .card-text { color:var(--text-secondary); font-size:0.9rem; margin-bottom:1rem; }

    .price-block { background:var(--light-gray); border-radius:8px; }
    .price { font-size:1.1rem; color:var(--primary); }

    .checkout-cta {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border: none; color: white;
    }
    .checkout-cta .card-title { color: white; font-weight:700; }
    .icon-empty { color: var(--border-gray); margin-bottom:1rem; opacity:0.9; }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-title { font-size: 1.2rem; }
        .container-fluid { padding-left:12px; padding-right:12px; }
    }

    /* small "clamp" helper if necessary */
    .clamp-1 { display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Validasi quantity: pastikan tidak melebihi stok dan tidak kurang dari 1
    document.querySelectorAll('input[name="quantity"]').forEach(function (input) {
        input.addEventListener('change', function () {
            const maxStock = parseInt(this.getAttribute('max') || '1', 10);
            let qty = parseInt(this.value, 10) || 1;
            if (qty > maxStock) qty = maxStock;
            if (qty < 1) qty = 1;
            this.value = qty;
        });
    });
});
</script>
@endpush
