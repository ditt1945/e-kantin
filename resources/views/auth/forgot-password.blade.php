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
<div class="forgot-password-page" data-bs-theme="light">
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>
    <div class="forgot-password-container">
        {{-- Left Side - Branding --}}
        <div class="forgot-password-branding d-none d-lg-flex">
            <div class="branding-content">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h1>Lupa Password</h1>
                    <p class="tagline">SMKN 2 Surabaya</p>
                </div>

                <div class="instructions-list">
                    <div class="instruction-item">
                        <div class="instruction-icon bg-1">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="instruction-text">
                            <h5>Masukkan Email</h5>
                            <p>Gunakan email yang terdaftar</p>
                        </div>
                    </div>
                    <div class="instruction-item">
                        <div class="instruction-icon bg-2">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="instruction-text">
                            <h5>Kirim Link Reset</h5>
                            <p>Periksa inbox email Anda</p>
                        </div>
                    </div>
                    <div class="instruction-item">
                        <div class="instruction-icon bg-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="instruction-text">
                            <h5>Reset Password</h5>
                            <p>Buat password baru Anda</p>
                        </div>
                    </div>
                </div>

                <div class="branding-footer">
                    <p><i class="fas fa-shield-alt me-2"></i>Keamanan akun prioritas kami</p>
                </div>
            </div>
        </div>

        {{-- Right Side - Forgot Password Form --}}
        <div class="forgot-password-form-section">
            <div class="forgot-password-card">
                {{-- Mobile Logo --}}
                <div class="mobile-logo d-lg-none">
                    <div class="logo-icon-sm">
                        <i class="fas fa-key"></i>
                    </div>
                    <h2>e-Kantin</h2>
                </div>

                <div class="form-header">
                    <h3>Lupa Password? 🔐</h3>
                    <p>Masukkan email untuk menerima link reset password</p>
                </div>

                @if (session('status'))
                    <div class="alert-box success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if($errors->has('email'))
                    <div class="alert-box error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="forgot-password-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email Terdaftar
                        </label>
                        <input type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="@error('email') error @enderror"
                            required
                            autofocus>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Kirim Link Reset</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <div class="divider">
                    <span>kembali ke</span>
                </div>

                <div class="login-link">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-2"></i>
                        Halaman Login
                    </a>
                </div>

                <div class="help-note">
                    <i class="fas fa-question-circle"></i>
                    <div>
                        <strong>Perlu bantuan?</strong>
                        <p>Hubungi admin sistem jika Anda tidak bisa mengakses email</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Forgot Password Page Styles */
.forgot-password-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    transition: background 0.3s ease;
}

.forgot-password-container {
    display: flex;
    max-width: 1000px;
    width: 100%;
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transition: all 0.3s ease;
}

/* Dark mode adjustments */
[data-theme="dark"] .forgot-password-page {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
}

[data-theme="dark"] .forgot-password-container {
    background: #0f172a;
    border: 1px solid rgba(148, 163, 184, 0.2);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

/* Form Section Dark Mode */
[data-theme="dark"] .forgot-password-form-section {
    background: #0f172a;
}

[data-theme="dark"] .form-header h3 {
    color: #f1f5f9;
}

[data-theme="dark"] .form-header p {
    color: #cbd5e1;
}

[data-theme="dark"] .alert-box.success {
    background: rgba(34, 197, 94, 0.1);
    color: #4ade80;
    border-color: rgba(74, 222, 128, 0.2);
}

[data-theme="dark"] .alert-box.error {
    background: rgba(220, 38, 38, 0.1);
    color: #f87171;
    border-color: rgba(248, 113, 113, 0.2);
}

[data-theme="dark"] .forgot-password-form label {
    color: #e2e8f0;
}

[data-theme="dark"] .forgot-password-form label i {
    color: #a78bfa;
}

[data-theme="dark"] .forgot-password-form input[type="email"] {
    background: #1e293b;
    border-color: rgba(71, 85, 105, 0.5);
    color: #f1f5f9;
}

[data-theme="dark"] .forgot-password-form input:focus {
    background: #334155;
    border-color: #a78bfa;
    box-shadow: 0 0 0 4px rgba(167, 139, 250, 0.1);
}

[data-theme="dark"] .forgot-password-form input::placeholder {
    color: #64748b;
}

[data-theme="dark"] .btn-submit {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}

[data-theme="dark"] .btn-submit:hover {
    box-shadow: 0 6px 20px rgba(139, 92, 246, 0.5);
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

[data-theme="dark"] .login-link a {
    color: #a78bfa;
}

[data-theme="dark"] .login-link a:hover {
    color: #8b5cf6;
}

[data-theme="dark"] .help-note {
    background: #1e293b;
    border-color: rgba(167, 139, 250, 0.2);
}

[data-theme="dark"] .help-note strong {
    color: #e2e8f0;
}

[data-theme="dark"] .help-note p {
    color: #94a3b8;
}

/* Mobile dark mode */
@media (max-width: 576px) {
    [data-theme="dark"] .forgot-password-page {
        background: #0f172a;
    }
}

/* Branding Section */
.forgot-password-branding {
    flex: 1;
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.forgot-password-branding::before {
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
    margin-bottom: 3rem;
}

.logo-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2.5rem;
    backdrop-filter: blur(10px);
}

.logo-section h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    letter-spacing: -0.5px;
}

.tagline {
    opacity: 0.9;
    font-size: 1rem;
    margin-top: 0.5rem;
}

.instructions-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.instruction-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255,255,255,0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    transition: transform 0.3s ease;
}

