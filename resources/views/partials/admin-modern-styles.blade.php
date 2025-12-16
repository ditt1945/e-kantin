@push('styles')
<style>
    /* ==================== MINIMALIS MODERN ADMIN UI 2025 ==================== */
    /* Clean, simple, and effective design */

    /* ==================== GLOBAL RESETS ==================== */
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

        /* Border Radius */
        --radius-sm: 6px;
        --radius-md: 8px;
        --radius-lg: 12px;

        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

        --admin-success: #059669;
        --admin-success-light: #10B981;
        --admin-warning: #D97706;
        --admin-warning-light: #F59E0B;
        --admin-danger: #DC2626;
        --admin-danger-light: #EF4444;
        --admin-info: #0891B2;
        --admin-info-light: #06B6D4;

        /* Professional accent colors - subdued */
        --admin-purple: #6B21A8;
        --admin-pink: #BE185D;
        --admin-rose: #E11D48;
        --admin-indigo: #4F46E5;
        --admin-emerald: #047857;
        --admin-amber: #B45309;
        --admin-cyan: #0E7490;
        --admin-teal: #115E59;
        --admin-slate: #1E293B;
        --admin-gray: #6B7280;
        --admin-neutral: #9CA3AF;

        /* Refined gradient colors */
        --admin-lavender: #8B5CF6;
        --admin-fuchsia: #DB2777;
        --admin-sky: #38BDF8;
        --admin-mint: #10B981;

        /* Professional gradient palette - Subtle & Consistent */
        --gradient-primary: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-light) 100%);
        --gradient-success: linear-gradient(135deg, var(--admin-success) 0%, var(--admin-success-light) 100%);
        --gradient-warning: linear-gradient(135deg, var(--admin-warning) 0%, var(--admin-warning-light) 100%);
        --gradient-danger: linear-gradient(135deg, var(--admin-danger) 0%, var(--admin-danger-light) 100%);
        --gradient-info: linear-gradient(135deg, var(--admin-info) 0%, var(--admin-info-light) 100%);
        --gradient-secondary: linear-gradient(135deg, var(--admin-neutral) 0%, var(--admin-gray) 100%);
        --gradient-accent: linear-gradient(135deg, var(--admin-purple) 0%, var(--admin-indigo) 100%);

        /* Refined themed gradients - Less saturated, more professional */
        --gradient-ocean: linear-gradient(135deg, #1E3A8A 0%, #1E40AF 50%, #1E293B 100%);
        --gradient-forest: linear-gradient(135deg, #064E3B 0%, #047857 50%, #065F46 100%);
        --gradient-sunset: linear-gradient(135deg, #92400E 0%, #B45309 50%, #78350F 100%);
        --gradient-luxury: linear-gradient(135deg, #4C1D95 0%, #5B21B6 50%, #6B21A8 100%);
        --gradient-royal: linear-gradient(135deg, #1E3A8A 0%, #1E293B 50%, #334155 100%);
        --gradient-mint: linear-gradient(135deg, #065F46 0%, #047857 50%, #0D9488 100%);
        --gradient-fuchsia: linear-gradient(135deg, #831843 0%, #BE185D 50%, #9F1239 100%);

        /* Shadow system - Subtler for Light Mode */
        --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.04);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15);

        /* Background Colors */
        --bg-primary: #FFFFFF;
        --bg-secondary: #F9FAFB;
        --bg-tertiary: #F3F4F6;
        --surface: #FFFFFF;
        --surface-hover: #F9FAFB;

        /* Border radius system */
        --radius-xs: 4px;
        --radius-sm: 6px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --radius-xl: 16px;
        --radius-2xl: 20px;
        --radius-3xl: 24px;
        --radius-full: 9999px;
    }

    /* Dark Mode Colors - Enhanced for Better Contrast */
    [data-theme="dark"] {
        --admin-primary: #60A5FA;
        --admin-primary-light: #93C5FD;
        --admin-primary-dark: #2563EB;
        --admin-primary-rgb: 96, 165, 250;

        --admin-success: #34D399;
        --admin-success-light: #6EE7B7;
        --admin-warning: #FCD34D;
        --admin-warning-light: #FDE68A;
        --admin-danger: #F87171;
        --admin-danger-light: #FCA5A5;
        --admin-info: #38BDF8;
        --admin-info-light: #7DD3FC;

        --admin-purple: #A78BFA;
        --admin-pink: #F472B6;
        --admin-emerald: #34D399;
        --admin-rose: #FB7185;
        --admin-amber: #FCD34D;
        --admin-cyan: #38BDF8;
        --admin-teal: #2DD4BF;
        --admin-slate: #CBD5E1;
        --admin-gray: #9CA3AF;
        --admin-neutral: #D1D5DB;

        /* Dark Mode Backgrounds - Better contrast */
        --bg-primary: #0F172A;
        --bg-secondary: #1E293B;
        --bg-tertiary: #334155;
        --surface: #1E293B;
        --surface-hover: #334155;

        /* Text colors for dark mode - less bright */
        --text-primary: #E2E8F0;
        --text-secondary: #94A3B8;
        --text-muted: #6B7280;

        /* Dark Mode Shadows - More subtle */
        --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.4), 0 1px 2px 0 rgba(0, 0, 0, 0.3);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.5), 0 2px 4px -1px rgba(0, 0, 0, 0.4);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.6), 0 4px 6px -2px rgba(0, 0, 0, 0.4);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.7), 0 10px 10px -5px rgba(0, 0, 0, 0.5);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.9);

        /* Dark Mode Gradients - Better contrast */
        --gradient-primary: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        --gradient-success: linear-gradient(135deg, #10B981 0%, #059669 100%);
        --gradient-warning: linear-gradient(135deg, #FCD34D 0%, #F59E0B 100%);
        --gradient-danger: linear-gradient(135deg, #F87171 0%, #DC2626 100%);
        --gradient-info: linear-gradient(135deg, #38BDF8 0%, #0891B2 100%);
        --gradient-secondary: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
        --gradient-accent: linear-gradient(135deg, #A78BFA 0%, #6B21A8 100%);

        /* Dark mode themed gradients - More vibrant */
        --gradient-ocean: linear-gradient(135deg, #0EA5E9 0%, #0284C7 50%, #0369A1 100%);
        --gradient-forest: linear-gradient(135deg, #10B981 0%, #059669 50%, #047857 100%);
        --gradient-sunset: linear-gradient(135deg, #F59E0B 0%, #D97706 50%, #B45309 100%);
        --gradient-luxury: linear-gradient(135deg, #A78BFA 0%, #9333EA 50%, #7C3AED 100%);
        --gradient-royal: linear-gradient(135deg, #1E293B 0%, #334155 50%, #475569 100%);
        --gradient-mint: linear-gradient(135deg, #10B981 0%, #0D9488 50%, #0F766E 100%);
        --gradient-fuchsia: linear-gradient(135deg, #F472B6 0%, #BE185D 50%, #9F1239 100%);
    }

        /* Spacing system */
        --space-1: 0.25rem;
        --space-2: 0.5rem;
        --space-3: 0.75rem;
        --space-4: 1rem;
        --space-5: 1.25rem;
        --space-6: 1.5rem;
        --space-8: 2rem;
        --space-10: 2.5rem;
        --space-12: 3rem;
    }

    /* ==================== ADMIN MAIN CONTAINER ==================== */
    .admin-container {
        padding: var(--space-6) 0;
        min-height: calc(100vh - 200px);
    }

    /* ==================== ADMIN HERO SECTION ==================== */
    .admin-hero {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
        border-radius: var(--radius-3xl);
        padding: var(--space-8);
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: var(--space-8);
        box-shadow: var(--shadow-xl);
    }

    .admin-hero::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: conic-gradient(from 180deg, var(--admin-primary), var(--admin-purple), var(--admin-pink), var(--admin-primary));
        border-radius: 50%;
        opacity: 0.1;
        animation: spin 30s linear infinite;
    }

    .admin-hero::after {
        content: '🛡️';
        position: absolute;
        bottom: var(--space-6);
        right: var(--space-8);
        font-size: 6rem;
        opacity: 0.05;
    }

    .admin-hero .content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--space-4);
    }

    .admin-hero .hero-left {
        flex: 1;
        min-width: 300px;
    }

    .admin-hero .hero-title {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: var(--space-2);
        background: linear-gradient(135deg, #ffffff 0%, #CBD5E1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.2;
    }

    .admin-hero .hero-subtitle {
        font-size: 1.1rem;
        color: #94A3B8;
        margin-bottom: var(--space-4);
        font-weight: 500;
    }

    .admin-hero .hero-stats {
        display: flex;
        gap: var(--space-6);
        flex-wrap: wrap;
    }

    .admin-hero .hero-stat {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
    }

    .admin-hero .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
    }

    .admin-hero .stat-label {
        font-size: 0.8rem;
        color: #94A3B8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .admin-hero .hero-right {
        display: flex;
        gap: var(--space-3);
        align-items: center;
    }

    .admin-hero .time-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: var(--space-3) var(--space-4);
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        font-weight: 600;
    }

    .admin-hero .time-badge i {
        color: var(--admin-warning-light);
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ==================== ADMIN QUICK ACTIONS ==================== */
    .admin-quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: var(--space-4);
        margin-bottom: var(--space-8);
    }

    .admin-quick-action {
        background: #ffffff;
        border: 2px solid #E5E7EB;
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        text-align: center;
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-3);
    }

    .admin-quick-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-primary);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: var(--radius-2xl);
    }

    .admin-quick-action:hover {
        transform: translateY(-8px) scale(1.05);
        border-color: transparent;
        color: #ffffff;
        box-shadow: var(--shadow-2xl);
    }

    .admin-quick-action:hover::before {
        opacity: 1;
    }

    .admin-quick-action:hover > * {
        position: relative;
        z-index: 1;
    }

    .admin-quick-action.primary:hover::before { background: var(--gradient-primary); }
    .admin-quick-action.success:hover::before { background: var(--gradient-success); }
    .admin-quick-action.warning:hover::before { background: var(--gradient-warning); }
    .admin-quick-action.danger:hover::before { background: var(--gradient-danger); }
    .admin-quick-action.info:hover::before { background: var(--gradient-info); }
    .admin-quick-action.purple:hover::before { background: var(--gradient-purple); }
    .admin-quick-action.pink:hover::before { background: var(--gradient-pink); }
    .admin-quick-action.cyan:hover::before { background: var(--gradient-cyan); }

    .admin-quick-action .action-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ffffff;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .admin-quick-action.primary .action-icon { background: var(--gradient-primary); }
    .admin-quick-action.success .action-icon { background: var(--gradient-success); }
    .admin-quick-action.warning .action-icon { background: var(--gradient-warning); }
    .admin-quick-action.danger .action-icon { background: var(--gradient-danger); }
    .admin-quick-action.info .action-icon { background: var(--gradient-info); }
    .admin-quick-action.purple .action-icon { background: var(--gradient-purple); }
    .admin-quick-action.pink .action-icon { background: var(--gradient-pink); }
    .admin-quick-action.cyan .action-icon { background: var(--gradient-cyan); }

    .admin-quick-action:hover .action-icon {
        transform: rotate(-10deg) scale(1.1);
        box-shadow: var(--shadow-xl);
    }

    .admin-quick-action .action-label {
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: var(--space-1);
    }

    .admin-quick-action .action-count {
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .admin-quick-action:hover .action-count {
        color: rgba(255, 255, 255, 0.8);
    }

    .admin-quick-action .badge-notification {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--gradient-danger);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-full);
        min-width: 24px;
        text-align: center;
        box-shadow: var(--shadow-md);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* ==================== ADMIN STATS CARDS ==================== */
    .admin-stats-modern {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-6);
        margin-bottom: var(--space-8);
    }

    .admin-stat-card {
        background: #ffffff;
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        border: 1px solid #E5E7EB;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .admin-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .admin-stat-card:nth-child(2)::before { background: var(--gradient-success); }
    .admin-stat-card:nth-child(3)::before { background: var(--gradient-warning); }
    .admin-stat-card:nth-child(4)::before { background: var(--gradient-danger); }
    .admin-stat-card:nth-child(5)::before { background: var(--gradient-purple); }
    .admin-stat-card:nth-child(6)::before { background: var(--gradient-cyan); }

    .admin-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-2xl);
        border-color: transparent;
    }

    .admin-stat-card:hover::before {
        transform: scaleX(1);
    }

    .admin-stat-card .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--space-4);
    }

    .admin-stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ffffff;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .admin-stat-card:nth-child(1) .stat-icon { background: var(--gradient-primary); }
    .admin-stat-card:nth-child(2) .stat-icon { background: var(--gradient-success); }
    .admin-stat-card:nth-child(3) .stat-icon { background: var(--gradient-warning); }
    .admin-stat-card:nth-child(4) .stat-icon { background: var(--gradient-danger); }
    .admin-stat-card:nth-child(5) .stat-icon { background: var(--gradient-purple); }
    .admin-stat-card:nth-child(6) .stat-icon { background: var(--gradient-cyan); }

    .admin-stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: var(--shadow-lg);
    }

    .admin-stat-card .stat-trend {
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        gap: var(--space-1);
    }

    .admin-stat-card .stat-trend.up {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .admin-stat-card .stat-trend.down {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
    }

    .admin-stat-card .stat-trend.neutral {
        background: linear-gradient(135deg, #F3F4F6, #E5E7EB);
        color: #374151;
    }

    .admin-stat-card .stat-content {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }

    .admin-stat-card .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--text-primary);
        line-height: 1;
        margin-bottom: var(--space-1);
    }

    .admin-stat-card:nth-child(1) .stat-value { color: var(--admin-primary); }
    .admin-stat-card:nth-child(2) .stat-value { color: var(--admin-success); }
    .admin-stat-card:nth-child(3) .stat-value { color: var(--admin-warning); }
    .admin-stat-card:nth-child(4) .stat-value { color: var(--admin-danger); }
    .admin-stat-card:nth-child(5) .stat-value { color: var(--admin-purple); }
    .admin-stat-card:nth-child(6) .stat-value { color: var(--admin-cyan); }

    .admin-stat-card .stat-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .admin-stat-card .stat-description {
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-weight: 500;
        line-height: 1.4;
    }

    /* ==================== ADMIN DATA TABLES ==================== */
    .admin-table-modern {
        background: #ffffff;
        border-radius: var(--radius-2xl);
        overflow: hidden;
        border: 1px solid #E5E7EB;
        box-shadow: var(--shadow-sm);
        margin-bottom: var(--space-6);
    }

    .admin-table-modern .table-header {
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        padding: var(--space-5) var(--space-6);
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--space-4);
    }

    .admin-table-modern .table-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }

    .admin-table-modern .table-title .title-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: var(--gradient-primary);
        color: #ffffff;
    }

    .admin-table-modern .table-actions {
        display: flex;
        gap: var(--space-3);
        align-items: center;
        flex-wrap: wrap;
    }

    .admin-table-modern .search-box {
        position: relative;
    }

    .admin-table-modern .search-input {
        padding: var(--space-2) var(--space-3) var(--space-2) 2.5rem;
        border: 2px solid #E5E7EB;
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        transition: all 0.3s ease;
        width: 250px;
        background: #ffffff;
    }

    .admin-table-modern .search-input:focus {
        outline: none;
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .admin-table-modern .search-icon {
        position: absolute;
        left: var(--space-3);
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        pointer-events: none;
    }

    .admin-table-modern .table-body {
        padding: 0;
    }

    .admin-table-modern .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .admin-table-modern .table thead {
        background: linear-gradient(135deg, #1E293B 0%, #334155 100%);
    }

    .admin-table-modern .table thead th {
        border: none;
        color: #F8FAFC;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        padding: var(--space-4) var(--space-4);
        background: transparent;
        font-family: 'Inter', sans-serif;
    }

    .admin-table-modern .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #E2E8F0;
        background: #FFFFFF;
    }

    .admin-table-modern .table tbody tr:hover {
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .admin-table-modern .table tbody tr:nth-child(even) {
        background: #FAFBFC;
    }

    .admin-table-modern .table tbody tr:nth-child(even):hover {
        background: linear-gradient(135deg, #F1F5F9 0%, #E2E8F0 100%);
    }

    .admin-table-modern .table td {
        vertical-align: middle;
        padding: var(--space-4) var(--space-4);
        color: var(--text-primary);
        border: none;
    }

    /* ==================== ADMIN STATUS BADGES ==================== */
    .admin-badge-modern {
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
    }

    .admin-badge-modern.active {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .admin-badge-modern.inactive {
        background: linear-gradient(135deg, #F3F4F6, #E5E7EB);
        color: #374151;
    }

    .admin-badge-modern.pending {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
    }

    .admin-badge-modern.completed {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .admin-badge-modern.cancelled {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
    }

    /* ==================== ADMIN BUTTONS ==================== */
    .admin-btn-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
        padding: var(--space-2) var(--space-4);
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .admin-btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .admin-btn-modern:hover::before {
        left: 100%;
    }

    .admin-btn-modern.primary {
        background: var(--gradient-primary);
        color: #ffffff;
    }

    .admin-btn-modern.primary:hover {
        background: var(--gradient-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    }

    .admin-btn-modern.success {
        background: var(--gradient-success);
        color: #ffffff;
    }

    .admin-btn-modern.success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .admin-btn-modern.warning {
        background: var(--gradient-warning);
        color: #ffffff;
    }

    .admin-btn-modern.danger {
        background: var(--gradient-danger);
        color: #ffffff;
    }

    .admin-btn-modern.info {
        background: var(--gradient-info);
        color: #ffffff;
    }

    .admin-btn-modern.outline {
        background: transparent;
        border: 2px solid #E5E7EB;
        color: var(--text-primary);
    }

    .admin-btn-modern.outline:hover {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
        background: rgba(37, 99, 235, 0.05);
    }

    .admin-btn-modern.sm {
        padding: var(--space-1) var(--space-3);
        font-size: 0.75rem;
    }

    /* ==================== ADMIN FORM ELEMENTS ==================== */
    .admin-form-modern {
        background: #ffffff;
        border-radius: var(--radius-2xl);
        padding: var(--space-6);
        border: 1px solid #E5E7EB;
        box-shadow: var(--shadow-sm);
        margin-bottom: var(--space-6);
    }

    .admin-form-modern .form-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-5);
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }

    .admin-form-modern .form-group {
        margin-bottom: var(--space-5);
    }

    .admin-form-modern .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin-bottom: var(--space-2);
    }

    .admin-form-modern .form-control,
    .admin-form-modern .form-select {
        width: 100%;
        padding: var(--space-3) var(--space-4);
        border: 2px solid #E5E7EB;
        border-radius: var(--radius-lg);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .admin-form-modern .form-control:focus,
    .admin-form-modern .form-select:focus {
        outline: none;
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* ==================== ADMIN EMPTY STATES ==================== */
    .admin-empty-modern {
        text-align: center;
        padding: var(--space-12) var(--space-6);
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        border-radius: var(--radius-2xl);
        border: 2px dashed #CBD5E1;
        margin: var(--space-6) 0;
    }

    .admin-empty-modern .empty-icon {
        font-size: 4rem;
        color: #CBD5E1;
        margin-bottom: var(--space-4);
        display: block;
    }

    .admin-empty-modern .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-2);
    }

    .admin-empty-modern .empty-text {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin-bottom: var(--space-6);
        line-height: 1.5;
    }

    .admin-empty-modern .empty-action {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-5);
        background: var(--gradient-primary);
        color: #ffffff;
        border-radius: var(--radius-lg);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .admin-empty-modern .empty-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        color: #ffffff;
    }

    /* ==================== DARK MODE SUPPORT ==================== */
    [data-theme="dark"] {
        --card-bg: #1E293B;
        --border-gray: #334155;
        --text-primary: #E2E8F0;
        --text-secondary: #94A3B8;
        --light-gray: #334155;

        /* Enhanced dark mode colors for better contrast */
        --bg-primary: #0F172A;
        --bg-secondary: #1E293B;
        --bg-tertiary: #334155;
        --surface: #1E293B;
        --surface-hover: #334155;
    }

    [data-theme="dark"] .admin-container {
        background: var(--body-bg);
    }

    [data-theme="dark"] .admin-hero {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
    }

    [data-theme="dark"] .admin-stat-card,
    [data-theme="dark"] .admin-table-modern,
    [data-theme="dark"] .admin-form-modern {
        background: var(--card-bg);
        border-color: var(--border-gray);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    [data-theme="dark"] .admin-table-modern .table-header {
        background: linear-gradient(135deg, #334155 0%, #475569 100%);
        border-bottom-color: var(--border-gray);
    }

    [data-theme="dark"] .admin-table-modern .table thead {
        background: linear-gradient(135deg, #334155 0%, #475569 100%);
    }

    [data-theme="dark"] .admin-table-modern .table tbody tr {
        border-bottom-color: var(--border-gray);
    }

    [data-theme="dark"] .admin-table-modern .table tbody tr:hover {
        background: linear-gradient(135deg, #334155 0%, #475569 100%);
    }

    [data-theme="dark"] .admin-quick-action {
        background: var(--card-bg);
        border-color: var(--border-gray);
    }

    [data-theme="dark"] .admin-empty-modern {
        background: linear-gradient(135deg, #1E293B 0%, #334155 100%);
        border-color: var(--border-gray);
    }

    [data-theme="dark"] .admin-form-modern .form-control,
    [data-theme="dark"] .admin-form-modern .form-select {
        background: var(--card-bg);
        border-color: var(--border-gray);
        color: var(--text-primary);
    }

    [data-theme="dark"] .admin-form-modern .form-control:focus,
    [data-theme="dark"] .admin-form-modern .form-select:focus {
        border-color: var(--admin-primary);
    }

    [data-theme="dark"] .admin-table-modern .search-input {
        background: var(--card-bg);
        border-color: var(--border-gray);
        color: var(--text-primary);
    }

    [data-theme="dark"] .admin-table-modern .search-input:focus {
        border-color: var(--admin-primary);
    }

    [data-theme="dark"] .admin-badge-modern.inactive {
        background: linear-gradient(135deg, #374151, #4B5563);
        color: #9CA3AF;
    }

    [data-theme="dark"] .admin-hero .hero-subtitle {
        color: #CBD5E1;
    }

    [data-theme="dark"] .admin-hero .hero-title {
        color: #F1F5F9;
    }

    [data-theme="dark"] .admin-hero .time-badge {
        background: rgba(255, 255, 255, 0.15);
        color: #E2E8F0;
    }

    [data-theme="dark"] .admin-stat-card .stat-value {
        color: #F1F5F9;
    }

    [data-theme="dark"] .admin-stat-card .stat-label {
        color: #CBD5E1;
    }

    [data-theme="dark"] .admin-stat-card .stat-description {
        color: #94A3B8;
    }

    /* ==================== RESPONSIVE DESIGN ==================== */
    @media (max-width: 1024px) {
        .admin-container {
            padding: var(--space-3) var(--space-2);
            max-width: 100%;
            overflow-x: hidden;
        }

        .admin-hero {
            padding: var(--space-5);
            margin-bottom: var(--space-5);
        }

        .admin-hero .hero-title {
            font-size: 1.75rem;
        }

        .admin-hero .hero-stats {
            gap: var(--space-3);
        }

        .admin-quick-actions {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: var(--space-3);
        }

        .admin-stats-modern {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-3);
        }

        .admin-table-modern .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--space-3);
        }

        .admin-table-modern .search-input {
            width: 200px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 600px;
        }
    }

    @media (max-width: 768px) {
        html, body {
            overflow-x: hidden;
        }

        .admin-container {
            padding: var(--space-2) var(--space-1);
            max-width: 100vw;
            overflow-x: hidden;
        }

        .admin-hero {
            padding: var(--space-5);
        }

        .admin-hero .content {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--space-4);
        }

        .admin-hero .hero-title {
            font-size: 1.5rem;
        }

        .admin-hero .hero-subtitle {
            font-size: 1rem;
        }

        .admin-hero .hero-stats {
            width: 100%;
            justify-content: space-between;
        }

        .admin-hero .stat-value {
            font-size: 1.5rem;
        }

        .admin-quick-actions {
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-3);
        }

        .admin-quick-action {
            padding: var(--space-4);
        }

        .admin-quick-action .action-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }

        .admin-stats-modern {
            grid-template-columns: 1fr;
            gap: var(--space-3);
        }

        .admin-stat-card {
            padding: var(--space-4);
        }

        .admin-stat-card .stat-value {
            font-size: 2rem;
        }

        .admin-stat-card .stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }

        .admin-table-modern .table-header {
            padding: var(--space-4);
        }

        .admin-table-modern .search-input {
            width: 100%;
        }

        .admin-table-modern .table-actions {
            flex-wrap: wrap;
            gap: var(--space-2);
        }

        .admin-table-modern .table-actions > * {
            flex: 1;
            min-width: 0;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 calc(var(--space-2) * -1);
            padding: 0 var(--space-2);
        }

        .admin-table-modern .table {
            min-width: 600px;
        }

        .admin-table-modern .table th,
        .admin-table-modern .table td {
            padding: var(--space-2);
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .admin-table-modern .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .admin-form-modern {
            padding: var(--space-4);
        }

        .admin-empty-modern {
            padding: var(--space-8) var(--space-4);
        }

        .admin-empty-modern .empty-icon {
            font-size: 3rem;
        }

        .admin-btn-modern {
            width: 100%;
            justify-content: center;
            padding: var(--space-2) var(--space-3);
            font-size: 0.85rem;
        }

        .admin-btn-modern.sm {
            padding: var(--space-1) var(--space-2);
            font-size: 0.75rem;
        }

        .btn-group {
            flex-wrap: wrap;
            gap: var(--space-1);
        }

        .btn-group .admin-btn-modern {
            flex: 1;
            min-width: 60px;
        }
    }

    @media (max-width: 480px) {
        .admin-quick-actions {
            grid-template-columns: 1fr;
        }

        .admin-hero .hero-stats {
            flex-direction: column;
            gap: var(--space-2);
        }

        .admin-hero .hero-stat {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
        }

        .admin-table-modern .table {
            font-size: 0.75rem;
        }

        .admin-table-modern .table th,
        .admin-table-modern .table td {
            padding: var(--space-2);
        }
    }

    /* ==================== ANIMATIONS ==================== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slideInRight 0.6s ease-out;
    }

    .animate-scale {
        animation: scaleIn 0.4s ease-out;
    }

    /* Stagger animation delays */
    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }

    /* ==================== ACCESSIBILITY ==================== */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Focus visible for better keyboard navigation */
    .admin-btn-modern:focus-visible,
    .admin-quick-action:focus-visible,
    .admin-form-modern .form-control:focus-visible,
    .admin-form-modern .form-select:focus-visible {
        outline: 2px solid var(--admin-primary);
        outline-offset: 2px;
    }

    /* ==================== LOADING STATES ==================== */
    .admin-loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #ffffff;
        animation: spin 1s ease-in-out infinite;
    }

    .admin-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* ==================== MODERN ENHANCEMENTS ==================== */
    .admin-glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .admin-gradient-text {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .admin-shadow-soft {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    }

    .admin-shadow-glow {
        box-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: var(--radius-full);
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        border-radius: var(--radius-full);
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, var(--admin-primary-dark), var(--admin-primary));
    }

    [data-theme="dark"] ::-webkit-scrollbar-track {
        background: #374151;
    }

    [data-theme="dark"] ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #4B5563, #6B7280);
    }

    /* ==================== ASYMMETRICAL HERO SECTION ==================== */
    .admin-hero-asymmetric {
        position: relative;
        padding: 3rem 0;
        background: linear-gradient(135deg, #0EA5E9 0%, #1E40AF 50%, #1E293B 100%);
        border-radius: 0 0 1.5rem 0;
        overflow: hidden;
        margin-bottom: 2rem;
        color: white;
    }

    [data-theme="dark"] .admin-hero-asymmetric {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
        color: white;
    }

    .admin-hero-asymmetric .hero-pattern {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        opacity: 0.15;
        background: conic-gradient(from 180deg, #1E3A8A, #4C1D95, #831843, #92400E, #064E3B, #1E3A8A);
        animation: conicRotate 30s linear infinite;
        border-radius: 0 0 1.5rem 0;
    }

    @keyframes conicRotate {
        0% { transform: rotate(0deg) scale(1.5); }
        100% { transform: rotate(360deg) scale(1.5); }
    }

    @keyframes patternFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(20px, -20px) scale(1.05); }
        66% { transform: translate(-20px, 20px) scale(0.95); }
    }

    .admin-hero-asymmetric .hero-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .greeting-container {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .greeting-emoji {
        font-size: 3rem;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        animation: emojiBounce 3s ease-in-out infinite;
    }

    @keyframes emojiBounce {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-10px) scale(1.1); }
    }

    .hero-stats-asymmetric {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
        align-items: stretch;
    }

    /* Large Featured Stat Card */
    .stat-item-large {
        background: var(--gradient-luxury);
        color: white;
        padding: 2rem;
        border-radius: 1.5rem;
        min-width: 280px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 20px 25px -5px rgba(139, 92, 246, 0.3);
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .stat-item-large::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-item-large:hover::before {
        opacity: 1;
    }

    .stat-item-large:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.4);
    }

    .stat-item-large .stat-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stat-item-large .stat-content {
        flex: 1;
    }

    .stat-item-large .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .stat-item-large .stat-label {
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .stat-item-large .stat-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.4rem 0.8rem;
        border-radius: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        width: fit-content;
    }

    .stat-item-large .stat-decoration {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 4s ease-in-out infinite;
    }

    /* Vertical Stack of Mini Stats */
    .stat-item-vertical {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        flex: 1;
    }

    .mini-stat {
        background: var(--surface);
        border-radius: 1rem;
        padding: 1.25rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
        min-height: 80px;
    }

    [data-theme="dark"] .mini-stat {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .mini-stat::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.4s ease;
    }

    .mini-stat:hover::after {
        width: 150px;
        height: 150px;
    }

    .mini-stat:hover {
        transform: translateY(-4px) translateX(4px);
        box-shadow: var(--shadow-lg);
        background: var(--surface-hover);
    }

    [data-theme="dark"] .mini-stat:hover {
        background: var(--surface-hover);
    }

    .mini-stat .mini-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .mini-stat:hover .mini-icon {
        transform: scale(1.1) rotate(3deg);
    }

    /* Mini stat backgrounds */
    .mini-stat.emerald {
        border-left: 4px solid var(--admin-emerald);
    }

    .mini-stat.emerald .mini-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
        color: var(--admin-emerald);
    }

    .mini-stat.ocean-gradient {
        background: var(--gradient-ocean) !important;
        color: white !important;
        border: none !important;
    }

    .mini-stat.ocean-gradient .mini-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .mini-stat.sunset-gradient {
        background: var(--gradient-sunset) !important;
        color: white !important;
        border: none !important;
    }

    .mini-stat.sunset-gradient .mini-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .mini-stat.ocean-gradient:hover,
    .mini-stat.sunset-gradient:hover {
        transform: translateY(-6px) translateX(6px) !important;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3) !important;
    }

    .mini-stat.ocean-gradient:hover {
        box-shadow: 0 20px 40px -10px rgba(14, 165, 233, 0.4) !important;
    }

    .mini-stat.sunset-gradient:hover {
        box-shadow: 0 20px 40px -10px rgba(236, 72, 153, 0.4) !important;
    }

    .mini-content {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .mini-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--text-primary);
    }

    .mini-stat.ocean-gradient .mini-number,
    .mini-stat.sunset-gradient .mini-number {
        color: white;
    }

    .mini-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .mini-stat.ocean-gradient .mini-label,
    .mini-stat.sunset-gradient .mini-label {
        color: rgba(255, 255, 255, 0.9);
    }

    .hero-card-floating {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 1.5rem;
        padding: 1.5rem;
        box-shadow: 0 20px 40px rgba(14, 165, 233, 0.15);
        position: relative;
        z-index: 2;
        animation: float 6s ease-in-out infinite;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }

    [data-theme="dark"] .hero-card-floating {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }

    .time-display {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--admin-warning-light);
        margin-bottom: 0.5rem;
        font-variant-numeric: tabular-nums;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* ==================== DYNAMIC QUICK ACTIONS ==================== */
    .admin-quick-dynamic {
        margin-bottom: 2rem;
    }

    .quick-actions-grid {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: 1fr;
    }

    .quick-action-large {
        background: var(--gradient-primary);
        color: white;
        border-radius: 1.5rem;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-xl);
    }

    .quick-action-large::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .quick-action-large:hover::before {
        opacity: 1;
    }

    .quick-action-large:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.3);
        color: white;
    }

    .quick-action-large:active {
        transform: translateY(-4px) scale(1.01);
        transition: all 0.1s ease;
    }

    .action-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .action-icon-wrapper {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        position: relative;
    }

    .icon-glow {
        position: absolute;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent);
        border-radius: 1rem;
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from { transform: scale(1); opacity: 0.5; }
        to { transform: scale(1.2); opacity: 0.8; }
    }

    .action-text h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .action-text p {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0.25rem 0 0 0;
    }

    .action-arrow {
        margin-left: auto;
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .quick-action-large:hover .action-arrow {
        transform: translateX(5px);
    }

    .action-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .quick-actions-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .quick-action-medium {
        background: var(--surface);
        border-radius: 1rem;
        padding: 1.75rem 1.5rem;
        text-decoration: none;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
        min-height: 140px;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    [data-theme="dark"] .quick-action-medium {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .quick-action-medium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .quick-action-medium:hover::before {
        left: 100%;
    }

    .quick-action-medium:hover {
        transform: translateY(-4px) rotateX(2deg);
        box-shadow: var(--shadow-xl);
        background: var(--surface-hover);
    }

    [data-theme="dark"] .quick-action-medium:hover {
        background: var(--surface-hover);
    }

    .quick-action-medium:active {
        transform: translateY(-2px) rotateX(1deg);
        transition: all 0.1s ease;
    }

    .quick-action-medium.success { border-left: 4px solid var(--admin-success); }
    .quick-action-medium.warning { border-left: 4px solid var(--admin-warning); }
    .quick-action-medium.emerald { border-left: 4px solid var(--admin-emerald); }
    .quick-action-medium.amber { border-left: 4px solid var(--admin-amber); }
    .quick-action-medium.rose { border-left: 4px solid var(--admin-rose); }
    .quick-action-medium.indigo { border-left: 4px solid var(--admin-indigo); }

    /* Premium gradient cards */
    .luxury-gradient {
        background: var(--gradient-luxury) !important;
        color: white !important;
        border: none !important;
    }

    .sunset-gradient {
        background: var(--gradient-sunset) !important;
        color: white !important;
        border: none !important;
    }

    .ocean-gradient {
        background: var(--gradient-ocean) !important;
        color: white !important;
        border: none !important;
    }

    .fuchsia-gradient {
        background: var(--gradient-pink) !important;
        color: white !important;
        border: none !important;
    }

    .forest-gradient {
        background: var(--gradient-forest) !important;
        color: white !important;
        border: none !important;
    }

    /* Premium gradient hover effects - Professional & Subtle */
    .luxury-gradient:hover,
    .sunset-gradient:hover,
    .ocean-gradient:hover,
    .fuchsia-gradient:hover,
    .forest-gradient:hover {
        transform: translateY(-6px) scale(1.02) !important;
        box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.2) !important;
        filter: brightness(1.05) !important;
    }

    /* Subtle color-specific hover effects */
    .luxury-gradient:hover {
        box-shadow: 0 16px 32px -8px rgba(76, 29, 149, 0.25) !important;
    }

    .sunset-gradient:hover {
        box-shadow: 0 16px 32px -8px rgba(146, 64, 14, 0.25) !important;
    }

    .ocean-gradient:hover {
        box-shadow: 0 16px 32px -8px rgba(30, 58, 138, 0.25) !important;
    }

    .fuchsia-gradient:hover {
        box-shadow: 0 16px 32px -8px rgba(131, 24, 67, 0.25) !important;
    }

    .forest-gradient:hover {
        box-shadow: 0 16px 32px -8px rgba(6, 78, 59, 0.25) !important;
    }

    .quick-actions-small {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
    }

    .quick-action-small {
        background: var(--surface);
        border-radius: 1rem;
        padding: 1.5rem 1rem;
        text-decoration: none;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        text-align: center;
        position: relative;
        overflow: hidden;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    [data-theme="dark"] .quick-action-small {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .quick-action-small::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.5s ease;
    }

    .quick-action-small:hover::after {
        width: 200px;
        height: 200px;
    }

    .quick-action-small:hover {
        transform: translateY(-6px) scale(1.05);
        box-shadow: var(--shadow-lg);
        background: var(--surface-hover);
    }

    [data-theme="dark"] .quick-action-small:hover {
        background: var(--surface-hover);
    }

    .quick-action-small:active {
        transform: translateY(-3px) scale(1.02);
        transition: all 0.1s ease;
    }

    .mini-icon {
        transition: all 0.3s ease;
    }

    .quick-action-small:hover .mini-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .quick-action-small.danger { border-left: 4px solid var(--admin-danger); }
    .quick-action-small.info { border-left: 4px solid var(--admin-info); }
    .quick-action-small.cyan { border-left: 4px solid var(--admin-cyan); }
    .quick-action-small.purple { border-left: 4px solid var(--admin-purple); }
    .quick-action-small.pink { border-left: 4px solid var(--admin-pink); }
    .quick-action-small.emerald { border-left: 4px solid var(--admin-emerald); }
    .quick-action-small.rose { border-left: 4px solid var(--admin-rose); }
    .quick-action-small.indigo { border-left: 4px solid var(--admin-indigo); }
    .quick-action-small.amber { border-left: 4px solid var(--admin-amber); }

    .mini-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(139, 92, 246, 0.1));
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.2rem;
        color: var(--admin-primary);
        position: relative;
    }

    /* Mini icon for gradient cards */
    .luxury-gradient .mini-icon,
    .sunset-gradient .mini-icon,
    .ocean-gradient .mini-icon,
    .fuchsia-gradient .mini-icon,
    .forest-gradient .mini-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .notification-dot {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--admin-danger);
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.4rem;
        border-radius: 1rem;
        min-width: 18px;
        text-align: center;
    }

    .quick-action-small span {
        display: block;
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 600;
        line-height: 1.2;
        text-align: center;
    }

    .quick-action-small strong {
        font-size: 0.9rem;
        color: var(--text-primary);
        font-weight: 700;
        line-height: 1.2;
        text-align: center;
    }

    /* ==================== ASYMMETRICAL STATS CARDS ==================== */
    .admin-stats-asymmetric {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
        align-items: start;
    }

    .stat-card-featured {
        background: var(--surface);
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: var(--shadow-xl);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    [data-theme="dark"] .stat-card-featured {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-card-featured::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(99, 102, 241, 0.1), transparent);
        animation: rotateCard 15s linear infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card-featured:hover::before {
        opacity: 1;
    }

    @keyframes rotateCard {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .stat-card-featured:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.2);
        border-color: rgba(99, 102, 241, 0.2);
    }

    .stat-card-featured:active {
        transform: translateY(-4px) scale(1.01);
        transition: all 0.1s ease;
    }

    .featured-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .featured-icon {
        width: 60px;
        height: 60px;
        background: var(--gradient-primary);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        position: relative;
    }

    .icon-ripple {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid rgba(37, 99, 235, 0.3);
        border-radius: 1rem;
        animation: rippleExpand 3s ease-out infinite;
    }

    @keyframes rippleExpand {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    .featured-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(16, 185, 129, 0.1);
        color: var(--admin-success);
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .featured-content {
        margin-bottom: 2rem;
    }

    .featured-number {
        font-size: 3rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-variant-numeric: tabular-nums;
    }

    .featured-label {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .featured-description {
        font-size: 1rem;
        color: var(--text-secondary);
    }

    .featured-chart {
        display: flex;
        align-items: end;
        gap: 0.5rem;
        height: 60px;
    }

    .mini-bar-chart {
        display: flex;
        align-items: end;
        gap: 0.5rem;
        height: 100%;
    }

    .mini-bar-chart .bar {
        width: 8px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        border-radius: 4px;
        transition: height 0.3s ease;
    }

    .mini-bar-chart .bar:hover {
        opacity: 0.8;
    }

    .stats-diagonal {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .stat-card-diagonal {
        background: var(--surface);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] .stat-card-diagonal {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-card-diagonal:hover {
        transform: translateX(3px);
        box-shadow: var(--shadow-md);
        background: var(--surface-hover);
    }

    [data-theme="dark"] .stat-card-diagonal:hover {
        background: var(--surface-hover);
    }

    .stat-card-diagonal.success { border-left-color: var(--admin-success); }
    .stat-card-diagonal.info { border-left-color: var(--admin-info); }

    /* Premium gradient diagonal cards */
    .stat-card-diagonal.ocean-gradient {
        background: var(--gradient-ocean) !important;
        color: white !important;
        border: none !important;
    }

    .stat-card-diagonal.ocean-gradient .diagonal-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .stat-card-diagonal.sunset-gradient {
        background: var(--gradient-sunset) !important;
        color: white !important;
        border: none !important;
    }

    .stat-card-diagonal.sunset-gradient .diagonal-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .stat-card-diagonal.ocean-gradient .diagonal-text,
    .stat-card-diagonal.sunset-gradient .diagonal-text {
        color: white;
    }

    .diagonal-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Premium Performance Card */
    .stat-card-performance {
        background: var(--gradient-luxury);
        color: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: var(--shadow-xl);
        position: relative;
        overflow: hidden;
        grid-column: 1 / -1;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card-performance::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card-performance:hover::before {
        opacity: 1;
    }

    .stat-card-performance:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.4);
    }

    .performance-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .performance-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .performance-title {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-left: 1rem;
    }

    .performance-title h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
    }

    .live-indicator {
        background: rgba(16, 185, 129, 0.2);
        color: #10B981;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        animation: pulse 2s ease-in-out infinite;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .performance-content {
        display: flex;
        gap: 2rem;
        align-items: stretch;
    }

    .performance-main {
        flex: 1;
    }

    .main-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .main-label {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .performance-metrics {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .metric-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .metric-label {
        font-size: 0.85rem;
        opacity: 0.9;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .metric-bar {
        height: 6px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .metric-fill {
        height: 100%;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 3px;
        transition: width 1s ease;
    }

    .metric-value {
        font-size: 1.1rem;
        font-weight: 700;
        text-align: center;
    }

    .performance-decoration {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        opacity: 0.2;
    }

    .decoration-circle {
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    /* Wave decoration for diagonal cards */
    .deco-wave {
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        clip-path: polygon(0 0, 100% 0, 0 100%);
        animation: waveFloat 8s ease-in-out infinite;
    }

    @keyframes waveFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(10px); }
    }

    .floating-progress {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .progress-bar {
        flex: 1;
        height: 6px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: white;
        border-radius: 3px;
        transition: width 1s ease;
    }

    /* ==================== ASYMMETRICAL TABLE ==================== */
    .admin-table-asymmetric {
        background: var(--surface);
        border-radius: 1.5rem;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] .admin-table-asymmetric {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table-header-asymmetric {
        background: var(--bg-secondary);
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 2rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] .table-header-asymmetric {
        background: var(--bg-tertiary);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex: 1;
    }

    .header-icon-large {
        width: 60px;
        height: 60px;
        background: var(--gradient-primary);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        position: relative;
    }

    .header-text h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: var(--text-primary);
    }

    .header-text p {
        font-size: 1rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .search-modern {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-modern i {
        position: absolute;
        left: 1rem;
        color: var(--text-secondary);
        z-index: 1;
    }

    .search-modern input {
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 2px solid rgba(37, 99, 235, 0.1);
        border-radius: 0.75rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        width: 250px;
    }

    .search-modern input:focus {
        outline: none;
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .view-all-btn {
        background: var(--gradient-primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .view-all-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    .table-body-asymmetric {
        padding: 2rem;
    }

    .orders-modern {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .order-card-asymmetric {
        background: var(--surface);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 1rem;
        padding: 1.5rem;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 2rem;
        align-items: center;
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    [data-theme="dark"] .order-card-asymmetric {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    @keyframes fadeInUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .order-card-asymmetric:hover {
        box-shadow: var(--shadow-md);
        transform: translateX(3px);
        background: var(--surface-hover);
    }

    [data-theme="dark"] .order-card-asymmetric:hover {
        background: var(--surface-hover);
    }

    /* ==================== FLOATING WIDGETS ==================== */
    .admin-widgets-floating {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .widget-floating {
        background: var(--surface);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] .widget-floating {
        background: var(--surface);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .widget-floating:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        background: var(--surface-hover);
    }

    [data-theme="dark"] .widget-floating:hover {
        background: var(--surface-hover);
    }

    .widget-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .widget-icon {
        width: 40px;
        height: 40px;
        background: var(--gradient-primary);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }

    .widget-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .metric-row {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .metric-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        min-width: 80px;
    }

    .metric-bar {
        flex: 1;
        height: 8px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        overflow: hidden;
    }

    .metric-fill {
        height: 100%;
        background: var(--gradient-primary);
        border-radius: 4px;
        transition: width 1s ease;
    }

    .metric-fill.success { background: var(--gradient-success); }
    .metric-fill.info { background: var(--gradient-info); }

    .quick-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        background: var(--bg-secondary);
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    [data-theme="dark"] .quick-stat {
        background: var(--bg-tertiary);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .quick-stat:hover {
        background: var(--surface-hover);
        transform: translateX(3px);
        border-color: rgba(0, 0, 0, 0.08);
    }

    [data-theme="dark"] .quick-stat:hover {
        border-color: rgba(255, 255, 255, 0.1);
    }

    .stat-icon-small {
        width: 35px;
        height: 35px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }

    .stat-icon-small.primary { background: var(--gradient-primary); }
    .stat-icon-small.success { background: var(--gradient-success); }
    .stat-icon-small.warning { background: var(--gradient-warning); }

    /* ==================== ENHANCED RESPONSIVE DESIGN ==================== */
    @media (max-width: 1024px) {
        .admin-hero-asymmetric .hero-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .admin-stats-asymmetric {
            grid-template-columns: 1fr;
        }

        .quick-actions-row {
            grid-template-columns: 1fr;
        }

        .table-header-asymmetric {
            flex-direction: column;
            gap: 1.5rem;
            align-items: stretch;
        }

        .header-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .search-modern input {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .admin-hero-asymmetric {
            padding: 2rem 0;
        }

        .greeting-container {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .hero-title {
            font-size: 2rem;
        }

        .hero-stats-asymmetric {
            justify-content: center;
            flex-wrap: wrap;
        }

        .quick-actions-small {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }

        .quick-action-small {
            min-height: 100px;
            padding: 1rem 0.75rem;
        }

        .quick-action-small span {
            font-size: 0.75rem;
        }

        .quick-action-small strong {
            font-size: 0.8rem;
        }

        .order-card-asymmetric {
            grid-template-columns: 1fr;
            gap: 1rem;
            text-align: left;
        }

        .order-right {
            align-items: start;
        }

        .admin-widgets-floating {
            grid-template-columns: 1fr;
        }

        .featured-number {
            font-size: 2.5rem;
        }

        .table-header-asymmetric {
            padding: 1.5rem;
        }

        .table-body-asymmetric {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .admin-container {
            padding: 0 0.5rem;
        }

        .admin-hero-asymmetric {
            padding: 1.5rem 0;
        }

        .hero-title {
            font-size: 1.75rem;
        }

        .quick-actions-small {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }

        .quick-action-small {
            min-height: 90px;
            padding: 0.75rem 0.5rem;
        }

        .quick-action-small span {
            font-size: 0.7rem;
        }

        .quick-action-small strong {
            font-size: 0.75rem;
        }

        .hero-card-floating {
            padding: 1rem;
        }

        .order-card-asymmetric {
            padding: 1rem;
        }
    }
</style>
@endpush