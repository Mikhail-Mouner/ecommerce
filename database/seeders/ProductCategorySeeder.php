<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories_data = [
            [
                'name' => 'Clothes',
                'cover' => 'clothes.jpg',
                'status' => TRUE,
                'childes' => [
                    [
                        'name' => 'Women\'s T-shirts',
                        'cover' => 'clothes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Men\'s T-shirts',
                        'cover' => 'clothes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Dresses',
                        'cover' => 'clothes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Novelty socks',
                        'cover' => 'clothes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Women\'s sunglasses',
                        'cover' => 'clothes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Men\'s sunglasses',
                        'cover' => 'clothes.jpg',
                        'status' => TRUE,
                    ],
                ],
            ],
            [
                'name' => 'Shoes',
                'cover' => 'shoes.jpg',
                'status' => TRUE,
                'childes' => [
                    [
                        'name' => 'Women\'s Shoes',
                        'cover' => 'shoes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Men\'s Shoes',
                        'cover' => 'shoes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Boy\'s Shoes',
                        'cover' => 'shoes.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Girl\'s Shoes',
                        'cover' => 'shoes.jpg',
                        'status' => TRUE,
                    ],
                ],
            ],
            [
                'name' => 'Watches',
                'cover' => 'watches.jpg',
                'status' => TRUE,
                'childes' => [
                    [
                        'name' => 'Women\'s Watches',
                        'cover' => 'watches.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Men\'s Watches',
                        'cover' => 'watches.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Boy\'s Watches',
                        'cover' => 'watches.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Girl\'s Watches',
                        'cover' => 'watches.jpg',
                        'status' => TRUE,
                    ],
                ],
            ],
            [
                'name' => 'Electronics',
                'cover' => 'electronics.jpg',
                'status' => TRUE,
                'childes' => [
                    [
                        'name' => 'Electronics',
                        'cover' => 'electronics.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'USB Flash Driver',
                        'cover' => 'electronics.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Headphones',
                        'cover' => 'electronics.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Speakers',
                        'cover' => 'electronics.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Mobiles',
                        'cover' => 'electronics.jpg',
                        'status' => TRUE,
                    ],
                    [
                        'name' => 'Keyboards',
                        'cover' => 'electronics.jpg',
                        'status' => TRUE,
                    ],
                ],
            ],
        ];

        foreach ($categories_data as $category_data) {
            $parent_id = ProductCategory::create( Arr::except( $category_data, 'childes' ) );
            foreach ($category_data['childes'] as $child_data) {
                $child = ProductCategory::create( $child_data );
                $child->parent_id = $parent_id->id;
                $child->save();
            }
        }

    }

}
