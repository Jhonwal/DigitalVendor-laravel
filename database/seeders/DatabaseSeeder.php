<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create seller user
        $seller = User::create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create buyer user
        User::create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Software', 'slug' => 'software'],
            ['name' => 'E-books', 'slug' => 'ebooks'],
            ['name' => 'Templates', 'slug' => 'templates'],
            ['name' => 'Graphics', 'slug' => 'graphics'],
            ['name' => 'Audio', 'slug' => 'audio'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'user_id' => $seller->id,
                'category_id' => 1, // Software
                'name' => 'Productivity Toolkit',
                'slug' => 'productivity-toolkit',
                'description' => 'A comprehensive toolkit for boosting productivity, including task management, pomodoro timer, and note-taking app.',
                'price' => 29.99,
                'thumbnail' => 'products/productivity-toolkit.jpg',
                'file_path' => 'products/files/productivity-toolkit.zip',
                'status' => 'published',
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 2, // E-books
                'name' => 'Web Development Mastery',
                'slug' => 'web-development-mastery',
                'description' => 'A complete guide to modern web development, covering HTML, CSS, JavaScript, and popular frameworks.',
                'price' => 19.99,
                'thumbnail' => 'products/web-dev-guide.jpg',
                'file_path' => 'products/files/web-dev-guide.pdf',
                'status' => 'published',
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 3, // Templates
                'name' => 'Business Proposal Template Pack',
                'slug' => 'business-proposal-template-pack',
                'description' => 'Professional business proposal templates for various industries, ready to customize and impress clients.',
                'price' => 14.99,
                'thumbnail' => 'products/proposal-templates.jpg',
                'file_path' => 'products/files/proposal-templates.zip',
                'status' => 'published',
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 4, // Graphics
                'name' => 'Icon Collection: Essential Pack',
                'slug' => 'icon-collection-essential-pack',
                'description' => '1000+ carefully crafted icons for web and app design in multiple formats (SVG, PNG, AI).',
                'price' => 24.99,
                'thumbnail' => 'products/icon-collection.jpg',
                'file_path' => 'products/files/icon-collection.zip',
                'status' => 'published',
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 5, // Audio
                'name' => 'Royalty-Free Music Pack',
                'slug' => 'royalty-free-music-pack',
                'description' => '50 original royalty-free music tracks for your videos, podcasts, and other content.',
                'price' => 39.99,
                'thumbnail' => 'products/music-pack.jpg',
                'file_path' => 'products/files/music-pack.zip',
                'status' => 'published',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}