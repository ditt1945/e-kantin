@push('styles')
<style>
/* Make sure admin styles don't interfere with page loader */
.admin-container {
    /* Only apply to admin container, not body */
}
/* ==================== MINIMALIS MODERN ADMIN UI 2025 ==================== */
/* Clean, simple, and effective design */

* {
    box-sizing: border-box;
}

html, body {
    overflow-x: hidden;
    max-width: 100%;
    background: #F8FAFC;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    line-height: 1.6;
    color: #1E293B;
}

:root {
    /* Minimalis Color Palette */
    --primary: #2563EB;
    --primary-light: #60A5FA;
    --success: #10B981;
    --warning: #F59E0B;
    --danger: #EF4444;
    --neutral: #64748B;
    --neutral-light: #94A3B8;

    /* Background System */
    --bg-main: #F8FAFC;
    --bg-card: #FFFFFF;
    --bg-hover: #F1F5F9;
    --bg-border: #E2E8F0;

    /* Text System */
    --text-primary: #1E293B;
    --text-secondary: #64748B;
    --text-muted: #94A3B8;
    --text-inverse: #FFFFFF;

    /* Spacing System */
    --space-xs: 4px;
    --space-sm: 8px;
    --space-md: 16px;
    --space-lg: 24px;
    --space-xl: 32px;
    --space-2xl: 48px;

    /* Border Radius */
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;

    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* ==================== ADMIN CONTAINER ==================== */
.admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: var(--space-lg);
    background: var(--bg-main);
    min-height: 100vh;
}

/* ==================== ADMIN HERO SECTION ==================== */
.admin-hero {
    background: var(--bg-card);
    border: 1px solid var(--bg-border);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    margin-bottom: var(--space-lg);
    box-shadow: var(--shadow-sm);
}

.admin-hero .content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--space-md);
}

.admin-hero .hero-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.2;
}

.admin-hero .hero-subtitle {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: var(--space-xs) 0 0 0;
}

.admin-hero .time-badge {
    display: inline-flex;
    align-items: center;
    gap: var(--space-sm);
    background: var(--primary);
    color: var(--text-inverse);
    padding: var(--space-sm) var(--space-md);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    font-weight: 500;
}

/* ==================== STATS CARDS ==================== */
.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-md);
    margin-bottom: var(--space-lg);
}

.admin-stat-card {
    background: var(--bg-card);
    border: 1px solid var(--bg-border);
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-sm);
}

.admin-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: inherit;
}

.admin-stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: var(--space-sm);
}

.admin-stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: var(--space-xs);
}

.admin-stat-change {
    font-size: 0.75rem;
    color: var(--success);
    font-weight: 500;
}

.admin-stat-change.negative {
    color: var(--danger);
}

/* ==================== FILTER SECTION ==================== */
.admin-filter {
    background: var(--bg-card);
    border: 1px solid var(--bg-border);
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    margin-bottom: var(--space-lg);
    box-shadow: var(--shadow-sm);
}

.admin-filter-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--space-md);
    display: flex;
    align-items: center;
    gap: var(--space-sm);
}

/* ==================== ACTION BAR ==================== */
.admin-action-bar {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    flex-wrap: wrap;
}

/* ==================== TABLE ==================== */
.admin-table-container {
    background: var(--bg-card);
    border: 1px solid var(--bg-border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.admin-table-header {
    padding: var(--space-lg);
    border-bottom: 1px solid var(--bg-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--space-md);
}

.admin-table-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: var(--space-sm);
}

.admin-table-search {
    position: relative;
    width: 300px;
}

.admin-table-search input {
    width: 100%;
    padding: var(--space-sm) var(--space-md);
    border: 1px solid var(--bg-border);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    outline: none;
    transition: border-color 0.2s ease;
}

.admin-table-search input:focus {
    border-color: var(--primary);
}

.admin-table-search i {
    position: absolute;
    right: var(--space-md);
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.admin-table thead th {
    background: #F8FAFC;
    padding: var(--space-sm) var(--space-lg);
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--bg-border);
}

.admin-table tbody tr {
    border-bottom: 1px solid var(--bg-border);
    transition: background-color 0.2s ease;
}

.admin-table tbody tr:hover {
    background: var(--bg-hover);
}

.admin-table tbody td {
    padding: var(--space-lg);
    font-size: 0.875rem;
    color: var(--text-primary);
    vertical-align: middle;
}

/* ==================== BUTTONS ==================== */
.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--space-sm);
    padding: var(--space-sm) var(--space-md);
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
}

.btn:focus {
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

.btn-primary {
    background: var(--primary);
    color: var(--text-inverse);
}

.btn-primary:hover {
    background: #1D4ED8;
}

.btn-secondary {
    background: var(--bg-card);
    color: var(--text-secondary);
    border: 1px solid var(--bg-border);
}

.btn-secondary:hover {
    background: var(--bg-hover);
    color: var(--text-primary);
}

.btn-success {
    background: var(--success);
    color: var(--text-inverse);
}

.btn-warning {
    background: var(--warning);
    color: var(--text-inverse);
}

.btn-danger {
    background: var(--danger);
    color: var(--text-inverse);
}

.btn-sm {
    padding: var(--space-sm);
    font-size: 0.75rem;
}

/* ==================== BADGES ==================== */
.badge {
    display: inline-flex;
    align-items: center;
    gap: var(--space-xs);
    padding: var(--space-xs) var(--space-sm);
    border-radius: var(--radius-xl);
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-success {
    background: #D1FAE5;
    color: #065F46;
}

.badge-warning {
    background: #FEF3C7;
    color: #92400E;
}

.badge-danger {
    background: #FEE2E2;
    color: #991B1B;
}

.badge-neutral {
    background: #F1F5F9;
    color: #475569;
}

/* ==================== AVATARS ==================== */
.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--text-inverse);
}

.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 0.75rem;
}

/* ==================== RESPONSIVE DESIGN ==================== */
@media (max-width: 768px) {
    .admin-container {
        padding: var(--space-md);
    }

    .admin-hero .content {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-md);
    }

    .admin-table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-md);
    }

    .admin-table-search {
        width: 100%;
    }

    .admin-stats {
        grid-template-columns: 1fr;
        gap: var(--space-sm);
    }

    .admin-action-bar {
        flex-direction: column;
        align-items: stretch;
        gap: var(--space-sm);
    }

    .btn {
        justify-content: center;
    }

    .admin-table tbody td {
        padding: var(--space-md);
    }
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    text-align: center;
    padding: var(--space-2xl);
    color: var(--text-secondary);
}

.empty-state-icon {
    font-size: 3rem;
    margin-bottom: var(--space-lg);
    opacity: 0.5;
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--space-sm);
}

.empty-state-text {
    margin-bottom: var(--space-lg);
}
</style>
@endpush