# Dokumentasi API - Simulasi Top Up Game

Dokumen ini menjelaskan spesifikasi API yang tersedia dalam project Simulasi Top Up Game.

Base URL: `http://localhost:3000`

---

## 1. Create Order (Membuat Transaksi)
Digunakan oleh Frontend untuk membuat order baru ketika user klik "Top Up".

- **Endpoint**: `/api/order`
- **Method**: `POST`
- **Content-Type**: `application/json`

### Request Body
```json
{
  "game": "mlbb",      // ID Game (mlbb, ff, genshin, valo)
  "userId": "12345",   // ID Player
  "zoneId": "1234",    // Zone ID (Opsional, tergantung game)
  "amount": 10000      // Nominal top up (dalam Rupiah)
}
```

### Response (Success - 200 OK)
```json
{
  "success": true,
  "orderId": "fc2875de-4706-4f78-b2fc-0429433bcac9",
  "message": "Order berhasil dibuat"
}
```

### Response (Error - 400 Bad Request)
```json
{
  "error": "Validasi gagal: User ID minimal 3 karakter"
}
```

---

## 2. Webhook Payment (Callback)
Endpoint ini dipanggil oleh **Payment Gateway** (dalam simulasi ini oleh Mock Server) untuk memberitahu bahwa pembayaran telah berhasil atau gagal.

- **Endpoint**: `/api/callback/payment`
- **Method**: `POST`
- **Content-Type**: `application/json`

### Security: Signature Header
Untuk keamanan, setiap request harus memiliki signature valid.
Formula: `SHA256(orderId + status + secret)`
*Secret default di .env adalah "super-rahasia-123"*

### Request Body
```json
{
  "orderId": "fc2875de-4706-4f78-b2fc-0429433bcac9",
  "status": "SUCCESS", // atau "FAILED"
  "signature": "dea69ca73d85e3fb8857665b8d5d7aaa00b48985f7a96765041349ce799ecf11"
}
```

### Response
```json
{
  "success": true
}
```

---

## 3. Mock Payment Process (Simulasi)
Endpoint helper untuk mensimulasikan proses user membayar di halaman payment gateway.

- **Endpoint**: `/api/mock/payment/process`
- **Method**: `POST`

### Request Body
```json
{
  "orderId": "fc2875de-4706-4f78-b2fc-0429433bcac9",
  "status": "SUCCESS",
  "amount": 10000
}
```
*Note: Endpoint ini akan otomatis mengirim request ke Webhook setelah jeda 1 detik.*

---

## 4. Mock Game Server Topup (Simulasi)
Endpoint helper yang berpura-pura menjadi server game (misal server Mobile Legends) untuk menerima request pengiriman item.

- **Endpoint**: `/api/mock/game/topup`
- **Method**: `POST`

### Request Body
```json
{
  "game": "mlbb",
  "userId": "12345",
  "amount": 10000
}
```

### Response
```json
{
  "success": true,
  "message": "Item added successfully"
}
```
