<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        $categories_id = ProductCategory::whereNotNull( 'parent_id' )->pluck( 'id' );
        $products_data = array();
        for ($i = 0; $i < 1000; $i++) {
            $products_data[] = [
                'name' => $faker->sentence( 2 ),
                'slug' => $faker->unique()->slug( 2 ),
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween( 5, 200 ),
                'qty' => $faker->numberBetween( 10, 100 ),
                'product_category_id' => $categories_id->random(),
                'featured' => rand( 0, 1 ),
                'status' => TRUE,
            ];
        }
        $chunks_data = array_chunk( $products_data, 100 );
        foreach ($chunks_data as $chunk) {
            Product::insert( $chunk );
        }
    }

}
