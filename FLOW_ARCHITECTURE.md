# Arsitektur & Alur Web Top Up Game (Laravel)

Dokumen ini menjelaskan alur sistem dari awal user memilih game hingga proses top-up berhasil, arsitektur database, rancangan fitur, dan struktur menu web.

---

## 1. Struktur Menu Utama (Navigasi)

Menu ini biasanya ditampilkan di header atau sidebar website:

- **Beranda / Home**: Halaman awal dengan banner promo & pilihan game populer.
- **Top-Up Game**: Daftar game yang bisa diisi ulang (MLBB, FF, PUBG, Genshin, dll).
- **Voucher / Pulsa Game**: Voucher Digital (Steam Wallet, Google Play, PSN, Xbox).
- **Riwayat Transaksi**: Cek histori dan status pembelian (Cek Pesanan).
- **Promo / Diskon**: Halaman penawaran khusus atau daftar harga termurah.
- **Metode Pembayaran**: Informasi panduan cara bayar.
- **Pusat Bantuan / FAQ**: Jawaban pertanyaan umum & panduan penggunaan.
- **Login / Daftar Akun**: Untuk membuat akun atau masuk (member system).
- **Kontak / Support**: Customer service live chat atau WhatsApp.

---

## 2. Fitur-Fitur Sistem

### Fitur Utama Top-Up

- **Top-Up Instan**: Isi ulang otomatis untuk diamond, coin, UC, BP, dll langsung masuk ke akun game.
- **Pilih Game & Paket**: Menampilkan list game populer dan paket/kategori isi ulang (Misal: MLBB 12 Diamond, 50 Diamond, dst; PUBG Mobile UC dalam berbagai jumlah).
- **Input ID Game Validasi**: Meminta input spesifik tiap game:
    - User ID
    - Server ID (tergantung game seperti MLBB)
- **Metode Pembayaran Lengkap**: Mendukung E-wallet (GoPay, DANA, OVO, ShopeePay), Transfer Bank, Kartu kredit/debit, Pulsa, dan QRIS.
- **Konfirmasi & Resi Pembayaran**: Cetak dan download bukti transaksi (Invoice tagihan).

### Fitur Keamanan & Loyalti

- **Keamanan & Anti Penipuan**: Verifikasi OTP, koneksi aman ber-SSL, dan proteksi akun member.
- **Promo, Cashback, Voucher**: Sistem diskon menggunakan Kode Promo, mekanisme Cashback, dan Bonus Isi Ulang.
- **Loyalty & Poin**: Sistem poin untuk member setiap transaksi yang bisa dikumpulkan dan ditukar dengan diskon atau saldo top-up.
- **Live Chat / Support**: Dukungan real-time via chat widget (atau link WhatsApp).

### Fitur Tambahan (Marketplace) _Opsional / Masa Depan_

- **Layanan Tambahan PPOB**: Pembelian pulsa, token listrik, & tagihan lain.
- Jual / Beli item & akun game.
- Marketplace voucher game.

---

## 3. Alur Pengguna (User Flow) Transaksi

1. **Eksplorasi Game**
    - User membuka Beranda atau halaman Top-Up Game.
    - User memilih salah satu game.
2. **Form Top Up**
    - User memasukkan Data Player (User ID / Server ID / Riot ID).
    - User memilih Nominal / Paket Top Up.
    - User memilih Metode Pembayaran.
    - User memasukkan Nomor WhatsApp / Email (untuk Guest, opsional bagi Member).
    - Klik tombol **Beli Sekarang / Checkout**.
3. **Checkout & Pembayaran**
    - Sistem men-generate Invoice / Order ID.
    - User melihat detail pesanan dan instruksi pembayaran/QR Code di halaman Invoice.
    - User melakukan pembayaran.
4. **Penyelesaian Order**
    - Halaman Invoice mengecek status secara berkala.
    - Pembayaran berhasil otomatis trigger sistem memproses top-up ke Provider.
    - Status berubah menjadi PROSES, lalu SUKSES.

---

## 4. Rencana Struktur Database (Migration)

**Tabel `users` (Member)**

- id, name, email, password, phone, role (admin/member), points

**Tabel `games` (Layanan)**

- id, name, slug, image_url, description
- category (Game, Voucher, PPOB)
- has_server_id (boolean)
- is_active

**Tabel `products` (Item/Denom)**

- id, game_id, name (ex: 86 Diamonds), provider_code (SKU Provider), price, discount_price, is_active

**Tabel `payment_methods`**

- id, name, code (ex: QRIS, BCAVA), fee_flat, fee_percent, image_url, instructions, is_active

**Tabel `promos` (Diskon/Voucher)**

- id, code, discount_amount, discount_percent, max_discount, min_transaction, valid_until

**Tabel `orders` (Transaksi)**

- id, user_id (nullable, jika guest), invoice_number
- game_id, product_id, payment_method_id, promo_id (nullable)
- customer_name, customer_phone
- game_user_id, game_server_id
- original_amount, discount_amount, fee, total_amount
- status (`UNPAID`, `PAID`, `PROCESSING`, `SUCCESS`, `FAILED`)
- provider_order_id
- timestamps

---

## 5. Rencana Teknologi (Tech Stack & Tooling)

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Database**: MySQL / PostgreSQL
- **Frontend/Tampilan**: Blade + Tailwind CSS + Alpine.js (TALL Stack) atau Inertia + React/Vue (menyesuaikan selera)
- **Queue/Background Job**: Redis / Database Queue (handling webhook Payment & Provider)
- **Integrasi Pihak ke-3**: API Payment Gateway (Midtrans/Tripay), API Provider Layanan (Digiflazz/Smile.One)
