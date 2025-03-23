<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Software',
                'description' => 'Digital software products, applications, plugins, and extensions',
                'image' => 'categories/software.jpg',
            ],
            [
                'name' => 'E-books',
                'description' => 'Digital books, guides, and educational content',
                'image' => 'categories/ebooks.jpg',
            ],
            [
                'name' => 'Templates',
                'description' => 'Design templates, website themes, and UI kits',
                'image' => 'categories/templates.jpg',
            ],
            [
                'name' => 'Graphics',
                'description' => 'Digital art, illustrations, icons, and graphic resources',
                'image' => 'categories/graphics.jpg',
            ],
            [
                'name' => 'Audio',
                'description' => 'Sound effects, music tracks, and audio resources',
                'image' => 'categories/audio.jpg',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'image' => $categoryData['image'],
            ]);
        }
    }
}
