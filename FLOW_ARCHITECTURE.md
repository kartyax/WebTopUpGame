# 🔄 Arsitektur & Alur Sistem — GameUp

Dokumen ini ngejelasin gimana alur sistem dari user buka web sampai top-up berhasil, plus arsitektur database dan rancangan fiturnya.

---

## 1. Menu & Halaman

### 🏠 Public (Tanpa Login)

| Halaman     | URL                  | Fungsi                                           |
| ----------- | -------------------- | ------------------------------------------------ |
| Homepage    | `/`                  | Daftar game populer, search bar, link ke top-up  |
| Form Top-Up | `/topup/{slug}`      | Isi ID game, pilih produk & pembayaran, checkout |
| Invoice     | `/invoice/{invoice}` | Detail pesanan, instruksi bayar, tombol simulasi |
| Track Order | `/track`             | Cari pesanan pakai nomor invoice                 |
| Login       | `/login`             | Masuk akun (khusus admin)                        |
| Register    | `/register`          | Daftar akun baru                                 |

### 🔒 Admin Dashboard (Login Required, Role = admin)

| Halaman    | URL                      | Fungsi                                      |
| ---------- | ------------------------ | ------------------------------------------- |
| Dashboard  | `/admin`                 | Statistik revenue, orders, pending, katalog |
| Games      | `/admin/games`           | CRUD game (tambah, edit, hapus)             |
| Produk     | `/admin/products`        | CRUD produk per game                        |
| Orders     | `/admin/orders`          | List semua pesanan + detail                 |
| Pembayaran | `/admin/payment-methods` | CRUD metode bayar                           |

---

## 2. Alur User Top-Up (Tanpa Login)

```
┌─────────────┐     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│  Homepage   │ ──▶ │  Form TopUp  │ ──▶ │   Checkout   │ ──▶ │   Invoice    │
│  Pilih Game │     │  Isi ID +    │     │  POST /order │     │  Lihat Detail│
│             │     │  Pilih Produk│     │  Buat Order  │     │  Bayar/Track │
└─────────────┘     └──────────────┘     └──────────────┘     └──────────────┘
     GET /           GET /topup/{slug}      POST /order        GET /invoice/{id}
```

### Detail Step-by-Step:

1. **Buka Homepage** (`/`)
    - Lihat daftar 8 game dengan gambar icon
    - Bisa search game yang diinginkan
    - Klik salah satu game

2. **Form Top-Up** (`/topup/{slug}`)
    - Masukkan **User ID** (wajib)
    - Masukkan **Server ID** (kalau game-nya butuh, kayak ML & Genshin)
    - Pilih **produk/nominal** yang mau dibeli
    - Pilih **metode pembayaran** (QRIS, GoPay, OVO, Dana, VA Bank)
    - Isi **nomor WhatsApp** (buat konfirmasi)
    - Klik **"Beli Sekarang"**

3. **Proses Order** (`POST /order`)
    - Sistem generate invoice number (`INV-YYYYMMDD-XXXXX`)
    - Hitung total = harga produk + fee admin pembayaran
    - Simpan ke database dengan status `UNPAID`
    - Redirect ke halaman invoice

4. **Invoice** (`/invoice/{invoice_number}`)
    - Tampilkan detail pesanan (game, produk, ID, total bayar)
    - Kalau belum bayar: tombol **"Simulasi Bayar"**
    - Kalau sudah bayar: status berubah jadi **"SUCCESS"** ✅

5. **Track Order** (`/track`)
    - User bisa cari pesanannya kapan aja pakai nomor invoice
    - Tanpa login, langsung redirect ke halaman invoice

---

## 3. Alur Admin Dashboard

```
Login ──▶ Dashboard ──▶ Kelola Games / Produk / Orders / Pembayaran
```

- Admin login pakai email `admin@admin.com`
- Middleware `IsAdmin` cek role user = `admin`
- Kalau bukan admin, kena **403 Forbidden**

### Yang bisa admin lakuin:

- **Lihat statistik** — total revenue, jumlah order, pending, sukses
- **CRUD Games** — tambah game baru, edit info, hapus
- **CRUD Produk** — tambah produk/nominal per game, set harga
- **Lihat Orders** — pantau semua pesanan yang masuk, lihat detail
- **CRUD Metode Bayar** — tambah/edit/hapus metode pembayaran + fee

---

## 4. Struktur Database

### `users`

