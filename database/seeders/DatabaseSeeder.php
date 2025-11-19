<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123', 
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);

        // Create categories
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and accessories'
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion and apparel'
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books and publications'
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Home improvement and garden supplies'
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports equipment and accessories'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation',
                'price' => 99.99,
                'stock_quantity' => 50,
                'category_id' => 1,
                'is_available' => true,
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Latest model smartphone with 5G capability',
                'price' => 799.99,
                'stock_quantity' => 30,
                'category_id' => 1,
                'is_available' => true,
            ],
            [
                'name' => 'Laptop',
                'description' => 'Powerful laptop for work and gaming',
                'price' => 1299.99,
                'stock_quantity' => 0,
                'category_id' => 1,
                'is_available' => false,
            ],
            [
                'name' => 'T-Shirt',
                'description' => 'Comfortable cotton t-shirt',
                'price' => 19.99,
                'stock_quantity' => 100,
                'category_id' => 2,
                'is_available' => true,
            ],
            [
                'name' => 'Jeans',
                'description' => 'Classic blue jeans',
                'price' => 49.99,
                'stock_quantity' => 75,
                'category_id' => 2,
                'is_available' => true,
            ],
            [
                'name' => 'Programming Book',
                'description' => 'Learn Laravel 11 from scratch',
                'price' => 39.99,
                'stock_quantity' => 25,
                'category_id' => 3,
                'is_available' => true,
            ],
            [
                'name' => 'Fiction Novel',
                'description' => 'Bestselling fiction novel',
                'price' => 14.99,
                'stock_quantity' => 60,
                'category_id' => 3,
                'is_available' => true,
            ],
            [
                'name' => 'Garden Tools Set',
                'description' => 'Complete set of garden tools',
                'price' => 89.99,
                'stock_quantity' => 15,
                'category_id' => 4,
                'is_available' => true,
            ],
            [
                'name' => 'Running Shoes',
                'description' => 'Professional running shoes',
                'price' => 129.99,
                'stock_quantity' => 40,
                'category_id' => 5,
                'is_available' => true,
            ],
            [
                'name' => 'Yoga Mat',
                'description' => 'Non-slip yoga mat',
                'price' => 29.99,
                'stock_quantity' => 80,
                'category_id' => 5,
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        echo "Database seeded successfully!\n";
        echo "Test user credentials:\n";
        echo "Email: test@example.com\n";
        echo "Password: password123\n";
    }
}