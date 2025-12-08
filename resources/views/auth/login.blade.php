@extends('layouts.app')

@section('content')
<div class="login-page" data-bs-theme="light">
    <div class="login-container">
        {{-- Left Side - Branding --}}
        <div class="login-branding d-none d-lg-flex">
            <div class="branding-content">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h1>e-Kantin</h1>
                    <p class="tagline">SMKN 2 Surabaya</p>
                </div>
                
                <div class="features-list">
                    <div class="feature-item">
                        <div class="feature-icon bg-1">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Pesan Cepat</h5>
                            <p>Proses pemesanan dalam hitungan detik</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon bg-2">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Pembayaran Aman</h5>
                            <p>Terintegrasi dengan Midtrans</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon bg-3">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="feature-text">
                            <h5>Menu Favorit</h5>
                            <p>Berbagai pilihan makanan lezat</p>
                        </div>
                    </div>
                </div>
                
                <div class="branding-footer">
                    <p><i class="fas fa-school me-2"></i>Platform Kantin Digital Sekolah</p>
                </div>
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div class="login-form-section">
            <div class="login-card">
                {{-- Mobile Logo --}}
                <div class="mobile-logo d-lg-none">
                    <div class="logo-icon-sm">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h2>e-Kantin</h2>
                </div>
                
                <div class="form-header">
                    <h3>Selamat Datang! 👋</h3>
                    <p>Masuk untuk melanjutkan ke akun Anda</p>
                </div>

                @if($errors->has('email') || $errors->has('password'))
                    <div class="alert-box error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first('email') ?? $errors->first('password') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

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
                            required 
                            autofocus>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-wrapper">
                            <input type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Masukkan password"
                                class="@error('password') error @enderror"
                                required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        <span>Masuk</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="register-link">
                    <p>Belum punya akun?</p>
                    <a href="{{ route('register') }}">
                        Daftar Sekarang
                        <i class="fas fa-user-plus ms-1"></i>
                    </a>
                </div>

                <div class="security-note">
                    <i class="fas fa-lock"></i>
                    <span>Koneksi aman & terenkripsi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Login Page Styles */
.login-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.login-container {
    display: flex;
    max-width: 1000px;
    width: 100%;
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Branding Section */
.login-branding {
    flex: 1;
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.login-branding::before {
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

.features-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255,255,255,0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateX(10px);
}

.feature-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.feature-icon.bg-1 { background: rgba(255, 193, 7, 0.3); }
.feature-icon.bg-2 { background: rgba(40, 167, 69, 0.3); }
.feature-icon.bg-3 { background: rgba(220, 53, 69, 0.3); }

.feature-text h5 {
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 0.25rem;
}

.feature-text p {
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
.login-form-section {
    flex: 1;
    padding: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
}

.login-card {
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
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
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
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
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

.alert-box.error {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-box i {
    font-size: 1.1rem;
}

.login-form .form-group {
    margin-bottom: 1.5rem;
}

.login-form label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.login-form label i {
    color: #2563EB;
    font-size: 0.85rem;
}

.login-form input[type="email"],
.login-form input[type="password"] {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #E2E8F0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #F8FAFC;
    color: #1E293B;
}

.login-form input:focus {
    outline: none;
    border-color: #2563EB;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.login-form input.error {
    border-color: #dc2626;
}

.login-form input::placeholder {
    color: #94A3B8;
}

.password-wrapper {
    position: relative;
}

.password-wrapper input {
    padding-right: 3rem;
}

.toggle-password {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94A3B8;
    cursor: pointer;
    padding: 0;
    transition: color 0.3s ease;
}

.toggle-password:hover {
    color: #2563EB;
}

.error-text {
    display: block;
    color: #dc2626;
    font-size: 0.8rem;
    margin-top: 0.5rem;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: #64748B;
    user-select: none;
}

.remember-me input {
    width: 18px;
    height: 18px;
    accent-color: #2563EB;
    cursor: pointer;
}

.btn-login {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
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
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
}

.btn-login:active {
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

.register-link {
    text-align: center;
    padding: 1.25rem;
    background: #F8FAFC;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.register-link p {
    margin: 0 0 0.5rem;
    color: #64748B;
    font-size: 0.9rem;
}

.register-link a {
    color: #2563EB;
    text-decoration: none;
    font-weight: 700;
    transition: color 0.3s ease;
}

.register-link a:hover {
    color: #1D4ED8;
}

.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #16A34A;
    font-size: 0.85rem;
}

.security-note i {
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 991px) {
    .login-container {
        max-width: 450px;
    }
    
    .login-form-section {
        padding: 2rem;
    }
}

@media (max-width: 576px) {
    .login-page {
        padding: 0;
        background: #fff;
    }
    
    .login-container {
        border-radius: 0;
        box-shadow: none;
    }
    
    .login-form-section {
        padding: 1.5rem;
    }
    
    .form-header h3 {
        font-size: 1.5rem;
    }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection
