import { NextResponse } from 'next/server'
import { prisma } from '@/lib/prisma'
import { createOrderSchema } from '@/lib/validators'

// Endpoint untuk MEMBUAT ORDER
// Method: POST /api/order
export async function POST(request: Request) {
  try {
    // 1. Ambil data JSON dari body request
    const body = await request.json()

    // 2. Validasi data menggunakan Zod
    // Jika data tidak sesuai, akan throw error
    const validation = createOrderSchema.safeParse(body)
    
    if (!validation.success) {
      return NextResponse.json(
        { error: validation.error.format() },
        { status: 400 } // Bad Request
      )
    }

    const { game, userId, zoneId, amount } = validation.data

    // 3. Simpan Order ke Database dengan status PENDING
    // Kita biarkan ID digenerate otomatis oleh UUID di schema
    const order = await prisma.order.create({
      data: {
        game,
        userId,
        zoneId,
        amount,
        status: 'PENDING', // Default status
      },
    })

    // 4. Return Order ID ke Frontend
    // Order ID ini nanti dipakai untuk redirect ke halaman pembayaran
    return NextResponse.json({
      success: true,
      orderId: order.id,
      message: 'Order berhasil dibuat',
    })

  } catch (error) {
    console.error('Create Order Error:', error)
    return NextResponse.json(
      { error: 'Terjadi kesalahan sistem' },
      { status: 500 } // Internal Server Error
    )
  }
}
