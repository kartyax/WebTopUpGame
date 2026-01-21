import { prisma } from '@/lib/prisma'
import { notFound } from 'next/navigation'
import PaymentSimulation from './PaymentSimulation'

// Halaman ini adalah SERVER COMPONENT
// Artinya: Kita bisa akses database langsung di sini sebelum halaman dikirim ke user.
interface Props {
  params: Promise<{
    orderId: string
  }>
}

export default async function PaymentPage({ params }: Props) {
  // 1. Ambil Order ID dari URL
  const { orderId } = await params

  // 2. Cari Order di Database
  const order = await prisma.order.findUnique({
    where: { id: orderId }
  })

  // Jika order tidak ketemu, tampilkan halaman 404 (Not Found)
  if (!order) {
    return notFound()
  }

  // 3. Tampilkan Halaman Pembayaran
  // Bagian interaktif (tombol) dipisah ke Client Component "PaymentSimulation"
  return (
    <div className="min-h-screen flex flex-col items-center justify-center p-8 bg-gray-100 dark:bg-black font-[family-name:var(--font-geist-sans)]">
      <div className="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-800">
        
        <h1 className="text-2xl font-bold mb-6 text-center text-blue-600">Simulasi Payment Gateway</h1>
        
        <div className="space-y-4 mb-8">
          <div className="flex justify-between border-b pb-2">
            <span className="text-gray-500">Order ID</span>
            <span className="font-mono font-medium">{order.id.slice(0, 8)}...</span>
          </div>
          <div className="flex justify-between border-b pb-2">
            <span className="text-gray-500">Item</span>
            <span className="font-medium">{order.game} - {order.amount} IDR</span>
          </div>
          <div className="flex justify-between border-b pb-2">
            <span className="text-gray-500">Status Saat Ini</span>
            <span className={`font-bold ${order.status === 'PENDING' ? 'text-yellow-500' : 'text-green-500'}`}>
              {order.status}
            </span>
          </div>
          <div className="flex justify-between text-xl font-bold pt-2">
            <span>Total Bayar</span>
            <span>Rp {order.amount.toLocaleString('id-ID')}</span>
          </div>
        </div>

        {/* Component Client untuk tombol aksi */}
        <PaymentSimulation orderId={order.id} amount={order.amount} />
        
      </div>
    </div>
  )
}
