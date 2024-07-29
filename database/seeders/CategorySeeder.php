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
        Category::factory()->create([
            'category_name' => 'Moda'
        ]);

        Category::factory()->create([
            'category_name' => 'Tecnologia'
        ]);

        Category::factory()->create([
            'category_name' => 'Hobbie'
        ]);

        Category::factory()->create([
            'category_name' => 'Casa'
        ]);
    }
}
