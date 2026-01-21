import { NextResponse } from 'next/server'
import { prisma } from '@/lib/prisma'
import crypto from 'crypto'

// WEBHOOK HANDLER
// Endpoint ini menerima notifikasi dari Payment Gateway (Simulasi)
// Method: POST /api/callback/payment
export async function POST(request: Request) {
  try {
    const body = await request.json()
    const { orderId, status, signature } = body

    console.log('Webhook Received:', body)

    // 1. Verifikasi Signature (KEAMANAN)
    // Pastikan request ini benar-benar dari Payment Gateway, bukan hacker.
    // Cara kerja: Hash(orderId + status + secret) harus sama dengan signature yang dikirim.
    
    const secret = process.env.PAYMENT_SECRET || 'super-rahasia-123'
    const payloadStr = `${orderId}${status}${secret}`
    const expectedSignature = crypto
      .createHash('sha256')
      .update(payloadStr)
      .digest('hex')

    if (signature !== expectedSignature) {
      console.error('Invalid Signature')
      return NextResponse.json({ message: 'Invalid Signature' }, { status: 400 })
    }

    // 2. Cek Order di Database
    const order = await prisma.order.findUnique({
      where: { id: orderId }
    })

    if (!order) {
      return NextResponse.json({ message: 'Order not found' }, { status: 404 })
    }

    // Jika status order sudah selesai, ignore (idempotency)
    if (order.status === 'SUCCESS' || order.status === 'FAILED') {
      return NextResponse.json({ message: 'Order already processed' })
    }

    // 3. Update Status Order berdasarkan notifikasi
    if (status === 'SUCCESS') {
      // Jika pembayaran sukses, update jadi PAID
      // Lalu kirim item ke game (Simulasi)
      
      await prisma.order.update({
        where: { id: orderId },
        data: { status: 'PAID' }
      })

      // Panggil Fake Game Server untuk kirim Diamond
      const gameRes = await fetch(`${process.env.NEXT_PUBLIC_BASE_URL || 'http://localhost:3000'}/api/mock/game/topup`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          userId: order.userId,
          game: order.game,
          amount: order.amount
        })
      })

      if (gameRes.ok) {
        // Jika top up sukses
        await prisma.order.update({
          where: { id: orderId },
          data: { status: 'SUCCESS' }
        })
        console.log('Top Up Success')
      } else {
        // Jika gagal kirim item (misal game server down), set manual check atau retry
        // Disini kita set PROCESS atau FAILED
        console.error('Game Server connection failed')
      }

    } else {
      // Pembayaran Gagal
      await prisma.order.update({
        where: { id: orderId },
        data: { status: 'FAILED' }
      })
    }

    return NextResponse.json({ success: true })

  } catch (error) {
    console.error('Webhook Error:', error)
    return NextResponse.json({ message: 'Internal Error' }, { status: 500 })
  }
}
