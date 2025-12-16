<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'e-Kantin - Kantin Digital SMKN 2 Surabaya')</title>

    <!-- Include loading states early -->
    @include('partials.loading-states')

    <!-- Include mobile optimizations -->
    @include('partials.mobile-optimizations')

    <!-- Include custom styles -->
    @stack('styles')

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ========== LOADING SCREEN ========== */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        
        [data-theme="dark"] .page-loader {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        
        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loader-logo {
            width: 100px;
            height: 100px;
            margin-bottom: 24px;
            animation: pulse-scale 1.5s ease-in-out infinite;
            filter: drop-shadow(0 8px 24px rgba(37, 99, 235, 0.3));
        }
        
        @keyframes pulse-scale {
            0%, 100% {
                transform: scale(1);
                filter: drop-shadow(0 8px 24px rgba(37, 99, 235, 0.3));
            }
            50% {
                transform: scale(1.08);
                filter: drop-shadow(0 12px 32px rgba(37, 99, 235, 0.5));
            }
        }
        
        .loader-spinner {
            width: 50px;
            height: 50px;
            position: relative;
            margin-bottom: 20px;
        }
        
        .loader-spinner::before,
        .loader-spinner::after {
            content: '';
            position: absolute;
            border-radius: 50%;
        }
        
        .loader-spinner::before {
            width: 100%;
            height: 100%;
            border: 4px solid #E2E8F0;
            border-top-color: #2563EB;
            animation: spin 1s linear infinite;
        }
        
        .loader-spinner::after {
            width: 70%;
            height: 70%;
            top: 15%;
            left: 15%;
            border: 3px solid transparent;
            border-bottom-color: #3B82F6;
            animation: spin 0.8s linear infinite reverse;
        }
        
        [data-theme="dark"] .loader-spinner::before {
            border-color: #334155;
            border-top-color: #3B82F6;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .loader-text {
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: #2563EB;
            letter-spacing: 0.5px;
        }
        
        .loader-text span {
            display: inline-block;
            animation: bounce-text 1.4s ease-in-out infinite;
        }
        
        .loader-text span:nth-child(1) { animation-delay: 0s; }
        .loader-text span:nth-child(2) { animation-delay: 0.1s; }
        .loader-text span:nth-child(3) { animation-delay: 0.2s; }
        .loader-text span:nth-child(4) { animation-delay: 0.3s; }
        .loader-text span:nth-child(5) { animation-delay: 0.4s; }
        .loader-text span:nth-child(6) { animation-delay: 0.5s; }
        .loader-text span:nth-child(7) { animation-delay: 0.6s; }
        .loader-text span:nth-child(8) { animation-delay: 0.7s; }
        
        @keyframes bounce-text {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .loader-dots {
            display: flex;
            gap: 6px;
            margin-top: 16px;
        }
        
        .loader-dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2563EB;
            animation: dot-pulse 1.4s ease-in-out infinite;
        }
        
        .loader-dots span:nth-child(1) { animation-delay: 0s; }
        .loader-dots span:nth-child(2) { animation-delay: 0.2s; }
        .loader-dots span:nth-child(3) { animation-delay: 0.4s; }
        
        @keyframes dot-pulse {
            0%, 80%, 100% { 
                transform: scale(0.6);
                opacity: 0.5;
            }
            40% { 
                transform: scale(1);
                opacity: 1;
            }
        }
        
        [data-theme="dark"] .loader-text {
            color: #60A5FA;
        }
        
        [data-theme="dark"] .loader-dots span {
            background: #60A5FA;
        }

        /* ========== DESIGN TOKENS ========== */
        :root {
            --primary: #2563EB;           /* Blue-600 */
            --primary-light: #3B82F6;     /* Blue-500 */
            --primary-dark: #1D4ED8;      /* Blue-700 */
            --primary-rgb: 37, 99, 235;

            --success: #16A34A;           /* Green-600 */
            --success-light: #22C55E;     /* Green-500 */
            --success-rgb: 22, 163, 74;

            --warning: #F59E0B;           /* Amber-500 */
            --danger: #DC2626;            /* Red-600 */
            --info: #3B82F6;              /* Blue-500 */

            --text-primary: #1E293B;      /* Slate-800 */
            --text-secondary: #64748B;    /* Slate-500 */
            --border-gray: #E2E8F0;       /* Slate-200 */
            --light-gray: #F8FAFC;        /* Slate-50 */
            --dark: #0F172A;              /* Slate-900 */
            
            --card-bg: #ffffff;
            --body-bg: #F8FAFC;
            --navbar-bg: #ffffff;
            --input-bg: #ffffff;

            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 0.75rem;
            --space-lg: 1rem;
            --space-xl: 1.5rem;

            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;

            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08);
            --shadow-md: 0 4px 12px rgba(15, 23, 42, 0.1);
            --shadow-lg: 0 10px 40px rgba(15, 23, 42, 0.12);

            --navbar-height: 76px;
        }

        /* ========== DARK MODE ========== */
        [data-theme="dark"] {
            --text-primary: #F1F5F9;      /* Slate-100 */
            --text-secondary: #94A3B8;    /* Slate-400 */
            --border-gray: #334155;       /* Slate-700 */
            --light-gray: #1E293B;        /* Slate-800 */
            --dark: #F8FAFC;              /* Slate-50 */
            
            --card-bg: #1E293B;
            --body-bg: #0F172A;
            --navbar-bg: #1E293B;
            --input-bg: #334155;
            
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        [data-theme="dark"] body {
            background: var(--body-bg);
        }

        [data-theme="dark"] .navbar {
            background: var(--navbar-bg) !important;
            border-color: var(--border-gray);
        }

        [data-theme="dark"] .card,
        [data-theme="dark"] .section-card,
        [data-theme="dark"] .stat-item,
        [data-theme="dark"] .quick-item,
        [data-theme="dark"] .search-card,
        [data-theme="dark"] .quick-action {
            background: var(--card-bg) !important;
            border-color: var(--border-gray) !important;
        }

        [data-theme="dark"] .dropdown-menu {
            background: var(--card-bg);
            border-color: var(--border-gray);
        }

        [data-theme="dark"] .dropdown-item {
            color: var(--text-primary);
        }

        [data-theme="dark"] .dropdown-item:hover {
            background: var(--light-gray);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: var(--input-bg);
            border-color: var(--border-gray);
            color: var(--text-primary);
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background: var(--input-bg);
            border-color: var(--primary);
        }

        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-secondary);
        }

        [data-theme="dark"] .table {
            color: var(--text-primary);
        }

        [data-theme="dark"] .table thead th {
            background: var(--light-gray);
            border-color: var(--border-gray);
        }

        [data-theme="dark"] .table td,
        [data-theme="dark"] .table th {
            border-color: var(--border-gray);
        }

        [data-theme="dark"] .btn-secondary {
            background: var(--light-gray);
            border-color: var(--border-gray);
            color: var(--text-primary);
        }

        [data-theme="dark"] .btn-light {
            background: var(--light-gray);
            border-color: var(--border-gray);
            color: var(--text-primary);
        }

        [data-theme="dark"] .text-dark {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .text-muted {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] .bg-white {
            background: var(--card-bg) !important;
        }

        [data-theme="dark"] .bg-light {
            background: var(--light-gray) !important;
        }

        [data-theme="dark"] .section-card .card-header {
            background: linear-gradient(135deg, var(--light-gray) 0%, var(--card-bg) 100%) !important;
            border-color: var(--border-gray) !important;
        }

        [data-theme="dark"] .order-row {
            background: var(--light-gray) !important;
        }

        [data-theme="dark"] .order-row:hover {
            background: var(--card-bg) !important;
        }

        [data-theme="dark"] .favorite-row {
            background: linear-gradient(135deg, var(--light-gray) 0%, var(--card-bg) 100%) !important;
        }

        [data-theme="dark"] .tip-item.amber {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.08) 100%) !important;
        }

        [data-theme="dark"] .tip-item.blue {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(37, 99, 235, 0.08) 100%) !important;
        }

        [data-theme="dark"] .empty-box {
            background: linear-gradient(135deg, var(--light-gray) 0%, var(--card-bg) 100%) !important;
        }

        [data-theme="dark"] .promo-card {
            border-color: var(--border-gray) !important;
        }

        [data-theme="dark"] .badge.bg-white {
            background: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .badge.bg-info {
            background: #1E40AF !important;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(30, 64, 175, 0.3);
        }

        /* Also fix bg-info in light mode for better contrast */
        .badge.bg-info {
            background: #0EA5E9 !important;
            color: #ffffff !important;
        }

        [data-theme="dark"] .modal-content {
            background: var(--card-bg);
            border-color: var(--border-gray);
        }

        /* Dark mode for order borders */
        [data-theme="dark"] .order-border-info {
            border-left-color: #1E40AF !important;
        }

        [data-theme="dark"] .modal-header,
        [data-theme="dark"] .modal-footer {
            border-color: var(--border-gray);
        }

        [data-theme="dark"] .alert {
            border-color: var(--border-gray);
        }

        [data-theme="dark"] hr {
            border-color: var(--border-gray);
        }

        /* Dark Mode Toggle Button */
        .theme-toggle {
            background: transparent;
            border: none;
            padding: 0.5rem;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            transition: all 0.3s ease;
            color: var(--text-primary);
        }

        .theme-toggle:hover {
            background: var(--light-gray);
        }

        .theme-toggle i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover i {
            transform: rotate(20deg);
        }

        [data-theme="dark"] .theme-toggle .fa-moon { display: none; }
        [data-theme="dark"] .theme-toggle .fa-sun { display: inline-block; color: #FBBF24; }
        [data-theme="light"] .theme-toggle .fa-sun { display: none; }
        [data-theme="light"] .theme-toggle .fa-moon { display: inline-block; color: #64748B; }

        /* ========== BASE STYLES ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--light-gray);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 0.95rem;
            -webkit-font-smoothing: antialiased;
            padding-top: calc(var(--navbar-height) + var(--space-sm));
        }

        .container {
            max-width: 1200px;
            padding-left: var(--space-lg);
            padding-right: var(--space-lg);
        }

        /* ========== NAVBAR DESIGN ========== */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-gray);
            box-shadow: var(--shadow-sm);
            padding: var(--space-md) 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1100;
            min-height: var(--navbar-height);
        }

        .navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            transition: transform 0.3s ease;
        }

        .navbar .navbar-brand:hover {
            transform: scale(1.02);
        }

        .navbar .navbar-brand i {
            margin-right: 0.5rem;
        }

        .navbar .nav-link {
            color: var(--text-primary) !important;
            padding: 0.5rem 0.9rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
            margin: 0 0.25rem;
        }

        .navbar .nav-link:hover {
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.08) 0%, rgba(var(--primary-rgb), 0.04) 100%);
            color: var(--primary) !important;
            transform: translateY(-1px);
        }

        .navbar .nav-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #ffffff !important;
            box-shadow: var(--shadow-md);
        }

        .navbar .nav-link i {
            margin-right: 0.3rem;
        }
        
        .navbar .nav-link.dropdown-toggle::after {
            border-color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .navbar .nav-link.dropdown-toggle:hover::after {
            border-color: var(--primary);
        }
        
        .dropdown-menu {
            border: 1px solid var(--border-gray);
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius-lg);
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: var(--card-bg);
        }

        .dropdown-item {
            color: var(--text-primary);
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: var(--radius-md);
            padding: 0.5rem 1rem;
            margin: 0.25rem 0;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.08) 0%, rgba(var(--primary-rgb), 0.04) 100%);
            color: var(--primary);
        }
        
        .dropdown-divider {
            border-color: var(--border-gray);
            margin: 0.5rem 0;
        }

        /* ========== QUICK ACTIONS (shared) ========== */
        .quick-action {
            height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 1rem;
            border-radius: var(--radius-md);
            gap: 0.25rem;
            text-align: center;
            border: 1px solid rgba(var(--primary-rgb), 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #ffffff;
        }

        .quick-action:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08); }

        .quick-actions-scroll {
            display: flex;
            gap: var(--space-sm);
            flex-wrap: wrap;
        }

        .quick-action.order-highlight {
            align-items: flex-start;
            justify-content: flex-start;
            text-align: left;
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.2), rgba(37, 99, 235, 0.45));
            color: #ffffff;
            border: none;
        }

        .quick-action.order-highlight small,
        .quick-action.order-highlight strong,
        .quick-action.order-highlight i { color: #ffffff; }
        .quick-action-title {
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .quick-action-desc {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .quick-action.primary { border-color: rgba(var(--primary-rgb), 0.2); background: rgba(var(--primary-rgb), 0.08); }
        .quick-action.primary .quick-action-icon { background: rgba(var(--primary-rgb), 0.2); color: var(--primary); }

        .quick-action.neutral { border-color: rgba(148, 163, 184, 0.4); }

        .quick-action.ghost { background: transparent; border-style: dashed; }
        .card .card-footer {
            background: var(--light-gray);
            border-top: 1px solid var(--border-gray);
            padding: var(--space-lg) calc(var(--space-xl) + var(--space-sm));
        }

        /* ========== BUTTONS ========== */
        .btn {
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.95rem;
            padding: var(--space-md) calc(var(--space-lg) + var(--space-xs));
            transition: all 0.3s ease;
            text-transform: capitalize;
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(var(--primary-rgb), 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
            color: #ffffff;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #edff86 0%, var(--success) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(var(--success-rgb), 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #F59E0B 100%);
            color: #ffffff;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, var(--primary-dark) 100%);
            color: #ffffff;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            border-radius: var(--radius-md);
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #ffffff;
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--text-secondary);
            border: 1px solid var(--border-gray);
        }

        .btn-secondary:hover {
            background: var(--border-gray);
            color: var(--text-primary);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        /* ========== BADGES ========== */
        .badge {
            border-radius: 999px;
            padding: 0.35em 0.7em;
            font-weight: 600;
            font-size: 0.78rem;
            letter-spacing: 0.3px;
            text-transform: capitalize;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%) !important;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #F59E0B 100%) !important;
            color: #ffffff;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, var(--danger) 0%, var(--primary-dark) 100%) !important;
        }

        /* ========== FORMS ========== */
        .form-control, .form-select {
            border: 2px solid var(--border-gray);
            border-radius: var(--radius-md);
            padding: var(--space-md) var(--space-xl);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #ffffff;
            font-weight: 400;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        /* ========== TABLES ========== */
        table.table {
            font-size: 0.95rem;
        }

        table.table thead th {
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.08) 0%, rgba(var(--primary-rgb), 0.04) 100%);
            border-bottom: 2px solid var(--border-gray);
            color: var(--text-primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            padding: 1rem;
        }

        table.table tbody tr {
            border-bottom: 1px solid var(--border-gray);
            transition: all 0.3s ease;
        }

        table.table tbody tr:hover {
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.04) 0%, rgba(var(--primary-rgb), 0.02) 100%);
        }

        table.table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* ========== ALERTS ========== */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            font-weight: 500;
            border-left: 4px solid;
        }

        .alert-success {
            background: rgba(var(--success-rgb), 0.1);
            border-left-color: var(--success);
            color: #064E3B;
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.1);
            border-left-color: var(--danger);
            color: #7F1D1D;
        }

        .alert-warning {
            background: rgba(217, 119, 6, 0.1);
            border-left-color: var(--warning);
            color: #7C2D12;
        }

        .alert-info {
            background: rgba(var(--primary-rgb), 0.1);
            border-left-color: var(--primary);
            color: #312e81;
        }

        /* ========== STAT CARDS ========== */
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f5f7fa 100%);
            border: 1px solid var(--border-gray);
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            text-align: center;
            transition: all 0.3s ease;
            min-height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        .stat-card .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0.5rem 0;
        }

        .stat-card .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modern Icon Badge */
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Hover lift effect */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        /* ========== FOOTER ========== */
        footer {
            background: #ffffff;
            border-top: 1px solid var(--border-gray);
            margin-top: 4rem;
            padding: 2rem 0;
        }

        footer p {
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* ========== ANIMATIONS ========== */
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

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        @keyframes scaleHover {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Apply fadeInUp to cards on load */
        .card {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Add smooth animation to order cards */
        .col-12 {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Smooth button hover with scale */
        .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn:not(.btn-secondary):hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Smooth badge animations */
        .badge {
            transition: all 0.3s ease;
        }

        /* Smooth form transitions */
        .form-control, .form-select {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth table row hover */
        table.table tbody tr {
            transition: all 0.3s ease;
        }

        table.table tbody tr:hover {
            background-color: rgba(var(--primary-rgb), 0.05);
            transform: scale(1.01);
        }

        /* Danger button hover animation */
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
        }

        /* Success button hover animation */
        .btn-success:hover {
            transform: translateY(-2px) scale(1.02);
        }

        /* Outline primary button hover animation */
        .btn-outline-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.25);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .container { padding: 0 1rem; }
            .navbar .navbar-brand { font-size: 1.1rem; }
            .navbar .nav-link { padding: 0.4rem 0.6rem; }
            .card .card-body { padding: 1.2rem; }
            .btn { padding: 0.5rem 1rem; font-size: 0.9rem; }
            .stat-card .stat-value { font-size: 2rem; }
            h2 { font-size: 1.5rem; }
        }

        /* ========== QUICK ACTIONS (shared) ========== */
        .quick-action {
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0.9rem;
            border-radius: var(--radius-md);
            gap: 0.35rem;
            text-align: center;
            border: 1px solid rgba(var(--primary-rgb), 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #ffffff;
        }

        .quick-action small {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            font-weight: 600;
        }

        .quick-action:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08); }

        .quick-action.order-highlight {
            grid-column: span 2;
            align-items: flex-start;
            justify-content: flex-start;
            flex-direction: column;
            text-align: left;
            padding: 1.05rem;
            gap: 0.5rem;
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.2), rgba(37, 99, 235, 0.45));
            color: #ffffff;
            border: none;
        }

        .order-highlight small,
        .order-highlight span,
        .order-highlight strong { color: #ffffff; }

        .quick-actions-scroll {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: var(--space-sm);
        }

        @media (min-width: 992px) {
            .quick-action { min-height: 120px; padding: 1.15rem; }
            .card .card-body { padding: 1.5rem 1.75rem; }
        }

        @media (min-width: 1200px) {
            .container { max-width: 1120px; }
            .card .card-body { padding: 1.75rem 2rem; }
        }

        .order-card {
            border: 1px solid var(--border-gray);
            border-radius: var(--radius-md);
            padding: var(--space-md);
            background: #ffffff;
            box-shadow: var(--shadow-sm);
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 600;
        }

        .promo-pill {
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .table-min-h { min-height: 260px; }

        table.table {
            border-spacing: 0 6px;
        }

        table.table tbody tr {
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        table.table tbody td {
            vertical-align: middle;
            border-color: transparent;
        }

        /* ========== MOBILE TWEAKS ========== */
        @media (max-width: 576px) {
            body { font-size: 14px; }
            .navbar .navbar-brand { font-size: 1rem; }
            .dropdown-menu { min-width: 85vw !important; width: 85vw !important; }
            .card .card-header { padding: 0.9rem 1rem; }
            .card .card-body { padding: 1rem; }
            .btn { min-height: 44px; }
            .stat-card { min-height: 120px; padding: var(--space-lg); }
            .stat-card .stat-value { font-size: 1.6rem; }
            .stat-icon { width: 40px; height: 40px; font-size: 1.1rem; }
            .quick-action { height: 76px; padding: 0.65rem; font-size: 0.8rem; }
            .quick-actions-scroll { flex-wrap: nowrap; overflow-x: auto; padding-bottom: 0.5rem; margin: 0 calc(-1 * var(--space-sm)); }
            .quick-actions-scroll .quick-action { min-width: 65vw; }
            .hero-strip { height: 96px !important; }
            table.table thead { font-size: 0.8rem; }
            table.table tbody tr:hover { transform: none; }
            h2 { font-size: 1.35rem; }
            h5 { font-size: 1rem; }
            .badge { font-size: 0.72rem; }
            .container { padding-left: 0.75rem; padding-right: 0.75rem; }
            .order-card { margin-bottom: var(--space-sm); }
        }

        /* ========== ANIMATIONS ========== */
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

        .fade-in-up {
            animation: fadeInUp 0.6s ease;
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Text clamping utilities */
        .clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* Mobile-first card columns */
        @media (max-width: 767px) {
            .col-md-6, .col-lg-4 { flex: 0 0 100%; max-width: 100%; }
            .row.g-4 { --bs-gutter-y: 1rem; --bs-gutter-x: 0; }
            .card .card-body { padding: 0.9rem; }
            .d-flex.gap-2 { gap: 0.5rem !important; }
            h2 { font-size: 1.25rem !important; }
            .hero-strip { height: 120px !important; }
            .btn { font-size: 0.85rem; padding: 0.5rem 0.75rem; }
            .badge { font-size: 0.7rem; padding: 0.3em 0.55em; }
            .form-control { font-size: 0.9rem; padding: 0.5rem 0.75rem; }
        }

        @media (max-width: 400px) {
            .container { padding-left: 0.5rem; padding-right: 0.5rem; }
            .stat-card { min-height: 100px; padding: 0.75rem; }
            .stat-card .stat-value { font-size: 1.4rem; }
            .quick-action { height: 70px; }
            .card .card-header { padding: 0.75rem; font-size: 0.9rem; }
        }

        /* ==================== ADMIN ENHANCEMENTS ==================== */

        /* Admin Dashboard Cards */
        .admin-dashboard-card {
            background: var(--card-bg);
            border: 1px solid var(--border-gray);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            overflow: hidden;
        }

        .admin-dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #06b6d4, #10b981);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .admin-dashboard-card:hover::before {
            transform: scaleX(1);
        }

        .admin-dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }

        /* Admin Stats Cards */
        .admin-stats-card {
            background: var(--card-bg);
            border: 1px solid var(--border-gray);
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .admin-stats-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(var(--primary-rgb), 0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .admin-stats-card:hover::after {
            opacity: 1;
        }

        .admin-stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        .admin-stats-card h5 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 1.75rem;
        }

        .admin-stats-card h6 {
            font-weight: 500;
            font-size: 0.875rem;
            opacity: 0.8;
        }

        /* Admin Table Enhancements */
        .admin-table {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .admin-table .table {
            margin-bottom: 0;
        }

        .admin-table .table-light {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .admin-table .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-gray);
        }

        .admin-table .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        /* Admin Form Enhancements */
        .admin-form {
            background: var(--card-bg);
            border: 1px solid var(--border-gray);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .admin-form .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .admin-form .form-control,
        .admin-form .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-gray);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .admin-form .form-control:focus,
        .admin-form .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
        }

        /* Admin Button Enhancements */
        .admin-btn {
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s cubic-bezier(0.23, 1, 0.320, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .admin-btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #ffffff;
            border: none;
        }

        .admin-btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3);
        }

        .admin-btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #10b981 100%);
            color: #ffffff;
            border: none;
        }

        .admin-btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .admin-btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #f59e0b 100%);
            color: #ffffff;
            border: none;
        }

        .admin-btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: #ffffff;
            border: none;
        }

        .admin-btn-outline {
            background: transparent;
            border: 2px solid var(--border-gray);
            color: var(--text-secondary);
        }

        .admin-btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(var(--primary-rgb), 0.05);
        }

        .admin-btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Admin Status Badges */
        .admin-badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .admin-badge-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #ffffff;
        }

        .admin-badge-success {
            background: linear-gradient(135deg, var(--success), #10b981);
            color: #ffffff;
        }

        .admin-badge-warning {
            background: linear-gradient(135deg, var(--warning), #f59e0b);
            color: #ffffff;
        }

        .admin-badge-danger {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: #ffffff;
        }

        .admin-badge-info {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            color: #ffffff;
        }

        /* Admin Alert Boxes */
        .admin-alert {
            border-radius: 8px;
            padding: 1rem 1.25rem;
            border: none;
            display: flex;
            align-items: flex-start;
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

        /* Admin Modal Enhancements */
        .admin-modal .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .admin-modal .modal-header {
            background: linear-gradient(135deg, var(--card-bg) 0%, var(--border-gray) 100%);
            border-bottom: 1px solid var(--border-gray);
            border-radius: 16px 16px 0 0;
            padding: 1.5rem;
        }

        .admin-modal .modal-body {
            padding: 1.5rem;
        }

        .admin-modal .modal-title {
            font-weight: 600;
            font-size: 1.125rem;
        }

        /* Admin Navigation */
        .admin-sidebar .nav-link {
            border-radius: 8px;
            margin-bottom: 0.25rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            color: var(--text-secondary);
        }

        .admin-sidebar .nav-link:hover {
            background: rgba(var(--primary-rgb), 0.1);
            color: var(--primary);
            transform: translateX(4px);
        }

        .admin-sidebar .nav-link.active {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(var(--primary-rgb), 0.3);
        }

        /* Admin Loading States */
        .admin-loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-gray);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: admin-spin 0.8s linear infinite;
        }

        @keyframes admin-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-5px);
            }
            60% {
                transform: translateY(-3px);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Admin Charts */
        .admin-chart-container {
            background: var(--card-bg);
            border: 1px solid var(--border-gray);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Dark mode adjustments for admin */
        [data-theme="dark"] .admin-dashboard-card,
        [data-theme="dark"] .admin-stats-card,
        [data-theme="dark"] .admin-table,
        [data-theme="dark"] .admin-form {
            background: var(--card-bg);
            border-color: #374151;
        }

        [data-theme="dark"] .admin-table .table-light {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }

        [data-theme="dark"] .admin-form .form-control,
        [data-theme="dark"] .admin-form .form-select {
            background: var(--input-bg);
            border-color: #4b5563;
            color: var(--text-primary);
        }

        [data-theme="dark"] .admin-form .form-control:focus,
        [data-theme="dark"] .admin-form .form-select:focus {
            border-color: var(--primary);
        }

        [data-theme="dark"] .admin-modal .modal-content {
            background: var(--card-bg);
        }

        [data-theme="dark"] .admin-modal .modal-header {
            background: linear-gradient(135deg, var(--card-bg) 0%, #374151 100%);
            border-bottom-color: #4b5563;
        }

        /* Responsive for admin */
        @media (max-width: 768px) {
            .admin-dashboard-card {
                padding: 1rem;
            }

            .admin-stats-card {
                padding: 1rem;
            }

            .admin-stats-card h5 {
                font-size: 1.5rem;
            }

            .admin-form {
                padding: 1rem;
            }

            .admin-table {
                border-radius: 8px;
            }

            .admin-table .table th,
            .admin-table .table td {
                font-size: 0.8rem;
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Include favicon fallback for better browser support -->
    @include('partials.favicon-fallback')
    <!-- Loading Screen -->
    <div class="page-loader" id="pageLoader">
        <img src="{{ asset('favicon-192.png') }}" alt="SMKN 2 Surabaya" class="loader-logo">
        <div class="loader-spinner"></div>
        <div class="loader-text">
            <span>M</span><span>e</span><span>m</span><span>u</span><span>a</span><span>t</span><span>.</span><span>.</span>
        </div>
        <div class="loader-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light" style="background: var(--navbar-bg); border-bottom: 1px solid var(--border-gray); box-shadow: var(--shadow-sm); position: fixed; top: 0; left: 0; right: 0; z-index: 1100; width: 100%;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" style="font-weight: 800; font-size: 1.3rem; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.5px;">
                <i class="fas fa-utensils me-2" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"></i>e-Kantin
            </a>
            
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border: 1px solid var(--border-gray); border-radius: 8px; padding: 0.5rem; background: var(--card-bg); color: var(--text-primary); transition: all 0.3s ease;">
                <i class="fas fa-bars" style="color: var(--text-primary);"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Tampilkan menu berdasarkan role -->
                    @if(auth()->user()->role === 'customer')
                        <!-- Menu CUSTOMER -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.tenants') }}">
                                <i class="fas fa-store me-1"></i>Pilih Tenant
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.orders') }}">
                                <i class="fas fa-history me-1"></i>Riwayat Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('customer.cart') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Keranjang
                                @php
                                    $cartCount = 0;
                                    if(auth()->check() && auth()->user()->role === 'customer') {
                                        $userCarts = \App\Models\Cart::where('user_id', auth()->id())->get();
                                        foreach($userCarts as $cart) {
                                            $cartCount += $cart->items->count();
                                        }
                                    }
                                @endphp
                                @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                    <span class="visually-hidden">item dalam keranjang</span>
                                </span>
                                @endif
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'tenant_owner')
                        <!-- Menu TENANT OWNER -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tenant.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tenant.orders') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Pesanan Saya
                            </a>
                        </li>
                    @else
                        <!-- Menu ADMIN / DEFAULT -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tenants.index') }}">
                                <i class="fas fa-store me-1"></i>Tenant
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fas fa-users me-1"></i>Pengguna
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">
                                <i class="fas fa-tags me-1"></i>Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('menus.index') }}">
                                <i class="fas fa-utensils me-1"></i>Menu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="fas fa-receipt me-1"></i>Pesanan
                            </a>
                        </li>
                    @endif
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown me-2">
                        @php
                            $unread = 0;
                            $recentNotifications = collect();
                            if (\Illuminate\Support\Facades\Schema::hasTable('notifications')) {
                                try {
                                    if (auth()->user()->role === 'tenant_owner') {
                                        $recentNotifications = auth()->user()->notifications()
                                            ->where('type', \App\Notifications\NewOrderForTenant::class)
                                            ->latest()->limit(5)->get();
                                        $unread = auth()->user()->unreadNotifications()->where('type', \App\Notifications\NewOrderForTenant::class)->count();
                                    } elseif (auth()->user()->role === 'customer') {
                                        $recentNotifications = auth()->user()->notifications()
                                            ->where('type', \App\Notifications\OrderStatusChanged::class)
                                            ->latest()->limit(5)->get();
                                        $unread = auth()->user()->unreadNotifications()->where('type', \App\Notifications\OrderStatusChanged::class)->count();
                                    } else {
                                        $unread = auth()->user()->unreadNotifications()->count();
                                        $recentNotifications = auth()->user()->notifications()->latest()->limit(5)->get();
                                    }
                                } catch (\Exception $e) {
                                    $unread = 0;
                                    $recentNotifications = collect();
                                }
                            }
                        @endphp
                        <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @if($unread > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">{{ $unread }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0" style="min-width: 360px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                            <li style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); padding: 1rem; border-radius: 12px 12px 0 0; color: white;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="font-size: 1rem;">
                                        <i class="fas fa-bell me-2"></i>Notifikasi
                                    </strong>
                                    @if($unread > 0)
                                        <span style="background: rgba(255,255,255,0.3); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem;">{{ $unread }} baru</span>
                                    @endif
                                </div>
                                @if($recentNotifications->count() > 0)
                                    <form action="{{ route('notifications.mark_all_read') }}" method="POST" class="mt-2">
                                        @csrf
                                        <button class="btn btn-sm" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 6px; font-size: 0.8rem;">
                                            <i class="fas fa-check me-1"></i>Tandai semua dibaca
                                        </button>
                                    </form>
                                @endif
                            </li>
                            @forelse($recentNotifications as $n)
                                @php
                                    $link = '#';
                                    if (auth()->user()->role === 'tenant_owner' && isset($n->data['order_id'])) {
                                        $link = route('tenant.orders', ['status' => 'pending']) . '#order-' . $n->data['order_id'];
                                    } elseif (isset($n->data['order_id'])) {
                                        $link = route('tenant.orders') . '#order-' . $n->data['order_id'];
                                    }
                                @endphp
                                <a href="{{ $link }}" class="list-group-item list-group-item-action" style="border-left: 4px solid {{ is_null($n->read_at) ? 'var(--primary)' : 'var(--border-gray)' }}; padding: 1rem; text-decoration: none; color: var(--text-primary); display: flex; justify-content: space-between; align-items: start; transition: all 0.3s ease; background: var(--card-bg);" onmouseover="this.style.background='var(--light-gray)'" onmouseout="this.style.background='var(--card-bg)'">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">
                                            {{ $n->data['message'] ?? 'Notifikasi' }}
                                        </div>
                                        <small style="color: var(--text-secondary); display: block; margin-top: 0.3rem;">
                                            {{ isset($n->data['created_at']) ? \Carbon\Carbon::parse($n->data['created_at'])->diffForHumans() : $n->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    @if(is_null($n->read_at))
                                        <span style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.7rem; font-weight: 600; margin-left: 0.5rem; white-space: nowrap;">Baru</span>
                                    @endif
                                </a>
                            @empty
                                <li style="padding: 2rem 1rem; text-align: center; background: var(--card-bg);">
                                    <i class="fas fa-inbox" style="font-size: 2rem; color: var(--border-gray); margin-bottom: 0.5rem; display: block;"></i>
                                    <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">Tidak ada notifikasi</p>
                                </li>
                            @endforelse
                            <li class="border-top" style="text-align: center; background: var(--card-bg); border-color: var(--border-gray) !important;">
                                <a href="{{ route('notifications.index') }}" class="d-block py-2" style="text-decoration: none; font-weight: 600; color: var(--primary);">Lihat semua notifikasi</a>
                            </li>
                        </ul>
                    </li>

                    {{-- Dark Mode Toggle --}}
                    <li class="nav-item me-2 d-flex align-items-center">
                        <button class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">
                            <i class="fas fa-moon"></i>
                            <i class="fas fa-sun"></i>
                        </button>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            <span class="badge bg-{{ 
                                auth()->user()->role === 'customer' ? 'info' : 
                                (auth()->user()->role === 'tenant_owner' ? 'success' : 'warning') 
                            }}">
                                {{ auth()->user()->role === 'customer' ? 'Konsumen' : 
                                   (auth()->user()->role === 'tenant_owner' ? 'Penjual' : 'Admin') }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                @if(auth()->user()->role === 'customer')
                                    <a class="dropdown-item" href="{{ route('customer.account') }}">
                                        <i class="fas fa-user me-1"></i>Profil
                                    </a>
                                @elseif(auth()->user()->role === 'tenant_owner')
                                    <a class="dropdown-item" href="{{ route('tenant.settings') }}">
                                        <i class="fas fa-store me-1"></i>Profil Tenant
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-user-shield me-1"></i>Profil Admin
                                    </a>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <!-- LOGOUT FORM DENGAN CSRF -->
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="bg-light mt-5 py-4">
        <div class="container text-center">
            <p class="text-muted mb-0">
                <i class="fas fa-utensils me-1"></i>e-Kantin &copy; {{ date('Y') }} - Sistem Manajemen Kantin Sekolah
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set CSRF token untuk semua AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Auto dismiss alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.isConnected) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });

            // Auto submit quantity forms on change
            const quantityInputs = document.querySelectorAll('input[name="quantity"]');
            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            });

            // Pastikan semua form punya CSRF token
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                if (!form.querySelector('input[name="_token"]')) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                }
            });

            // Handle logout form submission
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    this.submit();
                });
            }

            // ========== DARK MODE TOGGLE ==========
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            
            // Load saved theme or detect system preference
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme) {
                html.setAttribute('data-theme', savedTheme);
            } else if (systemPrefersDark) {
                html.setAttribute('data-theme', 'dark');
            } else {
                html.setAttribute('data-theme', 'light');
            }
            
            // Toggle theme on button click
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    const currentTheme = html.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    html.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    
                    // Add animation
                    this.style.transform = 'rotate(360deg)';
                    setTimeout(() => {
                        this.style.transform = 'rotate(0deg)';
                    }, 300);
                });
            }

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    html.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                }
            });
        });
    </script>
    
    {{-- Initialize theme before page renders to prevent flash --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    
    {{-- Page Loader Script --}}
    <script>
        // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                // Minimum display time of 500ms for smooth UX
                setTimeout(function() {
                    loader.classList.add('hidden');
                    // Remove from DOM after animation completes
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 500);
                }, 500);
            }
        });
        
        // Fallback: hide loader after 3 seconds max
        setTimeout(function() {
            const loader = document.getElementById('pageLoader');
            if (loader && !loader.classList.contains('hidden')) {
                loader.classList.add('hidden');
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 500);
            }
        }, 3000);
    </script>
    
    @stack('scripts')
</body>
</html>
