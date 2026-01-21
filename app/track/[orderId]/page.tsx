import { prisma } from '@/lib/prisma'
import { notFound } from 'next/navigation'
import Link from 'next/link'

interface Props {
  params: Promise<{
    orderId: string
  }>
}

export default async function TrackOrderPage({ params }: Props) {
  const { orderId } = await params

  // Ambil data terbaru dari database (Server Component selalu ambil data fresh saat refresh)
  const order = await prisma.order.findUnique({
    where: { id: orderId }
  })

  if (!order) return notFound()

  // Helper untuk warna status
  const getStatusColor = (status: string) => {
    switch (status) {
      case 'SUCCESS': return 'text-green-600 bg-green-100 border-green-200'
      case 'PENDING': return 'text-yellow-600 bg-yellow-100 border-yellow-200'
      case 'FAILED': return 'text-red-600 bg-red-100 border-red-200'
      case 'PAID': return 'text-blue-600 bg-blue-100 border-blue-200'
      default: return 'text-gray-600 bg-gray-100'
    }
  }

  return (
    <div className="min-h-screen flex flex-col items-center justify-center p-8 font-[family-name:var(--font-geist-sans)]">
      <div className="max-w-md w-full bg-white dark:bg-gray-900 border rounded-xl p-8 shadow-lg">
        <h1 className="text-2xl font-bold mb-6 text-center">Status Transaksi</h1>

        <div className={`p-4 rounded-lg border text-center font-bold text-xl mb-8 ${getStatusColor(order.status)}`}>
          {order.status}
        </div>

        <div className="space-y-4 text-sm">
          <div className="flex justify-between">
            <span className="text-gray-500">Order ID</span>
            <span className="font-mono">{order.id.slice(0, 8)}...</span>
          </div>
          <div className="flex justify-between">
            <span className="text-gray-500">Game</span>
            <span className="font-medium">{order.game}</span>
          </div>
          <div className="flex justify-between">
            <span className="text-gray-500">User ID</span>
            <span className="font-medium">{order.userId}</span>
          </div>
          <div className="flex justify-between">
            <span className="text-gray-500">Amount</span>
            <span className="font-medium">Rp {order.amount.toLocaleString('id-ID')}</span>
          </div>
          <div className="flex justify-between">
            <span className="text-gray-500">Terakhir Update</span>
            <span className="font-medium">{order.updatedAt.toLocaleString('id-ID')}</span>
          </div>
        </div>

        <div className="mt-8 flex justify-center">
          <Link 
            href="/"
            className="text-blue-600 hover:text-blue-800 font-medium hover:underline"
          >
            &larr; Buat Transaksi Baru
          </Link>
        </div>
      </div>
    </div>
  )
}
