<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
        	$table->integer('order_id')->unsigned();
	        $table->foreign('order_id')->references('id')->on('orders');
	        $table->string('product_id');
	        $table->foreign('product_id')->references('id')->on('products');
	        $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    \Illuminate\Support\Facades\DB::statement("SET foreign_key_checks = 0");
        Schema::dropIfExists('items');
	    \Illuminate\Support\Facades\DB::statement("SET foreign_key_checks = 1");

    }
}
