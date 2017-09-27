<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 27/09/2017
 * Time: 09:15
 */

/*
|--------------------------------------------------------------------------
| Discounts Api Routes
|--------------------------------------------------------------------------
*/

$router->group( [ 'prefix' => 'discounts/v1' ],
    function ( $router ) {

        //Customer routes
        $router->group( [ 'prefix' => 'customers', 'middleware' => 'customer' ],
            function ( $router ) {
                $router->get( '', 'CustomerController@show' );
                $router->get( '/{id}', 'CustomerController@show' );
                $router->post( '', 'CustomerController@store' );
                $router->put( '/{id}', 'CustomerController@update' );
                $router->delete( '{id}', 'CustomerController@delete' );
            }
        );

        //product routes
        $router->group( [ 'prefix' => 'products', 'middleware' => 'product' ],
            function ( $router ) {
                $router->get( '', 'ProductController@show' );
                $router->get( '/{id}', 'ProductController@show' );
                $router->post( '', 'ProductController@store' );
                $router->put( '/{id}', 'ProductController@update' );
                $router->delete( '{id}', 'ProductController@delete' );
            }
        );

        //order routes
        $router->group( [ 'prefix' => 'orders', 'middleware' => 'order' ],
            function ( $router ) {
                $router->get( '', 'OrderController@show' );
                $router->get( '/{id}', 'OrderController@show' );
                $router->post( '', 'OrderController@store' );
            }
        );

    } );

