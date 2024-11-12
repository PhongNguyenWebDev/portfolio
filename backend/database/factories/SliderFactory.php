<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    protected $model = \App\Models\Slider::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'position' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'url_cv' => $this->faker->url,
            'image' => $this->faker->imageUrl(640, 480, 'people'),
        ];
    }
}
