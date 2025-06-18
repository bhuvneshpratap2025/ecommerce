<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::create(['name' => 'Electronics']);
        $mobiles = Category::create(['name' => 'Mobiles', 'parent_id' => $electronics->id]);

        Product::create([
            'name' => 'iPhone 14',
             'description' => ' This is iphone.',
            'price' => 999.99,
            'category_id' => $mobiles->id,
        ]);
    }
}
