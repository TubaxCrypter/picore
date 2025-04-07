<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Haberler',
                'description' => 'Güncel haberler ve duyurular'
            ],
            [
                'name' => 'Makaleler',
                'description' => 'Bilgilendirici makaleler'
            ],
            [
                'name' => 'Bloglar',
                'description' => 'Blog yazıları'
            ],
            [
                'name' => 'Duyurular',
                'description' => 'Önemli duyurular'
            ],
            [
                'name' => 'Etkinlikler',
                'description' => 'Gelecek etkinlikler'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'order' => 0
            ]);
        }
    }
} 