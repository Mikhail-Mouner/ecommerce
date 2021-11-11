<?php

namespace Database\Seeders;

use App\Models\ProductCoupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProductCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupons_data = [
            [
                'code' => "SAMI200",
                'type' => "fixed",
                'value' => 200,
                'description' => "Discount 200 SAR on your sale on website",
                'use_times' => 20,
                'start_date' => Carbon::now(),
                'expire_date' => Carbon::now()->addMonth(),
                'greater_than' => 600,
                'status' => TRUE,
            ],
            [
                'code' => "FiftyFifty",
                'type' => "percentage",
                'value' => 50,
                'description' => "Discount 50% on your sale on website",
                'use_times' => 5,
                'start_date' => Carbon::now(),
                'expire_date' => Carbon::now()->addWeek(),
                'greater_than' => NULL,
                'status' => TRUE,
            ],
        ];

        foreach ($coupons_data as $coupon) {
            ProductCoupon::create( $coupon );
        }
    }

}
