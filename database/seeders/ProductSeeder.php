<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filename = database_path('seeders/dummy-data.csv');
        $dataSet = collect();

        if (($handle = fopen($filename, 'r')) !== false) {
            $headers = fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $dataSet->push(array_combine($headers, $data));
            }

            fclose($handle);
        }

        $categories = Category::all()->keyBy('name');
        $subcategories = Subcategory::all()->keyBy('name');
        $faker = \Faker\Factory::create();

        $products = $dataSet->map(function ($product) use ($categories, $subcategories, $faker) {
            $category = $categories[$product['Category']] ?? null;
            $subcategory = $subcategories[$product['SubCategory']] ?? null;

            return [
                'name' => $product['ProductName'],
                'brand' => $product['Brand'],
                'short_description' => $faker->sentence(),
                'long_description' => $faker->paragraphs(3, true),
                'thumbnail' => $product['Image_Url'] ?? $faker->imageUrl(),
                'category_id' => $category ? $category->id : null,
                'subcategory_id' => $subcategory ? $subcategory->id : null,
                'discount' => $faker->randomFloat(2, 0, 50),
                'price_1' => $product['DiscountPrice'],
                // 'price_2' => $faker->randomFloat(2, 10, 1000),
                // 'price_3' => $faker->randomFloat(2, 10, 1000),
                // 'price_4' => $faker->randomFloat(2, 10, 1000),
                // 'price_6' => $faker->randomFloat(2, 10, 1000),
                // 'price_7' => $faker->randomFloat(2, 10, 1000),
                // 'price_8' => $faker->randomFloat(2, 10, 1000),
                // 'price_9' => $faker->randomFloat(2, 10, 1000),
                // 'price_10' => $faker->randomFloat(2, 10, 1000),
                // 'price_11' => $faker->randomFloat(2, 10, 1000),
                // 'price_12' => $faker->randomFloat(2, 10, 1000),
                // 'price_13' => $faker->randomFloat(2, 10, 1000),
                // 'price_14' => $faker->randomFloat(2, 10, 1000),
                // 'price_15' => $faker->randomFloat(2, 10, 1000),
                // 'price_16' => $faker->randomFloat(2, 10, 1000),
                // 'price_17' => $faker->randomFloat(2, 10, 1000),
                'is_great_deal' => $faker->boolean(),
                'is_bestseller' => $faker->boolean(),
                'qty' => $faker->numberBetween(0, 1000),
                'unit' => $faker->randomElement(['pcs', 'kg', 'liter']),
                'sku' => $faker->unique()->ean13(),
                'status' => $faker->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        $chunkSize = 100; // Adjust this value based on your needs and memory constraints

        $products->chunk($chunkSize)->each(function ($chunk) {
            DB::table('products')->insert($chunk->toArray());
        });
    }
}
