# Marketonik - E-Commerce Platform

Marketonik adalah aplikasi e-commerce elektronik berbasis Laravel yang dirancang untuk mengelola penjualan produk elektronik dengan fitur manajemen inventory, order, dan sistem pembayaran. Aplikasi ini dibuat untuk asesmen Pemrograman Web dan Basis Data.

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Tech Stack](#tech-stack)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Akun Demo](#akun-demo)
- [Struktur Project](#struktur-project)
- [Struktur Database](#rancangan-database)
- [API Routes](#struktur-halaman)
- [Troubleshooting](#troubleshooting)

## ✨ Fitur Utama

### User & Authentication
- Login dan registrasi pembeli menggunakan session Laravel
- Login admin dengan middleware role-based access control
- Password hashing dan security

### Dashboard & Admin Panel
- Dashboard pembeli dengan order overview
- Dashboard admin dengan analytics penjualan
- Halaman error custom untuk 403, 404, dan 500

### E-Commerce Features
- Katalog produk elektronik dengan kategori, foto, harga, diskon, stok, dan spesifikasi
- Sistem keranjang belanja (cart) dengan real-time update
- Checkout dengan validasi inventory
- Riwayat pesanan dan detail pesanan

### Order & Payment Management
- Multiple order status tracking (pending, confirmed, shipped, delivered)
- Pembayaran online simulasi dan pembayaran offline
- Instruksi transfer bank dan upload bukti pembayaran
- Nomor resi pengiriman

### Admin Management
- Manajemen produk (CRUD operations)
- Manajemen kategori produk
- Manajemen pembeli/users
- Manajemen pesanan dan status pembayaran
- Laporan penjualan terperinci

### Frontend & UI
- Tampilan responsive menggunakan Blade templating
- Styling dengan Tailwind CSS
- Frontend bundling dengan Vite
- Mobile-friendly design

## 🛠️ Tech Stack

- **Backend:** Laravel 11+
- **Database:** SQLite (development), MySQL compatible
- **Frontend:** Blade Templates, Tailwind CSS
- **Build Tool:** Vite
- **Package Manager:** Composer, NPM
- **PHP:** 8.3+
- **Testing:** PHPUnit

## ⚙️ Persyaratan Sistem

- PHP 8.3 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite atau MySQL (untuk production)
- Laragon atau XAMPP (optional, untuk local development)

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Devr1us/marketonik2.git
cd marketonik2
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
php artisan storage:link
```

### 5. Jalankan Development Server
```bash
# Terminal 1: Run Vite dev server
npm run dev

# Terminal 2: Run Laravel development server
php artisan serve
```

Aplikasi akan tersedia di `http://localhost:8000`

## 🔐 Konfigurasi Environment

Edit file `.env`:

```env
APP_NAME=Marketonik
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite (default)

# Untuk production dengan MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=marketonik
# DB_USERNAME=root
# DB_PASSWORD=
```

## 👤 Akun Demo

Admin dibuat melalui seeder `AdminSeeder` saat menjalankan `php artisan db:seed`.

**Akun Test:**
- Username: Lihat di `database/seeders/AdminSeeder.php`
- Password: Sesuai di seeder atau gunakan akun yang dibuat

Pembeli dapat membuat akun sendiri melalui halaman registrasi.

## 📁 Struktur Project

```
marketonik2/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Middleware/          # Custom middleware
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── database.sqlite      # SQLite database file
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheet
│   └── js/                  # JavaScript files
├── routes/
│   ├── web.php              # Web routes
│   └── console.php          # Artisan commands
├── tests/                   # Unit & feature tests
├── public/                  # Public assets
├── config/                  # Configuration files
├── storage/                 # File storage
├── .env                     # Environment variables
├── composer.json            # PHP dependencies
└── package.json             # NPM dependencies
```

## Cara Menjalankan

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run dev
php artisan serve
```

## Struktur Halaman

- `/` halaman gerbang login/daftar.
- `/beranda` halaman beranda pembeli.
- `/dashboard` dashboard pembeli.
- `/toko` katalog produk.
- `/keranjang` keranjang belanja.
- `/checkout` checkout dan pembayaran.
- `/pesanan` riwayat pesanan.
- `/admin/dashboard` dashboard admin.
- `/admin/laporan` laporan penjualan.
- `/admin/produk` manajemen produk.
- `/admin/kategori` manajemen kategori.
- `/admin/pengguna` manajemen pembeli.
- `/admin/pesanan` manajemen pesanan.

## Rancangan Database

### users

| Field | Keterangan |
| --- | --- |
| id | Primary key |
| name | Nama pengguna |
| username | Username unik |
| email | Email pengguna |
| password | Password terenkripsi |
| role | `admin` atau `pembeli` |
| timestamps | Waktu dibuat dan diperbarui |

### categories

| Field | Keterangan |
| --- | --- |
| id | Primary key |
| name | Nama kategori |
| slug | Slug unik kategori |
| description | Deskripsi kategori |
| is_active | Status kategori |
| timestamps | Waktu dibuat dan diperbarui |

### products

| Field | Keterangan |
| --- | --- |
| id | Primary key |
| user_id | Penjual atau admin pembuat produk |
| title | Nama produk |
| category | Kategori produk |
| slug | Slug produk |
| description | Deskripsi produk |
| seller_location | Lokasi penjual |
| specifications | Spesifikasi dalam format JSON |
| price | Harga produk |
| discount_percent | Persentase diskon |
| stock | Stok produk |
| image_url | Foto produk |
| is_active | Status tampil produk |
| timestamps | Waktu dibuat dan diperbarui |

### cart_items

| Field | Keterangan |
| --- | --- |
| id | Primary key |
| user_id | Pemilik keranjang |
| product_id | Produk dalam keranjang |
| quantity | Jumlah barang |
| timestamps | Waktu dibuat dan diperbarui |

### orders

| Field | Keterangan |
| --- | --- |
| id | Primary key |
| user_id | Pembeli |
| order_code | Kode pesanan unik |
| subtotal | Total harga katalog |
| discount_amount | Total diskon |
| total | Total bayar |
| payment_method | `online` atau `offline` |
| payment_status | `pending`, `menunggu`, `lunas`, atau `cancelled` |
| payment_note | Instruksi atau catatan pembayaran |
| payment_proof_path | File bukti pembayaran |
| shipping_status | Status pengiriman |
| shipping_address | Alamat pengiriman |
| tracking_number | Nomor resi |
| timestamps | Waktu dibuat dan diperbarui |

### order_items

| Field | Keterangan |
| --- | --- |
| id | Primary key |
| order_id | Pesanan |
| product_id | Produk yang dibeli |
| product_title | Nama produk saat transaksi |
| quantity | Jumlah barang |
| unit_price | Harga satuan |
| discount_percent | Diskon saat transaksi |
| line_total | Total per item |
| timestamps | Waktu dibuat dan diperbarui |

## Checklist Rubrik

- Desain website: halaman toko, dashboard, admin, checkout, dan pesanan sudah dibuat.
- Responsive: layout menggunakan grid dan breakpoint Tailwind.
- Error handling: tersedia halaman 403, 404, dan 500.
- Desain tabel database: tabel utama sudah dirancang melalui migration Laravel.
- Halaman GitHub: README ini sudah berisi deskripsi fitur, rute halaman, cara menjalankan, dan rancangan database.

## Catatan Screenshot

### 📸 Screenshots

#### 🌐 Halaman Website (Pembeli)

![Web 1](screenshoots/web1.png)
![Web 2](screenshoots/web2.png)
![Web 3](screenshoots/web3.png)
![Web 4](screenshoots/web4.png)
![Web 5](screenshoots/web5.png)
![Web 6](screenshoots/web6.png)
![Web 7](screenshoots/web7.png)
![Web 8](screenshoots/web8.png)
![Web 9](screenshoots/web9.png)
![Web 10](screenshoots/web10.png)

#### 🛠️ Halaman Admin

![Admin 1](screenshoots/webadmin1.png)
![Admin 2](screenshoots/webadmin2.png)
![Admin 3](screenshoots/webadmin3.png)
![Admin 4](screenshoots/webadmin4.png)
![Admin 5](screenshoots/webadmin5.png)
![Admin 6](screenshoots/webadmin6.png)
![Admin 7](screenshoots/webadmin7.png)

#### 🗄️ Database (Adminer)

![Database 1](screenshoots/marketonik1.png)
![Database 2](screenshoots/marketonik2.png)
![Database 3](screenshoots/marketonik3.png)
![Database 4](screenshoots/marketonik4.png)
![Database 5](screenshoots/marketonik5.png)
![Database 6](screenshoots/marketonik6.png)
![Database 7](screenshoots/marketonik7.png)
![Database 8](screenshoots/marketonik8.png)
![Database 9](screenshoots/marketonik9.png)
![Database 10](screenshoots/marketonik10.png)
![Database 11](screenshoots/marketonik11.png)
![Database 12](screenshoots/marketonik12.png)
![Database 13](screenshoots/marketonik13.png)
![Database 14](screenshoots/marketonik14.png)
![Database 15](screenshoots/marketonik15.png)
