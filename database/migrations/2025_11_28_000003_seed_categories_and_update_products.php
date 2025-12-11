<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define default categories
        $categories = [
            [
                'name' => 'Velvet Flames',
                'slug' => 'hot',
                'description' => 'Warm indulgences to ignite your soul.',
                'display_order' => 1,
            ],
            [
                'name' => 'Frosted Allure',
                'slug' => 'cold',
                'description' => 'Chilled elixirs for a cool embrace.',
                'display_order' => 2,
            ],
            [
                'name' => 'Nectar Teas and Tonics',
                'slug' => 'non-coffee',
                'description' => 'Herbal infusions and non-caffeinated delights.',
                'display_order' => 3,
            ],
            [
                'name' => 'Scarlet Limited',
                'slug' => 'seasonal',
                'description' => 'Fleeting desires, available for a limited time.',
                'display_order' => 4,
            ],
        ];

        foreach ($categories as $catData) {
            Category::firstOrCreate(['slug' => $catData['slug']], $catData);
        }

        // Map existing products to categories
        $products = Product::whereNull('category_id')->get();
        foreach ($products as $product) {
            $slug = null;
            switch (strtolower($product->category)) {
                case 'hot':
                    $slug = 'hot';
                    break;
                case 'cold':
                    $slug = 'cold';
                    break;
                case 'tea':
                case 'nectar':
                case 'noncoffee':
                case 'non-coffee':
                    $slug = 'non-coffee';
                    break;
                case 'special':
                case 'seasonal':
                case 'seasonals':
                    $slug = 'seasonal';
                    break;
            }

            if ($slug) {
                $category = Category::where('slug', $slug)->first();
                if ($category) {
                    $product->category_id = $category->id;
                    $product->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to delete categories or reset category_id on rollback strictly speaking, 
        // but for completeness we could. However, since this is data migration, we usually leave it.
    }
};
