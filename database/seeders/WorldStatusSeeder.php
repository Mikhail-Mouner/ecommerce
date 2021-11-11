<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class WorldStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [ 'Egypt', 'United Arab Emirates', 'United Kingdom', 'United States', 'Canada' ];

        Country::whereHas( 'states' )
            ->whereIn( 'name', $countries )
            ->update( [ 'status' => TRUE ] );

        State::select( 'states.*' )
            ->whereHas( 'cities' )
            ->join( 'countries', 'countries.id', '=', 'states.country_id' )
            ->where( 'countries.status', 1 )
            ->update( [ 'states.status' => TRUE ] );

        City::select( 'cities.*' )
            ->join( 'states', 'states.id', '=', 'cities.state_id' )
            ->where( 'states.status', 1 )
            ->update( [ 'cities.status' => TRUE ] );
    }

}
