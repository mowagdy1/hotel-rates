<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rate::factory()->count(500)->create();
    }
}
