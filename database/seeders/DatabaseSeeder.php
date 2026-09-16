<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@zenscafe.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        // Create staff user
        User::create([
            'name' => 'Staff',
            'email' => 'staff@zenscafe.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Staff,
            'email_verified_at' => now(),
        ]);

        // Create categories
        $categories = collect([
            ['name' => 'Coffee Beans', 'slug' => 'coffee-beans', 'description' => 'Various coffee beans for brewing'],
            ['name' => 'Tea', 'slug' => 'tea', 'description' => 'Tea leaves and tea bags'],
            ['name' => 'Milk & Cream', 'slug' => 'milk-cream', 'description' => 'Dairy products for coffee and tea'],
            ['name' => 'Syrups & Flavors', 'slug' => 'syrups-flavors', 'description' => 'Flavoring syrups and additives'],
            ['name' => 'Pastries', 'slug' => 'pastries', 'description' => 'Fresh baked goods'],
            ['name' => 'Supplies', 'slug' => 'supplies', 'description' => 'Cups, lids, napkins, and other supplies'],
            ['name' => 'Equipment', 'slug' => 'equipment', 'description' => 'Cafe equipment and maintenance items'],
        ])->map(fn ($cat) => Category::create($cat)->id);

        // Create suppliers
        $suppliers = collect([
            ['name' => 'Premium Roasters Co.', 'slug' => 'premium-roasters-co', 'contact_person' => 'John Smith', 'email' => 'contact@premiumroasters.com', 'phone' => '555-0101', 'address' => '123 Bean Street, Coffee City'],
            ['name' => 'Fresh Dairy Farm', 'slug' => 'fresh-dairy-farm', 'contact_person' => 'Jane Doe', 'email' => 'orders@freshdairy.com', 'phone' => '555-0102', 'address' => '456 Farm Road, Milkville'],
            ['name' => 'Sweet Supplies Inc.', 'slug' => 'sweet-supplies-inc', 'contact_person' => 'Mike Johnson', 'email' => 'sales@sweetsupplies.com', 'phone' => '555-0103', 'address' => '789 Syrup Ave, Flavor Town'],
            ['name' => 'Paper Goods Ltd.', 'slug' => 'paper-goods-ltd', 'contact_person' => 'Sarah Wilson', 'email' => 'info@papergoods.com', 'phone' => '555-0104', 'address' => '321 Paper Lane, Supply City'],
            ['name' => 'Local Bakery', 'slug' => 'local-bakery', 'contact_person' => 'Tom Baker', 'email' => 'hello@localbakery.com', 'phone' => '555-0105', 'address' => '654 Baker Street, Pastry Town'],
        ])->map(fn ($supplier) => Supplier::create($supplier)->id);

        // Create products
        Product::insert([
            ['name' => 'Arabica Beans', 'slug' => 'arabica-beans', 'sku' => 'CF-BEAN-001', 'category_id' => $categories[0], 'supplier_id' => $suppliers[0], 'unit' => 'kg', 'quantity' => 45, 'min_stock' => 10, 'max_stock' => 100, 'cost_per_unit' => 12.50, 'status' => 'active', 'description' => 'Premium Arabica coffee beans', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Robusta Beans', 'slug' => 'robusta-beans', 'sku' => 'CF-BEAN-002', 'category_id' => $categories[0], 'supplier_id' => $suppliers[0], 'unit' => 'kg', 'quantity' => 30, 'min_stock' => 10, 'max_stock' => 80, 'cost_per_unit' => 8.75, 'status' => 'active', 'description' => 'Strong Robusta coffee beans', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Green Tea Leaves', 'slug' => 'green-tea-leaves', 'sku' => 'CF-TEA-001', 'category_id' => $categories[1], 'supplier_id' => $suppliers[0], 'unit' => 'kg', 'quantity' => 15, 'min_stock' => 5, 'max_stock' => 50, 'cost_per_unit' => 10.00, 'status' => 'active', 'description' => 'Premium green tea leaves', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Whole Milk', 'slug' => 'whole-milk', 'sku' => 'CF-MLK-001', 'category_id' => $categories[2], 'supplier_id' => $suppliers[1], 'unit' => 'L', 'quantity' => 20, 'min_stock' => 10, 'max_stock' => 50, 'cost_per_unit' => 2.50, 'status' => 'active', 'description' => 'Fresh whole milk', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vanilla Syrup', 'slug' => 'vanilla-syrup', 'sku' => 'CF-SYR-001', 'category_id' => $categories[3], 'supplier_id' => $suppliers[2], 'unit' => 'L', 'quantity' => 8, 'min_stock' => 5, 'max_stock' => 30, 'cost_per_unit' => 6.00, 'status' => 'active', 'description' => 'Classic vanilla flavoring syrup', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Caramel Syrup', 'slug' => 'caramel-syrup', 'sku' => 'CF-SYR-002', 'category_id' => $categories[3], 'supplier_id' => $suppliers[2], 'unit' => 'L', 'quantity' => 3, 'min_stock' => 5, 'max_stock' => 30, 'cost_per_unit' => 6.50, 'status' => 'active', 'description' => 'Rich caramel flavoring syrup', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Croissants', 'slug' => 'croissants', 'sku' => 'CF-PST-001', 'category_id' => $categories[4], 'supplier_id' => $suppliers[4], 'unit' => 'pcs', 'quantity' => 24, 'min_stock' => 10, 'max_stock' => 50, 'cost_per_unit' => 1.50, 'status' => 'active', 'description' => 'Fresh butter croissants', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blueberry Muffins', 'slug' => 'blueberry-muffins', 'sku' => 'CF-PST-002', 'category_id' => $categories[4], 'supplier_id' => $suppliers[4], 'unit' => 'pcs', 'quantity' => 0, 'min_stock' => 10, 'max_stock' => 40, 'cost_per_unit' => 2.00, 'status' => 'active', 'description' => 'Fresh blueberry muffins', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paper Cups (12oz)', 'slug' => 'paper-cups-12oz', 'sku' => 'CF-SUP-001', 'category_id' => $categories[5], 'supplier_id' => $suppliers[3], 'unit' => 'pcs', 'quantity' => 500, 'min_stock' => 100, 'max_stock' => 2000, 'cost_per_unit' => 0.10, 'status' => 'active', 'description' => 'Disposable paper cups 12oz', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cup Lids', 'slug' => 'cup-lids', 'sku' => 'CF-SUP-002', 'category_id' => $categories[5], 'supplier_id' => $suppliers[3], 'unit' => 'pcs', 'quantity' => 450, 'min_stock' => 100, 'max_stock' => 2000, 'cost_per_unit' => 0.05, 'status' => 'active', 'description' => 'Plastic cup lids for 12oz cups', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
