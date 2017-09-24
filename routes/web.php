<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get( '/',
    function () use ( $router ) {
        return $router->app->version();
    } );

$router->group( [ 'prefix' => 'discounts/v1' ],
    function ( $router ) {

        //Customer routes
        $router->group( [ 'prefix' => 'customer', 'middleware' => 'customer' ],
            function ( $router ) {
                $router->get( '', 'CustomerController@show' );
                $router->get( '/{id}', 'CustomerController@show' );
                $router->post( '', 'CustomerController@store' );
                $router->put( '', 'CustomerController@update' );
                $router->delete( '{id}', 'CustomerController@delete' );
            }
        );

        //product routes
        $router->group( [ 'prefix' => 'product', 'middleware' => 'product' ],
            function ( $router ) {
                $router->get( '', 'ProductController@show' );
                $router->get( '/{id}', 'ProductController@show' );
                $router->post( '', 'ProductController@store' );
                $router->put( '', 'ProductController@update' );
                $router->delete( '{id}', 'ProductController@delete' );
            }
        );

        //order routes
        $router->group( [ 'prefix' => 'order', 'middleware' => 'order' ],
            function ( $router ) {
                $router->get( '', 'OrderController@show' );
                $router->get( '/{id}', 'OrderController@show' );
                $router->post( '', 'OrderController@store' );
            }
        );

    } );

