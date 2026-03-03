<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // ======== GAMES ========
        $ml = \App\Models\Game::create([
            'name' => 'Mobile Legends',
            'slug' => 'mobile-legends',
            'category' => 'Mobile Game',
            'has_server_id' => true,
            'description' => 'Top up diamond Mobile Legends: Bang Bang secara instan. Diamond langsung masuk ke akun game kamu.',
            'image_url' => '/images/games/mobile-legends.png',
        ]);

        $ff = \App\Models\Game::create([
            'name' => 'Free Fire',
            'slug' => 'free-fire',
            'category' => 'Mobile Game',
            'has_server_id' => false,
            'description' => 'Top up diamond Free Fire langsung ke akun. Proses cepat dan aman 24/7.',
            'image_url' => '/images/games/free-fire.png',
        ]);

        $pubg = \App\Models\Game::create([
            'name' => 'PUBG Mobile',
            'slug' => 'pubg-mobile',
            'category' => 'Mobile Game',
            'has_server_id' => false,
            'description' => 'Top up UC PUBG Mobile dengan harga termurah dan proses tercepat.',
            'image_url' => '/images/games/pubg-mobile.png',
        ]);

        $gi = \App\Models\Game::create([
            'name' => 'Genshin Impact',
            'slug' => 'genshin-impact',
            'category' => 'PC / Mobile',
            'has_server_id' => true,
            'description' => 'Top up Genesis Crystal dan Blessing of the Welkin Moon Genshin Impact.',
            'image_url' => '/images/games/genshin-impact.png',
        ]);

        $valo = \App\Models\Game::create([
            'name' => 'Valorant',
            'slug' => 'valorant',
            'category' => 'PC Game',
            'has_server_id' => false,
            'description' => 'Top up Valorant Points (VP) untuk membeli skin dan battle pass.',
            'image_url' => '/images/games/valorant.png',
        ]);

        $hsr = \App\Models\Game::create([
            'name' => 'Honkai: Star Rail',
            'slug' => 'honkai-star-rail',
            'category' => 'PC / Mobile',
            'has_server_id' => true,
            'description' => 'Top up Oneiric Shard untuk Honkai: Star Rail. Proses instan dan aman.',
            'image_url' => '/images/games/honkai-star-rail.png',
        ]);

        $cod = \App\Models\Game::create([
            'name' => 'Call of Duty Mobile',
            'slug' => 'call-of-duty-mobile',
            'category' => 'Mobile Game',
            'has_server_id' => false,
            'description' => 'Top up CP (COD Points) untuk Call of Duty: Mobile.',
            'image_url' => '/images/games/call-of-duty-mobile.png',
        ]);

        $aov = \App\Models\Game::create([
            'name' => 'Arena of Valor',
            'slug' => 'arena-of-valor',
            'category' => 'Mobile Game',
            'has_server_id' => false,
            'description' => 'Top up Voucher Arena of Valor (AOV) harga murah dan proses cepat.',
            'image_url' => '/images/games/arena-of-valor.png',
        ]);

        // ======== PRODUCTS ========
        // Mobile Legends
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '5 Diamonds', 'price' => 1579]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '12 Diamonds', 'price' => 3688]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '86 Diamonds', 'price' => 25000]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '172 Diamonds', 'price' => 50000]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '257 Diamonds', 'price' => 75000]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '344 Diamonds', 'price' => 100000]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '429 Diamonds', 'price' => 124000]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '514 Diamonds', 'price' => 149000]);
        \App\Models\Product::create(['game_id' => $ml->id, 'name' => '706 Diamonds', 'price' => 199000]);

        // Free Fire
        \App\Models\Product::create(['game_id' => $ff->id, 'name' => '5 Diamonds', 'price' => 1500]);
        \App\Models\Product::create(['game_id' => $ff->id, 'name' => '12 Diamonds', 'price' => 3000]);
        \App\Models\Product::create(['game_id' => $ff->id, 'name' => '50 Diamonds', 'price' => 7000]);
        \App\Models\Product::create(['game_id' => $ff->id, 'name' => '70 Diamonds', 'price' => 10000]);
        \App\Models\Product::create(['game_id' => $ff->id, 'name' => '140 Diamonds', 'price' => 20000]);
        \App\Models\Product::create(['game_id' => $ff->id, 'name' => '355 Diamonds', 'price' => 50000]);
        \App\Models\Product::create(['game_id' => $ff->id, 'name' => '720 Diamonds', 'price' => 100000]);

        // PUBG Mobile
        \App\Models\Product::create(['game_id' => $pubg->id, 'name' => '60 UC', 'price' => 15000]);
        \App\Models\Product::create(['game_id' => $pubg->id, 'name' => '325 UC', 'price' => 75000]);
        \App\Models\Product::create(['game_id' => $pubg->id, 'name' => '660 UC', 'price' => 150000]);
        \App\Models\Product::create(['game_id' => $pubg->id, 'name' => '1800 UC', 'price' => 375000]);

        // Genshin Impact
        \App\Models\Product::create(['game_id' => $gi->id, 'name' => '60 Genesis Crystals', 'price' => 16000]);
        \App\Models\Product::create(['game_id' => $gi->id, 'name' => '300 Genesis Crystals', 'price' => 79000]);
        \App\Models\Product::create(['game_id' => $gi->id, 'name' => '980 Genesis Crystals', 'price' => 249000]);
        \App\Models\Product::create(['game_id' => $gi->id, 'name' => '1980 Genesis Crystals', 'price' => 479000]);
        \App\Models\Product::create(['game_id' => $gi->id, 'name' => 'Welkin Moon', 'price' => 79000]);

        // Valorant
        \App\Models\Product::create(['game_id' => $valo->id, 'name' => '125 VP', 'price' => 15000]);
        \App\Models\Product::create(['game_id' => $valo->id, 'name' => '420 VP', 'price' => 50000]);
        \App\Models\Product::create(['game_id' => $valo->id, 'name' => '700 VP', 'price' => 80000]);
        \App\Models\Product::create(['game_id' => $valo->id, 'name' => '1375 VP', 'price' => 150000]);
        \App\Models\Product::create(['game_id' => $valo->id, 'name' => '2400 VP', 'price' => 250000]);

        // Honkai Star Rail
        \App\Models\Product::create(['game_id' => $hsr->id, 'name' => '60 Oneiric Shard', 'price' => 16000]);
        \App\Models\Product::create(['game_id' => $hsr->id, 'name' => '300 Oneiric Shard', 'price' => 79000]);
        \App\Models\Product::create(['game_id' => $hsr->id, 'name' => '980 Oneiric Shard', 'price' => 249000]);
        \App\Models\Product::create(['game_id' => $hsr->id, 'name' => 'Express Supply Pass', 'price' => 79000]);

        // COD Mobile
        \App\Models\Product::create(['game_id' => $cod->id, 'name' => '80 CP', 'price' => 16000]);
        \App\Models\Product::create(['game_id' => $cod->id, 'name' => '400 CP', 'price' => 79000]);
        \App\Models\Product::create(['game_id' => $cod->id, 'name' => '800 CP', 'price' => 149000]);
        \App\Models\Product::create(['game_id' => $cod->id, 'name' => '2000 CP', 'price' => 329000]);

        // AOV
        \App\Models\Product::create(['game_id' => $aov->id, 'name' => '20 Voucher', 'price' => 3600]);
        \App\Models\Product::create(['game_id' => $aov->id, 'name' => '50 Voucher', 'price' => 9000]);
        \App\Models\Product::create(['game_id' => $aov->id, 'name' => '100 Voucher', 'price' => 18000]);
        \App\Models\Product::create(['game_id' => $aov->id, 'name' => '200 Voucher', 'price' => 36000]);

        // ======== PAYMENT METHODS ========
        \App\Models\PaymentMethod::create([
            'name' => 'QRIS',
            'code' => 'QRIS',
            'fee_flat' => 700,
            'instructions' => 'Scan QR code melalui aplikasi e-wallet atau mobile banking.',
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'GoPay',
            'code' => 'GOPAY',
            'fee_flat' => 1000,
            'instructions' => 'Bayar via aplikasi GoPay / Gojek.',
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'OVO',
            'code' => 'OVO',
            'fee_flat' => 1000,
            'instructions' => 'Bayar via aplikasi OVO.',
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'Dana',
            'code' => 'DANA',
            'fee_flat' => 1000,
            'instructions' => 'Bayar via aplikasi Dana.',
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'BCA Virtual Account',
            'code' => 'BCAVA',
            'fee_flat' => 4000,
            'instructions' => 'Transfer ke nomor Virtual Account via m-BCA / KlikBCA.',
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'BRI Virtual Account',
            'code' => 'BRIVA',
            'fee_flat' => 4000,
            'instructions' => 'Transfer ke nomor Virtual Account via BRImo.',
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'Mandiri Virtual Account',
            'code' => 'MANDIRIVA',
            'fee_flat' => 4000,
            'instructions' => 'Transfer ke nomor Virtual Account via Livin by Mandiri.',
        ]);
    }
}

