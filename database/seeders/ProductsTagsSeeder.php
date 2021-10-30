<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductsTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags_id = Tag::whereStatus( TRUE )->pluck( 'id' )->toArray();
        Product::all()->each( function ($product) use ($tags_id) {
            $product->tags()->attach( Arr::random( $tags_id, rand( 2, 3 ) ) );
        } );
    }

}
