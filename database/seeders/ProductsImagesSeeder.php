<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\True_;

class ProductsImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images_data = array();
        for ($i = 1; $i < 9; $i++) {
            $images_data[] = [
                'file_name' => "0{$i}.jpg",
                'file_type' => 'image/jpg',
                'file_size' => rand( 100, 900 ),
                'file_status' => TRUE,
                'file_sort' => 0,
            ];
        }
        Product::all()->each( function ($product) use ($images_data) {
            $product->media()->createMany( Arr::random( $images_data, rand( 2, 3 ) ) );
        } );
    }

}
