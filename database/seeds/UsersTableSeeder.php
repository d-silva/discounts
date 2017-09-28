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
            'email'    => env( 'ADMIN_EMAIL' ),
            'password' => password_hash( env( 'ADMIN_PASSWORD' ),
                PASSWORD_BCRYPT ),
        ] );
    }
}