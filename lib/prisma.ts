import { PrismaClient } from '@prisma/client'

// PrismaClient adalah library utama untuk berinteraksi dengan database.
// Kita menggunakan pattern "singleton" agar koneksi database tidak duplikat saat hot-reload di Next.js development.

const globalForPrisma = global as unknown as { prisma: PrismaClient }

export const prisma = globalForPrisma.prisma || new PrismaClient()

if (process.env.NODE_ENV !== 'production') globalForPrisma.prisma = prisma

export default prisma
