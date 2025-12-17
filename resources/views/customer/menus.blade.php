@extends('layouts.app')

@include('partials.menu-styles')

@section('content')
<div class="container-fluid py-2">
    <!-- Compact Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('customer.tenants') }}" class="btn btn-sm btn-link text-muted p-0">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h5 mb-0 fw-bold">{{ $tenant->nama_tenant }}</h1>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge {{ $tenant->is_active ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 text-dark">
                        <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                        {{ $tenant->is_active ? 'Buka' : 'Tutup' }}
                    </span>
                    <small class="text-muted">{{ $menus->count() }} menu</small>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Cart -->
            <a href="{{ route('customer.cart') }}" class="btn btn-sm btn-primary position-relative">
                <i class="fas fa-shopping-cart me-1"></i>
                Keranjang
                @if($cartCount ?? 0 > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    <!-- Best Seller Section -->
    @php
        $bestSellers = $menus->filter(function($menu) {
            return $menu->isBestSeller();
        })->take(3);
    @endphp
    @if($bestSellers->count() > 0)
    <div class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <h5 class="mb-0 text-danger">
                🔥 Rekomendasi Terlaris
            </h5>
            <small class="text-muted">Menu paling populer di {{ $tenant->nama_tenant }}</small>
        </div>
        <div class="row g-2">
            @foreach($bestSellers as $menu)
            <div class="col-12 col-md-4">
                <div class="card border-danger" style="border-width: 2px;">
                    <div class="card-body p-3">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                @if($menu->gambar)
                                    <img src="{{ asset('storage/' . $menu->gambar) }}"
                                         alt="{{ $menu->nama_menu }}"
                                         class="rounded-2"
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="rounded-2 d-flex align-items-center justify-content-center bg-light"
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-utensils text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">
                                    {{ $menu->nama_menu }}
                                    <span class="badge bg-{{ $menu->getBestSellerBadgeColor() }}" style="font-size: 0.6rem;">
                                        {{ $menu->getBestSellerLabel() }}
                                    </span>
                                </h6>
                                <div class="fw-bold text-primary mb-1">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                <small class="text-muted">
                                    <i class="fas fa-shopping-bag me-1"></i>{{ $menu->order_count }} terjual
                                </small>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <form action="{{ route('customer.add_to_cart', [$tenant, $menu]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1" min="1" max="{{ $menu->isPoBased() ? $menu->stok : $menu->stok }}">
                                    @if($menu->isPoBased())
                                        <input type="hidden" name="is_po_order" value="1">
                                    @endif
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            @if(!$menu->canOrderNow()) disabled @endif>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Pre-Order Info Banner -->
    <div class="alert alert-info alert-sm mb-3" style="border-radius: 8px; font-size: 0.85rem;">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Pre-Order Makanan Berat:</strong> Pesan makanan berat (nasi, lauk, sayur) sebelum pukul 20:00 untuk pengambilan besok.
    </div>

    <!-- Compact Filter Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3 py-2 border-bottom">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <small class="text-muted">Filter:</small>
            <button class="btn btn-xs btn-primary active category-filter" data-category="all">
                Semua
            </button>
            <button class="btn btn-xs btn-outline-warning order-type-filter" data-type="heavy">
                🍛 Makanan Berat
            </button>
            <button class="btn btn-xs btn-outline-info order-type-filter" data-type="light">
                🍰 Cemilan
            </button>
            @foreach($categories ?? [] as $category)
                <button class="btn btn-xs btn-light category-filter" data-category="{{ $category->id }}">
                    {{ $category->nama_kategori }}
                </button>
            @endforeach
        </div>

        <div class="d-flex align-items-center gap-3">
            <small class="text-muted">{{ $menus->count() }} menu</small>
            <select class="form-select form-select-sm" id="sort-select" style="width: 130px; font-size: 0.8rem;">
                <option value="name">Urutkan</option>
                <option value="name">Nama A-Z</option>
                <option value="price-low">Harga ↓</option>
                <option value="price-high">Harga ↑</option>
                <option value="popular">Terpopuler</option>
            </select>
        </div>
    </div>

    @if($menus->count() > 0)

        <!-- Compact Menu Grid -->
        <div class="row g-3" id="menu-container">
            @foreach($menus as $menu)
                @php
                    $isHeavyMeal = $menu->isHeavyMeal();
                    $requiresPreorder = $menu->requiresPreorder();
                    $canPreorderForTomorrow = $menu->canPreorderForTomorrow();
                    $preorderMessage = $menu->getPreorderDeadlineMessage();
                    $restrictionMessage = $menu->getRestrictionMessage();
                    $canOrder = $menu->canOrderNow();
                @endphp
                <div class="col-12 col-sm-6 col-lg-4 menu-item"
                     data-category="{{ $menu->category_id ?? 'all' }}"
                     data-name="{{ strtolower($menu->nama_menu) }}"
                     data-price="{{ $menu->harga }}"
                     data-stock="{{ $menu->stok }}"
                     data-order-type="{{ $isHeavyMeal ? 'heavy' : 'light' }}">
                    <div class="menu-compact d-flex gap-3 p-3 border rounded-3 h-100 @if(!$menu->is_available) unavailable @endif @if($requiresPreorder) border-warning @endif" style="background: #fff; transition: all 0.2s;">
                        <!-- Compact Image -->
                        <div class="flex-shrink-0">
                            @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}"
                                     alt="{{ $menu->nama_menu }}"
                                     class="rounded-2"
                                     style="width: 80px; height: 80px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"
                                     loading="lazy"
                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiByeD0iOCIgZmlsbD0iI0Y1RjVGNSIvPgo8cGF0aCBkPSJNMzAgNDBIMzVWMzVIMzBWNDBaIiBmaWxsPSIjQ0NDQ0NDIi8+CjxwYXRoIGQ9Ik00NSA0MEg1MFYzNUg0NVY0MFoiIGZpbGw9IiNDQ0NDQ0MiLz4KPC9zdmc+';">
                            @else
                                <div class="rounded-2 d-flex align-items-center justify-content-center bg-light" style="width: 80px; height: 80px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <i class="fas fa-utensils text-muted"></i>
                                </div>
                            @endif

                            @if(!$menu->is_available)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-danger">Habis</span>
                                </div>
                            @elseif($requiresPreorder)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Pre-Order
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">
                                        {{ $menu->nama_menu }}
                                        @if($menu->isBestSeller())
                                            <span class="badge bg-{{ $menu->getBestSellerBadgeColor() }} ms-1" style="font-size: 0.55rem;">
                                                {{ $menu->getBestSellerLabel() }}
                                            </span>
                                        @endif
                                    </h6>
                                    @if($menu->category)
                                        <span class="badge bg-light text-dark" style="font-size: 0.7rem;">{{ $menu->category->nama_kategori }}</span>
                                    @endif
                                </div>

                                @if($menu->deskripsi)
                                    <p class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.3;">
                                        {{ Str::limit($menu->deskripsi, 50) }}
                                    </p>
                                @endif
                            </div>

                            <!-- Price & Action -->
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="fw-bold text-primary" style="font-size: 1rem;">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                    @if($menu->is_available)
                                        @if($requiresPreorder)
                                            <small class="text-warning" style="font-size: 0.7rem;">
                                                <i class="fas fa-clock me-1"></i>Pre-Order untuk besok
                                            </small>
                                        @else
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                Stok: {{ $menu->stok }}
                                                @if($menu->order_count > 0)
                                                    • <i class="fas fa-shopping-bag me-1"></i>{{ $menu->order_count }}
                                                @endif
                                            </small>
                                        @endif
                                    @endif
                                </div>

                                <form class="add-to-cart-form" action="{{ route('customer.add_to_cart', [$tenant, $menu]) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1" min="1">
                                    @if($requiresPreorder)
                                        <input type="hidden" name="order_type" value="preorder">
                                        <input type="hidden" name="delivery_date" value="{{ now()->addDay()->format('Y-m-d') }}">
                                    @endif

                                    @if($canOrder)
                                        <button type="submit" class="btn btn-sm @if($requiresPreorder) btn-warning @else btn-primary @endif"
                                                style="min-width: 80px; font-size: 0.8rem;"
                                                @if($requiresPreorder) title="{{ $preorderMessage }}" @endif>
                                            <i class="fas fa-plus me-1"></i>
                                            @if($requiresPreorder)
                                                PO Besok
                                            @else
                                                Tambah
                                            @endif
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-secondary disabled"
                                                style="min-width: 80px; font-size: 0.8rem;"
                                                title="{{ $restrictionMessage }}">
                                            <i class="fas fa-times me-1"></i>
                                            @if($requiresPreorder)
                                                Ditutup
                                            @else
                                                Habis
                                            @endif
                                        </button>
                                    @endif
                                </form>
                            </div>

                            @if($requiresPreorder && $preorderMessage)
                                <div class="mt-2">
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fas fa-info-circle me-1"></i>{{ $preorderMessage }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Compact Checkout CTA -->
        <div class="text-center mt-4 pt-3 border-top">
            <p class="text-muted small mb-2">Lihat keranjang Anda dan selesaikan pemesanan</p>
            <a href="{{ route('customer.cart') }}" class="btn btn-primary">
                <i class="fas fa-shopping-cart me-2"></i>Lihat Keranjang
            </a>
        </div>

        <!-- Pagination -->
        @if($menus->hasPages())
            <div class="d-flex flex-column align-items-center mt-4">
                <div class="pagination-info">
                    Menampilkan {{ $menus->firstItem() }} - {{ $menus->lastItem() }} dari {{ $menus->total() }} menu
                </div>
                {{ $menus->links() }}
            </div>
        @endif
    @else
        <!-- Compact Empty State -->
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-utensils fa-3x text-muted"></i>
            </div>
            <h5 class="mb-2">{{ $tenant->nama_tenant }} belum memiliki menu</h5>
            <p class="text-muted mb-3">Coba tenant lain untuk pilihan menu yang tersedia.</p>
            <a href="{{ route('customer.tenants') }}" class="btn btn-outline-primary">
                <i class="fas fa-store me-2"></i>Lihat Tenant Lain
            </a>
        </div>
    @endif
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity validation
    document.querySelectorAll('input[name="quantity"]').forEach(function(input) {
        input.addEventListener('change', function() {
            const maxStock = parseInt(this.getAttribute('max') || '1', 10);
            let qty = parseInt(this.value, 10) || 1;
            if (qty > maxStock) qty = maxStock;
            if (qty < 1) qty = 1;
            this.value = qty;
        });
    });

    // Category filter
    const categoryButtons = document.querySelectorAll('.category-filter');
    const orderTypeButtons = document.querySelectorAll('.order-type-filter');
    const menuItems = document.querySelectorAll('.menu-item');

    function filterMenus() {
        const activeCategory = document.querySelector('.category-filter.active').dataset.category;
        const activeOrderType = document.querySelector('.order-type-filter.active')?.dataset.type || 'all';
        let visibleCount = 0;

        menuItems.forEach(item => {
            const matchesCategory = activeCategory === 'all' || item.dataset.category === activeCategory;
            const matchesOrderType = activeOrderType === 'all' || item.dataset.orderType === activeOrderType;

            if (matchesCategory && matchesOrderType) {
                item.style.display = '';
                item.classList.remove('filtered-category');
                visibleCount++;
            } else {
                item.style.display = 'none';
                item.classList.add('filtered-category');
            }
        });

        // Update count
        const countElement = document.querySelector('.text-muted');
        if (countElement) {
            countElement.textContent = `${visibleCount} menu`;
        }
    }

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            categoryButtons.forEach(b => {
                b.classList.remove('active', 'btn-primary');
                b.classList.add('btn-light');
            });
            this.classList.remove('btn-light');
            this.classList.add('active', 'btn-primary');

            filterMenus();
        });
    });

    // Order type filter
    orderTypeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            orderTypeButtons.forEach(b => {
                b.classList.remove('active', 'btn-warning', 'btn-info');
                b.classList.add('btn-outline-warning', 'btn-outline-info');
            });
            this.classList.remove('btn-outline-warning', 'btn-outline-info');

            if (this.dataset.type === 'heavy') {
                this.classList.add('active', 'btn-warning');
            } else {
                this.classList.add('active', 'btn-info');
            }

            filterMenus();
        });
    });

    // Sort functionality
    const sortSelect = document.getElementById('sort-select');
    const menuContainer = document.getElementById('menu-container');

    sortSelect.addEventListener('change', function() {
        const sortBy = this.value;
        const items = Array.from(menuContainer.querySelectorAll('.menu-item'));

        items.sort((a, b) => {
            switch(sortBy) {
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'price-low':
                    return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                case 'price-high':
                    return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                case 'popular':
                    // Sort by order count (add order_count to dataset)
                    const aOrders = parseInt(a.querySelector('.fa-shopping-bag')?.closest('small')?.textContent?.match(/\d+/)?.[0] || 0);
                    const bOrders = parseInt(b.querySelector('.fa-shopping-bag')?.closest('small')?.textContent?.match(/\d+/)?.[0] || 0);
                    return bOrders - aOrders;
                case 'stock':
                    return parseInt(b.dataset.stock) - parseInt(a.dataset.stock);
                default:
                    return 0;
            }
        });

        // Clear and re-append sorted items
        menuContainer.innerHTML = '';
        items.forEach(item => menuContainer.appendChild(item));
    });

    // Add loading states to forms
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;

            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menambah...';

            // Reset after 2 seconds (in case of error)
            setTimeout(() => {
                if (button.disabled) {
                    button.disabled = false;
                    button.innerHTML = originalContent;
                }
            }, 2000);
        });
    });
});
</script>
@endpush
@endsection