<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CustomersTableSeeder');
        $this->call('ProductsTableSeeder');
        $this->call( 'UsersTableSeeder' );
    }
}
