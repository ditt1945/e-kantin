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
<div class="reset-password-page" data-bs-theme="light">
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>
    <div class="reset-password-container">
        {{-- Left Side - Branding --}}
        <div class="reset-password-branding d-none d-lg-flex">
            <div class="branding-content">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h1>Reset Password</h1>
                    <p class="tagline">SMKN 2 Surabaya</p>
                </div>

                <div class="password-requirements">
                    <h4>Password Baru Harus:</h4>
                    <div class="requirement-item">
                        <i class="fas fa-check text-success" id="length-check"></i>
                        <span>Minimal 8 karakter</span>
                    </div>
                    <div class="requirement-item">
                        <i class="fas fa-check text-success" id="match-check"></i>
                        <span>Password konfirmasi cocok</span>
                    </div>
                    <div class="requirement-item">
                        <i class="fas fa-check text-success" id="complexity-check"></i>
                        <span>Mengandung huruf dan angka</span>
                    </div>
                </div>

                <div class="security-tips">
                    <h4><i class="fas fa-shield-alt me-2"></i>Tips Keamanan:</h4>
                    <ul>
                        <li>Gunakan kombinasi huruf besar & kecil</li>
                        <li>Tambahkan angka dan simbol</li>
                        <li>Hindari informasi pribadi</li>
                        <li>Gunakan password unik</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Right Side - Reset Password Form --}}
        <div class="reset-password-form-section">
            <div class="reset-password-card">
                {{-- Mobile Logo --}}
                <div class="mobile-logo d-lg-none">
                    <div class="logo-icon-sm">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h2>e-Kantin</h2>
                </div>

                <div class="form-header">
                    <h3>Buat Password Baru 🔄</h3>
                    <p>Masukkan password baru yang kuat dan aman</p>
                </div>

                @if($errors->has('email') || $errors->has('password'))
                    <div class="alert-box error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first('email') ?? $errors->first('password') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="reset-password-form" id="resetForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input type="email"
                            id="email"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            placeholder="nama@email.com"
                            class="@error('email') error @enderror"
                            required>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password Baru
                        </label>
                        <div class="password-wrapper">
                            <input type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password baru"
                                class="@error('password') error @enderror"
                                required
                                onkeyup="checkPasswordStrength()">
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-toggle-icon"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strength-fill"></div>
                            </div>
                            <span class="strength-text" id="strength-text">Password strength</span>
                        </div>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">
                            <i class="fas fa-lock"></i>
                            Konfirmasi Password
                        </label>
                        <div class="password-wrapper">
                            <input type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Konfirmasi password baru"
                                class="@error('password_confirmation') error @enderror"
                                required
                                onkeyup="checkPasswordMatch()">
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-toggle-icon"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                        <span>Reset Password</span>
                        <i class="fas fa-check"></i>
                    </button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="login-link">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Login
                    </a>
                </div>

                <div class="expiry-note">
                    <i class="fas fa-clock"></i>
                    <span>Link reset akan kadaluarsa dalam 60 menit</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset Password Page Styles */
.reset-password-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    transition: background 0.3s ease;
}

.reset-password-container {
    display: flex;
    max-width: 1200px;
    width: 100%;
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transition: all 0.3s ease;
}

/* Dark mode adjustments */
[data-theme="dark"] .reset-password-page {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
}

