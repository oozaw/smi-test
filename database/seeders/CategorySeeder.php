<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Toys',
            'Furniture',
            'Food',
            'Drinks',
            'Stationery',
            'Tools',
            'Sporting Goods',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::factory()->create(['name' => $category]);
        }
    }
}
