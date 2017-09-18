<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('since');
            $table->decimal('revenue', 8,2);
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
	    Schema::dropIfExists('customers');
	    \Illuminate\Support\Facades\DB::statement("SET foreign_key_checks = 1");
    }
}
