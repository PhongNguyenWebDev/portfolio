<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IconFactory extends Factory
{
    protected $model = \App\Models\Icon::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'url' => $this->faker->url,
            'class_name' => 'fab fa-' . $this->faker->word,
        ];
    }
}
