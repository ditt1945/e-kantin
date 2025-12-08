@extends('layouts.app')

@section('content')
<div class="register-page" data-bs-theme="light">
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
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.register-container {
    display: flex;
    max-width: 1000px;
    width: 100%;
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
    font-size: 1.5rem;
    color: white;
}

.mobile-logo h2 {
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
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
    color: #1a1a2e;
    margin: 0 0 0.3rem;
}

.form-header p {
    color: #6b7280;
    margin: 0;
    font-size: 0.9rem;
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
    background: #f9fafb;
    color: #1a1a2e;
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
    color: #9ca3af;
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
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    color: white;
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
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
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
    background: #f9fafb;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.login-link p {
    margin: 0 0 0.3rem;
    color: #6b7280;
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
}
</style>
@endsection


