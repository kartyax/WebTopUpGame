'use client'

import React from 'react'
import Link from 'next/link'
import { GAMES } from '@/lib/constants'
import { GameIcon } from '@/components/GameIcons'

// LANDING PAGE - GAME GALLERY
export default function Home() {
  return (
    <div className="min-h-screen p-8 pb-20 sm:p-20 font-[family-name:var(--font-geist-sans)] bg-white dark:bg-black text-gray-900 dark:text-gray-100 transition-colors duration-300">
      
      {/* Background Decor (Gradient Blurs) */}
      <div className="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div className="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-500/20 dark:bg-blue-900/20 rounded-full blur-[100px]" />
        <div className="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-500/20 dark:bg-purple-900/20 rounded-full blur-[100px]" />
      </div>

      <main className="max-w-5xl mx-auto flex flex-col gap-12">
        
        {/* Hero Section */}
        <section className="text-center space-y-6 pt-12">
          <h1 className="text-4xl md:text-6xl font-extrabold tracking-tight">
            <span className="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
              Game Top Up
            </span>{' '}
            Simulation
          </h1>
          <p className="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Sistem simulasi top up game modern. integrasi API, Payment Gateway, dan Webhook No risk.
          </p>
          <div className="flex justify-center gap-4">
            <Link 
              href="/api-docs" 
              className="px-6 py-2.5 rounded-full font-medium text-sm transition-all border border-gray-300 dark:border-gray-700 hover:border-blue-500 hover:text-blue-500 hover:scale-105 bg-white/50 dark:bg-black/50 backdrop-blur-sm"
            >
              Dokumentasi API
            </Link>
          </div>
        </section>

        {/* Game Grid Section */}
        <section>
            <div className="flex items-center gap-4 mb-8">
                <h2 className="text-2xl font-bold">Pilih Game Populer</h2>
                <div className="h-px flex-1 bg-gradient-to-r from-gray-200 dark:from-gray-800 to-transparent" />
            </div>
            
            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                {GAMES.map((game) => (
                    <Link 
                        key={game.id} 
                        href={`/topup/${game.id}`}
                        className="group relative flex flex-col p-6 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden"
                    >
                        {/* Glow Effect on Hover */}
                        <div className="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-purple-500/0 group-hover:from-blue-500/5 group-hover:to-purple-500/5 transition-all duration-300" />
                        
                        {/* Icon Wrapper */}
                        <div className="w-full aspect-square bg-gray-50 dark:bg-gray-800 rounded-xl mb-4 flex items-center justify-center p-6 group-hover:scale-105 transition-transform duration-300">
                            <GameIcon id={game.id} className="w-16 h-16 text-gray-500 dark:text-gray-400 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors" />
                        </div>
                        
                        <div className="text-center z-10">
                            <h3 className="font-bold text-lg group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {game.name}
                            </h3>
                            <span className="text-xs text-gray-400 dark:text-gray-500">
                                Instant Delivery
                            </span>
                        </div>
                    </Link>
                ))}
            </div>
        </section>

        {/* Footer */}
        <footer className="text-center text-gray-500 text-sm mt-12 py-8 border-t border-gray-100 dark:border-gray-900">
            <p>Designed for Learning Purpose with Next.js 14 & Tailwind CSS</p>
        </footer>

      </main>
    </div>
  )
}
