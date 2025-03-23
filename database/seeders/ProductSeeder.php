<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the seller user
        $seller = User::where('email', 'seller@example.com')->first();
        
        // Software products (Category ID: 1)
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 1,
            'name' => 'Productivity Suite Pro',
            'description' => 'A comprehensive suite of productivity tools for professionals. Includes task management, time tracking, and project collaboration features.',
            'price' => 49.99,
            'thumbnail' => 'products/productivity-suite.jpg',
            'file_path' => 'products/files/productivity-suite-pro.zip',
            'status' => 'published',
        ]);
        
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 1,
            'name' => 'Code Formatter Plugin',
            'description' => 'Advanced code formatting plugin for popular IDEs. Supports multiple languages and customizable formatting rules.',
            'price' => 19.99,
            'thumbnail' => 'products/code-formatter.jpg',
            'file_path' => 'products/files/code-formatter-plugin.zip',
            'status' => 'published',
        ]);
        
        // E-books (Category ID: 2)
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 2,
            'name' => 'Mastering Web Development',
            'description' => 'Comprehensive guide to modern web development technologies. Learn HTML5, CSS3, JavaScript, and popular frameworks.',
            'price' => 24.99,
            'thumbnail' => 'products/web-dev-ebook.jpg',
            'file_path' => 'products/files/mastering-web-development.pdf',
            'status' => 'published',
        ]);
        
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 2,
            'name' => 'Digital Marketing Essentials',
            'description' => 'Complete guidebook for digital marketing strategies. Covers SEO, content marketing, social media, and analytics.',
            'price' => 29.99,
            'thumbnail' => 'products/marketing-ebook.jpg',
            'file_path' => 'products/files/digital-marketing-essentials.pdf',
            'status' => 'published',
        ]);
        
        // Templates (Category ID: 3)
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 3,
            'name' => 'Modern Portfolio Template',
            'description' => 'Clean and responsive portfolio template for creatives. Customizable sections and ready-to-use components.',
            'price' => 39.99,
            'thumbnail' => 'products/portfolio-template.jpg',
            'file_path' => 'products/files/modern-portfolio-template.zip',
            'status' => 'published',
        ]);
        
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 3,
            'name' => 'Business Proposal Template Pack',
            'description' => 'Collection of professional business proposal templates. Includes multiple designs and customizable elements.',
            'price' => 34.99,
            'thumbnail' => 'products/proposal-templates.jpg',
            'file_path' => 'products/files/business-proposal-templates.zip',
            'status' => 'published',
        ]);
        
        // Graphics (Category ID: 4)
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 4,
            'name' => 'Icon Collection Essential',
            'description' => 'Set of 500+ vector icons for web and mobile projects. Includes multiple styles and formats.',
            'price' => 19.99,
            'thumbnail' => 'products/icon-collection.jpg',
            'file_path' => 'products/files/icon-collection-essential.zip',
            'status' => 'published',
        ]);
        
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 4,
            'name' => 'UI Elements Pack',
            'description' => 'Comprehensive collection of UI elements for modern web and mobile design. Includes buttons, forms, cards, and more.',
            'price' => 29.99,
            'thumbnail' => 'products/ui-elements.jpg',
            'file_path' => 'products/files/ui-elements-pack.zip',
            'status' => 'published',
        ]);
        
        // Audio (Category ID: 5)
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 5,
            'name' => 'Sound Effects Collection',
            'description' => '200+ high-quality sound effects for multimedia projects. Includes UI sounds, transitions, and environmental effects.',
            'price' => 24.99,
            'thumbnail' => 'products/sound-effects.jpg',
            'file_path' => 'products/files/sound-effects-collection.zip',
            'status' => 'published',
        ]);
        
        Product::create([
            'user_id' => $seller->id,
            'category_id' => 5,
            'name' => 'Background Music Pack',
            'description' => 'Collection of 50 royalty-free background music tracks for videos, presentations, and other media projects.',
            'price' => 39.99,
            'thumbnail' => 'products/background-music.jpg',
            'file_path' => 'products/files/background-music-pack.zip',
            'status' => 'published',
        ]);
    }
}
