<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = \App\Models\Project::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'image_project' => $this->faker->imageUrl(640, 480, 'projects'),
            'description' => $this->faker->paragraph,
            'image_tech' => $this->faker->imageUrl(640, 480, 'technology'),
            'url' => $this->faker->url,
        ];
    }
}
