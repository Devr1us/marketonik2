# Marketonik

Marketonik adalah aplikasi e-commerce elektronik berbasis Laravel. Aplikasi ini dibuat untuk asesmen Pemrograman Web dan Basis Data dengan fitur login, dashboard, manajemen data, transaksi, dan rancangan database relasional.

## Fitur Utama

- Login dan registrasi pembeli menggunakan session Laravel.
- Login admin dengan middleware role.
- Dashboard pembeli dan dashboard admin.
- Katalog produk elektronik dengan kategori, foto produk, harga, diskon, stok, dan spesifikasi.
- Keranjang belanja, checkout, riwayat pesanan, detail pesanan, dan cetak struk.
- Pembayaran online simulasi dan pembayaran offline dengan instruksi transfer serta upload bukti pembayaran.
- Admin dapat mengelola produk, kategori, pembeli, pesanan, status pembayaran, status pengiriman, nomor resi, dan laporan penjualan.
- Halaman error custom untuk 403, 404, dan 500.
- Tampilan responsive menggunakan Blade, Tailwind CSS, dan Vite.

## Akun Demo

Admin dibuat melalui seeder `AdminSeeder`. Jalankan seeder setelah migrasi, lalu gunakan akun admin yang didefinisikan di file tersebut.

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

Untuk memenuhi ketentuan pengumpulan, tambahkan screenshot halaman web dan screenshot struktur tabel database ke folder dokumentasi, lalu sisipkan di bagian ini sebelum dikirim ke Google Form.
