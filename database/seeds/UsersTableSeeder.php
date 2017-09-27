<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 27/09/2017
 * Time: 09:58
 */

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = factory( User::class )->create( [
            'name'     => 'Administrator',
            'email'    => 'silva.diogo1990@gmail.com',
            'password' => password_hash( 'this_is_my_api', PASSWORD_BCRYPT ),
        ] );
    }
}