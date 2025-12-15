@extends('layouts.app')

@push('styles')
<style>
/* Theme Toggle Button */
.theme-toggle {
    position: fixed;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 1000;
    backdrop-filter: blur(10px);
}

.theme-toggle:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.95);
}

.theme-toggle i {
    font-size: 1.2rem;
    color: #2563EB;
    transition: all 0.3s ease;
}

[data-theme="dark"] .theme-toggle {
    background: rgba(15, 23, 42, 0.9);
    border-color: rgba(71, 85, 105, 0.3);
}

[data-theme="dark"] .theme-toggle:hover {
    background: rgba(15, 23, 42, 0.95);
}

[data-theme="dark"] .theme-toggle i {
    color: #fbbf24;
}
</style>
@endpush

@section('content')
<div class="register-page" data-bs-theme="light">
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>
    <div class="register-container">
        {{-- Left Side - Branding --}}
        <div class="register-branding d-none d-lg-flex">
            <div class="branding-content">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h1>e-Kantin</h1>
                    <p class="tagline">SMKN 2 Surabaya</p>
                </div>
                
                <div class="benefits-list">
                    <h4><i class="fas fa-star me-2"></i>Keuntungan Bergabung</h4>
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Pesan makanan kapan saja</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Bayar tanpa ribet dengan QRIS</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Lihat menu favorit sekolah</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Notifikasi pesanan real-time</span>
                        </li>
                    </ul>
                </div>
                
                <div class="branding-footer">
                    <div class="stats">
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Pengguna</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Menu</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">5</span>
                            <span class="stat-label">Tenant</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Register Form --}}
        <div class="register-form-section">
            <div class="register-card">
                {{-- Mobile Logo --}}
                <div class="mobile-logo d-lg-none">
                    <div class="logo-icon-sm">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h2>e-Kantin</h2>
                </div>
                
                <div class="form-header">
                    <h3>Buat Akun Baru ✨</h3>
                    <p>Daftar untuk mulai memesan makanan</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="register-form">
                    @csrf

                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="Masukkan nama lengkap"
                            class="@error('name') error @enderror"
                            required 
                            autofocus>
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="nama@email.com"
                            class="@error('email') error @enderror"
                            required>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i>
                                Password
                            </label>
                            <input type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Min. 8 karakter"
                                class="@error('password') error @enderror"
                                required>
                            @error('password')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                <i class="fas fa-lock"></i>
                                Konfirmasi
                            </label>
                            <input type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Ulangi password"
                                required>
                        </div>
                    </div>

                    <div class="terms-check">
                        <label>
                            <input type="checkbox" required>
                            <span>Saya setuju dengan <a href="#">Syarat & Ketentuan</a></span>
                        </label>
                    </div>

                    <button type="submit" class="btn-register">
                        <span>Daftar Sekarang</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="login-link">
                    <p>Sudah punya akun?</p>
                    <a href="{{ route('login') }}">
                        Masuk di sini
                        <i class="fas fa-sign-in-alt ms-1"></i>
                    </a>
                </div>

                <div class="security-note">
                    <i class="fas fa-shield-alt"></i>
                    <span>Data Anda aman & terenkripsi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Register Page Styles */
.register-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    transition: background 0.3s ease;
}

.register-container {
    display: flex;
    max-width: 1000px;
    width: 100%;
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Dark mode adjustments */
[data-theme="dark"] .register-page {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
}

[data-theme="dark"] .register-container {
    background: #0f172a;
    border: 1px solid rgba(148, 163, 184, 0.2);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

/* Branding Section */
.register-branding {
    flex: 0 0 400px;
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.register-branding::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.branding-content {
    position: relative;
    z-index: 1;
}

.logo-section {
    text-align: center;
    margin-bottom: 2.5rem;
}

.logo-icon {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.2);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    backdrop-filter: blur(10px);
}

.logo-section h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin: 0;
    letter-spacing: -0.5px;
}

.tagline {
    opacity: 0.9;
    font-size: 0.95rem;
    margin-top: 0.3rem;
}

.benefits-list {
    background: rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 1.5rem;
    backdrop-filter: blur(10px);
}

.benefits-list h4 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0 0 1rem;
    display: flex;
    align-items: center;
}

.benefits-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.benefits-list li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.6rem 0;
    font-size: 0.9rem;
}

.benefits-list li i {
    width: 20px;
    height: 20px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
}

.branding-footer {
    margin-top: 2rem;
}

.stats {
    display: flex;
    justify-content: space-around;
    text-align: center;
}

.stat-item {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 800;
}

.stat-label {
    font-size: 0.8rem;
    opacity: 0.8;
}

/* Form Section */
.register-form-section {
    flex: 1;
    padding: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
}

.register-card {
    width: 100%;
    max-width: 400px;
}

.mobile-logo {
    text-align: center;
    margin-bottom: 1.5rem;
}

.logo-icon-sm {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
    font-size: 1.5rem;
    color: #1e40af;
}

.mobile-logo h2 {
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

.form-header {
    margin-bottom: 1.5rem;
}

.form-header h3 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0 0 0.3rem;
}

.form-header p {
    color: #64748b;
    margin: 0;
    font-size: 0.9rem;
}

