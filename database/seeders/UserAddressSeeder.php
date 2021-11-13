<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        User::withRole( 'customer' )->each( function ($user) use ($faker) {
            for ($i = 0; $i < 2; $i++) {
                $country = Country::whereStatus( TRUE )->whereHas( 'states' )->inRandomOrder()->first();
                $state = State::whereHas( 'cities' )->inRandomOrder()->first();
                $city = $state->cities->random();
                $user->addresses()->create(
                    [
                        'address_title' => $faker->randomElement( [ 'Home', 'Office' ] ),
                        'default_address' => $faker->boolean(),
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'mobile' => $user->phone,
                        'address' => $faker->address,
                        'address2' => $faker->address,
                        'country_id' => $country->id,
                        'state_id' => $state->id,
                        'city_id' => $city->id,
                        'zip_code' => $faker->randomNumber( 5 ),
                        'po_box' => $faker->randomNumber( 4 ),
                    ]
                );
            }
        } );


    }

}
