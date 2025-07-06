<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::factory(0)->create();
        // You can adjust the number of categories created by changing the number in factory(10)
        // This will create 10 categories with random data
    }
}
