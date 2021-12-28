<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::withRole( 'customer' )->inRandomOrder()->first();
        
        $country = Country::whereStatus( TRUE )->whereHas( 'states' )->inRandomOrder()->first();
        $state = $country->states->random()->first();
        $city = $state->cities->random();

        return [
            'address_title' => $this->faker->randomElement( [ 'Home', 'Work', 'Family House', 'Office' ] ),
            'default_address' => $this->faker->boolean(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'mobile' => $user->phone,
            'address' => $this->faker->streetAddress,
            'address2' => $this->faker->address,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'zip_code' => $this->faker->randomNumber( 5 ),
            'po_box' => $this->faker->randomNumber( 4 ),
        ];
    }
}
