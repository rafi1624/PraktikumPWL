<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology'
            ],
            [
                'name' => 'Programming',
                'slug' => 'programming'
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
