'use client'

import { useState } from 'react'
import { useRouter } from 'next/navigation'

interface Props {
  orderId: string
  amount: number
}

export default function PaymentSimulation({ orderId, amount }: Props) {
  const router = useRouter()
  const [processing, setProcessing] = useState(false)

  const handlePayment = async (status: 'SUCCESS' | 'FAILED') => {
    setProcessing(true)
    try {
      // Panggil API endpoint Mock Payment Process
      const res = await fetch('/api/mock/payment/process', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          orderId,
          amount,
          status, // Kirim status yang dipilih (Simulasi)
        }),
      })

      const data = await res.json()
      
      if (data.success) {
        alert(`Simulasi Pembayaran ${status}!`)
        // Redirect ke halaman tracking/status
        router.push(`/track/${orderId}`)
      } else {
        alert('Gagal memproses pembayaran: ' + data.message)
        setProcessing(false)
      }

    } catch (error) {
      console.error(error)
      alert('Error connecting to payment gateway')
      setProcessing(false)
    }
  }

  return (
    <div className="flex flex-col gap-3">
      <p className="text-sm text-center text-gray-400 mb-2">
        Pilih skenario pembayaran (Simulasi):
      </p>
      
      <button
        onClick={() => handlePayment('SUCCESS')}
        disabled={processing}
        className="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition disabled:opacity-50"
      >
        {processing ? 'Memproses...' : '✅ Bayar Sukses'}
      </button>

      <button
        onClick={() => handlePayment('FAILED')}
        disabled={processing}
        className="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition disabled:opacity-50"
      >
        {processing ? 'Memproses...' : '❌ Bayar Gagal'}
      </button>
    </div>
  )
}
