@push('styles')
<style>
    /* ==================== ADMIN PAGE STYLES ==================== */

    /* Container for admin pages */
    .admin-page {
        padding: 1.5rem;
        max-width: 100%;
    }

    /* Page Header */
    .admin-page-header {
        background: linear-gradient(135deg, var(--card-bg) 0%, rgba(var(--primary-rgb), 0.02) 100%);
        border: 1px solid var(--border-gray);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .admin-page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .admin-page-subtitle {
        color: var(--text-secondary);
        font-size: 0.975rem;
        margin: 0;
    }

    /* Action Buttons */
    .admin-action-bar {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .admin-action-btn {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s cubic-bezier(0.23, 1, 0.320, 1);
    }

    .admin-action-btn:hover {
        transform: translateY(-1px);
    }

    /* Stats Cards */
    .admin-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    /* Search and Filter */
    .admin-search-filter {
        background: var(--card-bg);
        border: 1px solid var(--border-gray);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Data Table */
    .admin-data-table {
        background: var(--card-bg);
        border: 1px solid var(--border-gray);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .admin-data-table .table {
        margin-bottom: 0;
        font-size: 0.875rem;
    }

    .admin-data-table .table-light {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.8rem;
    }

    .admin-data-table .table-light th {
        border-bottom: 2px solid var(--border-gray);
        padding: 1rem;
    }

    .admin-data-table .table td {
        vertical-align: middle;
        padding: 0.875rem 1rem;
    }

    .admin-data-table .table tbody tr {
        transition: all 0.2s ease;
    }

    .admin-data-table .table tbody tr:hover {
        background: rgba(var(--primary-rgb), 0.03);
    }

    /* Mobile Cards */
    .admin-mobile-card {
        background: var(--card-bg);
        border: 1px solid var(--border-gray);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .admin-mobile-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Status Badges */
    .admin-status-badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        white-space: nowrap;
    }

    .admin-status-active {
        background: linear-gradient(135deg, var(--success), #10b981);
        color: #ffffff;
    }

    .admin-status-inactive {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
        color: #ffffff;
    }

    .admin-status-pending {
        background: linear-gradient(135deg, var(--warning), #f59e0b);
        color: #ffffff;
    }

    .admin-status-completed {
        background: linear-gradient(135deg, var(--success), #10b981);
        color: #ffffff;
    }

    .admin-status-cancelled {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: #ffffff;
    }

    /* Action Buttons in Table */
    .admin-table-action {
        display: flex;
        gap: 0.25rem;
        align-items: center;
    }

    .admin-table-action .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .admin-table-action .btn:hover {
        transform: scale(1.05);
    }

    /* Form Enhancements */
    .admin-form-container {
        background: var(--card-bg);
        border: 1px solid var(--border-gray);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .admin-form-group {
        margin-bottom: 1.25rem;
    }

    .admin-form-label {
        font-weight: 500;
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        display: block;
    }

    .admin-form-control {
        border-radius: 8px;
        border: 1px solid var(--border-gray);
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: var(--input-bg);
        color: var(--text-primary);
    }

    .admin-form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
    }

    /* Empty State */
    .admin-empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--text-secondary);
    }

    .admin-empty-state-icon {
        font-size: 4rem;
        color: var(--border-gray);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .admin-empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .admin-empty-state-text {
        font-size: 0.975rem;
        margin-bottom: 1.5rem;
    }

    /* Pagination */
    .admin-pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .admin-pagination .pagination {
        margin-bottom: 0;
    }

    .admin-pagination .page-link {
        border-radius: 6px;
        margin: 0 0.125rem;
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border-gray);
        color: var(--text-primary);
        background: var(--card-bg);
    }

    .admin-pagination .page-link:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: #ffffff;
    }

    .admin-pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: #ffffff;
    }

    /* Alert Messages */
    .admin-alert {
        border-radius: 8px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .admin-alert-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(34, 197, 94, 0.1));
        color: #166534;
        border-left: 4px solid #10b981;
    }

    .admin-alert-warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.1));
        color: #92400e;
        border-left: 4px solid #f59e0b;
    }

    .admin-alert-danger {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(239, 68, 68, 0.1));
        color: #991b1b;
        border-left: 4px solid #dc2626;
    }

    .admin-alert-info {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(6, 182, 212, 0.1));
        color: #075985;
        border-left: 4px solid #0ea5e9;
    }

    /* Dark mode adjustments */
    [data-theme="dark"] .admin-page-header {
        background: linear-gradient(135deg, var(--card-bg) 0%, rgba(var(--primary-rgb), 0.05) 100%);
        border-color: #374151;
    }

    [data-theme="dark"] .admin-search-filter,
    [data-theme="dark"] .admin-data-table,
    [data-theme="dark"] .admin-form-container {
        background: var(--card-bg);
        border-color: #374151;
    }

    [data-theme="dark"] .admin-data-table .table-light {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    }

    [data-theme="dark"] .admin-form-control {
        background: var(--input-bg);
        border-color: #4b5563;
    }

    [data-theme="dark"] .admin-mobile-card {
        background: var(--card-bg);
        border-color: #374151;
    }

    [data-theme="dark"] .admin-pagination .page-link {
        background: var(--card-bg);
        border-color: #4b5563;
        color: var(--text-primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-page {
            padding: 1rem;
        }

        .admin-page-header {
            padding: 1.25rem;
        }

        .admin-page-title {
            font-size: 1.5rem;
        }

        .admin-action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-action-btn {
            justify-content: center;
        }

        .admin-data-table .table td,
        .admin-data-table .table th {
            padding: 0.5rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .admin-stats-row {
            grid-template-columns: 1fr;
        }

        .admin-table-action {
            flex-direction: column;
            gap: 0.5rem;
        }

        .admin-table-action .btn {
            font-size: 0.7rem;
            padding: 0.375rem 0.625rem;
        }
    }
</style>
@endpush