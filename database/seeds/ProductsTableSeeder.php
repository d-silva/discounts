<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 21:25
 */

use \Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder {

	public function run() {
		Product::create( [
			"id"          => "A101",
			"description" => "Screwdriver",
			"category"    => "1",
			"price"       => "9.75"
		] );

		Product::create( [
			"id"          => "A102",
			"description" => "Electric screwdriver",
			"category"    => "1",
			"price"       => "49.50"
		] );

		Product::create( [
			"id"          => "B101",
			"description" => "Basic on-off switch",
			"category"    => "2",
			"price"       => "4.99"
		] );

		Product::create( [
			"id"          => "B102",
			"description" => "Press button",
			"category"    => "2",
			"price"       => "4.99"
		] );

		Product::create( [
			"id"          => "B103",
			"description" => "Switch with motion detector",
			"category"    => "2",
			"price"       => "12.95"
		] );
	}
}