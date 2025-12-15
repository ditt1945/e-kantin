@push('styles')
<style>
/* Menu Pages Styles */
.menu-card {
    border: 1px solid var(--border-gray);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.menu-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.hero-strip {
    height: 200px;
    background: linear-gradient(135deg,
        rgba(var(--primary-rgb, 13, 110, 253), 0.06) 0%,
        rgba(var(--success-rgb, 25, 135, 84), 0.06) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.hero-strip::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg,
        transparent 30%,
        rgba(255,255,255,0.1) 50%,
        transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.menu-card:hover .hero-strip::before {
    transform: translateX(100%);
}

.menu-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.image-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    opacity: 0.35;
    display: flex;
}

.overlay-unavailable {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(2px);
}

.overlay-unavailable span {
    color: #fff;
    font-weight: 700;
    font-size: 1.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.card-title {
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 1rem;
    line-height: 1.4;
}

.card-text {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.price-block {
    background: var(--light-gray);
    border-radius: 8px;
    padding: 1rem;
    transition: background 0.3s ease;
}

.menu-card:hover .price-block {
    background: linear-gradient(135deg, var(--light-gray) 0%, #f0f4f8 100%);
}

.price {
    font-size: 1.1rem;
    color: var(--primary);
    font-weight: 600;
}

.menu-quantity-input {
    width: 60px;
    padding: 6px 8px;
    text-align: center;
    font-weight: 600;
    font-size: 0.9rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    outline: none;
    transition: all 0.2s ease;
}

.menu-quantity-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    transform: scale(1.05);
}

.menu-quantity-label {
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
    color: var(--text-secondary);
}

.checkout-cta {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light, 33, 136, 255) 100%);
    border: none;
    color: white;
    position: relative;
    overflow: hidden;
}

.checkout-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.checkout-cta:hover::before {
    left: 100%;
}

.checkout-cta .card-title {
    color: white;
    font-weight: 700;
}

.icon-empty {
    color: var(--border-gray);
    margin-bottom: 1rem;
    opacity: 0.9;
}

.btn-add-to-cart {
    position: relative;
    overflow: hidden;
}

.btn-add-to-cart::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    transform: translate(-50%, -50%);
    transition: width 0.4s, height 0.4s;
}

.btn-add-to-cart:hover::after {
    width: 120%;
    height: 120%;
}

/* Loading state for menu cards */
.menu-card.loading {
    pointer-events: none;
    opacity: 0.6;
}

.menu-card.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.menu-card.loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    margin: -20px 0 0 -20px;
    border: 3px solid var(--light-gray);
    border-top: 3px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 11;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Compact Menu Styles */
.menu-compact {
    transition: all 0.2s ease;
    cursor: pointer;
}

.menu-compact:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    border-color: #e0e7ff !important;
}

.menu-compact.unavailable {
    opacity: 0.7;
    background: #f8fafc !important;
}

.btn-xs {
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    border-radius: 0.375rem;
}

/* Text clamp utilities */
.clamp-1 {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-title {
        font-size: 1.2rem;
    }

    .container-fluid {
        padding-left: 12px;
        padding-right: 12px;
    }

    .menu-card:hover {
        transform: translateY(-4px);
    }

    .hero-strip {
        height: 150px;
    }

    .menu-quantity-input {
        width: 50px;
        font-size: 0.85rem;
    }

    .menu-quantity-label {
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .row.g-4 > * {
        margin-bottom: 1rem;
    }

    .checkout-cta {
        max-width: none;
        width: 100%;
    }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
    .menu-card,
    .menu-quantity-input,
    .hero-strip::before,
    .btn-add-to-cart::after,
    .checkout-cta::before {
        transition: none;
        animation: none;
    }

    .menu-card:hover {
        transform: none;
    }
}

/* Dark mode styles */
[data-theme="dark"] .menu-card {
    background: #1e293b;
    border-color: rgba(71, 85, 105, 0.3);
    color: #f1f5f9;
}

[data-theme="dark"] .menu-card:hover {
    box-shadow: 0 12px 24px rgba(0,0,0,0.3);
}

[data-theme="dark"] .hero-strip {
    background: linear-gradient(135deg,
        rgba(59, 130, 246, 0.1) 0%,
        rgba(34, 197, 94, 0.1) 100%);
}

[data-theme="dark"] .card-body {
    background: #1e293b;
}

[data-theme="dark"] .card-title {
    color: #f1f5f9;
}

[data-theme="dark"] .card-text {
    color: #cbd5e1;
}

[data-theme="dark"] .badge.bg-light {
    background: #334155 !important;
    color: #f1f5f9 !important;
}

[data-theme="dark"] .image-placeholder {
    background: #334155;
    color: #64748b;
}

[data-theme="dark"] .btn-outline-secondary {
    border-color: rgba(71, 85, 105, 0.5);
    color: #cbd5e1;
}

[data-theme="dark"] .btn-outline-secondary:hover {
    background: rgba(71, 85, 105, 0.3);
    border-color: rgba(71, 85, 105, 0.7);
}

[data-theme="dark"] .form-select {
    background-color: #1e293b;
    border-color: rgba(71, 85, 105, 0.5);
    color: #f1f5f9;
}

[data-theme="dark"] .icon-empty {
    color: #475569;
}

/* Dark mode loading states */
[data-theme="dark"] .menu-card.loading::after {
    background: rgba(15, 23, 42, 0.8);
}

[data-theme="dark"] .menu-card.loading::before {
    border-color: #475569;
    border-top-color: #3b82f6;
}

/* Dark mode for compact menu */
[data-theme="dark"] .menu-compact {
    background: #1e293b !important;
    border-color: rgba(71, 85, 105, 0.3);
}

[data-theme="dark"] .menu-compact:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    border-color: rgba(59, 130, 246, 0.5) !important;
}

[data-theme="dark"] .menu-compact.unavailable {
    background: #334155 !important;
    opacity: 0.6;
}

[data-theme="dark"] .btn-xs.btn-light {
    background: #334155;
    color: #cbd5e1;
    border-color: rgba(71, 85, 105, 0.3);
}

[data-theme="dark"] .btn-xs.btn-light:hover {
    background: #475569;
    color: #f1f5f9;
}

/* Compact header dark mode */
[data-theme="dark"] .border-bottom {
    border-color: rgba(71, 85, 105, 0.3);
}

/* Mobile responsive for compact design */
@media (max-width: 768px) {
    .menu-compact {
        padding: 0.75rem !important;
        gap: 0.75rem !important;
    }

    .menu-compact .rounded-2 {
        width: 60px !important;
        height: 60px !important;
    }

    .btn-xs {
        padding: 0.2rem 0.5rem;
        font-size: 0.7rem;
    }

    /* Filter bar mobile */
    .d-flex.justify-content-between.align-items-center.mb-3.py-2 {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .form-select.form-select-sm {
        width: 100% !important;
        font-size: 0.8rem;
    }

    /* Compact header mobile */
    .d-flex.justify-content-between.align-items-center.mb-3 {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
}

@media (max-width: 576px) {
    .menu-compact {
        flex-direction: column;
        text-align: center;
    }

    .menu-compact .d-flex.justify-content-between {
        flex-direction: column;
        gap: 0.75rem;
    }

    .menu-compact .d-flex.align-items-end {
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .btn-sm {
        width: 100%;
        min-width: auto;
    }
}
</style>
@endpush