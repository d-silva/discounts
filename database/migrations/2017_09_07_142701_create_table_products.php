<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->primary('id');
            $table->string('description');
            $table->integer('category');
            $table->decimal('price', 6,2);
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
	    Schema::dropIfExists('products');
	    \Illuminate\Support\Facades\DB::statement("SET foreign_key_checks = 1");

    }
}
