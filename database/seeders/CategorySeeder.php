<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Groceries'],
            ['name' => 'Clothing'],
            ['name' => 'Books'],
            ['name' => 'Toys'],
            ['name' => 'Sports'],
            ['name' => 'Health & Beauty'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
