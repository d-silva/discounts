<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
	        $table->integer('id')->unsigned();
	        $table->primary('id');
	        $table->integer('customer_id', false, true);
	        $table->foreign('customer_id')->references('id')->on('customers');
	        $table->decimal('total', 8,2);
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
	    Schema::dropIfExists('orders');
	    \Illuminate\Support\Facades\DB::statement("SET foreign_key_checks = 1");
    }
}
