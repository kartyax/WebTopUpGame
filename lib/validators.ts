import { z } from 'zod'

// Validasi Input Top Up
// Zod membantu kita memastikan data yang dikirim user sesuai format yang diinginkan.

export const createOrderSchema = z.object({
  game: z.string().min(1, "Silakan pilih game"), // Game harus dipilih
  userId: z.string().min(3, "User ID minimal 3 karakter"), // User ID minimal 3 valid
  zoneId: z.string().optional(), // Zone ID boleh kosong
  amount: z.number().min(1000, "Minimal top up Rp 1.000"), // Minimal top up
})
