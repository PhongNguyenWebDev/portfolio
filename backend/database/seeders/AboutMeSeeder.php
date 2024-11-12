<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AboutMeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $index) { // Tạo 5 bản ghi
            DB::table('about_me')->insert([
                'title' => $faker->sentence(3), // Tạo tiêu đề ngẫu nhiên
                'description' => $faker->paragraph, // Tạo nội dung mô tả ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
