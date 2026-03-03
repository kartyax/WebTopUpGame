<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $game = \App\Models\Game::create([
            'name' => 'Mobile Legends',
            'slug' => 'mobile-legends',
            'has_server_id' => true,
            'description' => 'Top up Mobile Legends diamond instant',
        ]);

        \App\Models\Product::create(['game_id' => $game->id, 'name' => '86 Diamonds', 'price' => 25000]);
        \App\Models\Product::create(['game_id' => $game->id, 'name' => '172 Diamonds', 'price' => 50000]);
        \App\Models\Product::create(['game_id' => $game->id, 'name' => '257 Diamonds', 'price' => 75000]);

        $game2 = \App\Models\Game::create([
            'name' => 'PUBG Mobile',
            'slug' => 'pubg-mobile',
            'has_server_id' => false,
            'description' => 'Top up PUBG Mobile UC instant',
        ]);

        \App\Models\Product::create(['game_id' => $game2->id, 'name' => '60 UC', 'price' => 15000]);
        \App\Models\Product::create(['game_id' => $game2->id, 'name' => '325 UC', 'price' => 75000]);
        
        \App\Models\PaymentMethod::create([
            'name' => 'QRIS',
            'code' => 'QRIS',
            'fee_flat' => 700,
            'instructions' => 'Scan the QR code to pay.',
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'BCA Virtual Account',
            'code' => 'BCAVA',
            'fee_flat' => 4000,
            'instructions' => 'Transfer to Virtual Account number.',
        ]);
    }
}
