<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Technology',
            'Education',
            'Programming',
            'Web Development',
            'Career Tips',
            'Industry News',
            'Student Success Stories',
            'Instructor Insights',
        ];

        foreach ($categories as $category) {
            BlogCategory::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
            ]);
        }
    }
}
