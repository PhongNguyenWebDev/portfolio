<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = \App\Models\Skill::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'process' => $this->faker->numberBetween(0, 100),
            'level' => $this->faker->randomElement(['basic', 'medium', 'advanced']),
        ];
    }
}
