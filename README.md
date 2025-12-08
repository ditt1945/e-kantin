# Kantin Digital - Kantin SMKN 2 Surabaya

Platform e-commerce kantin terintegrasi untuk SMKN 2 Surabaya dengan fitur order tracking, multiple tenants, dan payment gateway.

## 🚀 Fitur Utama

- **Multi-Tenant Support** - Kelola banyak kantin dalam satu platform
- **Order Management** - Sistem order dengan real-time status tracking
- **Payment Gateway** - Integrasi Midtrans untuk pembayaran online
- **Email Notifications** - Notifikasi otomatis untuk status pesanan
- **Role-Based Access** - Customer, Tenant Owner, dan Admin
- **Stock Management** - Tracking stok menu real-time
- **Invoice Generation** - Automatic invoice generation
- **Analytics** - Dashboard monitoring untuk admin

## 📋 Requirements

- PHP 8.2+
- Laravel 12
- MySQL 8.0+
- Composer
- Node.js (untuk npm packages)

## ⚙️ Instalasi

### 1. Clone Repository
```bash
git clone <repo-url>
cd e-kantin
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build
```

### 6. Start Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## 🔐 Configuration

### Environment Variables (.env)

**Critical Variables untuk Production:**

```env
APP_NAME="KANTIN DIGITAL - Kantin SMKN 2 Surabaya"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_DATABASE=e_kantin_production
DB_USERNAME=root
DB_PASSWORD=your-password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password

MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_ENVIRONMENT=production

ENABLE_EMAIL_VERIFICATION=true
ORDER_CANCELLATION_MINUTES=15
```

---

## 👥 User Roles & Access

### 1. **Customer** (Siswa/Konsumen)
- Melihat menu dari berbagai kantin
- Membuat pesanan
- Melakukan pembayaran
- Tracking status pesanan
- Melihat riwayat pesanan

**Route:** `/customer/*`

### 2. **Tenant Owner** (Pemilik Kantin)
- Manage menu dan stok
- Terima dan proses pesanan
- Update status pesanan
- Lihat laporan penjualan
- Manage kategori menu

**Route:** `/tenant/*`

### 3. **Admin** (Pengelola Website)
- Manage seluruh kantin
- Manage kategori & menu
- Monitor semua pesanan
- Lihat analytics & reports
- User management

**Route:** `/admin/*`

---

## 💳 Payment Integration (Midtrans)

### Setup Midtrans

1. Daftar di [Midtrans.com](https://midtrans.com)
2. Dapatkan Server Key dan Client Key
3. Masukkan ke `.env`:

```env
MIDTRANS_SERVER_KEY=your-key-here
MIDTRANS_CLIENT_KEY=your-key-here
MIDTRANS_ENVIRONMENT=production
```

### Payment Flow

```
Customer → Checkout → Payment Page → Midtrans → Callback → Order Confirmed
```

### Webhook Configuration

Setup webhook di Midtrans Dashboard:
- **URL:** `https://your-domain.com/api/payment/callback`
- **Events:** `payment_success`, `payment_failure`, `payment_pending`

---

## 📧 Email Configuration

### SMTP (Recommended)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@e-kantin.local
```

### Email Types

- **Order Confirmation** - Terkirim saat order dibuat
- **Order Status Update** - Saat status berubah
- **Email Verification** - Saat registrasi

---

## 🗄️ Database Schema

### Key Tables

```
users (customer, tenant_owner, admin)
tenants (kantin/canteen)
menus (dengan stok tracking)
orders (dengan payment relation)
payments (Midtrans tracking)
order_items (line items)
categories (menu categories)
carts (temporary shopping carts)
```

### Relationships

```
User → has many Orders
Order → belongs to User, Tenant
Order → has one Payment
Order → has many OrderItems
Menu → has many OrderItems
```

---

## 🚀 Deployment

### Production Server

1. **SSH ke Server**
```bash
ssh user@server.com
cd /var/www/e-kantin
```

2. **Pull Latest Code**
```bash
git pull origin main
```

3. **Install Dependencies**
```bash
composer install --no-dev
npm ci
```

4. **Run Migrations**
```bash
php artisan migrate --force
```

5. **Build Assets**
```bash
npm run build
```

6. **Clear Caches**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

7. **Set Permissions**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/e-kantin/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.html index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### SSL Certificate (Let's Encrypt)

```bash
sudo certbot certonly --nginx -d your-domain.com
```

---

## 🧪 Testing

### Run Tests

```bash
php artisan test
```

### Feature Tests

```bash
php artisan test --filter=OrderTest
php artisan test --filter=PaymentTest
php artisan test --filter=AuthTest
```

---

## 📊 Admin Dashboard Features

- **KPI Cards:**
  - Total Kantin
  - Total Menu
  - Total Users
  - Total Orders

- **Management Links:**
  - Kantin Management
  - Category Management
  - Menu Management
  - Order Management

- **Recent Orders Table** dengan status badges

---

## 🔒 Security Best Practices

- ✅ CSRF Protection enabled
- ✅ Rate limiting on sensitive endpoints
- ✅ Email verification required
- ✅ Role-based middleware
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection
- ✅ CORS configured
- ✅ Password hashing (bcrypt)

---

## 🐛 Troubleshooting

### "Class PaymentController not found"
```bash
php artisan route:clear
php artisan cache:clear
```

### Migration failed
```bash
php artisan migrate:reset
php artisan migrate
```

### Email not sending
- Check `.env` mail configuration
- Test dengan: `php artisan tinker`
- Verify SMTP credentials

### Payment not working
- Check Midtrans credentials in `.env`
- Verify webhook URL in Midtrans dashboard
- Check logs: `storage/logs/laravel.log`

---

## 📝 Maintenance

### Regular Tasks

- **Backup Database** - Daily
- **Clear Logs** - Weekly
- **Monitor Storage** - Weekly
- **Update Dependencies** - Monthly

### Backup Command

```bash
php artisan backup:run
```

### Monitor Performance

```bash
php artisan optimize
php artisan config:cache
```

---

## 👥 Support & Contact

- **Email:** support@e-kantin.local
- **Admin:** admin@e-kantin.local

---

## 📄 License

E-KANTIN © 2025. All rights reserved.

---

## 🎯 Future Enhancements

- [ ] Mobile app (React Native)
- [ ] Real-time order tracking (WebSocket)
- [ ] QR code payment
- [ ] Customer reviews & ratings
- [ ] Loyalty program
- [ ] Advanced analytics & reporting
- [ ] SMS notifications
- [ ] Dark mode toggle

---

**Last Updated:** November 25, 2025

**Version:** 1.0 Production Ready
