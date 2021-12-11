<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create( [
            'name' => 'PayPal',
            'code' => 'PPEX',
            'driver_name' => 'PayPal_Express',
            'merchant_email' => NULL,
            'username' => NULL,
            'password' => NULL,
            'secret' => NULL,
            'sandbox_username' => NULL,
            'sandbox_password' => NULL,
            'sandbox_secret' => NULL,
            'sandbox' => TRUE,
            'status' => TRUE,
        ] );
    }

}
