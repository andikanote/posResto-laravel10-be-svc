<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::factory(0)->create();
    }
}

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use App\Models\Product;

// class ProductSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         $products = [
//             // Appetizers (category_id 1)
//             [
//                 'category_id' => 1,
//                 'name' => 'Bruschetta',
//                 'description' => 'Toasted bread topped with tomatoes, garlic, and fresh basil',
//                 'price' => 8.99,
//                 'image' => 'http://www.google.co.id/images/products/bruschetta.jpg',
//                 'stock' => 50,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ],
//             [
//                 'category_id' => 1,
//                 'name' => 'Calamari',
//                 'description' => 'Crispy fried squid served with marinara sauce',
//                 'price' => 12.50,
//                 'image' => 'http://www.google.co.id/images/products/calamari.jpg',
//                 'stock' => 30,
//                 'status' => '1',
//                 'is_favorite' => 0
//             ],
//             [
//                 'category_id' => 1,
//                 'name' => 'Spinach Artichoke Dip',
//                 'description' => 'Creamy dip with spinach, artichokes, and melted cheese, served with tortilla chips',
//                 'price' => 10.99,
//                 'image' => 'http://www.google.co.id/images/products/spinach-dip.jpg',
//                 'stock' => 40,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ],

//             // Main Courses (category_id 2)
//             [
//                 'category_id' => 2,
//                 'name' => 'Grilled Salmon',
//                 'description' => 'Fresh Atlantic salmon with lemon butter sauce, served with seasonal vegetables',
//                 'price' => 22.99,
//                 'image' => 'http://www.google.co.id/images/products/grilled-salmon.jpg',
//                 'stock' => 25,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ],
//             [
//                 'category_id' => 2,
//                 'name' => 'Filet Mignon',
//                 'description' => '8oz tender beef filet with red wine reduction, mashed potatoes, and asparagus',
//                 'price' => 34.99,
//                 'image' => 'http://www.google.co.id/images/products/filet-mignon.jpg',
//                 'stock' => 20,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ],
//             [
//                 'category_id' => 2,
//                 'name' => 'Chicken Parmesan',
//                 'description' => 'Breaded chicken breast topped with marinara and mozzarella, served with spaghetti',
//                 'price' => 19.99,
//                 'image' => 'http://www.google.co.id/images/products/chicken-parm.jpg',
//                 'stock' => 35,
//                 'status' => '1',
//                 'is_favorite' => 0
//             ],

//             // Pasta (category_id 3)
//             [
//                 'category_id' => 3,
//                 'name' => 'Spaghetti Carbonara',
//                 'description' => 'Classic pasta with pancetta, eggs, parmesan, and black pepper',
//                 'price' => 16.99,
//                 'image' => 'http://www.google.co.id/images/products/carbonara.jpg',
//                 'stock' => 40,
//                 'status' => '1',
//                 'is_favorite' => 0
//             ],
//             [
//                 'category_id' => 3,
//                 'name' => 'Fettuccine Alfredo',
//                 'description' => 'Ribbon pasta with creamy parmesan sauce',
//                 'price' => 15.50,
//                 'image' => 'http://www.google.co.id/images/products/alfredo.jpg',
//                 'stock' => 45,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ],

//             // Desserts (category_id 4)
//             [
//                 'category_id' => 4,
//                 'name' => 'Tiramisu',
//                 'description' => 'Classic Italian dessert with layers of coffee-soaked ladyfingers and mascarpone cream',
//                 'price' => 9.99,
//                 'image' => 'http://www.google.co.id/images/products/tiramisu.jpg',
//                 'stock' => 30,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ],
//             [
//                 'category_id' => 4,
//                 'name' => 'Chocolate Lava Cake',
//                 'description' => 'Warm chocolate cake with a molten center, served with vanilla ice cream',
//                 'price' => 8.50,
//                 'image' => 'http://www.google.co.id/images/products/lava-cake.jpg',
//                 'stock' => 25,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ],

//             // Beverages (category_id 5)
//             [
//                 'category_id' => 5,
//                 'name' => 'House Red Wine',
//                 'description' => 'Glass of our signature Cabernet Sauvignon',
//                 'price' => 10.00,
//                 'image' => 'http://www.google.co.id/images/products/red-wine.jpg',
//                 'stock' => 100,
//                 'status' => '1',
//                 'is_favorite' => 0
//             ],
//             [
//                 'category_id' => 5,
//                 'name' => 'Iced Tea',
//                 'description' => 'Freshly brewed unsweetened iced tea with lemon',
//                 'price' => 3.50,
//                 'image' => 'http://www.google.co.id/images/products/iced-tea.jpg',
//                 'stock' => 200,
//                 'status' => '1',
//                 'is_favorite' => 0
//             ],
//             [
//                 'category_id' => 5,
//                 'name' => 'Craft Beer',
//                 'description' => 'Local IPA from our microbrewery partner',
//                 'price' => 7.00,
//                 'image' => 'http://www.google.co.id/images/products/craft-beer.jpg',
//                 'stock' => 80,
//                 'status' => '1',
//                 'is_favorite' => 1
//             ]
//         ];

//         foreach ($products as $product) {
//             Product::create($product);
//         }

//         // Create additional random products if needed
//         \App\Models\Product::factory(10)->create();
//     }
// }

