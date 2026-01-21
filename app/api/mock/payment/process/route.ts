import { NextResponse } from 'next/server'
import crypto from 'crypto'

// MOCK PAYMENT PROCESSOR
// Ini simulasi server Payment Gateway (seperti Midtrans/Xendit)
// Saat user klik "Bayar", endpoint ini dipanggil.
export async function POST(request: Request) {
  const body = await request.json()
  const { orderId, status } = body

  // 1. Simulasi Proses (Delay ceritanya)
  await new Promise(resolve => setTimeout(resolve, 1000))

  // 2. Buat Signature untuk Webhook
  const secret = process.env.PAYMENT_SECRET || 'super-rahasia-123'
  const payloadStr = `${orderId}${status}${secret}`
  const signature = crypto
    .createHash('sha256')
    .update(payloadStr)
    .digest('hex')

  // 3. Kirim Webhook ke Backend Utama (Self-call)
  // Di dunia nyata, ini request dari server payment gateway ke server kita.
  try {
    const webhookUrl = `${process.env.NEXT_PUBLIC_BASE_URL || 'http://localhost:3000'}/api/callback/payment`
    
    // Kita panggil webhook secara asynchronous (jangan await response penuh di real case, tapi disini kita await biar debug gampang)
    await fetch(webhookUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        orderId,
        status,
        signature
      })
    })

    return NextResponse.json({ success: true })
  } catch (error) {
    console.error('Failed to send webhook:', error)
    return NextResponse.json({ success: false, message: 'Webhook failed' })
  }
}
