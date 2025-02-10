<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'brand' => $this->faker->company(),
            'short_description' => $this->faker->sentence(),
            'long_description' => $this->faker->paragraphs(3, true),
            'thumbnail' => $this->faker->imageUrl(),
            'category_id' => Category::factory(),
            'subcategory_id' => Subcategory::factory(),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'price_1' => $this->faker->randomFloat(2, 10, 1000),
            'price_2' => $this->faker->randomFloat(2, 10, 1000),
            'price_3' => $this->faker->randomFloat(2, 10, 1000),
            'price_4' => $this->faker->randomFloat(2, 10, 1000),
            'price_6' => $this->faker->randomFloat(2, 10, 1000),
            'price_7' => $this->faker->randomFloat(2, 10, 1000),
            'price_8' => $this->faker->randomFloat(2, 10, 1000),
            'price_9' => $this->faker->randomFloat(2, 10, 1000),
            'price_10' => $this->faker->randomFloat(2, 10, 1000),
            'price_11' => $this->faker->randomFloat(2, 10, 1000),
            'price_12' => $this->faker->randomFloat(2, 10, 1000),
            'price_13' => $this->faker->randomFloat(2, 10, 1000),
            'price_14' => $this->faker->randomFloat(2, 10, 1000),
            'price_15' => $this->faker->randomFloat(2, 10, 1000),
            'price_16' => $this->faker->randomFloat(2, 10, 1000),
            'price_17' => $this->faker->randomFloat(2, 10, 1000),
            'is_great_deal' => $this->faker->boolean(),
            'is_bestseller' => $this->faker->boolean(),
            'qty' => $this->faker->numberBetween(0, 1000),
            'unit' => $this->faker->randomElement(['pcs', 'kg', 'liter']),
            'sku' => $this->faker->unique()->ean13(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