.instruction-item:hover {
    transform: translateX(10px);
}

.instruction-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.instruction-icon.bg-1 { background: rgba(59, 130, 246, 0.3); }
.instruction-icon.bg-2 { background: rgba(16, 185, 129, 0.3); }
.instruction-icon.bg-3 { background: rgba(251, 191, 36, 0.3); }

.instruction-text h5 {
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 0.25rem;
}

.instruction-text p {
    margin: 0;
    font-size: 0.85rem;
    opacity: 0.8;
}

.branding-footer {
    text-align: center;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255,255,255,0.2);
}

.branding-footer p {
    margin: 0;
    opacity: 0.8;
    font-size: 0.9rem;
}

/* Form Section */
.forgot-password-form-section {
    flex: 1;
    padding: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
}

.forgot-password-card {
    width: 100%;
    max-width: 380px;
}

.mobile-logo {
    text-align: center;
    margin-bottom: 2rem;
}

.logo-icon-sm {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.75rem;
    color: white;
}

.mobile-logo h2 {
    font-size: 1.75rem;
    font-weight: 800;
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

.form-header {
    margin-bottom: 2rem;
}

.form-header h3 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #1E293B;
    margin: 0 0 0.5rem;
}

.form-header p {
    color: #64748B;
    margin: 0;
    font-size: 0.95rem;
}

.alert-box {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.alert-box.success {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}

.alert-box.error {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-box i {
    font-size: 1.1rem;
}

.forgot-password-form .form-group {
    margin-bottom: 1.5rem;
}

.forgot-password-form label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.forgot-password-form label i {
    color: #8B5CF6;
    font-size: 0.85rem;
}

.forgot-password-form input[type="email"] {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #E2E8F0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #F8FAFC;
    color: #1E293B;
}

.forgot-password-form input:focus {
    outline: none;
    border-color: #8B5CF6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
}

.forgot-password-form input.error {
    border-color: #dc2626;
}

.forgot-password-form input::placeholder {
    color: #94A3B8;
}

.error-text {
    display: block;
    color: #dc2626;
    font-size: 0.8rem;
    margin-top: 0.5rem;
}

.btn-submit {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 92, 246, 0.5);
}

.btn-submit:active {
    transform: translateY(0);
}

.divider {
    display: flex;
    align-items: center;
    margin: 1.5rem 0;
    color: #94A3B8;
    font-size: 0.85rem;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #E2E8F0;
}

.divider span {
    padding: 0 1rem;
}

.login-link {
    text-align: center;
    padding: 1.25rem;
    background: #F8FAFC;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.login-link a {
    color: #8B5CF6;
    text-decoration: none;
    font-weight: 700;
    transition: color 0.3s ease;
}

.login-link a:hover {
    color: #7C3AED;
}

.help-note {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.85rem;
}

.help-note i {
    color: #8B5CF6;
    font-size: 1rem;
    margin-top: 0.1rem;
}

.help-note strong {
    color: #1e293b;
    font-size: 0.9rem;
}

.help-note p {
    margin: 0.25rem 0 0;
    color: #64748b;
    line-height: 1.4;
}

/* Responsive */
@media (max-width: 991px) {
    .forgot-password-container {
        max-width: 450px;
    }

    .forgot-password-form-section {
        padding: 2rem;
    }
}

@media (max-width: 576px) {
    .forgot-password-page {
        padding: 0;
        background: #fff;
    }

    .forgot-password-container {
        border-radius: 0;
        box-shadow: none;
    }

    .forgot-password-form-section {
        padding: 1.5rem;
    }

    .form-header h3 {
        font-size: 1.5rem;
    }
}
</style>

<script>
// Theme Toggle Functionality
function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    const forgotPasswordPage = document.querySelector('.forgot-password-page');
    const themeIcon = document.getElementById('themeIcon');

    if (savedTheme === 'dark') {
        forgotPasswordPage.setAttribute('data-theme', 'dark');
        forgotPasswordPage.setAttribute('data-bs-theme', 'dark');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
    }
}

function toggleTheme() {
    const forgotPasswordPage = document.querySelector('.forgot-password-page');
    const themeIcon = document.getElementById('themeIcon');
    const currentTheme = forgotPasswordPage.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    forgotPasswordPage.setAttribute('data-theme', newTheme);
    forgotPasswordPage.setAttribute('data-bs-theme', newTheme);

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
        const forgotPasswordPage = document.querySelector('.forgot-password-page');
        const themeIcon = document.getElementById('themeIcon');

        forgotPasswordPage.setAttribute('data-theme', e.detail.theme);
        forgotPasswordPage.setAttribute('data-bs-theme', e.detail.theme);

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