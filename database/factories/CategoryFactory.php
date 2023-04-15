<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => "ID_".$this->faker->ean8(),
            'category_name' => $this->faker->name(),
            'category_description' => $this->faker->sentence(),
            'category_avatar' => "images_upload/".mt_rand(1,50),
        ];
    }
}