/* Dark mode form section */
[data-theme="dark"] .register-form-section {
    background: #0f172a;
}

[data-theme="dark"] .form-header h3 {
    color: #f1f5f9;
}

[data-theme="dark"] .form-header p {
    color: #cbd5e1;
}

.register-form .form-group {
    margin-bottom: 1.25rem;
}

.register-form label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.4rem;
    font-size: 0.85rem;
}

.register-form label i {
    color: #2563EB;
    font-size: 0.8rem;
}

.register-form input[type="text"],
.register-form input[type="email"],
.register-form input[type="password"] {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f8fafc;
    color: #1e293b;
}

.register-form input:focus {
    outline: none;
    border-color: #2563EB;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.register-form input.error {
    border-color: #dc2626;
}

.register-form input::placeholder {
    color: #94a3b8;
}

/* Dark mode form elements */
[data-theme="dark"] .register-form label {
    color: #e2e8f0;
}

[data-theme="dark"] .register-form label i {
    color: #60a5fa;
}

[data-theme="dark"] .register-form input[type="text"],
[data-theme="dark"] .register-form input[type="email"],
[data-theme="dark"] .register-form input[type="password"] {
    background: #1e293b;
    border-color: rgba(71, 85, 105, 0.5);
    color: #f1f5f9;
}

[data-theme="dark"] .register-form input:focus {
    background: #334155;
    border-color: #60a5fa;
    box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.1);
}

[data-theme="dark"] .register-form input::placeholder {
    color: #64748b;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.error-text {
    display: block;
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.4rem;
}

.terms-check {
    margin-bottom: 1.25rem;
}

.terms-check label {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.85rem;
    color: #6b7280;
}

.terms-check input {
    width: 16px;
    height: 16px;
    margin-top: 2px;
    accent-color: #2563EB;
    cursor: pointer;
}

.terms-check a {
    color: #2563EB;
    text-decoration: none;
    font-weight: 600;
}

.terms-check a:hover {
    text-decoration: underline;
}

.btn-register {
    width: 100%;
    padding: 0.875rem;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
}

.btn-register:active {
    transform: translateY(0);
}

.divider {
    display: flex;
    align-items: center;
    margin: 1.25rem 0;
    color: #9ca3af;
    font-size: 0.8rem;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
}

.divider span {
    padding: 0 1rem;
}

.login-link {
    text-align: center;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.login-link p {
    margin: 0 0 0.3rem;
    color: #64748b;
    font-size: 0.85rem;
}

.login-link a {
    color: #2563EB;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.login-link a:hover {
    color: #1D4ED8;
}

.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #10b981;
    font-size: 0.8rem;
}

.security-note i {
    font-size: 0.85rem;
}

/* Dark mode remaining elements */
[data-theme="dark"] .terms-check label {
    color: #cbd5e1;
}

[data-theme="dark"] .terms-check a {
    color: #60a5fa;
}

[data-theme="dark"] .btn-register {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

[data-theme="dark"] .btn-register:hover {
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
}

[data-theme="dark"] .divider {
    color: #64748b;
}

[data-theme="dark"] .divider::before,
[data-theme="dark"] .divider::after {
    background: rgba(71, 85, 105, 0.5);
}

[data-theme="dark"] .login-link {
    background: #1e293b;
}

[data-theme="dark"] .login-link p {
    color: #cbd5e1;
}

[data-theme="dark"] .login-link a {
    color: #60a5fa;
}

[data-theme="dark"] .security-note {
    color: #34d399;
}

/* Responsive */
@media (max-width: 991px) {
    .register-container {
        max-width: 450px;
    }
    
    .register-form-section {
        padding: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .register-page {
        padding: 0;
        background: #fff;
    }

    .register-container {
        border-radius: 0;
        box-shadow: none;
    }

    .register-form-section {
        padding: 1.5rem;
    }

    .form-header h3 {
        font-size: 1.3rem;
    }

    [data-theme="dark"] .register-page {
        background: #0f172a;
    }
}
</style>

<script>
// Theme Toggle Functionality
function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    const registerPage = document.querySelector('.register-page');
    const themeIcon = document.getElementById('themeIcon');

    if (savedTheme === 'dark') {
        registerPage.setAttribute('data-theme', 'dark');
        registerPage.setAttribute('data-bs-theme', 'dark');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
    }
}

function toggleTheme() {
    const registerPage = document.querySelector('.register-page');
    const themeIcon = document.getElementById('themeIcon');
    const currentTheme = registerPage.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    registerPage.setAttribute('data-theme', newTheme);
    registerPage.setAttribute('data-bs-theme', newTheme);

    if (newTheme === 'dark') {
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
    } else {
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
    }

    localStorage.setItem('theme', newTheme);

    // Dispatch custom event for other components
    window.dispatchEvent(new CustomEvent('themeChanged', {
        detail: { theme: newTheme }
    }));
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    initTheme();

    // Listen for theme changes from other components
    window.addEventListener('themeChanged', function(e) {
        const registerPage = document.querySelector('.register-page');
        const themeIcon = document.getElementById('themeIcon');

        registerPage.setAttribute('data-theme', e.detail.theme);
        registerPage.setAttribute('data-bs-theme', e.detail.theme);

        if (e.detail.theme === 'dark') {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    });
});
</script>
@endsection


