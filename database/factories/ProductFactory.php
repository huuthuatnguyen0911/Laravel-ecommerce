<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => "ID_".$this->faker->ean8(),
            'product_name' => $this->faker->name(),
            'product_description' => $this->faker->sentence(),
            'product_avatar' => "images_upload/".mt_rand(1,50),
            'category_id' => "ID_".$this->faker->ean8(),
        ];
    }
}
