<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
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

        // Extract all image URLs from the dataset
        $imageUrls = $dataSet->pluck('Image_Url')->filter()->values()->toArray();

        $categories = $dataSet->pluck('Category')->unique();
        $subcategories = $dataSet->groupBy('Category')->map(function ($items) {
            return $items->pluck('SubCategory')->unique();
        });

        $categorySubcategoryMap = $categories->mapWithKeys(function ($category) use ($subcategories) {
            return [$category => $subcategories->get($category, collect())->toArray()];
        });

        foreach ($categorySubcategoryMap as $categoryName => $subcategories) {
            // Select a random image URL from the entire dataset
            $randomImageUrl = $imageUrls[array_rand($imageUrls)] ?? null;

            $mainCategory = Category::factory()->create([
                'name' => $categoryName,
                'status' => true,
                'thumbnail' => $randomImageUrl,
            ]);

            foreach ($subcategories as $subCategoryName) {
                if (! empty($subCategoryName)) {
                    Subcategory::factory()->create([
                        'name' => $subCategoryName,
                        'category_id' => $mainCategory->id,
                        'status' => true,
                    ]);
                }
            }
        }
    }
}
