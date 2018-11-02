<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty all tables before seeding
        DB::Statement('SET FOREIGN_KEY_CHECKS = 0'); //
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate(); // this table has no model

        //Set of numbers of records to generate
       $user_quantity = 200;
       $category_quantity = 30;
       $product_quantity = 1000;
       $transaction_quantity = 1000;

       factory(User::class, $user_quantity)->create();
       factory(Category::class, $category_quantity)->create();
        factory(Product::class, $product_quantity)->create()->each(
        // get each product, assign 5 categories to product
            function($product){
                $categories = Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            });
       factory(Transaction::class, $transaction_quantity)->create();


    }
}
