'use client'

import { useState, use } from 'react'
import { useRouter } from 'next/navigation'
import Link from 'next/link'
import { GAMES, TOPUP_AMOUNTS } from '@/lib/constants'

// Component ini menerima params dari URL secara dinamis (misal: /topup/mlbb)
export default function TopUpPage({ params }: { params: Promise<{ gameId: string }> }) {
  const router = useRouter()
  // React 19+ (Next.js 15+): params adalah Promise, gunakan hook use()
  const { gameId } = use(params)

  const [userId, setUserId] = useState('')
  const [zoneId, setZoneId] = useState('')
  const [selectedAmount, setSelectedAmount] = useState<number | null>(null)
  const [loading, setLoading] = useState(false)

  // Cari game berdasarkan URL
  const gameConfig = GAMES.find(g => g.id === gameId)

  // Jika game ID tidak valid (ngawur)
  if (!gameConfig) {
    return (
      <div className="min-h-screen flex flex-col items-center justify-center p-8">
        <h1 className="text-2xl font-bold mb-4">Game Tidak Ditemukan</h1>
        <Link href="/" className="text-blue-500 hover:underline">Kembali ke Beranda</Link>
      </div>
    )
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)

    const payload = {
      game: gameConfig.id, // Ambil dari URL/Config langsung
      userId,
      zoneId: zoneId || undefined,
      amount: selectedAmount,
    }

    try {
      const res = await fetch('/api/order', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      })

      const data = await res.json()

      if (!res.ok) {
        alert('Gagal: ' + JSON.stringify(data.error))
        setLoading(false)
        return
      }

      router.push(`/pay/${data.orderId}`)

    } catch (err) {
      console.error(err)
      alert('Terjadi kesalahan sistem')
      setLoading(false)
    }
  }

  return (
    <div className="min-h-screen p-8 pb-20 sm:p-20 font-[family-name:var(--font-geist-sans)]">
      <main className="max-w-2xl mx-auto flex flex-col gap-8">
        
        {/* Header: Tombol Back & Judul Game */}
        <div className="flex items-center gap-4">
            <Link href="/" className="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                &larr;
            </Link>
            <h1 className="text-3xl font-bold">Top Up {gameConfig.name}</h1>
        </div>
        
        <form onSubmit={handleSubmit} className="flex flex-col gap-6 border p-6 rounded-xl shadow-lg bg-gray-50 dark:bg-gray-900">
          
          {/* Note: Tidak perlu dropdown pilih game, karena sudah spesifik */}

          {/* 1. Masukkan User ID */}
          <div className="flex flex-col gap-2">
            <label className="font-semibold">1. Masukkan ID Player</label>
            <div className="flex gap-4">
              <input 
                type="text" 
                placeholder="User ID" 
                className="flex-1 p-3 border rounded-md dark:bg-gray-800"
                value={userId}
                onChange={(e) => setUserId(e.target.value)}
                required
              />
              {gameConfig.needZone && (
                <input 
                  type="text" 
                  placeholder="Zone ID" 
                  className="w-1/3 p-3 border rounded-md dark:bg-gray-800"
                  value={zoneId}
                  onChange={(e) => setZoneId(e.target.value)}
                  required 
                />
              )}
            </div>
            <p className="text-xs text-gray-500">Contoh ID: 12345678 (Zone: 1234)</p>
          </div>

          {/* 2. Pilih Nominal */}
          <div className="flex flex-col gap-2">
            <label className="font-semibold">2. Pilih Nominal Top Up</label>
            <div className="grid grid-cols-2 gap-4">
              {TOPUP_AMOUNTS.map(item => (
                <button
                  type="button"
                  key={item.value}
                  onClick={() => setSelectedAmount(item.value)}
                  className={`p-4 border rounded-lg text-left transition-all ${
                    selectedAmount === item.value 
                      ? 'border-blue-500 bg-blue-50 dark:bg-blue-900 ring-2 ring-blue-500' 
                      : 'hover:bg-gray-100 dark:hover:bg-gray-800'
                  }`}
                >
                  {item.label}
                </button>
              ))}
            </div>
          </div>

          {/* Tombol Submit */}
          <button 
            type="submit" 
            disabled={loading || !selectedAmount}
            className="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {loading ? 'Memproses...' : 'Lanjut Pembayaran'}
          </button>

        </form>
      </main>
    </div>
  )
}
