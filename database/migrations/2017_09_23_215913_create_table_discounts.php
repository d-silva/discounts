<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDiscounts extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'discounts',
            function ( Blueprint $table ) {
                $table->increments( 'id' );
                $table->integer( 'order_id' )->unsigned();
                $table->foreign( 'order_id' )->references( 'id' )->on( 'orders' );
                $table->string( 'type' );
                $table->string( 'description' );
                $table->decimal( 'amount', 6, 2 );
            } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        \Illuminate\Support\Facades\DB::statement( "SET foreign_key_checks = 0" );
        Schema::dropIfExists( 'discounts' );
        \Illuminate\Support\Facades\DB::statement( "SET foreign_key_checks = 1" );

    }
}
