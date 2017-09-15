<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 21:19
 */

use Illuminate\Database\Seeder;
use App\Customer;

class CustomersTableSeeder extends Seeder {

	public function run() {
		Customer::create([
			"name"    => "Coca Cola",
            "since"   => "2014-06-28",
            "revenue" => "492.12"
		]);

		Customer::create([
			"name"    => "Teamleader",
			"since"   => "2015-01-15",
			"revenue" => "1505.95"
		]);

		Customer::create([
			"name"    => "Jeroen De Wit",
			"since"   =>  "2016-02-11",
			"revenue" => "0.00"
		]);
	}
}
