<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\General;

class GeneralSeeder extends Seeder
{
    public function run()
    {
        General::factory()->count(5)->create();
    }
}
