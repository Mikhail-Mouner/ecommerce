<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql_file = public_path( 'world.sql' );

        $db = [
            'username' => env( 'DB_USERNAME' ),
            'password' => env( 'DB_PASSWORD' ),
            'host' => env( 'DB_HOST' ),
            'database' => env( 'DB_DATABASE' ),
        ];

        //        exec("E:\\xampp\\mysql\\bin\\mysql.exe --user={$db['username']} --password={$db['password']} --host={$db['host']} --database={$db['database']} < $sql_file");
        exec( "E:\\xampp\\mysql\\bin\\mysql.exe --user=root --password= --host=127.0.0.1 --database=ecommerce < $sql_file" );

        Log::info( 'SQL Import Done' );
    }

}
