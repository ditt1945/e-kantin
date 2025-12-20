@extends('layouts.app')

@push('styles')
<style>
/* Modern Minimalist Tenant Page Styles */

/* Page Header */
.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    opacity: 0;
    animation: fadeIn 0.5s ease forwards;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--text-secondary);
    margin: 0;
    opacity: 0;
    animation: fadeIn 0.5s ease 0.1s forwards;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Search Bar */
.search-container {
    position: relative;
}

.search-container.mb-4 {
    margin-bottom: 1.5rem !important;
}

.search-box {
    width: 100%;
    padding: 1rem 1.5rem 1rem 3.5rem;
    border: 2px solid transparent;
    border-radius: 16px;
    background: #f8fafc;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    color: var(--text-primary);
}

.search-box:focus {
    outline: none;
    border-color: var(--primary);
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.search-icon {
    position: absolute;
    left: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
}

/* Filter Pills */
.filter-container {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.filter-pill {
    padding: 0.625rem 1.25rem;
    border: 2px solid #e2e8f0;
    border-radius: 100px;
    background: #ffffff;
    color: #64748b;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.filter-pill:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: rgba(37, 99, 235, 0.05);
}

.filter-pill.active {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
}

/* Tenant Grid */
.tenant-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

/* Tenant Card */
.tenant-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
    border: 1px solid #e5e7eb;
    cursor: pointer;
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.tenant-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), #06b6d4);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
    z-index: 1;
}

.tenant-card:hover::before {
    transform: scaleX(1);
}

.tenant-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    border-color: #d1d5db;
}

/* Tenant Header */
.tenant-header {
    padding: 1.25rem 1.25rem 0.75rem;
    background: #fafbfc;
    border-bottom: 1px solid #f3f4f6;
    position: relative;
}

.tenant-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.5rem 0;
    line-height: 1.4;
}

.tenant-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
}

.status-open {
    background: #f0fdf4;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.status-closed {
    background: #f9fafb;
    color: #6b7280;
    border: 1px solid #e5e7eb;
}

.status-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: currentColor;
}

/* Tenant Body */
.tenant-body {
    padding: 0.875rem 1.25rem;
    flex: 1;
}