[data-theme="dark"] .reset-password-container {
    background: #0f172a;
    border: 1px solid rgba(148, 163, 184, 0.2);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

/* Form Section Dark Mode */
[data-theme="dark"] .reset-password-form-section {
    background: #0f172a;
}

[data-theme="dark"] .form-header h3 {
    color: #f1f5f9;
}

[data-theme="dark"] .form-header p {
    color: #cbd5e1;
}

[data-theme="dark"] .alert-box.error {
    background: rgba(220, 38, 38, 0.1);
    color: #f87171;
    border-color: rgba(248, 113, 113, 0.2);
}

[data-theme="dark"] .reset-password-form label {
    color: #e2e8f0;
}

[data-theme="dark"] .reset-password-form label i {
    color: #34d399;
}

[data-theme="dark"] .reset-password-form input[type="email"],
[data-theme="dark"] .reset-password-form input[type="password"] {
    background: #1e293b;
    border-color: rgba(71, 85, 105, 0.5);
    color: #f1f5f9;
}

[data-theme="dark"] .reset-password-form input:focus {
    background: #334155;
    border-color: #34d399;
    box-shadow: 0 0 0 4px rgba(52, 211, 153, 0.1);
}

[data-theme="dark"] .reset-password-form input::placeholder {
    color: #64748b;
}

[data-theme="dark"] .toggle-password {
    color: #64748b;
}

[data-theme="dark"] .toggle-password:hover {
    color: #34d399;
}

[data-theme="dark"] .strength-bar {
    background: rgba(71, 85, 105, 0.3);
}

[data-theme="dark"] .strength-text {
    color: #94a3b8;
}

[data-theme="dark"] .btn-submit {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

[data-theme="dark"] .btn-submit:hover:not(:disabled) {
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
}

[data-theme="dark"] .btn-submit:disabled {
    background: #374151;
    box-shadow: none;
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
    color: #34d399;
}

[data-theme="dark"] .login-link a:hover {
    color: #10b981;
}

[data-theme="dark"] .expiry-note {
    background: #1e293b;
    border-color: rgba(52, 211, 153, 0.2);
    color: #94a3b8;
}

/* Branding Section Dark Mode */
[data-theme="dark"] .password-requirements h4 {
    color: #e2e8f0;
}

[data-theme="dark"] .requirement-item {
    color: #cbd5e1;
}

[data-theme="dark"] .security-tips h4 {
    color: #e2e8f0;
}

[data-theme="dark"] .security-tips ul {
    color: #94a3b8;
}

/* Mobile dark mode */
@media (max-width: 576px) {
    [data-theme="dark"] .reset-password-page {
        background: #0f172a;
    }
}

/* Branding Section */
.reset-password-branding {
    flex: 1;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.reset-password-branding::before {
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

.password-requirements {
    margin-bottom: 3rem;
}

.password-requirements h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1rem;
    opacity: 0.95;
}

.requirement-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    margin-bottom: 0.75rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.requirement-item.met {
    background: rgba(34, 197, 94, 0.2);
}

.requirement-item i {
    font-size: 1rem;
    width: 20px;
    text-align: center;
}

.requirement-item span {
    font-size: 0.9rem;
    opacity: 0.9;
}

.security-tips h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1rem;
    opacity: 0.95;
}

.security-tips ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.security-tips li {
    padding: 0.5rem 0;
    padding-left: 1.5rem;
    position: relative;
    font-size: 0.85rem;
    opacity: 0.9;
    line-height: 1.4;
}

.security-tips li::before {
    content: '•';
    position: absolute;
    left: 0;
    font-weight: bold;
    opacity: 0.7;
}

/* Form Section */
.reset-password-form-section {
    flex: 1;
    padding: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
}

.reset-password-card {
    width: 100%;
    max-width: 420px;
}

.mobile-logo {
    text-align: center;
    margin-bottom: 2rem;
}

.logo-icon-sm {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
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
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
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

.reset-password-form .form-group {
    margin-bottom: 1.5rem;
}

.reset-password-form label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.reset-password-form label i {
    color: #10B981;
    font-size: 0.85rem;
}

.reset-password-form input[type="email"],
.reset-password-form input[type="password"] {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #E2E8F0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #F8FAFC;
    color: #1E293B;
}

.reset-password-form input:focus {
    outline: none;
    border-color: #10B981;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

.reset-password-form input.error {
    border-color: #dc2626;
}

.reset-password-form input::placeholder {
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
    color: #10B981;
}

.password-strength {
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.strength-bar {
    flex: 1;
    height: 4px;
    background: #E2E8F0;
    border-radius: 2px;
    overflow: hidden;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-fill.weak {
    width: 25%;
    background: #dc2626;
}

.strength-fill.fair {
    width: 50%;
    background: #f59e0b;
}

.strength-fill.good {
    width: 75%;
    background: #3b82f6;
}

.strength-fill.strong {
    width: 100%;
    background: #10b981;
}

.strength-text {
    font-size: 0.75rem;
    color: #64748B;
    font-weight: 500;
    min-width: 100px;
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
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
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
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.btn-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
}

.btn-submit:disabled {
    background: #94A3B8;
    cursor: not-allowed;
    box-shadow: none;
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
    color: #10B981;
    text-decoration: none;
    font-weight: 700;
    transition: color 0.3s ease;
}

.login-link a:hover {
    color: #059669;
}

.expiry-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    font-size: 0.8rem;
    color: #16a34a;
}

.expiry-note i {
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 991px) {
    .reset-password-container {
        max-width: 450px;
    }

    .reset-password-form-section {
        padding: 2rem;
    }
}

@media (max-width: 576px) {
    .reset-password-page {
        padding: 0;
        background: #fff;
    }

    .reset-password-container {
        border-radius: 0;
        box-shadow: none;
    }

    .reset-password-form-section {
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
    const resetPasswordPage = document.querySelector('.reset-password-page');
    const themeIcon = document.getElementById('themeIcon');

    if (savedTheme === 'dark') {
        resetPasswordPage.setAttribute('data-theme', 'dark');
        resetPasswordPage.setAttribute('data-bs-theme', 'dark');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
    }
}

function toggleTheme() {
    const resetPasswordPage = document.querySelector('.reset-password-page');
    const themeIcon = document.getElementById('themeIcon');
    const currentTheme = resetPasswordPage.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    resetPasswordPage.setAttribute('data-theme', newTheme);
    resetPasswordPage.setAttribute('data-bs-theme', newTheme);

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

// Password Toggle
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(fieldId + '-toggle-icon');

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

// Password Strength Checker
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    const lengthCheck = document.getElementById('length-check');
    const complexityCheck = document.getElementById('complexity-check');

    let strength = 0;
    let hasNumber = /\d/.test(password);
    let hasLetter = /[a-zA-Z]/.test(password);
    let hasUpper = /[A-Z]/.test(password);
    let hasLower = /[a-z]/.test(password);
    let hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    // Check length
    if (password.length >= 8) {
        strength++;
        lengthCheck.classList.add('text-success');
        lengthCheck.classList.remove('text-muted');
    } else {
        lengthCheck.classList.remove('text-success');
        lengthCheck.classList.add('text-muted');
    }

    // Check complexity
    if (hasLetter && hasNumber && (hasUpper || hasLower || hasSpecial)) {
        strength++;
        complexityCheck.classList.add('text-success');
        complexityCheck.classList.remove('text-muted');
    } else {
        complexityCheck.classList.remove('text-success');
        complexityCheck.classList.add('text-muted');
    }

    // Update strength bar
    if (password.length === 0) {
        strengthFill.className = 'strength-fill';
        strengthText.textContent = 'Password strength';
        strengthText.style.color = '#64748B';
    } else if (strength === 1) {
        strengthFill.className = 'strength-fill weak';
        strengthText.textContent = 'Weak';
        strengthText.style.color = '#dc2626';
    } else if (strength === 2) {
        strengthFill.className = 'strength-fill strong';
        strengthText.textContent = 'Strong';
        strengthText.style.color = '#10b981';
    }

    checkPasswordMatch();
}

// Password Match Checker
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const matchCheck = document.getElementById('match-check');
    const submitBtn = document.getElementById('submitBtn');

    if (confirmPassword.length > 0 && password === confirmPassword) {
        matchCheck.classList.add('text-success');
        matchCheck.classList.remove('text-muted');
        if (password.length >= 8) {
            submitBtn.disabled = false;
        }
    } else {
        matchCheck.classList.remove('text-success');
        matchCheck.classList.add('text-muted');
        submitBtn.disabled = true;
    }
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    initTheme();

    // Listen for theme changes from other components
    window.addEventListener('themeChanged', function(e) {
        const resetPasswordPage = document.querySelector('.reset-password-page');
        const themeIcon = document.getElementById('themeIcon');

        resetPasswordPage.setAttribute('data-theme', e.detail.theme);
        resetPasswordPage.setAttribute('data-bs-theme', e.detail.theme);

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