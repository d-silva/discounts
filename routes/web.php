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
$router->get( '/', function () use ( $router ) {
	return $router->app->version();
} );

$router->group( [ 'prefix' => 'discounts/v1' ], function ( $router ) {
	//Customer routes
	$router->get( 'customer', 'CustomerController@index' );
	$router->post( 'customer', 'CustomerController@createCustomer' );
	$router->put( 'customer', 'CustomerController@updateCustomer' );
	$router->delete( 'customer', 'CustomerController@deleteCustomer' );

	//product routes
	$router->get( 'product', 'ProductController@index' );
	$router->post( 'product', 'ProductController@createProduct' );
	$router->put( 'product', 'ProductController@updateProduct' );
	$router->delete( 'product', 'ProductController@deleteProduct' );

	//order routes
	$router->get( 'order', 'OrderController@index' );
	$router->post( 'order', 'OrderController@createOrder' );
} );

