# Simulasi Top Up Game (Web Top Up Simulation)

Project ini adalah **Sistem Simulasi Top Up Game** untuk tujuan pembelajaran. Sistem ini meniru cara kerja website top up sungguhan (seperti Codashop/Unipin) lengkap dengan frontend user, backend API, dan simulasi Payment Gateway serta Game Server.

> **Disclaimer**: Tidak ada uang asli atau koneksi ke game server sungguhan. Semua hanya simulasi logika dalam satu aplikasi.

## 🚀 Teknologi yang Digunakan

- **Framework**: [Next.js 14](https://nextjs.org/) (App Router, Server Components)
- **Language**: TypeScript
- **Database**: SQLite (via [Prisma ORM](https://www.prisma.io/))
- **Styling**: Tailwind CSS
- **Validation**: Zod
- **Encryption**: SHA256 Signature (untuk keamanan Webhook)

## 📂 Fitur Utama

### 1. Frontend User
- **Landing Page**: Galeri game yang tersedia.
- **Top Up Page**: Form input User ID, Zone ID (opsional), dan pilihan nominal.
- **Payment Page**: Halaman pembayaran tiruan dengan status Real-time.
- **Tracking Page**: Halaman untuk melihat status transaksi (Pending/Success/Failed).

### 2. Backend & API
- **Order System**: Membuat Order ID unik.
- **Webhook Handler**: Menerima notifikasi dari Payment Gateway "palsu" dengan validasi Signature keamanan.
- **Mock Services**:
  - `Mock Payment Gateway`: Meniru proses pembayaran dan mengirim callback.
  - `Mock Game Server`: Meniru proses pengiriman diamond/item ke akun user.

### 3. Edukasi
- **Dokumentasi API**: Tersedia di `/api-docs` untuk mempelajari struktur JSON request/response.
- **Komentar Kode**: Banyak komentar `//` penjelas di dalam kode program untuk membantu memahami alur.

---

## 🛠️ Cara Menjalankan Project

### 1. Install Dependencies
Pastikan Node.js sudah terinstall.
```bash
npm install
```

### 2. Setup Database
Inisialisasi database SQLite:
```bash
npx prisma generate
npx prisma migrate dev --name init
```

### 3. Jalankan Server Development
```bash
npm run dev
```
Buka browser dan akses [http://localhost:3000](http://localhost:3000).

---

## 📚 Alur Simulasi (How it Works)

1.  **User** memilih Game dan Nominal di web.
2.  **Backend** membuat order dengan status `PENDING`.
3.  **User** diarahkan ke halaman pembayaran simulasi.
4.  User klik **"Bayar Sukses"**.
5.  **Mock Payment Gateway** mengirim **Webhook** ke Backend kita.
6.  **Backend** memverifikasi tanda tangan digital (Signature) webhook tersebut.
7.  Jika valid, Backend mengubah status order jadi `PAID`.
8.  **Backend** memanggil **Mock Game Server** untuk mengirim item.
9.  Jika sukses, status order menjadi `SUCCESS`.

## 🧪 Dokumentasi Alur API

Lihat dokumentasi lengkap endpoint di menu **[Dokumentasi API](http://localhost:3000/api-docs)** setelah server berjalan.

---

## 📝 Catatan Penting
- File konfigurasi ada di `.env`.
- Jangan lupa cek file `prisma/schema.prisma` untuk melihat struktur database.
- Logika utama ada di folder `app/api/`.

Happy Coding! 🚀
