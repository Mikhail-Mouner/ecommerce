<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags_data = [
            [
                'name' => 'Clothes',
                'slug' => Str::slug('Clothes'),
                'status' => TRUE,
            ],
            [
                'name' => 'Shoes',
                'slug' => Str::slug('Shoes'),
                'status' => TRUE,
            ],
            [
                'name' => 'Watches',
                'slug' => Str::slug('Watches'),
                'status' => TRUE,
            ],
            [
                'name' => 'Electronics',
                'slug' => Str::slug('Electronics'),
                'status' => TRUE,
            ],
            [
                'name' => 'Men',
                'slug' => Str::slug('Men'),
                'status' => TRUE,
            ],
            [
                'name' => 'Women',
                'slug' => Str::slug('Women'),
                'status' => TRUE,
            ],
            [
                'name' => 'Boys',
                'slug' => Str::slug('Boys'),
                'status' => TRUE,
            ],
            [
                'name' => 'Girls',
                'slug' => Str::slug('Girls'),
                'status' => TRUE,
            ],
        ];
        Tag::insert( $tags_data );
    }

}
