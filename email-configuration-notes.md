# Konfigurasi Email untuk Fitur Lupa Password

## Konfigurasi Email di .env

Pastikan konfigurasi berikut sudah benar di file `.env`:

```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@kantinku.local"
MAIL_FROM_NAME="${APP_NAME}"
```

## Konfigurasi untuk Development (Mailpit)

Mailpit adalah alat development email yang sangat simpel dan mudah digunakan:

### Instalasi & Setup Mailpit:

**Cara 1: Install via package manager**
```bash
# Windows dengan scoop
scoop install mailpit

# Atau download langsung dari https://github.com/axllent/mailpit/releases
```

**Cara 2: Jalankan dengan Docker**
```bash
docker run -d --name mailpit -p 1025:1025 -p 8025:8025 axllent/mailpit
```

### Menjalankan Mailpit:

**Cara 1: Jalankan Binary Mailpit**
```bash
# Jika sudah diinstall
mailpit
```

**Cara 2: Jalankan dengan Docker**
```bash
docker run -d --name mailpit -p 1025:1025 -p 8025:8025 axllent/mailpit
```

**Cara 3: Download Manual Windows**
1. Download dari https://github.com/axllent/mailpit/releases
2. Extract `mailpit.exe`
3. Jalankan dari terminal: `.\mailpit.exe`

**Web Interface:**
- Akses http://127.0.0.1:8025
- Interface untuk melihat semua email yang dikirim

**Default Ports:**
- SMTP Port: `1025` (untuk aplikasi Laravel)
- Web UI Port: `8025` (untuk melihat email)

### Alternative: Mailhog (Jika Mailpit tidak tersedia)

Jika Mailpit tidak bisa diinstall, bisa gunakan Mailhog:
```bash
# Docker
docker run -p 1025:1025 -p 8025:8025 mailhog/mailhog

# Konfigurasi .env tetap sama
```

## Konfigurasi untuk Production

Gunakan layanan email berikut untuk production:

### Gmail/Google Workspace
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_SCHEME=tls
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
```

### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
```

### Amazon SES
```env
MAIL_MAILER=ses
MAIL_HOST=email-smtp.us-east-1.amazonaws.com
MAIL_PORT=587
MAIL_USERNAME=your_ses_smtp_username
MAIL_PASSWORD=your_ses_smtp_password
```

## Testing Email Configuration

### Quick Test dengan Script
Run test script yang sudah disediakan:
```bash
php test-password-reset.php
```

### Test dengan Tinker
```bash
php artisan tinker
```

Kemudian jalankan:
```php
use App\Models\User;
use Illuminate\Support\Facades\Password;

// Test token generation
$user = User::first();
$token = Password::createToken($user);
echo "Token: " . $token . "\n";
```

### Test Manual di Browser
1. **Start Mailpit:** Buka terminal dan jalankan `mailpit`
2. **Buka Mailpit UI:** http://127.0.0.1:8025
3. **Buka Aplikasi:** http://127.0.0.1:8000/forgot-password
4. **Masukkan Email:** Gunakan email user yang ada (misal: `raditvitsava@gmail.com`)
5. **Submit:** Klik "Kirim Link Reset"
6. **Check Email:** Lihat email masuk di Mailpit UI

## Fitur yang Sudah Diimplementasikan

✅ **Route Password Reset**
- `/forgot-password` - Form lupa password
- `/reset-password/{token}` - Form reset password
- Method POST untuk proses reset

✅ **Controller**
- `ForgotPasswordController` - Handle request lupa password
- `ResetPasswordController` - Handle proses reset password

✅ **View Template**
- `auth/forgot-password.blade.php` - Form lupa password
- `auth/reset-password.blade.php` - Form reset password
- Responsive design dengan dark mode support
- Password strength indicator
- Real-time validation

✅ **Email Notification**
- Custom email template untuk reset password
- Link reset dengan token yang aman
- Auto-expire dalam 60 menit

✅ **Security Features**
- Token-based reset system
- CSRF protection
- Rate limiting
- Password validation
- Secure token storage

## Cara Penggunaan

1. User klik "Lupa Password?" di halaman login
2. Masukkan email yang terdaftar
3. Cek email untuk link reset password
4. Klik link reset dalam email
5. Masukkan password baru yang kuat
6. Password berhasil di-reset

## Troubleshooting

### Email tidak terkirim:
- **Pastikan Mailpit berjalan:** Cek dengan `mailpit --version`
- **Cek port:** Pastikan port 1025 tidak digunakan aplikasi lain
- **Test connection:** Buka http://127.0.0.1:8025 untuk verifikasi Mailpit running
- **Check error logs:** `storage/logs/laravel.log`

### Mailpit tidak berjalan:
- **Install Mailpit:** Download dari https://github.com/axllent/mailpit/releases
- **Cek Windows Defender:** Jangan block mailpit.exe
- **Run as administrator:** Jika ada permission issue

### Token tidak valid:
- Token expired (60 menit)
- Link sudah digunakan
- Email tidak ditemukan di database

### Form tidak berfungsi:
- Check CSRF token
- Verify route definitions: `php artisan route:list --name=password`
- Clear cache: `php artisan cache:clear && php artisan config:clear`

### Debugging Tools:
```bash
# Check configuration
php artisan config:show mail

# Test mail sending
php artisan tinker
use Illuminate\Support\Facades\Mail;
use App\Notifications\ResetPasswordNotification;
$user = App\Models\User::first();
$user->notify(new ResetPasswordNotification('test-token'));
```