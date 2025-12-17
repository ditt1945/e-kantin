@push('styles')
<style>
    /* ==================== GLOBAL BUTTON STANDARDS ==================== */

    /* Base Button Classes */
    .btn {
        border-radius: 8px !important;
        font-weight: 500;
        transition: all 0.2s cubic-bezier(0.23, 1, 0.320, 1);
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(var(--bs-primary-rgb, 13, 110, 253), 0.25);
    }

    .btn:active {
        transform: translateY(0);
    }

    /* Button Sizes */
    .btn-xs {
        padding: 0.2rem 0.4rem !important;
        font-size: 0.7rem !important;
        line-height: 1.2;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem !important;
        font-size: 0.8rem !important;
        line-height: 1.3;
    }

    .btn {
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem !important;
        line-height: 1.4;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem !important;
        font-size: 1rem !important;
        line-height: 1.5;
    }

    /* Button Colors with Consistent Styling */
    .btn-primary {
        background: linear-gradient(135deg, var(--bs-primary, #0d6efd), #0056b3) !important;
        border-color: var(--bs-primary, #0d6efd) !important;
        color: #ffffff !important;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3, #004085) !important;
        border-color: #004085 !important;
        color: #ffffff !important;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268) !important;
        border-color: #6c757d !important;
        color: #ffffff !important;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #495057) !important;
        border-color: #495057 !important;
        color: #ffffff !important;
    }

    .btn-success {
        background: linear-gradient(135deg, #198754, #157347) !important;
        border-color: #198754 !important;
        color: #ffffff !important;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #157347, #125730) !important;
        border-color: #125730 !important;
        color: #ffffff !important;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #bb2d3b) !important;
        border-color: #dc3545 !important;
        color: #ffffff !important;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #bb2d3b, #a61e24) !important;
        border-color: #a61e24 !important;
        color: #ffffff !important;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800) !important;
        border-color: #ffc107 !important;
        color: #212529 !important;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00) !important;
        border-color: #d39e00 !important;
        color: #212529 !important;
    }

    .btn-info {
        background: linear-gradient(135deg, #0dcaf0, #0b8fa5) !important;
        border-color: #0dcaf0 !important;
        color: #ffffff !important;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #0b8fa5, #0a7486) !important;
        border-color: #0a7486 !important;
        color: #ffffff !important;
    }

    .btn-light {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
        border-color: #f8f9fa !important;
        color: #212529 !important;
    }

    .btn-light:hover {
        background: linear-gradient(135deg, #e9ecef, #dee2e6) !important;
        border-color: #dee2e6 !important;
        color: #212529 !important;
    }

    .btn-dark {
        background: linear-gradient(135deg, #212529, #343a40) !important;
        border-color: #212529 !important;
        color: #ffffff !important;
    }

    .btn-dark:hover {
        background: linear-gradient(135deg, #343a40, #495057) !important;
        border-color: #495057 !important;
        color: #ffffff !important;
    }

    /* Outline Buttons */
    .btn-outline-primary {
        background: transparent !important;
        border-color: var(--bs-primary, #0d6efd) !important;
        color: var(--bs-primary, #0d6efd) !important;
    }

    .btn-outline-primary:hover {
        background: var(--bs-primary, #0d6efd) !important;
        color: #ffffff !important;
    }

    .btn-outline-secondary {
        background: transparent !important;
        border-color: #6c757d !important;
        color: #6c757d !important;
    }

    .btn-outline-secondary:hover {
        background: #6c757d !important;
        color: #ffffff !important;
    }

    .btn-outline-success {
        background: transparent !important;
        border-color: #198754 !important;
        color: #198754 !important;
    }

    .btn-outline-success:hover {
        background: #198754 !important;
        color: #ffffff !important;
    }

    .btn-outline-danger {
        background: transparent !important;
        border-color: #dc3545 !important;
        color: #dc3545 !important;
    }

    .btn-outline-danger:hover {
        background: #dc3545 !important;
        color: #ffffff !important;
    }

    .btn-outline-warning {
        background: transparent !important;
        border-color: #ffc107 !important;
        color: #ffc107 !important;
    }

    .btn-outline-warning:hover {
        background: #ffc107 !important;
        color: #212529 !important;
    }

    .btn-outline-info {
        background: transparent !important;
        border-color: #0dcaf0 !important;
        color: #0dcaf0 !important;
    }

    .btn-outline-info:hover {
        background: #0dcaf0 !important;
        color: #ffffff !important;
    }

    .btn-outline-light {
        background: transparent !important;
        border-color: #f8f9fa !important;
        color: #f8f9fa !important;
    }

    .btn-outline-light:hover {
        background: #f8f9fa !important;
        color: #212529 !important;
    }

    .btn-outline-dark {
        background: transparent !important;
        border-color: #212529 !important;
        color: #212529 !important;
    }

    .btn-outline-dark:hover {
        background: #212529 !important;
        color: #ffffff !important;
    }

    /* Link Buttons */
    .btn-link {
        background: transparent !important;
        border-color: transparent !important;
        color: var(--bs-primary, #0d6efd) !important;
        text-decoration: underline !important;
        box-shadow: none !important;
    }

    .btn-link:hover {
        color: var(--bs-primary-shade-20, #0a58ca) !important;
        text-decoration: underline !important;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Special Button States */
    .btn.disabled, .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .btn-outline-secondary.disabled {
        background: transparent !important;
        border-color: #6c757d !important;
        color: #6c757d !important;
        opacity: 0.6;
    }

    /* Loading State */
    .btn.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ==================== GLOBAL PAGINATION STANDARDS ==================== */

    .pagination {
        margin-bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.25rem;
    }

    .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 0.125rem;
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--bs-border-color, #dee2e6);
        color: var(--bs-primary, #0d6efd);
        background: #ffffff;
        transition: all 0.2s ease;
        font-weight: 500;
        min-width: 40px;
        text-align: center;
    }

    .pagination .page-link:hover {
        background: var(--bs-primary, #0d6efd);
        border-color: var(--bs-primary, #0d6efd);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--bs-primary, #0d6efd), #0056b3);
        border-color: var(--bs-primary, #0d6efd);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
    }

    .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Pagination Info Text */
    .pagination-info {
        text-align: center;
        color: #6c757d;
        font-size: 0.875rem;
        margin: 1rem 0;
    }

    /* Dark Mode Support */
    [data-theme="dark"] .pagination .page-link {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }

    [data-theme="dark"] .pagination .page-link:hover {
        background: var(--bs-primary, #0d6efd);
        border-color: var(--bs-primary, #0d6efd);
        color: #ffffff;
    }

    [data-theme="dark"] .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--bs-primary, #0d6efd), #0056b3);
        border-color: var(--bs-primary, #0d6efd);
        color: #ffffff;
    }

    [data-theme="dark"] .pagination .page-item.disabled .page-link {
        background: #1a202c;
        border-color: #2d3748;
        color: #718096;
    }

    /* Mobile Responsive Pagination */
    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.8rem;
            min-width: 36px;
        }

        .pagination {
            gap: 0.125rem;
        }

        .pagination .page-link {
            margin: 0 0.0625rem;
        }
    }

    /* ==================== SPECIAL BUTTON VARIANTS ==================== */

    /* Cash Button Special Treatment */
    .btn-cash {
        background: linear-gradient(135deg, #0ea5e9, #06b6d4) !important;
        border-color: #0ea5e9 !important;
        color: #ffffff !important;
        box-shadow: 0 6px 18px rgba(6, 182, 212, 0.35) !important;
    }

    .btn-cash:hover {
        background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
        border-color: #06b6d4 !important;
        color: #ffffff !important;
        box-shadow: 0 8px 22px rgba(6, 182, 212, 0.45) !important;
    }

    /* Button Groups */
    .btn-group .btn {
        border-radius: 0 !important;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 8px !important;
        border-bottom-left-radius: 8px !important;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }

    /* Icon-only Buttons */
    .btn-icon {
        padding: 0.5rem !important;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon.btn-sm {
        width: 32px;
        height: 32px;
        padding: 0.375rem !important;
    }

    .btn-icon.btn-xs {
        width: 28px;
        height: 28px;
        padding: 0.25rem !important;
    }
</style>
@endpush