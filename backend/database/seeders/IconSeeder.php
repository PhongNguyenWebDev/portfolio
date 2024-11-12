<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Icon;

class IconSeeder extends Seeder
{
    public function run()
    {
        Icon::factory()->count(5)->create();
    }
}
