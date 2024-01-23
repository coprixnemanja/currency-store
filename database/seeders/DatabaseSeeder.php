<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Currency::insert([
            [
                'name' => 'Japanese Yen',
                'signature' => 'JPY',
                'rate' => 107.17,
                'surcharge' => 7.5,
                'send_order_email' => false,
                'discount' => 0,
                'created_at' => Carbon::now()->utc(),
                'updated_at' => Carbon::now()->utc()
            ],
            [
                'name' => 'British Pound',
                'signature' => 'GBP',
                'rate' => 0.711178,
                'surcharge' => 5,
                'send_order_email' => true,
                'discount' => 0,
                'created_at' => Carbon::now()->utc(),
                'updated_at' => Carbon::now()->utc()
            ],
            [
                'name' => 'Euro',
                'signature' => 'EUR',
                'rate' => 0.884872,
                'surcharge' => 5,
                'send_order_email' => false,
                'discount' => 2,
                'created_at' => Carbon::now()->utc(),
                'updated_at' => Carbon::now()->utc()
            ],
        ]);
    }
}
