@push('styles')
<style>
/* Mobile Optimizations */
@media (max-width: 768px) {
    /* Navigation improvements */
    .navbar-brand {
        font-size: 1.2rem !important;
    }

    .navbar .container-fluid {
        padding: 0.5rem;
    }

    /* Touch-friendly targets */
    .btn {
        min-height: 44px;
        min-width: 44px;
        padding: 0.5rem 1rem;
    }

    .form-control, .form-select {
        min-height: 44px;
        font-size: 16px; /* Prevent zoom on iOS */
    }

    /* Card adjustments */
    .card {
        margin-bottom: 1rem;
    }

    .card-body {
        padding: 1rem;
    }

    .menu-card, .tenant-card {
        margin-bottom: 1rem;
    }

    /* Grid adjustments */
    .row.g-4 > * {
        margin-bottom: 1rem !important;
    }

    .col-md-6.col-lg-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100%;
    }

    /* Typography */
    .page-title {
        font-size: 1.2rem;
    }

    .card-title {
        font-size: 0.95rem;
    }

    /* Images */
    .hero-strip {
        height: 120px !important;
    }

    .menu-image {
        height: 120px !important;
    }

    /* Forms */
    .input-group {
        margin-bottom: 0.5rem;
    }

    .form-row > div {
        margin-bottom: 0.75rem;
    }

    /* Tables */
    .table-responsive {
        font-size: 0.875rem;
    }

    .table td, .table th {
        padding: 0.5rem;
        white-space: nowrap;
    }

    /* Modals */
    .modal-dialog {
        margin: 1rem;
        max-width: calc(100% - 2rem);
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        flex-wrap: wrap;
    }

    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Cart specific */
    .cart-item {
        padding: 1rem !important;
        flex-direction: column !important;
        gap: 1rem !important;
    }

    .quantity-input {
        width: 80px !important;
    }

    /* Dashboard adjustments */
    .stat-card {
        margin-bottom: 0.75rem;
        min-height: 80px;
        padding: 1rem;
    }

    .quick-action {
        height: 80px;
    }

    /* Search and filters */
    #tenant-search, #sort-select {
        margin-bottom: 0.75rem;
    }

    /* Button groups */
    .btn-group .btn {
        min-height: auto;
        margin-bottom: 0.25rem;
    }

    /* Alerts */
    .alert {
        padding: 0.75rem;
        font-size: 0.875rem;
    }

    /* Breadcrumbs */
    .breadcrumb {
        padding: 0.5rem 0;
        font-size: 0.875rem;
    }

    /* Footers */
    footer {
        text-align: center;
    }
}

@media (max-width: 576px) {
    /* Extra small screens */
    .container-fluid {
        padding-left: 8px !important;
        padding-right: 8px !important;
    }

    .btn-sm {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    .badge {
        font-size: 0.6rem;
    }

    /* Stacked layouts */
    .d-flex.flex-md-row {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }

    /* Collapse cards */
    .card-header {
        padding: 0.75rem;
        font-size: 0.875rem;
    }

    /* Hide non-essential elements */
    .d-none.d-sm-block,
    .d-none.d-md-block,
    .d-none.d-lg-block {
        display: none !important;
    }

    .d-sm-none.d-md-block {
        display: block !important;
    }

    /* Mobile-specific layouts */
    .mobile-full-width {
        width: 100% !important;
        max-width: 100% !important;
    }

    .mobile-text-center {
        text-align: center !important;
    }

    /* Compact forms */
    .form-row .col-6 {
        width: 100% !important;
        flex: 0 0 100%;
    }

    /* Compact cards */
    .card-sm .card-body {
        padding: 0.75rem;
    }

    /* Touch spacing */
    .btn + .btn,
    .input-group + .btn,
    .form-control + .btn {
        margin-top: 0.5rem;
    }
}

/* Landscape mobile optimizations */
@media (max-width: 768px) and (orientation: landscape) {
    .hero-strip {
        height: 100px !important;
    }

    .page-loader {
        padding: 1rem;
    }

    .modal-body {
        max-height: 80vh;
        overflow-y: auto;
    }
}

/* Large touch screens */
@media (min-width: 992px) and (max-width: 1024px) {
    .col-lg-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .menu-image,
    .loader-logo {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }
}

/* Dark mode mobile adjustments */
@media (max-width: 768px) {
    [data-theme="dark"] .card {
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .form-control,
    [data-theme="dark"] .form-select {
        background-color: var(--bg-secondary);
        border-color: rgba(255, 255, 255, 0.1);
    }
}

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
    .menu-card:hover,
    .tenant-card:hover {
        transform: none;
    }

    .btn::after,
    .hero-strip::before {
        animation: none;
    }
}

/* Print styles */
@media print {
    .btn,
    .pagination,
    .navbar,
    footer,
    .loading-overlay {
        display: none !important;
    }

    .card {
        break-inside: avoid;
        border: 1px solid #000 !important;
    }
}

/* Custom scrollbar for mobile WebKit browsers */
@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-gray);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 2px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-dark);
    }
}

/* Focus styles for mobile keyboard navigation */
@media (max-width: 768px) {
    *:focus {
        outline: 2px solid var(--primary);
        outline-offset: 2px;
    }

    .btn:focus,
    .form-control:focus,
    .form-select:focus {
        outline-width: 3px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Mobile optimizations
document.addEventListener('DOMContentLoaded', function() {
    // Handle viewport height issues on mobile browsers
    function setViewportHeight() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }

    setViewportHeight();
    window.addEventListener('resize', setViewportHeight);
    window.addEventListener('orientationchange', setViewportHeight);

    // Prevent zoom on double tap for form inputs
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('touchstart', function(e) {
            this.style.fontSize = '16px';
        });

        element.addEventListener('focus', function() {
            this.style.fontSize = '16px';
        });

        element.addEventListener('blur', function() {
            this.style.fontSize = '';
        });
    });

    // Handle scroll events for better mobile UX
    let lastScrollTop = 0;
    let ticking = false;

    function updateScrollClasses() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            document.body.classList.add('scrolled-down');
            document.body.classList.remove('scrolled-up');
        } else {
            // Scrolling up
            document.body.classList.add('scrolled-up');
            document.body.classList.remove('scrolled-down');
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        ticking = false;
    }

    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(updateScrollClasses);
            ticking = true;
        }
    });

    // Add smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Detect mobile device
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    if (isMobile) {
        document.body.classList.add('mobile-device');
    }

    // Handle swipe gestures for carousels (if any)
    let touchStartX = 0;
    let touchEndX = 0;

    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            // Trigger custom event for swipe
            const swipeEvent = new CustomEvent('swipe', {
                detail: { direction: diff > 0 ? 'left' : 'right' }
            });
            document.dispatchEvent(swipeEvent);
        }
    }
});
</script>
@endpush