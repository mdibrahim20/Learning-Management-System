<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Mobile Development',
            'Data Science',
            'Business & Marketing',
            'Design',
            'Programming Languages',
            'Database Management',
            'Cloud Computing',
            'Cybersecurity',
            'Artificial Intelligence',
        ];

        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
                'image' => null,
            ]);
        }
    }
}
