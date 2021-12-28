<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        /*
        $customer = User::find(3);
        $products = Product::Active()->ActiveCategory()->hasQty()->inRandomOrder()->take(3)->get();
        $sub_total_value = $products->sum('price');
        $discount_value = $sub_total_value / 2;
        $shipping_value = 14.99;
        $tax_value = ($sub_total_value - $discount_value) * 0.15;
        $total_value = $sub_total_value - $discount_value + $shipping_value + $tax_value;

        //Create Order
        $order = $customer->orders()->create([
            'ref_id' => 'ORD-' . Str::random(15),
            'user_address_id' => $customer->addresses()->first()->id,
            'shipping_company_id' => 1,
            'payment_method_id' => 1,
            'sub_total' => $sub_total_value,
            'discount_code' => 'FiftyFifty',
            'discount' => $discount_value,
            'shipping' => $shipping_value,
            'tax' => $tax_value,
            'total' => $tax_value,
            'order_status' => Order::PAYMENT_COMPLETED,
        ]);

        $order->products()->attach($products->pluck('id')->toArray());
        $order->transactions()->createMany([
            [
                'transaction' => Order::NEW_ORDER
            ],
            [
                'transaction' => Order::PAYMENT_COMPLETED,
                'transaction_no' => Str::random(15),
                'payment_result' => 'success',
            ],
        ]);

*/
        User::withRole('customer')->whereHas( 'addresses' )->each(function ($customer) use ($faker) {
            foreach (range(3, 6) as $index) {
                $products = Product::Active()->ActiveCategory()->hasQty()->inRandomOrder()->take(3)->get();
                $sub_total_value = $products->sum('price');
                $discount_value = $sub_total_value / 2;
                $shipping_value = 14.99;
                $tax_value = ($sub_total_value - $discount_value) * 0.15;
                $total_value = $sub_total_value - $discount_value + $shipping_value + $tax_value;
                $order_status = rand(0, 8);
                //Create Order
                $order = $customer->orders()->create([
                    'ref_id' => 'ORD-' . Str::random(15),
                    'user_address_id' => $customer->addresses()->first()->id,
                    'shipping_company_id' => 1,
                    'payment_method_id' => 1,
                    'sub_total' => $sub_total_value,
                    'discount_code' => 'FiftyFifty',
                    'discount' => $discount_value,
                    'shipping' => $shipping_value,
                    'tax' => $tax_value,
                    'total' => $tax_value,
                    'order_status' => $order_status,
                    'created_at' => $faker->dateTimeBetween('-1 year', now()),
                    'updated_at' => $faker->dateTimeBetween('-1 year', now()),
                ]);

                $order->products()->attach($products->pluck('id')->toArray());
                $order->transactions()->createMany([
                    [
                        'transaction' => Order::NEW_ORDER
                    ],
                    [
                        'transaction' => Order::PAYMENT_COMPLETED,
                        'transaction_no' => $order_status,
                        'payment_result' => 'success',
                    ],
                ]);
            }
        });
    }
}
