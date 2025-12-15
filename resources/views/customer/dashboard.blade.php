@extends('layouts.app')

@section('title', 'Dashboard Customer - e-Kantin')

@section('content')
<style>
    .dashboard-container { padding-top: 1rem; padding-bottom: 2rem; }
    
    /* ===== HERO WELCOME - BENTO STYLE ===== */
    .hero-bento {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 992px) { .hero-bento { grid-template-columns: 1fr; } }
    
    .welcome-card {
        background: linear-gradient(135deg, #0EA5E9 0%, #1E40AF 50%, #1E293B 100%);
        border-radius: 28px;
        padding: 2rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 20px 40px rgba(14, 165, 233, 0.15);
    }
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: conic-gradient(from 180deg, #3B82F6, #8B5CF6, #EC4899, #F59E0B, #10B981, #3B82F6);
        border-radius: 50%;
        opacity: 0.2;
        animation: spin 20s linear infinite;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: 15px;
        right: 20px;
        font-size: 80px;
        opacity: 0.1;
    }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(14, 165, 233, 0.3); }
        50% { box-shadow: 0 0 30px rgba(14, 165, 233, 0.5); }
    }
    
    .welcome-card .content { position: relative; z-index: 1; }
    .welcome-card .greeting-emoji { font-size: 2.5rem; margin-bottom: 0.5rem; display: block; animation: float 3s ease-in-out infinite; }
    .welcome-card h2 { 
        font-weight: 800; 
        font-size: 1.75rem; 
        margin-bottom: 0.25rem;
        background: linear-gradient(135deg, #fff, #CBD5E1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .welcome-card .subtitle { opacity: 0.7; font-size: 0.9rem; }
    .welcome-card .time-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 0.6rem 1rem;
        border-radius: 100px;
        font-size: 0.85rem;
        border: 1px solid rgba(255,255,255,0.1);
        margin-top: 1rem;
    }
    .welcome-card .time-badge i { color: #FBBF24; }
    
    /* Status Summary Card */
    .status-summary {
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: 1rem;
    }
    .mini-stat {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        border-radius: 20px;
        padding: 1.25rem;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }
    .mini-stat:hover { transform: scale(1.03) translateY(-2px); box-shadow: 0 15px 40px rgba(0,0,0,0.12); }
    .mini-stat .mini-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
        flex-shrink: 0;
    }
    .mini-stat .mini-info { flex: 1; }
    .mini-stat .mini-value { font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1; transition: color 0.3s ease; }
    .mini-stat .mini-label { font-size: 0.75rem; color: #475569; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 4px; transition: color 0.3s ease; }

    /* Dark mode mini stat */
    [data-theme="dark"] .mini-stat {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-color: rgba(100, 116, 139, 0.5);
    }
    [data-theme="dark"] .mini-stat .mini-value {
        color: #ffffff;
    }
    [data-theme="dark"] .mini-stat .mini-label {
        color: #e2e8f0;
    }
    .mini-stat .mini-trend { font-size: 0.7rem; font-weight: 700; padding: 0.25rem 0.5rem; border-radius: 6px; }
    .mini-stat .mini-trend.up { background: #DCFCE7; color: #16A34A; }
    .mini-stat .mini-trend.pending { background: #FEF3C7; color: #D97706; }
    [data-theme="dark"] .mini-stat .mini-trend.up { background: rgba(22, 163, 74, 0.2); color: #4ADE80; }
    [data-theme="dark"] .mini-stat .mini-trend.pending { background: rgba(245, 158, 11, 0.2); color: #FBBF24; }
    
    /* ===== QUICK ACTIONS - PILL STYLE ===== */
    .quick-actions-strip {
        display: flex;
        gap: 0.75rem;
        overflow-x: auto;
        padding: 0.5rem 0 1rem;
        margin-bottom: 1rem;
        scrollbar-width: none;
    }
    .quick-actions-strip::-webkit-scrollbar { display: none; }
    
    .quick-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 1.5rem;
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 100px;
        text-decoration: none;
        color: #1e293b;
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .quick-pill::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 100px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .quick-pill:hover {
        color: #fff;
        border-color: transparent;
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    .quick-pill:hover::before { opacity: 1; }
    .quick-pill:hover .pill-icon, .quick-pill:hover span { position: relative; z-index: 1; }
    
    .quick-pill.blue:hover { background: linear-gradient(135deg, #2563EB, #0EA5E9); border-color: transparent; }
    .quick-pill.orange:hover { background: linear-gradient(135deg, #F59E0B, #FBBF24); border-color: transparent; }
    .quick-pill.green:hover { background: linear-gradient(135deg, #10B981, #34D399); border-color: transparent; }
    .quick-pill.purple:hover { background: linear-gradient(135deg, #8B5CF6, #A78BFA); border-color: transparent; }
    
    .quick-pill .pill-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: #fff;
        transition: transform 0.3s;
    }
    .quick-pill:hover .pill-icon { transform: rotate(-10deg) scale(1.1); }
    .quick-pill .pill-badge {
        background: #EF4444;
        color: #fff;
        font-size: 0.65rem;
        padding: 0.15rem 0.4rem;
        border-radius: 6px;
        font-weight: 700;
        margin-left: -0.25rem;
    }
    
    /* ===== LIVE ORDER TRACKER ===== */
    .live-tracker {
        background: linear-gradient(135deg, #FEFCE8 0%, #FEF3C7 100%);
        border: 2px solid #FDE047;
        border-radius: 20px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    [data-theme="dark"] .live-tracker { 
        background: linear-gradient(135deg, rgba(234, 179, 8, 0.15), rgba(251, 191, 36, 0.1)); 
        border-color: rgba(251, 191, 36, 0.3);
    }
    .live-tracker::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #F59E0B, #EAB308);
        border-radius: 20px 0 0 20px;
    }
    .live-tracker .pulse-dot {
        width: 12px;
        height: 12px;
        background: #EF4444;
        border-radius: 50%;
        animation: pulse-ring 1.5s ease-out infinite;
        flex-shrink: 0;
    }
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    .live-tracker .tracker-content { flex: 1; }
    .live-tracker .tracker-title { font-weight: 700; color: #92400E; font-size: 0.95rem; }
    [data-theme="dark"] .live-tracker .tracker-title { color: #FBBF24; }
    .live-tracker .tracker-sub { font-size: 0.8rem; color: #A16207; margin-top: 2px; }
    [data-theme="dark"] .live-tracker .tracker-sub { color: #FCD34D; }
    .live-tracker .tracker-btn {
        background: linear-gradient(135deg, #F59E0B, #D97706);
        color: #fff;
        padding: 0.6rem 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    .live-tracker .tracker-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4); color: #fff; }
    
    /* ===== BENTO GRID LAYOUT ===== */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 992px) { .bento-grid { grid-template-columns: 1fr; } }
    
    .bento-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .bento-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.03) 0%, rgba(139, 92, 246, 0.03) 100%);
        pointer-events: none;
    }
    .bento-card:hover {
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        transform: translateY(-4px);
        border-color: #3b82f6;
        background: #ffffff;
    }

    /* Dark mode adjustments for bento cards */
    [data-theme="dark"] .bento-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-color: rgba(71, 85, 105, 0.5);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }
    [data-theme="dark"] .bento-card::before {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.08) 100%);
    }
    [data-theme="dark"] .bento-card:hover {
        box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        border-color: rgba(59, 130, 246, 0.6);
        background: linear-gradient(135deg, #334155 0%, #475569 100%);
    }
    .bento-card.span-8 { grid-column: span 8; }
    .bento-card.span-4 { grid-column: span 4; }
    .bento-card.span-6 { grid-column: span 6; }
    .bento-card.span-12 { grid-column: span 12; }
    @media (max-width: 992px) { 
        .bento-card.span-8, .bento-card.span-4, .bento-card.span-6 { grid-column: span 1; } 
    }
    
    .bento-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-gray);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .bento-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        color: #1e293b;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        transition: color 0.3s ease;
    }
    .bento-header h5 .header-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .bento-header .header-action {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .bento-header .header-action:hover { background: var(--light-gray); }
    .bento-body {
        padding: 1.25rem;
        color: #1e293b;
        position: relative;
        z-index: 1;
        transition: color 0.3s ease;
    }

    /* Dark mode text colors */
    [data-theme="dark"] .bento-header h5 {
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    [data-theme="dark"] .bento-header .header-action:hover {
        background: rgba(148, 163, 184, 0.3);
        color: #f1f5f9;
    }
    [data-theme="dark"] .bento-body {
        color: #f1f5f9;
    }
    
    /* ===== ORDER CARDS - COLORFUL ===== */
    .order-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 16px;
        margin-bottom: 0.75rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .order-card:last-child { margin-bottom: 0; }
    .order-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-radius: 4px 0 0 4px;
    }
    .order-card.status-pending { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); }
    .order-card.status-pending::before { background: linear-gradient(180deg, #F59E0B, #FBBF24); }
    .order-card.status-diproses { background: linear-gradient(135deg, #EFF6FF, #DBEAFE); }
    .order-card.status-diproses::before { background: linear-gradient(180deg, #2563EB, #3B82F6); }
    .order-card.status-selesai { background: linear-gradient(135deg, #F0FDF4, #DCFCE7); }
    .order-card.status-selesai::before { background: linear-gradient(180deg, #16A34A, #22C55E); }
    .order-card.status-pending_cash { background: linear-gradient(135deg, #E0F2FE, #BAE6FD); }
    .order-card.status-pending_cash::before { background: linear-gradient(180deg, #0EA5E9, #38BDF8); }
    .order-card.status-dibatalkan { background: linear-gradient(135deg, #FEF2F2, #FEE2E2); }
    .order-card.status-dibatalkan::before { background: linear-gradient(180deg, #DC2626, #EF4444); }
    
    [data-theme="dark"] .order-card.status-pending { background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(251, 191, 36, 0.08)); }
    [data-theme="dark"] .order-card.status-diproses { background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(59, 130, 246, 0.08)); }
    [data-theme="dark"] .order-card.status-selesai { background: linear-gradient(135deg, rgba(22, 163, 74, 0.12), rgba(34, 197, 94, 0.08)); }
    [data-theme="dark"] .order-card.status-pending_cash { background: linear-gradient(135deg, rgba(14, 165, 233, 0.12), rgba(56, 189, 248, 0.08)); }
    [data-theme="dark"] .order-card.status-dibatalkan { background: linear-gradient(135deg, rgba(220, 38, 38, 0.12), rgba(239, 68, 68, 0.08)); }
    
    .order-card:hover { transform: translateX(8px) scale(1.02); box-shadow: 0 12px 35px rgba(0,0,0,0.12); }
    
    .order-card .order-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    .order-card .order-info { flex: 1; min-width: 0; }
    .order-card .order-title { font-weight: 900; color: #000000; font-size: 0.9rem; margin-bottom: 2px; transition: color 0.3s ease; }
    .order-card .order-sub { font-size: 0.78rem; color: #1e293b; font-weight: 600; transition: color 0.3s ease; }
    .order-card .order-end { text-align: right; }
    .order-card .order-amount { font-weight: 900; color: #000000; font-size: 0.9rem; margin-bottom: 4px; transition: color 0.3s ease; }

    /* Dark mode order cards */
    [data-theme="dark"] .order-card .order-title {
        color: #ffffff;
        font-weight: 900;
        text-shadow: 0 1px 2px rgba(0,0,0,0.8);
    }
    [data-theme="dark"] .order-card .order-sub {
        color: #f1f5f9;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    [data-theme="dark"] .order-card .order-amount {
        color: #ffffff;
        font-weight: 900;
        text-shadow: 0 1px 2px rgba(0,0,0,0.8);
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.65rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.65rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .status-badge.pending {
        background: linear-gradient(135deg, #F59E0B, #F97316);
        color: #ffffff;
        border: 1px solid #F59E0B;
    }
    .status-badge.diproses {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: #ffffff;
        border: 1px solid #3B82F6;
    }
    .status-badge.selesai {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #ffffff;
        border: 1px solid #10B981;
    }
    .status-badge.pending_cash {
        background: linear-gradient(135deg, #1E40AF, #3B82F6);
        color: #ffffff;
        border: 1px solid #1E40AF;
    }
    .status-badge.dibatalkan {
        background: linear-gradient(135deg, #DC2626, #EF4444);
        color: #ffffff;
        border: 1px solid #DC2626;
    }
    [data-theme="dark"] .status-badge.pending {
        background: linear-gradient(135deg, #F59E0B, #F97316);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    [data-theme="dark"] .status-badge.diproses {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    [data-theme="dark"] .status-badge.selesai {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    [data-theme="dark"] .status-badge.pending_cash {
        background: linear-gradient(135deg, #1E40AF, #3B82F6);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    [data-theme="dark"] .status-badge.dibatalkan {
        background: linear-gradient(135deg, #DC2626, #EF4444);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    
    /* ===== FAVORITE TENANT CARDS ===== */
    .fav-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.15rem;
        margin-bottom: 0.75rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }
    .fav-card:last-child { margin-bottom: 0; }
    .fav-card::after {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(139, 92, 246, 0.05));
    }
    .fav-card:hover { transform: scale(1.03) translateY(-2px); box-shadow: 0 15px 40px rgba(0,0,0,0.12); background: #ffffff; }
    
    .fav-card .fav-top {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .fav-card .fav-emoji {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: linear-gradient(135deg, #2563EB, #8B5CF6);
    }
    .fav-card .fav-name { font-weight: 800; color: #000000; font-size: 0.95rem; transition: color 0.3s ease; }
    .fav-card .fav-count { font-size: 0.75rem; color: #1e293b; font-weight: 600; transition: color 0.3s ease; }

    /* Dark mode fav cards */
    [data-theme="dark"] .fav-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-color: rgba(71, 85, 105, 0.5);
    }
    [data-theme="dark"] .fav-card .fav-name {
        color: #ffffff;
        font-weight: 900;
        text-shadow: 0 1px 2px rgba(0,0,0,0.8);
    }
    [data-theme="dark"] .fav-card .fav-count {
        color: #f1f5f9;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    [data-theme="dark"] .fav-card:hover {
        background: linear-gradient(135deg, #334155 0%, #475569 100%);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }
    .fav-card .fav-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.65rem;
        background: linear-gradient(135deg, #2563EB, #0EA5E9);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }
    .fav-card .fav-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3); color: #fff; }
    
    /* ===== PROMO CAROUSEL ===== */
    .promo-scroll {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        scrollbar-width: thin;
        scrollbar-color: var(--border-gray) transparent;
    }
    .promo-scroll::-webkit-scrollbar { height: 4px; }
    .promo-scroll::-webkit-scrollbar-track { background: transparent; }
    .promo-scroll::-webkit-scrollbar-thumb { background: var(--border-gray); border-radius: 4px; }
    
    .promo-item {
        flex: 0 0 280px;
        padding: 1.25rem;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #fff;
    }
    .promo-item:hover { transform: translateY(-4px); box-shadow: 0 15px 40px rgba(0,0,0,0.2); color: #fff; }
    .promo-item.blue { background: linear-gradient(135deg, #1E3A8A, #3B82F6); }
    .promo-item.orange { background: linear-gradient(135deg, #9A3412, #F97316); }
    .promo-item.green { background: linear-gradient(135deg, #14532D, #22C55E); }
    .promo-item.purple { background: linear-gradient(135deg, #4C1D95, #8B5CF6); }
    
    .promo-item::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .promo-item .promo-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }
    .promo-item .promo-title { font-weight: 700; font-size: 1rem; margin-bottom: 0.35rem; }
    .promo-item .promo-desc { font-size: 0.82rem; opacity: 0.85; line-height: 1.4; }
    .promo-item .promo-emoji { position: absolute; bottom: 10px; right: 15px; font-size: 2.5rem; opacity: 0.3; }
    
    /* ===== SPENDING CHART VISUAL ===== */
    .spending-visual {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 100px;
        padding: 1rem 0;
    }
    .spending-bar {
        width: 32px;
        border-radius: 8px 8px 0 0;
        transition: all 0.3s ease;
        position: relative;
    }
    .spending-bar::after {
        content: attr(data-label);
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.65rem;
        color: #475569;
        font-weight: 700;
    }
    .spending-bar:hover { opacity: 0.8; transform: scaleY(1.05); transform-origin: bottom; }
    .spending-bar.bar-1 { height: 40%; background: linear-gradient(180deg, #CBD5E1, #94A3B8); }
    .spending-bar.bar-2 { height: 60%; background: linear-gradient(180deg, #93C5FD, #3B82F6); }
    .spending-bar.bar-3 { height: 75%; background: linear-gradient(180deg, #86EFAC, #22C55E); }
    .spending-bar.bar-4 { height: 55%; background: linear-gradient(180deg, #FDE68A, #F59E0B); }
    .spending-bar.bar-5 { height: 90%; background: linear-gradient(180deg, #C4B5FD, #8B5CF6); }
    .spending-bar.bar-6 { height: 70%; background: linear-gradient(180deg, #FBCFE8, #EC4899); }
    .spending-bar.bar-7 { height: 85%; background: linear-gradient(180deg, #6EE7B7, #10B981); }
    
    .spending-summary {
        display: flex;
        justify-content: space-between;
        padding-top: 2rem;
        border-top: 1px dashed var(--border-gray);
        margin-top: 1rem;
    }
    .spending-item { text-align: center; }
    .spending-item .sp-label { font-size: 0.7rem; color: #475569; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
    .spending-item .sp-value { font-size: 1.1rem; font-weight: 800; color: #0f172a; }

    /* Dark mode spending chart */
    [data-theme="dark"] .spending-bar::after {
        color: #e2e8f0;
    }
    [data-theme="dark"] .spending-item .sp-label {
        color: #e2e8f0;
    }
    [data-theme="dark"] .spending-item .sp-value {
        color: #ffffff;
    }
    
    /* ===== TIPS INTERACTIVE ===== */
    .tip-bubble {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        border-radius: 14px;
        margin-bottom: 0.65rem;
        transition: all 0.3s ease;
    }
    .tip-bubble:last-child { margin-bottom: 0; }
    .tip-bubble:hover { transform: translateX(4px); }
    .tip-bubble.yellow { background: linear-gradient(135deg, #FFFBEB, #FEF3C7); }
    .tip-bubble.blue { background: linear-gradient(135deg, #EFF6FF, #DBEAFE); }
    .tip-bubble.green { background: linear-gradient(135deg, #F0FDF4, #DCFCE7); }
    
    [data-theme="dark"] .tip-bubble.yellow { background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(251, 191, 36, 0.1)); }
    [data-theme="dark"] .tip-bubble.blue { background: linear-gradient(135deg, rgba(37, 99, 235, 0.2), rgba(59, 130, 246, 0.1)); }
    [data-theme="dark"] .tip-bubble.green { background: linear-gradient(135deg, rgba(22, 163, 74, 0.2), rgba(34, 197, 94, 0.1)); }

    .tip-bubble .tip-icon { font-size: 1.5rem; flex-shrink: 0; }
    .tip-bubble .tip-text { font-size: 0.85rem; font-weight: 600; color: #0f172a; line-height: 1.4; }

    /* Dark mode tips */
    [data-theme="dark"] .tip-bubble .tip-text {
        color: #f1f5f9;
    }
    
    /* ===== EMPTY STATES ===== */
    .empty-state {
        text-align: center;
        padding: 2.5rem 1.5rem;
    }
    .empty-state .empty-emoji { font-size: 3rem; margin-bottom: 0.75rem; display: block; opacity: 0.7; }
    .empty-state .empty-text { color: #475569; font-size: 0.9rem; margin-bottom: 1rem; }

    /* Dark mode empty state */
    [data-theme="dark"] .empty-state .empty-text {
        color: #e2e8f0;
    }
    .empty-state .empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #2563EB, #0EA5E9);
        color: #fff;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .empty-state .empty-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3); color: #fff; }
    
    /* ===== MOBILE RESPONSIVENESS ===== */
    @media (max-width: 992px) {
        .hero-bento { grid-template-columns: 1fr; gap: 1rem; }
        .bento-grid { grid-template-columns: 1fr; }
        .bento-card.span-8, .bento-card.span-4, .bento-card.span-6 { grid-column: span 1; }
    }
    
    @media (max-width: 768px) {
        .dashboard-container { padding-top: 0.75rem; padding-bottom: 1.5rem; }
        
        .welcome-card {
            padding: 1.25rem;
            min-height: auto;
            border-radius: 18px;
        }
        .welcome-card h2 { font-size: 1.3rem; }
        .welcome-card .subtitle { font-size: 0.8rem; }
        .welcome-card .time-badge { font-size: 0.75rem; padding: 0.4rem 0.7rem; }
        .welcome-card::before { width: 150px; height: 150px; top: -50px; right: -50px; }
        
        .status-summary { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr; gap: 0.5rem; }
        .mini-stat { padding: 0.85rem; border-radius: 14px; }
        .mini-stat .mini-icon { width: 38px; height: 38px; font-size: 0.9rem; border-radius: 10px; }
        .mini-stat .mini-value { font-size: 1.15rem; }
        .mini-stat .mini-label { font-size: 0.6rem; }
        .mini-stat .mini-trend { font-size: 0.6rem; padding: 0.2rem 0.4rem; }
        
        .quick-actions-strip { padding: 0.25rem 0 0.5rem; gap: 0.5rem; }
        .quick-pill { padding: 0.6rem 1rem; font-size: 0.75rem; border-radius: 50px; }
        .quick-pill .pill-icon { width: 26px; height: 26px; font-size: 0.75rem; }
        .quick-pill .pill-badge { font-size: 0.55rem; padding: 0.1rem 0.25rem; }
        
        .live-tracker { padding: 0.85rem 1rem; margin-bottom: 0.75rem; border-radius: 14px; flex-wrap: wrap; gap: 0.75rem; }
        .live-tracker .tracker-content { flex: 1 1 60%; }
        .live-tracker .tracker-title { font-size: 0.8rem; }
        .live-tracker .tracker-sub { font-size: 0.7rem; }
        .live-tracker .tracker-btn { padding: 0.45rem 0.9rem; font-size: 0.75rem; border-radius: 10px; }
        
        .bento-card { border-radius: 16px; }
        .bento-header { padding: 0.85rem 1rem; }
        .bento-header h5 { font-size: 0.85rem; gap: 0.5rem; }
        .bento-header h5 .header-icon { width: 28px; height: 28px; font-size: 0.75rem; border-radius: 8px; }
        .bento-header .header-action { font-size: 0.7rem; padding: 0.3rem 0.5rem; }
        
        .bento-body { padding: 0.85rem 1rem; }
        
        .order-card { padding: 0.75rem; border-radius: 12px; margin-bottom: 0.5rem; }
        .order-card::before { width: 3px; }
        .order-card .order-avatar { width: 34px; height: 34px; font-size: 0.85rem; margin-right: 0.65rem; border-radius: 10px; }
        .order-card .order-title { font-size: 0.78rem; }
        .order-card .order-sub { font-size: 0.68rem; }
        .order-card .order-amount { font-size: 0.78rem; }
        .status-badge { font-size: 0.6rem; padding: 0.2rem 0.45rem; border-radius: 6px; }
        
        .fav-card { padding: 0.85rem; margin-bottom: 0.5rem; border-radius: 12px; }
        .fav-card .fav-top { gap: 0.5rem; margin-bottom: 0.5rem; }
        .fav-card .fav-emoji { width: 34px; height: 34px; font-size: 0.9rem; border-radius: 10px; }
        .fav-card .fav-name { font-size: 0.82rem; }
        .fav-card .fav-count { font-size: 0.68rem; }
        .fav-card .fav-btn { padding: 0.5rem; font-size: 0.75rem; border-radius: 8px; }
        
        .promo-scroll { gap: 0.6rem; padding-bottom: 0.25rem; }
        .promo-item { flex: 0 0 200px; padding: 0.9rem; border-radius: 14px; }
        .promo-item .promo-badge { font-size: 0.6rem; padding: 0.25rem 0.5rem; margin-bottom: 0.5rem; }
        .promo-item .promo-title { font-size: 0.82rem; }
        .promo-item .promo-desc { font-size: 0.7rem; }
        .promo-item .promo-emoji { font-size: 1.75rem; bottom: 8px; right: 10px; }
        
        .spending-visual { height: 70px; padding: 0.5rem 0; }
        .spending-bar { width: 24px; border-radius: 6px 6px 0 0; }
        .spending-bar::after { font-size: 0.55rem; bottom: -16px; }
        .spending-summary { padding-top: 1.25rem; margin-top: 0.5rem; }
        .spending-item .sp-label { font-size: 0.6rem; }
        .spending-item .sp-value { font-size: 0.9rem; }
        
        .tip-bubble { padding: 0.7rem; margin-bottom: 0.4rem; border-radius: 10px; }
        .tip-bubble .tip-icon { font-size: 1.1rem; }
        .tip-bubble .tip-text { font-size: 0.75rem; }
        
        .empty-state { padding: 1.5rem 1rem; }
        .empty-state .empty-emoji { font-size: 2rem; margin-bottom: 0.5rem; }
        .empty-state .empty-text { font-size: 0.8rem; margin-bottom: 0.75rem; }
        .empty-state .empty-btn { padding: 0.5rem 1rem; font-size: 0.75rem; border-radius: 10px; }
    }
    
    @media (max-width: 480px) {
        .dashboard-container { padding-left: 0.5rem; padding-right: 0.5rem; }
        
        .welcome-card { padding: 1rem; border-radius: 14px; }
        .welcome-card h2 { font-size: 1.15rem; }
        .welcome-card h2 i { font-size: 0.9rem; }
        .welcome-card .subtitle { font-size: 0.75rem; }
        .welcome-card .time-badge { font-size: 0.7rem; padding: 0.35rem 0.6rem; }
        
        .status-summary { gap: 0.4rem; }
        .mini-stat { padding: 0.7rem; gap: 0.6rem; border-radius: 12px; }
        .mini-stat .mini-icon { width: 32px; height: 32px; font-size: 0.8rem; border-radius: 8px; }
        .mini-stat .mini-value { font-size: 1rem; }
        .mini-stat .mini-label { font-size: 0.55rem; }
        .mini-stat .mini-trend { display: none; }
        
        .quick-actions-strip { gap: 0.4rem; }
        .quick-pill { padding: 0.5rem 0.75rem; font-size: 0.7rem; }
        .quick-pill .pill-icon { width: 22px; height: 22px; font-size: 0.65rem; }
        .quick-pill span:not(.pill-icon):not(.pill-badge) { display: none; }
        
        .live-tracker { padding: 0.7rem 0.85rem; border-radius: 12px; }
        .live-tracker .pulse-dot { width: 8px; height: 8px; }
        .live-tracker .tracker-title { font-size: 0.75rem; }
        .live-tracker .tracker-sub { font-size: 0.65rem; }
        .live-tracker .tracker-btn { padding: 0.4rem 0.75rem; font-size: 0.7rem; }
        
        .bento-card { border-radius: 14px; }
        .bento-header { padding: 0.7rem 0.85rem; }
        .bento-header h5 { font-size: 0.8rem; }
        .bento-header h5 .header-icon { width: 24px; height: 24px; font-size: 0.7rem; }
        .bento-body { padding: 0.7rem 0.85rem; }
        
        .order-card { padding: 0.6rem; border-radius: 10px; }
        .order-card .order-avatar { width: 30px; height: 30px; font-size: 0.75rem; margin-right: 0.5rem; border-radius: 8px; }
        .order-card .order-title { font-size: 0.72rem; }
        .order-card .order-sub { font-size: 0.62rem; }
        .order-card .order-amount { font-size: 0.72rem; }
        .status-badge { font-size: 0.55rem; padding: 0.15rem 0.35rem; }
        
        .fav-card { padding: 0.7rem; border-radius: 10px; }
        .fav-card .fav-emoji { width: 30px; height: 30px; font-size: 0.8rem; border-radius: 8px; }
        .fav-card .fav-name { font-size: 0.75rem; }
        .fav-card .fav-btn { padding: 0.4rem; font-size: 0.7rem; }
        
        .promo-item { flex: 0 0 170px; padding: 0.75rem; }
        .promo-item .promo-badge { font-size: 0.55rem; }
        .promo-item .promo-title { font-size: 0.75rem; }
        .promo-item .promo-desc { font-size: 0.65rem; }
        .promo-item .promo-emoji { font-size: 1.5rem; }
        
        .spending-visual { height: 60px; }
        .spending-bar { width: 20px; }
        .spending-summary { flex-direction: column; gap: 0.5rem; text-align: center; }
        
        .tip-bubble { padding: 0.6rem; }
        .tip-bubble .tip-icon { font-size: 1rem; }
        .tip-bubble .tip-text { font-size: 0.7rem; }
        
        .promo-item { flex: 0 0 170px; padding: 0.75rem; }
        .promo-item .promo-title { font-size: 0.75rem; }
        .promo-item .promo-desc { font-size: 0.65rem; }
        .promo-item .promo-emoji { font-size: 1.5rem; }
    }
</style>

<div class="container dashboard-container">
    @php
        use Illuminate\Support\Str;

        $stats = $stats ?? [];
        $totalOrders = $stats['total_orders'] ?? 0;
        $completedOrders = $stats['completed_orders'] ?? 0;
        $pendingOrders = $stats['pending_orders'] ?? 0;
        $todaySpending = $stats['today_spending'] ?? 0;
        $monthlySpending = $stats['monthly_spending'] ?? 0;

        $recent_orders = $recent_orders ?? collect();
        $favorite_tenants = $favorite_tenants ?? collect();
        $cart_count = $cart_count ?? 0;

        
        // Time-based greeting
        $hour = now()->format('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
            $greetEmoji = '☀️';
            $greetText = 'Sudah sarapan belum?';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
            $greetEmoji = '🌤️';
            $greetText = 'Waktunya makan siang!';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
            $greetEmoji = '🌅';
            $greetText = 'Cari cemilan sore?';
        } else {
            $greeting = 'Selamat Malam';
            $greetEmoji = '🌙';
            $greetText = 'Lapar malam hari?';
        }

        // Get active/processing orders for live tracker
        $activeOrders = $recent_orders->whereIn('status', ['pending', 'diproses', 'pending_cash'])->take(1);
    @endphp

    {{-- ===== HERO BENTO ===== --}}
    <div class="hero-bento animate-in">
        <div class="welcome-card">
            <div class="content">
                    <h2><i class="fas fa-hand-wave me-2" style="color: #FBBF24;"></i>{{ $greeting }}, {{ Auth::user()->name }}!</h2>
                <p class="subtitle">{{ $greetText }}</p>
                <div class="time-badge">
                    <i class="fas fa-clock"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>
        
        <div class="status-summary">
            <div class="mini-stat">
                <div class="mini-icon" style="background: linear-gradient(135deg, #F59E0B, #FBBF24);">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="mini-info">
                    <div class="mini-value">{{ $pendingOrders }}</div>
                    <div class="mini-label">Pesanan Aktif</div>
                </div>
                @if($pendingOrders > 0)
                <span class="mini-trend pending"><i class="fas fa-circle fa-xs"></i> Live</span>
                @endif
            </div>
            <div class="mini-stat">
                <div class="mini-icon" style="background: linear-gradient(135deg, #10B981, #34D399);">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="mini-info">
                    <div class="mini-value">{{ $completedOrders }}</div>
                    <div class="mini-label">Selesai Bulan Ini</div>
                </div>
                <span class="mini-trend up"><i class="fas fa-arrow-up fa-xs"></i> Nice!</span>
            </div>
        </div>
    </div>

    {{-- ===== QUICK ACTIONS STRIP ===== --}}
    <div class="quick-actions-strip animate-in delay-1">
        <a href="{{ route('customer.tenants') }}" class="quick-pill blue">
            <span class="pill-icon" style="background: linear-gradient(135deg, #2563EB, #0EA5E9);"><i class="fas fa-store"></i></span>
            <span>Pesan Sekarang</span>
        </a>
        <a href="{{ route('customer.cart') }}" class="quick-pill orange">
            <span class="pill-icon" style="background: linear-gradient(135deg, #F59E0B, #FBBF24);"><i class="fas fa-shopping-cart"></i></span>
            <span>Keranjang</span>
            @if($cart_count > 0)
            <span class="pill-badge">{{ $cart_count }}</span>
            @endif
        </a>
        <a href="{{ route('customer.orders') }}" class="quick-pill green">
            <span class="pill-icon" style="background: linear-gradient(135deg, #10B981, #34D399);"><i class="fas fa-receipt"></i></span>
            <span>Riwayat</span>
        </a>
        <a href="{{ route('customer.account') }}" class="quick-pill purple">
            <span class="pill-icon" style="background: linear-gradient(135deg, #8B5CF6, #A78BFA);"><i class="fas fa-user-circle"></i></span>
            <span>Akun Saya</span>
        </a>
    </div>

    {{-- ===== LIVE ORDER TRACKER (if has active order) ===== --}}
    @if($activeOrders->count() > 0)
    @php $activeOrder = $activeOrders->first(); @endphp
    <div class="live-tracker animate-in delay-2">
        <div class="pulse-dot"></div>
        <div class="tracker-content">
            <div class="tracker-title">
                <i class="fas fa-fire-alt me-1"></i>
                Pesanan #{{ $activeOrder->kode_pesanan ?? $activeOrder->id }} sedang {{ $activeOrder->status == 'pending' ? 'menunggu konfirmasi' : 'diproses' }}
            </div>
            <div class="tracker-sub">{{ $activeOrder->tenant->nama_tenant ?? '-' }} • Rp {{ number_format($activeOrder->total_harga ?? 0, 0, ',', '.') }}</div>
        </div>
        <a href="{{ route('customer.orders') }}" class="tracker-btn">
            <i class="fas fa-eye"></i> Lacak
        </a>
    </div>
    @endif

    {{-- ===== BENTO GRID LAYOUT ===== --}}
    <div class="bento-grid">
        {{-- Recent Orders - Main Card --}}
        <div class="bento-card span-8 animate-in delay-2">
            <div class="bento-header">
                <h5>
                    <span class="header-icon" style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE); color: #2563EB;">
                        <i class="fas fa-clock"></i>
                    </span>
                    Pesanan Terbaru
                </h5>
                @if($recent_orders->count() > 0)
                <a href="{{ route('customer.orders') }}" class="header-action">
                    Lihat Semua <i class="fas fa-chevron-right"></i>
                </a>
                @endif
            </div>
            <div class="bento-body">
                @if($recent_orders->count() > 0)
                    @foreach($recent_orders->take(4) as $index => $order)
                        @php
                            $status = $order->status ?? '';
                        @endphp
                        <div class="order-card status-{{ $status }}">
                            <div class="order-info">
                                <div class="order-title">#{{ $order->kode_pesanan ?? $order->id ?? '-' }}</div>
                                <div class="order-sub">{{ $order->tenant->nama_tenant ?? '-' }} • {{ optional($order->created_at)->format('d M, H:i') }}</div>
                            </div>
                            <div class="order-end">
                                <div class="order-amount">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</div>
                                <span class="status-badge {{ $status }}">
                                    @if($status == 'pending')
                                        <i class="fas fa-clock fa-xs"></i> Menunggu
                                    @elseif($status == 'diproses')
                                        <i class="fas fa-fire fa-xs"></i> Diproses
                                    @elseif($status == 'selesai')
                                        <i class="fas fa-check fa-xs"></i> Selesai
                                    @elseif($status == 'pending_cash')
                                        Bayar Tunai
                                    @elseif($status == 'dibatalkan')
                                        <i class="fas fa-times fa-xs"></i> Dibatalkan
                                    @else
                                        {{ ucfirst($status) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <span class="empty-emoji"><i class="fas fa-utensils" style="color: var(--text-secondary);"></i></span>
                        <p class="empty-text">Belum ada pesanan. Yuk mulai pesan makanan favoritmu!</p>
                        <a href="{{ route('customer.tenants') }}" class="empty-btn">
                            <i class="fas fa-store"></i> Jelajahi Menu
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Favorite Tenants --}}
        <div class="bento-card span-4 animate-in delay-3">
            <div class="bento-header">
                <h5>
                    <span class="header-icon" style="background: linear-gradient(135deg, #FDF2F8, #FCE7F3); color: #EC4899;">
                        <i class="fas fa-heart"></i>
                    </span>
                    Favorit Kamu
                </h5>
            </div>
            <div class="bento-body">
                @if($favorite_tenants->count() > 0)
                    @foreach($favorite_tenants->take(2) as $index => $tenant)
                        <div class="fav-card">
                            <div class="fav-top">
                                <div class="fav-emoji"><i class="fas fa-store" style="color: white;"></i></div>
                                <div>
                                    <div class="fav-name">{{ $tenant->nama_tenant ?? '-' }}</div>
                                    <div class="fav-count">Dipesan {{ $tenant->order_count ?? 0 }}x</div>
                                </div>
                            </div>
                            <a href="{{ route('customer.tenants') }}" class="fav-btn">
                                <i class="fas fa-utensils"></i> Pesan Lagi
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state" style="padding: 1.5rem;">
                        <span class="empty-emoji" style="font-size: 2rem;"><i class="fas fa-heart" style="color: #EC4899;"></i></span>
                        <p class="empty-text" style="font-size: 0.85rem; margin-bottom: 0.75rem;">Belum ada tenant favorit</p>
                        <a href="{{ route('customer.tenants') }}" class="empty-btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                            <i class="fas fa-compass"></i> Jelajahi
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Spending Stats --}}
        <div class="bento-card span-4 animate-in delay-2">
            <div class="bento-header">
                <h5>
                    <span class="header-icon" style="background: linear-gradient(135deg, #F0FDF4, #DCFCE7); color: #16A34A;">
                        <i class="fas fa-chart-line"></i>
                    </span>
                    Pengeluaran
                </h5>
            </div>
            <div class="bento-body">
                <div class="spending-visual">
                    <div class="spending-bar bar-1" data-label="Sen"></div>
                    <div class="spending-bar bar-2" data-label="Sel"></div>
                    <div class="spending-bar bar-3" data-label="Rab"></div>
                    <div class="spending-bar bar-4" data-label="Kam"></div>
                    <div class="spending-bar bar-5" data-label="Jum"></div>
                    <div class="spending-bar bar-6" data-label="Sab"></div>
                    <div class="spending-bar bar-7" data-label="Min"></div>
                </div>
                <div class="spending-summary">
                    <div class="spending-item">
                        <div class="sp-label">Hari Ini</div>
                        <div class="sp-value">Rp {{ number_format($todaySpending, 0, ',', '.') }}</div>
                    </div>
                    <div class="spending-item">
                        <div class="sp-label">Bulan Ini</div>
                        <div class="sp-value" style="color: #16A34A;">Rp {{ number_format($monthlySpending, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tips & Tricks --}}
        <div class="bento-card span-4 animate-in delay-3">
            <div class="bento-header">
                <h5>
                    <span class="header-icon" style="background: linear-gradient(135deg, #FFFBEB, #FEF3C7); color: #D97706;">
                        <i class="fas fa-lightbulb"></i>
                    </span>
                    Tips Hemat
                </h5>
            </div>
            <div class="bento-body" style="padding: 1rem;">
                <div class="tip-bubble yellow">
                    <span class="tip-icon"><i class="fas fa-lightbulb" style="color: #D97706;"></i></span>
                    <span class="tip-text">Pesan di jam 10-11 pagi untuk antrian lebih cepat!</span>
                </div>
                <div class="tip-bubble blue">
                    <span class="tip-icon"><i class="fas fa-bullseye" style="color: #2563EB;"></i></span>
                    <span class="tip-text">Kumpulkan 10 pesanan untuk badge loyal customer</span>
                </div>
                <div class="tip-bubble green">
                    <span class="tip-icon"><i class="fas fa-tag" style="color: #16A34A;"></i></span>
                    <span class="tip-text">Gunakan kode EKANTIN untuk diskon 10%</span>
                </div>
            </div>
        </div>

        {{-- Stats Summary --}}
        <div class="bento-card span-4 animate-in delay-2">
            <div class="bento-header">
                <h5>
                    <span class="header-icon" style="background: linear-gradient(135deg, #EDE9FE, #DDD6FE); color: #7C3AED;">
                        <i class="fas fa-trophy"></i>
                    </span>
                    Statistik Kamu
                </h5>
            </div>
            <div class="bento-body">
                <div class="d-flex align-items-center justify-content-between mb-3 p-3 rounded-3" style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); font-weight: 600;">TOTAL PESANAN</div>
                        <div style="font-size: 1.75rem; font-weight: 800; color: #1E40AF;">{{ $totalOrders }}</div>
                    </div>
                    <div style="font-size: 2.5rem; color: #3B82F6;"><i class="fas fa-box"></i></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="flex-fill p-2 rounded-3 text-center" style="background: var(--light-gray);">
                        <div style="font-size: 1.25rem; font-weight: 800; color: #F59E0B;">{{ $pendingOrders }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary);">Pending</div>
                    </div>
                    <div class="flex-fill p-2 rounded-3 text-center" style="background: var(--light-gray);">
                        <div style="font-size: 1.25rem; font-weight: 800; color: #10B981;">{{ $completedOrders }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary);">Selesai</div>
                    </div>
                    <div class="flex-fill p-2 rounded-3 text-center" style="background: var(--light-gray);">
                        <div style="font-size: 1.25rem; font-weight: 800; color: #8B5CF6;">{{ $favorite_tenants->count() }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-secondary);">Favorit</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PROMO CAROUSEL ===== --}}
    <div class="bento-card span-12 animate-in delay-3" style="margin-bottom: 0;">
        <div class="bento-header">
            <h5>
                <span class="header-icon" style="background: linear-gradient(135deg, #FEF2F2, #FECACA); color: #DC2626;">
                    <i class="fas fa-fire"></i>
                </span>
                Info & Promo
            </h5>
        </div>
        <div class="bento-body">
            <div class="promo-scroll">
                <a href="{{ route('customer.tenants') }}" class="promo-item blue">
                    <div class="promo-badge"><i class="fas fa-star"></i> BARU</div>
                    <div class="promo-title">Menu Spesial Minggu Ini</div>
                    <div class="promo-desc">Cek menu baru dari tenant favorit kamu!</div>
                    <span class="promo-emoji"><i class="fas fa-utensils"></i></span>
                </a>
                <a href="{{ route('customer.tenants', ['sort' => 'popular']) }}" class="promo-item orange">
                    <div class="promo-badge"><i class="fas fa-fire"></i> POPULER</div>
                    <div class="promo-title">Tenant Terlaris</div>
                    <div class="promo-desc">Lihat tenant dengan pesanan terbanyak</div>
                    <span class="promo-emoji"><i class="fas fa-fire-alt"></i></span>
                </a>
                <a href="{{ route('customer.tenants', ['filter' => 'promo']) }}" class="promo-item green">
                    <div class="promo-badge"><i class="fas fa-percent"></i> DISKON</div>
                    <div class="promo-title">Promo Akhir Bulan</div>
                    <div class="promo-desc">Diskon hingga 20% untuk menu pilihan</div>
                    <span class="promo-emoji"><i class="fas fa-coins"></i></span>
                </a>
                <a href="{{ route('customer.tenants') }}" class="promo-item purple">
                    <div class="promo-badge"><i class="fas fa-gift"></i> BONUS</div>
                    <div class="promo-title">Rewards Program</div>
                    <div class="promo-desc">Kumpulkan poin setiap transaksi</div>
                    <span class="promo-emoji"><i class="fas fa-gift"></i></span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.animate-in').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(el);
    });
    
    // Add hover sound effect simulation with visual feedback
    document.querySelectorAll('.quick-pill, .order-card, .fav-card, .promo-item').forEach(el => {
        el.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.2s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });
});
</script>
@endsection

