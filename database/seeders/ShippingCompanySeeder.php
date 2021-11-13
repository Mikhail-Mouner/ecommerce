<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\ShippingCompany;
use Illuminate\Database\Seeder;

class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shipping_data = [
            [
                'name' => 'Aramex Inside',
                'code' => 'ARA',
                'description' => '8 - 10 days',
                'fast' => FALSE,
                'cost' => '14.99',
                'status' => TRUE,
            ],
            [
                'name' => 'Aramex Inside Speed Shipping',
                'code' => 'ARA-SPD',
                'description' => '1 - 3 days',
                'fast' => TRUE,
                'cost' => '24.99',
                'status' => TRUE,
            ],
            [
                'name' => 'Aramex Outside',
                'code' => 'ARA-O',
                'description' => '10 - 20 days',
                'fast' => FALSE,
                'cost' => '49.99',
                'status' => TRUE,
            ],
            [
                'name' => 'Aramex Outside Speed Shipping',
                'code' => 'ARA-O-SPD',
                'description' => '5 - 10 days',
                'fast' => TRUE,
                'cost' => '79.99',
                'status' => TRUE,
            ],
        ];

        foreach ($shipping_data as $index => $data) {
            if ($index < 2) {
                $countries = [ 64 ];
            } else {
                    $countries = Country::whereStatus( TRUE )->where( 'id', '!=', 64 )->pluck( 'id' )->toArray();
            }

            $company = ShippingCompany::create( $data );
            $company->countries()->attach( $countries );
        }
    }

}
