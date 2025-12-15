@push('styles')
<style>
/* Modern Minimalist Tenant Page Styles */

/* Page Header */
.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1rem;
    color: var(--text-secondary);
    margin: 0;
}

/* Search Bar */
.search-container {
    position: relative;
    margin-bottom: 2rem;
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
    margin-bottom: 2rem;
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
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    border: 1px solid #f1f5f9;
    cursor: pointer;
    position: relative;
}

.tenant-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--success));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.tenant-card:hover::before {
    transform: scaleX(1);
}

.tenant-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    border-color: #e2e8f0;
}

/* Tenant Header */
.tenant-header {
    padding: 1.5rem 1.5rem 1rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #f1f5f9;
}

.tenant-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.tenant-status {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
    border-radius: 100px;
    margin-bottom: 0.75rem;
}

.status-open {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.status-closed {
    background: rgba(148, 163, 184, 0.1);
    color: #64748b;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

/* Tenant Body */
.tenant-body {
    padding: 1rem 1.5rem;
}

.tenant-description {
    font-size: 0.875rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1.25rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Tenant Stats */
.tenant-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.813rem;
    color: #475569;
}

.stat-value {
    font-weight: 600;
    color: #1e293b;
}

/* Tenant Footer */
.tenant-footer {
    padding: 1rem 1.5rem 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
}

.btn-primary-modern {
    flex: 1;
    padding: 0.75rem 1rem;
    background: linear-gradient(135deg, var(--primary), #1d4ed8);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    color: #ffffff;
}

.btn-outline-modern {
    padding: 0.75rem 1rem;
    background: #ffffff;
    color: var(--primary);
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-outline-modern:hover {
    border-color: var(--primary);
    background: rgba(37, 99, 235, 0.05);
    color: var(--primary);
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
    width: 16px;
    height: 16px;
    position: relative;
    display: inline-block;
}

.star::before {
    content: '★';
    font-size: 16px;
    color: #e2e8f0;
}

.star.filled::before {
    color: #fbbf24;
}

.rating-count {
    font-size: 0.813rem;
    color: #64748b;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: #f1f5f9;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 2rem;
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state-text {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 2rem;
}

/* Dark Mode */
[data-theme="dark"] .search-box {
    background: #1e293b;
    color: #f1f5f9;
}

[data-theme="dark"] .search-box:focus {
    background: #334155;
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
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

[data-theme="dark"] .tenant-header {
    background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
    border-bottom-color: #334155;
}

[data-theme="dark"] .tenant-name {
    color: #f1f5f9;
}

[data-theme="dark"] .tenant-body {
    color: #cbd5e1;
}

[data-theme="dark"] .tenant-description {
    color: #94a3b8;
}

[data-theme="dark"] .stat-item {
    color: #94a3b8;
}

[data-theme="dark"] .stat-value {
    color: #f1f5f9;
}

[data-theme="dark"] .tenant-footer {
    background: #334155;
    border-top-color: #334155;
}

[data-theme="dark"] .btn-outline-modern {
    background: #1e293b;
    border-color: #475569;
    color: #cbd5e1;
}

[data-theme="dark"] .btn-outline-modern:hover {
    border-color: var(--primary);
    background: rgba(37, 99, 235, 0.1);
    color: #ffffff;
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

/* Animation for page load */
.tenant-card {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease forwards;
}

.tenant-card:nth-child(1) { animation-delay: 0.1s; }
.tenant-card:nth-child(2) { animation-delay: 0.2s; }
.tenant-card:nth-child(3) { animation-delay: 0.3s; }
.tenant-card:nth-child(4) { animation-delay: 0.4s; }
.tenant-card:nth-child(5) { animation-delay: 0.5s; }
.tenant-card:nth-child(6) { animation-delay: 0.6s; }

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
</style>
@endpush