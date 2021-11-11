<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $password = Hash::make( '123456' );

        /** Seed User with His Roles  **/
        $roles_data = [
            [
                'name' => 'admin',
                'display_name' => 'Administration',
                'description' => 'Administration',
                'allowed_route' => 'admin',
            ], [
                'name' => 'supervisor',
                'display_name' => 'Supervisor',
                'description' => 'Supervisor',
                'allowed_route' => 'admin',
            ], [
                'name' => 'customer',
                'display_name' => 'Customer',
                'description' => 'Customer',
                'allowed_route' => NULL,
            ],
        ];
        $users_data = [
            [
                'username' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'System',
                'email' => 'admin@ecommerce.de',
                'email_verified_at' => now(),
                'phone' => $faker->phoneNumber,
                'status' => 1,
                'password' => $password,
                'remember_token' => Str::random( 10 ),
            ],
            [
                'username' => 'supervisor',
                'first_name' => 'Supervisor',
                'last_name' => 'System',
                'email' => 'supervisor@ecommerce.de',
                'email_verified_at' => now(),
                'phone' => $faker->phoneNumber,
                'status' => 1,
                'password' => $password,
                'remember_token' => Str::random( 10 ),
            ],
            [
                'username' => 'customer',
                'first_name' => 'Customer',
                'last_name' => 'System',
                'email' => 'customer@ecommerce.de',
                'email_verified_at' => now(),
                'phone' => $faker->phoneNumber,
                'status' => 1,
                'password' => $password,
                'remember_token' => Str::random( 10 ),
            ],
        ];
        foreach ($users_data as $index => $user_data) {
            $user = User::create( $user_data );
            $role = Role::create( $roles_data[$index] );
            $user->attachRole( $role );
        }
        for ($i = 0; $i < 10; $i++) {
            $user = User::create( [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->userName,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'phone' => $faker->phoneNumber,
                'status' => 1,
                'password' => $password,
                'remember_token' => Str::random( 10 ),
            ] );
            $user->attachRole( $role );
        }

        /** Seed Permission  **/
        $permissions_data = [
            [
                'name' => 'main',
                'display_name' => 'Main',
                'route' => 'index',
                'module' => 'index',
                'as' => 'index',
                'icon' => 'fa fa-home',
                'parent' => '0',
                'parent_original' => '0',
                'sidebar_link' => '1',
                'appear' => '1',
                'ordering' => '1',
                'childes' => [],
            ],
            [
                'name' => 'manage_product_categories',
                'display_name' => 'Categories',
                'route' => 'product_categories',
                'module' => 'product_categories',
                'as' => 'product_categories.index',
                'icon' => 'fa fa-archive',
                'parent' => '0',
                'parent_original' => '0',
                'sidebar_link' => '1',
                'appear' => '1',
                'ordering' => '5',
                'childes' => [
                    [
                        'name' => 'list_product_categories',
                        'display_name' => 'Categories',
                        'route' => 'product_categories',
                        'module' => 'product_categories',
                        'as' => 'product_categories.index',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '1',
                    ],
                    [
                        'name' => 'create_product_categories',
                        'display_name' => 'Create Category',
                        'route' => 'product_categories',
                        'module' => 'product_categories',
                        'as' => 'product_categories.create',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'display_product_categories',
                        'display_name' => 'Show Category',
                        'route' => 'product_categories',
                        'module' => 'product_categories',
                        'as' => 'product_categories.show',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'update_product_categories',
                        'display_name' => 'Update Category',
                        'route' => 'product_categories',
                        'module' => 'product_categories',
                        'as' => 'product_categories.edit',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'delete_product_categories',
                        'display_name' => 'Delete Category',
                        'route' => 'product_categories',
                        'module' => 'product_categories',
                        'as' => 'product_categories.destroy',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],

                ],
            ],
            [
                'name' => 'manage_product',
                'display_name' => 'Products',
                'route' => 'product',
                'module' => 'product',
                'as' => 'product.index',
                'icon' => 'fa fa-file-archive',
                'parent' => '0',
                'parent_original' => '0',
                'sidebar_link' => '1',
                'appear' => '1',
                'ordering' => '2',
                'childes' => [
                    [
                        'name' => 'list_product',
                        'display_name' => 'Products',
                        'route' => 'product',
                        'module' => 'product',
                        'as' => 'product.index',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '1',
                    ],
                    [
                        'name' => 'create_product',
                        'display_name' => 'Create Product',
                        'route' => 'product',
                        'module' => 'product',
                        'as' => 'product.create',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'display_product',
                        'display_name' => 'Show Product',
                        'route' => 'product',
                        'module' => 'product',
                        'as' => 'product.show',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'update_product',
                        'display_name' => 'Update Product',
                        'route' => 'product',
                        'module' => 'product',
                        'as' => 'product.edit',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'delete_product',
                        'display_name' => 'Delete Product',
                        'route' => 'product',
                        'module' => 'product',
                        'as' => 'product.destroy',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],

                ],
            ],
            [
                'name' => 'manage_tags',
                'display_name' => 'Tags',
                'route' => 'tags',
                'module' => 'tags',
                'as' => 'tag.index',
                'icon' => 'fa fa-tags',
                'parent' => '0',
                'parent_original' => '0',
                'sidebar_link' => '1',
                'appear' => '1',
                'ordering' => '5',
                'childes' => [
                    [
                        'name' => 'list_tags',
                        'display_name' => 'Tags',
                        'route' => 'tags',
                        'module' => 'tags',
                        'as' => 'tag.index',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '1',
                    ],
                    [
                        'name' => 'create_tags',
                        'display_name' => 'Create Tag',
                        'route' => 'tags',
                        'module' => 'tags',
                        'as' => 'tag.create',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'display_tags',
                        'display_name' => 'Show Tag',
                        'route' => 'tags',
                        'module' => 'tags',
                        'as' => 'tag.show',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'update_tags',
                        'display_name' => 'Update Tag',
                        'route' => 'tags',
                        'module' => 'tags',
                        'as' => 'tag.edit',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'delete_tags',
                        'display_name' => 'Delete Tag',
                        'route' => 'tags',
                        'module' => 'tags',
                        'as' => 'tag.destroy',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                ],
            ],
            [
                'name' => 'manage_product_coupons',
                'display_name' => 'Coupons',
                'route' => 'product_coupon',
                'module' => 'product_coupons',
                'as' => 'product_coupons.index',
                'icon' => 'fa fa-percent',
                'parent' => '0',
                'parent_original' => '0',
                'sidebar_link' => '1',
                'appear' => '1',
                'ordering' => '5',
                'childes' => [
                    [
                        'name' => 'list_product_coupons',
                        'display_name' => 'Coupons',
                        'route' => 'product_coupon',
                        'module' => 'product_coupons',
                        'as' => 'product_coupons.index',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '1',
                    ],
                    [
                        'name' => 'create_product_coupons',
                        'display_name' => 'Create Coupon',
                        'route' => 'product_coupon',
                        'module' => 'product_coupons',
                        'as' => 'product_coupons.create',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'display_product_coupons',
                        'display_name' => 'Show Coupon',
                        'route' => 'product_coupon',
                        'module' => 'product_coupons',
                        'as' => 'product_coupons.show',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'update_product_coupons',
                        'display_name' => 'Update Coupon',
                        'route' => 'product_coupon',
                        'module' => 'product_coupons',
                        'as' => 'product_coupons.edit',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'delete_product_coupons',
                        'display_name' => 'Delete Coupon',
                        'route' => 'product_coupon',
                        'module' => 'product_coupons',
                        'as' => 'product_coupons.destroy',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],

                ],
            ],
            [
                'name' => 'manage_product_reviews',
                'display_name' => 'Reviews',
                'route' => 'product_review',
                'module' => 'product_reviews',
                'as' => 'product_reviews.index',
                'icon' => 'fa fa-comments',
                'parent' => '0',
                'parent_original' => '0',
                'sidebar_link' => '1',
                'appear' => '1',
                'ordering' => '5',
                'childes' => [
                    [
                        'name' => 'list_product_reviews',
                        'display_name' => 'Reviews',
                        'route' => 'product_review',
                        'module' => 'product_reviews',
                        'as' => 'product_reviews.index',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '1',
                    ],
                    [
                        'name' => 'create_product_reviews',
                        'display_name' => 'Create Review',
                        'route' => 'product_review',
                        'module' => 'product_reviews',
                        'as' => 'product_reviews.create',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'display_product_reviews',
                        'display_name' => 'Show Review',
                        'route' => 'product_review',
                        'module' => 'product_reviews',
                        'as' => 'product_reviews.show',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'update_product_reviews',
                        'display_name' => 'Update Review',
                        'route' => 'product_review',
                        'module' => 'product_reviews',
                        'as' => 'product_reviews.edit',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],
                    [
                        'name' => 'delete_product_reviews',
                        'display_name' => 'Delete Review',
                        'route' => 'product_review',
                        'module' => 'product_reviews',
                        'as' => 'product_reviews.destroy',
                        'icon' => NULL,
                        'parent' => '0',
                        'parent_original' => '0',
                        'parent_show' => '0',
                        'sidebar_link' => '1',
                        'appear' => '0',
                    ],

                ],
            ],

        ];
        foreach ($permissions_data as $permission_data) {
            $permission = Permission::create( Arr::except( $permission_data, 'childes' ) );
            $permission->parent_show = $permission->id;
            $permission->save();
            foreach ($permission_data['childes'] as $child_data) {
                $child = Permission::create( $child_data );
                $child->parent = $permission->id;
                $child->parent_original = $permission->id;
                $child->parent_show = $permission->id;
                $child->save();
            }
        }

    }

}
