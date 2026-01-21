import { NextResponse } from 'next/server'
import { prisma } from '@/lib/prisma'

// MOCK GAME SERVER - TOP UP
// Ini simulasi API milik developer Game (misal Moonton/Garena)
// Backend kita memanggil ini untuk mengirim item ke player.
export async function POST(request: Request) {
  const body = await request.json()
  const { userId, game, amount } = body

  // 1. Catat Log ke Database (Audit Trail)
  await prisma.log.create({
    data: {
      level: 'INFO',
      message: `Sending ${amount} diamonds to ${userId} (${game})`,
      metadata: JSON.stringify(body)
    }
  })

  // 2. Simulasi logic kirim item
  // Di dunia nyata, ini akan ubah data di database game.
  console.log(`[GAME SERVER] Adding ${amount} currency to User ${userId}`)

  // 3. Return Success
  return NextResponse.json({ 
    success: true,
    message: 'Item added successfully'
  })
}
