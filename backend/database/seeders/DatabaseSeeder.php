<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // WorkExperienceSeeder::class,
            // // Nếu bạn có thêm AboutMeSeeder, hãy thêm vào đây
            // AboutMeSeeder::class,
            // IconSeeder::class,
            // SkillSeeder::class,
            // ProjectSeeder::class,
            // SliderSeeder::class,
            GeneralSeeder::class,
        ]);
    }
}
