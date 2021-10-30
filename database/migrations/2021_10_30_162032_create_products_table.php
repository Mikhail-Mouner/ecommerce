<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'products', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'slug' )->unique();
            $table->text( 'description' )->nullable();
            $table->double( 'price' );
            $table->unsignedBigInteger( 'qty' )->default( 0 );
            $table->foreignId( 'product_category_id' )->constrained()->cascadeOnDelete();
            $table->boolean( 'featured' )->default( FALSE );
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
        Schema::dropIfExists( 'products' );
    }

}
