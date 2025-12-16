@push('styles')
<style>
/* ==================== PROFESSIONAL ADMIN DASHBOARD ==================== */
/* Clean, Modern, and Presentation-Ready */

:root {
    /* Professional Color Palette */
    --primary: #2563eb;
    --primary-light: #3b82f6;
    --primary-dark: #1d4ed8;

    --success: #10b981;
    --success-light: #34d399;
    --success-dark: #059669;

    --warning: #f59e0b;
    --warning-light: #fbbf24;
    --warning-dark: #d97706;

    --danger: #ef4444;
    --danger-light: #f87171;
    --danger-dark: #dc2626;

    --info: #06b6d4;
    --info-light: #22d3ee;
    --info-dark: #0891b2;

    --secondary: #64748b;
    --secondary-light: #94a3b8;
    --secondary-dark: #475569;

    /* Neutral Colors */
    --white: #ffffff;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;

    /* Background Colors */
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-tertiary: #f1f5f9;

    /* Text Colors */
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --text-muted: #94a3b8;

    /* Border Colors */
    --border: #e2e8f0;
    --border-light: #f1f5f9;

    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);

    /* Radius */
    --radius: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
}

/* Body */
body {
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
}

/* Main Container */
.admin-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header Section */
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 3rem;
    gap: 2rem;
}

.admin-header-left {
    flex: 1;
}

.admin-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.admin-title i {
    color: var(--primary);
    font-size: 2rem;
}

.admin-subtitle {
    font-size: 1rem;
    color: var(--text-secondary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.admin-subtitle i {
    font-size: 0.875rem;
}

.admin-header-right {
    display: flex;
    gap: 0.75rem;
    flex-shrink: 0;
}

/* Professional Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-lg);
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    cursor: pointer;
}

.btn-primary {
    background-color: var(--primary);
    color: white;
    border-color: var(--primary);
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    border-color: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-outline {
    background-color: var(--white);
    color: var(--text-primary);
    border-color: var(--border);
}

.btn-outline:hover {
    background-color: var(--bg-secondary);
    border-color: var(--gray-300);
    transform: translateY(-1px);
    box-shadow: var(--shadow);
}

/* Stats Overview */
.admin-stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
}

.stat-card.success::before {
    background: linear-gradient(90deg, var(--success), var(--success-light));
}

.stat-card.info::before {
    background: linear-gradient(90deg, var(--info), var(--info-light));
}

.stat-card.warning::before {
    background: linear-gradient(90deg, var(--warning), var(--warning-light));
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: var(--gray-200);
}

.stat-icon {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
}

.stat-card.primary .stat-icon {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
}

.stat-card.success .stat-icon {
    background: linear-gradient(135deg, var(--success), var(--success-light));
}

.stat-card.info .stat-icon {
    background: linear-gradient(135deg, var(--info), var(--info-light));
}

.stat-card.warning .stat-icon {
    background: linear-gradient(135deg, var(--warning), var(--warning-light));
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.stat-trend.positive {
    color: var(--success);
}

.stat-trend i {
    font-size: 0.75rem;
}

/* Management Section */
.admin-management {
    margin-bottom: 3rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-manajemen {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title i {
    color: var(--primary);
}

.management-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.management-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.management-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary);
    text-decoration: none;
    color: var(--text-primary);
}

.management-card::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.05));
    transition: width 0.3s ease;
}

.management-card:hover::after {
    width: 100%;
}

.card-icon {
    width: 3rem;
    height: 3rem;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.card-icon.primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
}

.card-icon.success {
    background: linear-gradient(135deg, var(--success), var(--success-light));
}

.card-icon.warning {
    background: linear-gradient(135deg, var(--warning), var(--warning-light));
}

.card-icon.info {
    background: linear-gradient(135deg, var(--info), var(--info-light));
}

.card-icon.danger {
    background: linear-gradient(135deg, var(--danger), var(--danger-light));
}

.card-icon.secondary {
    background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
}

.card-content {
    flex: 1;
}

.card-content h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.card-content p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.4;
}

.card-arrow {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    color: var(--text-muted);
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.management-card:hover .card-arrow {
    background: var(--primary);
    color: white;
    transform: translateX(2px);
}

/* Recent Orders Section */
.admin-recent-orders {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    background: var(--bg-secondary);
}

.section-header .section-title {
    margin: 0;
}

.view-all {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.view-all:hover {
    color: var(--primary-dark);
    text-decoration: none;
}

.view-all i {
    transition: transform 0.2s ease;
}

.view-all:hover i {
    transform: translateX(2px);
}

/* Orders Table */
.orders-table {
    overflow-x: auto;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

thead th {
    background: var(--bg-tertiary);
    font-weight: 600;
    color: var(--text-primary);
    padding: 1rem;
    text-align: left;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--border);
}

tbody td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-light);
    vertical-align: middle;
}

tbody tr:hover {
    background: var(--bg-secondary);
}

tbody tr:last-child td {
    border-bottom: none;
}

.order-id {
    font-weight: 600;
    color: var(--text-primary);
}

.tenant-name {
    color: var(--text-secondary);
}

.order-total {
    font-weight: 600;
    color: var(--text-primary);
    text-align: right;
}

.order-time {
    color: var(--text-secondary);
    font-size: 0.8rem;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
    white-space: nowrap;
}

.status-badge.selesai {
    background: #dcfce7;
    color: #166534;
}

.status-badge.diproses {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.pending {
    background: #dbeafe;
    color: #1d4ed8;
}

.status-badge.pending_cash {
    background: #e0e7ff;
    color: #3730a3;
}

.status-badge.dibatalkan {
    background: #fee2e2;
    color: #dc2626;
}

/* Empty State */
.empty-state {
    padding: 3rem;
    text-align: center;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 3rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
    display: block;
}

.empty-state h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .admin-container {
        padding: 1.5rem;
    }

    .admin-stats-overview {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .management-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
}

@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }

    .admin-header {
        flex-direction: column;
        gap: 1.5rem;
        align-items: stretch;
    }

    .admin-title {
        font-size: 2rem;
    }

    .admin-header-right {
        justify-content: flex-start;
    }

    .admin-stats-overview {
        grid-template-columns: 1fr;
    }

    .management-grid {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .stat-card,
    .management-card {
        padding: 1rem;
    }

    .stat-icon,
    .card-icon {
        width: 2.5rem;
        height: 2.5rem;
        font-size: 0.875rem;
    }

    .stat-value {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .admin-title {
        font-size: 1.75rem;
    }

    .admin-subtitle {
        font-size: 0.875rem;
    }

    .btn {
        padding: 0.625rem 1.25rem;
        font-size: 0.8rem;
    }

    .orders-table {
        font-size: 0.8rem;
    }

    thead th {
        padding: 0.75rem;
        font-size: 0.7rem;
    }

    tbody td {
        padding: 0.75rem;
    }
}

/* Print Styles */
@media print {
    .admin-header-right {
        display: none;
    }

    .admin-container {
        max-width: none;
        padding: 0;
    }

    .stat-card,
    .management-card {
        break-inside: avoid;
    }
}
</style>
@endpush