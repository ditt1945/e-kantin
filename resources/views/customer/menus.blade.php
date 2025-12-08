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
                    if(auth()->check()) {
                        $userCarts = \App\Models\Cart::where('user_id', auth()->id())->get();
                        foreach($userCarts as $cart) {
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
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('customer.tenants') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-store"></i>
                    <span class="d-none d-sm-inline ms-1">Tenant</span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($menus->count() > 0)
    <div class="row g-4">
        @foreach($menus as $menu)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" style="border: 1px solid var(--border-gray); border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">
                <div class="hero-strip" style="height: 200px; background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.1) 0%, rgba(var(--success-rgb), 0.1) 100%); display: flex; align-items: center; justify-content: center; border-radius: 0; position: relative; overflow: hidden;">
                    @if($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.parentElement.querySelector('.image-placeholder').style.display='flex'; this.style.display='none';">
                    @endif
                    <div class="image-placeholder" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: {{ $menu->gambar ? 'none' : 'flex' }}; align-items: center; justify-content: center;">
                        <i class="fas fa-image fa-3x" style="color: var(--primary); opacity: 0.3;"></i>
                    </div>
                    @if(!$menu->is_available)
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center;">
                        <span style="color: white; font-weight: 700; font-size: 1rem;">Habis</span>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title clamp-1" style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">{{ $menu->nama_menu }}</h5>
                    <p class="card-text clamp-2" style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem;">{{ Str::limit($menu->deskripsi ?? 'Menu spesial dari ' . $tenant->nama_tenant, 50) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-start mb-2 p-2" style="background: var(--light-gray); border-radius: 8px;">
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Harga</small>
                            <strong style="font-size: 1.1rem; color: var(--primary);">Rp {{ number_format($menu->harga, 0, ',', '.') }}</strong>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $menu->is_available ? 'success' : 'danger' }} mb-1" style="font-size: 0.7rem;">
                                {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                            </span>
                            @if($menu->is_available)
                            <small class="d-block text-muted" style="font-size: 0.75rem;">Stok: {{ $menu->stok }}</small>
                            @endif
                        </div>
                    </div>
                    
                    @if($menu->is_available)
                    <form action="{{ route('customer.add_to_cart', ['tenant' => $tenant, 'menu' => $menu]) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0" style="font-size: 0.8rem; font-weight: 600; white-space: nowrap;">Qty:</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $menu->stok }}" 
                                    class="form-control form-control-sm" required style="width: 60px; text-align: center; font-weight: 600;">
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

    <div class="card mt-5" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border: none; color: white;">
        <div class="card-body text-center py-4">
            <h5 class="card-title" style="font-weight: 700; color: white; margin-bottom: 0.5rem;">Siap untuk Checkout?</h5>
            <p style="font-size: 0.95rem; margin-bottom: 1rem; opacity: 0.95;">Lihat keranjang Anda dan selesaikan pemesanan</p>
            <a href="{{ route('customer.cart') }}" class="btn btn-light" style="font-weight: 600;">
                <i class="fas fa-arrow-right me-2"></i>Ke Keranjang
            </a>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-utensils fa-4x" style="color: var(--border-gray); margin-bottom: 1rem;"></i>
        <h4 style="color: var(--text-secondary); font-weight: 700;">Belum ada menu</h4>
        <p style="color: var(--text-secondary); font-size: 0.95rem;">Tenant {{ $tenant->nama_tenant }} belum menambahkan menu.</p>
        <a href="{{ route('customer.tenants') }}" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left me-1"></i>Lihat Tenant Lain
        </a>
    </div>
    @endif
</div>

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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto increment/decrement dengan hover
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const maxStock = parseInt(this.getAttribute('max'));
            const quantity = parseInt(this.value);
            if (quantity > maxStock) this.value = maxStock;
            if (quantity < 1) this.value = 1;
        });
    });
});
</script>
@endpush

