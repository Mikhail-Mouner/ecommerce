<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'shipping_companies', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'code' )->unique();
            $table->string( 'description' )->unique();
            $table->boolean( 'fast' )->default( FALSE );
            $table->unsignedDecimal( 'cost' )->default( FALSE );
            $table->boolean( 'status' )->default( FALSE );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'shipping_companies' );
    }

}
