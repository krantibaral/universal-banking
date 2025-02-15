<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'site_name' => 'Universal Banking',
            'color_scheme' => '#da0010',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
