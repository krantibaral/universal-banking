<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CryptoRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('crypto_rates')->insert([
            'bitcoin' => 47.00, 
            'dogecoin' => 10.00,   
            'trump' => 20.00,   
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
