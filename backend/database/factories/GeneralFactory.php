<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralFactory extends Factory
{
    protected $model = \App\Models\General::class;

    public function definition()
    {
        return [
            'logo' => $this->faker->imageUrl(200, 200, 'logo'),
            'des_footer' => $this->faker->sentence,
        ];
    }
}