| Kolom    | Tipe    | Keterangan                              |
| -------- | ------- | --------------------------------------- |
| id       | bigint  | Auto increment                          |
| name     | string  | Nama user                               |
| email    | string  | Email (unique)                          |
| password | string  | Hash password                           |
| phone    | string  | Nomor HP (nullable)                     |
| role     | string  | `admin` atau `member` (default: member) |
| points   | integer | Poin loyalty (default: 0)               |

### `games`

| Kolom         | Tipe    | Keterangan                                   |
| ------------- | ------- | -------------------------------------------- |
| id            | bigint  | Auto increment                               |
| name          | string  | Nama game (ex: Mobile Legends)               |
| slug          | string  | URL-friendly (ex: mobile-legends)            |
| category      | string  | Kategori (Mobile Game, PC Game, dll)         |
| image_url     | string  | Path gambar lokal (ex: /images/games/ml.png) |
| description   | text    | Deskripsi singkat                            |
| has_server_id | boolean | Apakah butuh Server/Zone ID                  |
| is_active     | boolean | Aktif / nonaktif                             |

### `products`

| Kolom         | Tipe        | Keterangan                    |
| ------------- | ----------- | ----------------------------- |
| id            | bigint      | Auto increment                |
| game_id       | foreign key | Relasi ke `games`             |
| name          | string      | Nama produk (ex: 86 Diamonds) |
| price         | integer     | Harga dalam Rupiah            |
| provider_code | string      | Kode SKU provider (nullable)  |
| is_active     | boolean     | Aktif / nonaktif              |

### `payment_methods`

| Kolom        | Tipe    | Keterangan                   |
| ------------ | ------- | ---------------------------- |
| id           | bigint  | Auto increment               |
| name         | string  | Nama tampilan (ex: QRIS)     |
| code         | string  | Kode unik (ex: QRIS, BCAVA)  |
| fee_flat     | integer | Fee tetap per transaksi (Rp) |
| fee_percent  | decimal | Fee persen (opsional)        |
| instructions | text    | Panduan bayar                |
| is_active    | boolean | Aktif / nonaktif             |

### `orders`

| Kolom             | Tipe        | Keterangan                   |
| ----------------- | ----------- | ---------------------------- |
| id                | bigint      | Auto increment               |
| user_id           | foreign key | Nullable (guest boleh order) |
| invoice_number    | string      | INV-YYYYMMDD-XXXXX           |
| game_id           | foreign key | Game yang di-topup           |
| product_id        | foreign key | Produk yang dibeli           |
| payment_method_id | foreign key | Metode bayar                 |
| game_user_id      | string      | ID game user                 |
| game_server_id    | string      | Server/Zone ID (nullable)    |
| customer_phone    | string      | Nomor WA customer            |
| original_amount   | integer     | Harga asli produk            |
| fee               | integer     | Biaya admin                  |
| total_amount      | integer     | Total yang harus dibayar     |
| status            | string      | UNPAID / SUCCESS             |

### `promos` (belum diimplementasi)

| Kolom            | Tipe     | Keterangan                |
| ---------------- | -------- | ------------------------- |
| id               | bigint   | Auto increment            |
| code             | string   | Kode promo (ex: DISKON10) |
| discount_amount  | integer  | Potongan tetap (Rp)       |
| discount_percent | integer  | Potongan persen           |
| max_discount     | integer  | Max potongan              |
| min_transaction  | integer  | Min transaksi             |
| valid_until      | datetime | Berlaku sampai            |

---

## 5. Tech Stack

| Komponen   | Teknologi                   |
| ---------- | --------------------------- |
| Backend    | Laravel 11.x (PHP 8.2+)     |
| Frontend   | Blade + Tailwind CSS        |
| Interaktif | Alpine.js                   |
| Database   | SQLite (dev) / MySQL (prod) |
| Build Tool | Vite                        |
| Auth       | Laravel Breeze              |
| Middleware | Custom `IsAdmin`            |

---

## 6. Yang Belum Diimplementasi

- 🔌 Integrasi payment gateway asli (Midtrans/Tripay)
- 🔌 Integrasi provider top-up (Digiflazz/Unipin)
- 🎫 Sistem promo & voucher diskon
- 📊 Halaman riwayat transaksi member
- ⭐ Loyalty points system
- 💬 Live chat / WhatsApp support widget
- 🔔 Notifikasi WhatsApp otomatis setelah bayar
- 📱 Progressive Web App (PWA)
