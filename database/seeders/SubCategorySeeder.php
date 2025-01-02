<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            // Web Development subcategories
            ['category_id' => 1, 'name' => 'Laravel'],
            ['category_id' => 1, 'name' => 'Vue.js'],
            ['category_id' => 1, 'name' => 'React'],
            ['category_id' => 1, 'name' => 'Node.js'],
            ['category_id' => 1, 'name' => 'WordPress'],
            
            // Mobile Development subcategories
            ['category_id' => 2, 'name' => 'Flutter'],
            ['category_id' => 2, 'name' => 'React Native'],
            ['category_id' => 2, 'name' => 'Android'],
            ['category_id' => 2, 'name' => 'iOS'],
            
            // Data Science subcategories
            ['category_id' => 3, 'name' => 'Machine Learning'],
            ['category_id' => 3, 'name' => 'Python for Data Science'],
            ['category_id' => 3, 'name' => 'Data Analysis'],
            ['category_id' => 3, 'name' => 'Statistics'],
            
            // Business & Marketing subcategories
            ['category_id' => 4, 'name' => 'Digital Marketing'],
            ['category_id' => 4, 'name' => 'SEO'],
            ['category_id' => 4, 'name' => 'Social Media Marketing'],
            ['category_id' => 4, 'name' => 'Business Strategy'],
            
            // Design subcategories
            ['category_id' => 5, 'name' => 'UI/UX Design'],
            ['category_id' => 5, 'name' => 'Graphic Design'],
            ['category_id' => 5, 'name' => 'Web Design'],
            ['category_id' => 5, 'name' => 'Adobe Photoshop'],
        ];

        foreach ($subCategories as $subCategory) {
            SubCategory::create([
                'category_id' => $subCategory['category_id'],
                'subcategory_name' => $subCategory['name'],
                'subcategory_slug' => Str::slug($subCategory['name']),
            ]);
        }
    }
}
