import Link from 'next/link'

export default function ApiDocsPage() {
  return (
    <div className="min-h-screen p-8 max-w-4xl mx-auto font-[family-name:var(--font-geist-sans)]">
      <Link href="/" className="inline-block mb-8 text-blue-500 hover:underline">&larr; Kembali ke Beranda</Link>
      
      <h1 className="text-4xl font-bold mb-8">Dokumentasi API Simulasi</h1>
      
      <div className="space-y-12">

        {/* 1. Create Order */}
        <section className="space-y-4">
          <div className="flex items-center gap-3">
            <span className="bg-green-600 text-white px-3 py-1 rounded font-bold text-sm">POST</span>
            <code className="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">/api/order</code>
          </div>
          <p>Digunakan untuk membuat transaksi baru.</p>
          
          <div className="grid md:grid-cols-2 gap-6">
            <div>
              <h3 className="font-bold mb-2">Request Body (JSON)</h3>
              <pre className="bg-gray-900 text-gray-100 p-4 rounded-lg text-sm overflow-x-auto">
{`{
  "game": "mlbb",
  "userId": "12345",
  "zoneId": "1234",
  "amount": 10000
}`}
              </pre>
            </div>
            <div>
              <h3 className="font-bold mb-2">Response</h3>
              <pre className="bg-gray-900 text-gray-100 p-4 rounded-lg text-sm overflow-x-auto">
{`{
  "success": true,
  "orderId": "ORDER-UUID-123",
  "message": "Order berhasil dibuat"
}`}
              </pre>
            </div>
          </div>
        </section>

        <hr className="border-gray-200 dark:border-gray-800" />

        {/* 2. Webhook */}
        <section className="space-y-4">
          <div className="flex items-center gap-3">
            <span className="bg-green-600 text-white px-3 py-1 rounded font-bold text-sm">POST</span>
            <code className="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">/api/callback/payment</code>
          </div>
          <p>Webhook url yang dipanggil oleh Payment Gateway saat pembayaran sukses.</p>
          
          <div className="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 p-4 rounded-lg">
            <strong>Security Check:</strong> Signature harus valid.
            <br />
            <code>Signature = SHA256(orderId + status + secret)</code>
          </div>

          <div className="grid md:grid-cols-2 gap-6">
            <div>
              <h3 className="font-bold mb-2">Payload dari Payment Gateway</h3>
              <pre className="bg-gray-900 text-gray-100 p-4 rounded-lg text-sm overflow-x-auto">
{`{
  "orderId": "ORDER-UUID-123",
  "status": "SUCCESS",
  "signature": "a1b2c3d4..."
}`}
              </pre>
            </div>
            <div>
              <h3 className="font-bold mb-2">Logic Backend</h3>
              <ul className="list-disc pl-5 space-y-2 text-sm">
                <li>Verifikasi signature.</li>
                <li>Cek apakah order sudah dibayar sebelumnya.</li>
                <li>Update status order jadi <code>PAID</code>.</li>
                <li>Kirim request ke Game Server.</li>
                <li>Update status jadi <code>SUCCESS</code>.</li>
              </ul>
            </div>
          </div>
        </section>

        <hr className="border-gray-200 dark:border-gray-800" />

        {/* 3. Helper Tools */}
        <section className="space-y-4">
          <h2 className="text-2xl font-bold">Helper / Mock Services</h2>
          <p>Endpoint ini hanya simulasi untuk menggantikan pihak ketiga.</p>
          
          <div className="grid gap-4">
            <div className="p-4 border rounded-lg">
              <div className="flex items-center gap-3 mb-2">
                <span className="bg-green-600 text-white px-3 py-1 rounded font-bold text-xs">POST</span>
                <code className="text-sm">/api/mock/payment/process</code>
              </div>
              <p className="text-sm text-gray-600 dark:text-gray-400">Mensimulasikan proses pembayaran dan mentrigger webhook pengiriman.</p>
            </div>

            <div className="p-4 border rounded-lg">
              <div className="flex items-center gap-3 mb-2">
                <span className="bg-green-600 text-white px-3 py-1 rounded font-bold text-xs">POST</span>
                <code className="text-sm">/api/mock/game/topup</code>
              </div>
              <p className="text-sm text-gray-600 dark:text-gray-400">Endpoint "Game Server" pura-pura. Menerima request kirim item dan mencatat log.</p>
            </div>
          </div>
        </section>

      </div>
    </div>
  )
}