.tenant-description {
    font-size: 0.813rem;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Tenant Stats */
.tenant-stats {
    display: flex;
    gap: 1.25rem;
    margin-bottom: 0.75rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-label {
    font-size: 0.688rem;
    font-weight: 500;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.stat-value {
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
}

/* Tenant Footer */
.tenant-footer {
    padding: 0.875rem 1.25rem 1.25rem;
    background: #fafbfc;
    border-top: 1px solid #f3f4f6;
    margin-top: auto;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
}

.action-buttons .btn {
    padding: 0.75rem 1rem !important;
    font-weight: 500;
    flex: 1;
}

.btn-primary-modern {
    flex: 1;
    padding: 0.625rem 1rem;
    background: var(--primary);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.813rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-primary-modern:hover {
    background: #1d4ed8;
    color: #ffffff;
}

.btn-outline-modern {
    padding: 0.625rem 1rem;
    background: transparent;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.813rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-outline-modern:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
}

/* Rating */
.rating-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.rating-stars {
    display: flex;
    gap: 0.125rem;
}

.star {
    width: 14px;
    height: 14px;
    position: relative;
    display: inline-block;
}

.star::before {
    content: '★';
    font-size: 14px;
    color: #f3f4f6;
}

.star.filled::before {
    color: #fbbf24;
}

.rating-count {
    font-size: 0.75rem;
    color: #9ca3af;
}

/* Dark Mode */
[data-theme="dark"] .search-box {
    background: #1e293b;
    color: #f1f5f9;
    border-color: #334155;
}

[data-theme="dark"] .search-box:focus {
    background: #334155;
    border-color: var(--primary);
}

[data-theme="dark"] .filter-pill {
    background: #1e293b;
    border-color: #334155;
    color: #cbd5e1;
}

[data-theme="dark"] .filter-pill:hover {
    border-color: var(--primary);
    background: rgba(37, 99, 235, 0.1);
}

[data-theme="dark"] .tenant-card {
    background: #1e293b;
    border-color: #334155;
}

[data-theme="dark"] .tenant-card:hover {
    border-color: #475569;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

[data-theme="dark"] .tenant-header {
    background: #334155;
    border-bottom-color: #475569;
}

[data-theme="dark"] .tenant-name {
    color: #f1f5f9;
}

[data-theme="dark"] .tenant-description {
    color: #94a3b8;
}

[data-theme="dark"] .stat-label {
    color: #64748b;
}

[data-theme="dark"] .stat-value {
    color: #f1f5f9;
}

[data-theme="dark"] .tenant-footer {
    background: #334155;
    border-top-color: #475569;
}

[data-theme="dark"] .btn-outline-modern {
    background: transparent;
    border-color: #475569;
    color: #94a3b8;
}

[data-theme="dark"] .btn-outline-modern:hover {
    background: #475569;
    border-color: #64748b;
    color: #cbd5e1;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }

    .page-subtitle {
        font-size: 0.875rem;
    }

    .tenant-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .search-box {
        padding: 0.875rem 1.25rem 0.875rem 3rem;
    }

    .filter-container {
        gap: 0.5rem;
    }

    .filter-pill {
        padding: 0.5rem 1rem;
        font-size: 0.813rem;
    }

    .tenant-header {
        padding: 1.25rem 1.25rem 0.75rem;
    }

    .tenant-name {
        font-size: 1.125rem;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-primary-modern,
    .btn-outline-modern {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .tenant-header {
        padding: 1rem;
    }

    .tenant-body {
        padding: 0.75rem 1rem;
    }

    .tenant-footer {
        padding: 0.75rem 1rem 1rem;
    }

    .tenant-stats {
        flex-direction: column;
        gap: 0.5rem;
    }
}

/* Subtle page load animations */
.tenant-card {
    opacity: 0;
    animation: fadeInUp 0.4s ease forwards;
}

.tenant-card:nth-child(1) { animation-delay: 0.05s; }
.tenant-card:nth-child(2) { animation-delay: 0.1s; }
.tenant-card:nth-child(3) { animation-delay: 0.15s; }
.tenant-card:nth-child(4) { animation-delay: 0.2s; }
.tenant-card:nth-child(5) { animation-delay: 0.25s; }
.tenant-card:nth-child(6) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Card hover effect */
.tenant-card {
    transition: all 0.2s ease;
}

.tenant-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

/* Button hover effect */
.btn-primary-modern {
    transition: all 0.2s ease;
}

.btn-primary-modern:hover {
    transform: translateY(-1px);
}

.btn-outline-modern {
    transition: all 0.2s ease;
}

/* Filter pill transitions */
.filter-pill {
    transition: all 0.2s ease;
}

/* Star hover effect */
.star {
    transition: transform 0.15s ease;
}

.star:hover {
    transform: scale(1.1);
}

/* Simple Pagination Enhancements */
.pagination .page-link {
    border-radius: 8px;
    margin: 0 2px;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    transform: translateY(-1px);
}

.pagination .page-item.active .page-link {
    background: var(--primary);
    border-color: var(--primary);
}
</style>
@endpush

@section('content')
@php
    $cartCount = 0;
    if(auth()->check() && auth()->user()->role === 'customer') {
        $userCarts = \App\Models\Cart::where('user_id', auth()->id())->get();
        foreach($userCarts as $cart) {
            $cartCount += $cart->items->count();
        }
    }
@endphp
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="page-title mb-2">Pilih Tenant</h1>
            <p class="page-subtitle mb-0">Temukan berbagai pilihan makanan favorit Anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-home me-1"></i>
                <span class="d-none d-sm-inline">Dashboard</span>
            </a>
            <a href="{{ route('customer.cart') }}" class="btn btn-sm btn-outline-success position-relative">
                <i class="fas fa-shopping-cart"></i>
                @if($cartCount ?? 0 > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-5">
        <!-- Search Bar -->
        <div class="search-container mb-4">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-box" id="tenant-search" placeholder="Cari tenant...">
        </div>

        <!-- Filter Pills -->
        <div class="filter-container">
            <button class="filter-pill active" id="filter-all">
                Semua
            </button>
            <button class="filter-pill" id="filter-popular">
                Populer
            </button>
            <button class="filter-pill" id="filter-open">
                Buka
            </button>
        </div>
    </div>

    @if($tenants->count() > 0)
    <div class="tenant-grid" id="tenants-container">
        @foreach($tenants as $tenant)
        <div class="tenant-item" data-name="{{ strtolower($tenant->nama_tenant) }}" data-status="{{ $tenant->is_active ? 'open' : 'closed' }}" data-menu-count="{{ $tenant->menus_count ?? 0 }}">
            <div class="tenant-card">
                <!-- Header -->
                <div class="tenant-header">
                    <h3 class="tenant-name">{{ $tenant->nama_tenant }}</h3>
                    <div class="tenant-status {{ $tenant->is_active ? 'status-open' : 'status-closed' }}">
                        <span class="status-dot"></span>
                        {{ $tenant->is_active ? 'Buka' : 'Tutup' }}
                    </div>
                </div>

                <!-- Body -->
                <div class="tenant-body">
                    <p class="tenant-description">
                        {{ Str::limit($tenant->deskripsi ?? 'Nikmati berbagai pilihan makanan lezat', 120) }}
                    </p>

                    <!-- Stats -->
                    <div class="tenant-stats">
                        <div class="stat-item">
                            <span class="stat-label">Menu</span>
                            <span class="stat-value">{{ $tenant->menus_count ?? 0 }}</span>
                        </div>
                        @if($tenant->rating ?? 0)
                        <div class="stat-item">
                            <span class="stat-label">Rating</span>
                            <span class="stat-value">{{ number_format($tenant->rating, 1) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Rating -->
                    @if($tenant->rating ?? 0)
                    <div class="rating-container">
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @php
                                    $starClass = $i <= $tenant->rating ? 'filled' : '';
                                @endphp
                                <span class="star {{ $starClass }}"></span>
                            @endfor
                        </div>
                        <span class="rating-count">({{ $tenant->reviews ?? 0 }} ulasan)</span>
                    </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="tenant-footer">
                    <div class="action-buttons">
                        <a href="{{ route('customer.menus', $tenant) }}" class="btn btn-primary">
                            <i class="fas fa-utensils me-1"></i>Lihat Menu
                        </a>
                        <button class="btn btn-outline-secondary quick-view" data-tenant="{{ $tenant->id }}">
                            <i class="fas fa-eye me-1"></i>Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-store"></i>
        </div>
        <h2 class="empty-state-title">Tenant Tidak Ditemukan</h2>
        <p class="empty-state-text">Coba ubah filter atau kata kunci pencarian Anda</p>
        <a href="{{ route('customer.tenants') }}" class="btn btn-primary">
            <i class="fas fa-redo me-2"></i>Reset Filter
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('tenant-search');
    const tenantItems = document.querySelectorAll('.tenant-item');

    function filterTenants() {
        const searchTerm = searchInput.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-pill.active').id;

        tenantItems.forEach(item => {
            const tenantName = item.dataset.name;
            const tenantStatus = item.dataset.status;
            const menuCount = parseInt(item.dataset.menuCount) || 0;

            let showBySearch = tenantName.includes(searchTerm);
            let showByFilter = true;

            // Apply filter
            switch(activeFilter) {
                case 'filter-popular':
                    showByFilter = menuCount >= 5;
                    break;
                case 'filter-open':
                    showByFilter = tenantStatus === 'open';
                    break;
            }

            if (showBySearch && showByFilter) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTenants);

    // Filter buttons
    const filterButtons = document.querySelectorAll('.filter-pill');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Apply filter
            filterTenants();
        });
    });

    // Quick view functionality
    document.querySelectorAll('.quick-view').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const tenantId = this.dataset.tenant;

            // Create a simple modal for quick view
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                animation: fadeIn 0.3s ease;
            `;

            const modalContent = document.createElement('div');
            modalContent.style.cssText = `
                background: white;
                padding: 2rem;
                border-radius: 16px;
                max-width: 500px;
                width: 90%;
                position: relative;
                animation: scaleIn 0.3s ease;
            `;

            modalContent.innerHTML = `
                <h3 style="margin: 0 0 1rem 0;">Detail Tenant #${tenantId}</h3>
                <p style="color: #64748b; margin-bottom: 1.5rem;">Informasi lengkap tentang tenant akan segera tersedia.</p>
                <button onclick="this.closest('div').parentElement.remove()" style="
                    background: var(--primary);
                    color: white;
                    border: none;
                    padding: 0.5rem 1rem;
                    border-radius: 8px;
                    cursor: pointer;
                    transition: all 0.2s ease;
                ">Tutup</button>
            `;

            modal.appendChild(modalContent);
            document.body.appendChild(modal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => modal.remove(), 300);
                }
            });
        });
    });

    // Add modal animations CSS
    const modalStyle = document.createElement('style');
    modalStyle.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    `;
    document.head.appendChild(modalStyle);
});
</script>
@endpush
@endsection