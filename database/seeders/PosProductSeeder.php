<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PosProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            ['name' => 'Fresh Juice', 'icon' => '🥤', 'sort_order' => 1],
            ['name' => 'Milkshake',   'icon' => '🧋', 'sort_order' => 2],
            ['name' => 'Lassi',       'icon' => '🥛', 'sort_order' => 3],
            ['name' => 'Desserts',    'icon' => '🍨', 'sort_order' => 4],
            ['name' => 'Hot Drinks',  'icon' => '☕', 'sort_order' => 5],
            ['name' => 'Fast Food',   'icon' => '🍔', 'sort_order' => 6],
            ['name' => 'Snacks',      'icon' => '🥟', 'sort_order' => 7],
        ];

        $categoryMap = [];

        foreach ($categoriesData as $cat) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name'       => $cat['name'],
                    'icon'       => $cat['icon'],
                    'sort_order' => $cat['sort_order'],
                    'is_active'  => true,
                ]
            );
            $categoryMap[$cat['name']] = $category->id;
        }

        $productsData = [
            // Fresh Juice
            ['name' => 'Papaya Juice',        'category' => 'Fresh Juice', 'price' => 200.00, 'image' => 'products/papaya-juice.jpg'],
            ['name' => 'Watermelon Juice',    'category' => 'Fresh Juice', 'price' => 200.00, 'image' => 'products/mango-juice.jpg'],
            ['name' => 'Lime Juice',          'category' => 'Fresh Juice', 'price' => 200.00, 'image' => 'products/papaya-juice.jpg'],
            ['name' => 'Embul Thodan Juice',  'category' => 'Fresh Juice', 'price' => 220.00, 'image' => 'products/papaya-juice.jpg'],
            ['name' => 'Mango Juice',         'category' => 'Fresh Juice', 'price' => 230.00, 'image' => 'products/mango-juice.jpg'],
            ['name' => 'Banana Juice',        'category' => 'Fresh Juice', 'price' => 230.00, 'image' => 'products/mango-juice.jpg'],
            ['name' => 'Peni Thodan Juice',   'category' => 'Fresh Juice', 'price' => 230.00, 'image' => 'products/papaya-juice.jpg'],
            ['name' => 'Divil Juice',         'category' => 'Fresh Juice', 'price' => 250.00, 'image' => 'products/papaya-juice.jpg'],
            ['name' => 'Pineapple Juice',     'category' => 'Fresh Juice', 'price' => 300.00, 'image' => 'products/mango-juice.jpg'],
            ['name' => 'Orange Juice',        'category' => 'Fresh Juice', 'price' => 300.00, 'image' => 'products/papaya-juice.jpg'],
            ['name' => 'Apple Juice',         'category' => 'Fresh Juice', 'price' => 300.00, 'image' => 'products/mango-juice.jpg'],
            ['name' => 'Dragon Fruit Juice',  'category' => 'Fresh Juice', 'price' => 350.00, 'image' => 'products/rose-falooda.jpg'],

            // Milkshake
            ['name' => 'Badam Milkshake',     'category' => 'Milkshake',   'price' => 600.00, 'image' => 'products/badam-milkshake.jpg'],
            ['name' => 'Avocado Milkshake',   'category' => 'Milkshake',   'price' => 250.00, 'image' => 'products/avocado-milkshake.webp'],
            ['name' => 'Chocolate Milkshake', 'category' => 'Milkshake',   'price' => 250.00, 'image' => 'products/chocolate-milkshake.jpg'],
            ['name' => 'Banana Milkshake',    'category' => 'Milkshake',   'price' => 250.00, 'image' => 'products/badam-milkshake.jpg'],
            ['name' => 'Mango Milkshake',     'category' => 'Milkshake',   'price' => 250.00, 'image' => 'products/mango-juice.jpg'],
            ['name' => 'Milo Milkshake',      'category' => 'Milkshake',   'price' => 250.00, 'image' => 'products/chocolate-milkshake.jpg'],
            ['name' => 'Nestomalt Milkshake', 'category' => 'Milkshake',   'price' => 250.00, 'image' => 'products/chocolate-milkshake.jpg'],
            ['name' => 'Date Milkshake',      'category' => 'Milkshake',   'price' => 250.00, 'image' => 'products/badam-milkshake.jpg'],
            ['name' => 'Durian Milkshake',    'category' => 'Milkshake',   'price' => 400.00, 'image' => 'products/avocado-milkshake.webp'],

            // Lassi
            ['name' => 'Sweet Lassi',         'category' => 'Lassi',       'price' => 250.00, 'image' => 'products/badam-milkshake.jpg'],
            ['name' => 'Mango Lassi',         'category' => 'Lassi',       'price' => 300.00, 'image' => 'products/mango-juice.jpg'],

            // Desserts
            ['name' => 'Falooda',             'category' => 'Desserts',    'price' => 300.00, 'image' => 'products/rose-falooda.jpg'],
            ['name' => 'Molisha',             'category' => 'Desserts',    'price' => 350.00, 'image' => 'products/rose-falooda.jpg'],
            ['name' => 'Fruit Salad',         'category' => 'Desserts',    'price' => 250.00, 'image' => 'products/fruit-salad.jpg'],

            // Hot Drinks
            ['name' => 'Tea',                 'category' => 'Hot Drinks',  'price' => 120.00, 'image' => 'products/badam-milkshake.jpg'],
            ['name' => 'Masala Tea',          'category' => 'Hot Drinks',  'price' => 150.00, 'image' => 'products/badam-milkshake.jpg'],

            // Fast Food
            ['name' => 'Chicken Shawarma',    'category' => 'Fast Food',   'price' => 180.00, 'image' => 'products/chicken-shawarma.jpg'],
            ['name' => 'Mini Submarine',      'category' => 'Fast Food',   'price' => 350.00, 'image' => 'products/chicken-shawarma.jpg'],

            // Snacks
            ['name' => 'Egg Patties',         'category' => 'Snacks',      'price' => 80.00,  'image' => 'products/snacks.jpg'],
            ['name' => 'Bread Pakoda',        'category' => 'Snacks',      'price' => 100.00, 'image' => 'products/snacks.jpg'],
        ];

        foreach ($productsData as $index => $item) {
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name'            => $item['name'],
                    'category_id'     => $categoryMap[$item['category']],
                    'price'           => $item['price'],
                    'image'           => $item['image'] ?? null,
                    'is_available'    => true,
                    'show_on_pos'     => true,
                    'show_on_website' => true,
                    'sort_order'      => $index + 1,
                ]
            );
        }
    }
}
