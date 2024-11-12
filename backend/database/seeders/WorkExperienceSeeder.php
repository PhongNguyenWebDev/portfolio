<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class WorkExperienceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) { // Tạo 10 bản ghi
            DB::table('work_experience')->insert([
                'title' => $faker->jobTitle,
                'start_date' => $faker->date,
                'end_date' => $faker->dateTimeBetween('now', '+1 year'), // Ngày kết thúc trong vòng 1 năm tới
                'gpa' => $faker->randomFloat(2, 0, 4), // GPA từ 0 đến 4
                'gpa_scale' => 4.0,
                'position' => $faker->word,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
