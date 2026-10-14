<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BarangSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BarangSeeder::class,
        ]);
    }
}