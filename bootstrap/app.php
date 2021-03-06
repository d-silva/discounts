<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    ( new Dotenv\Dotenv( __DIR__ . '/../' ) )->load();
} catch ( Dotenv\Exception\InvalidPathException $e ) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath( __DIR__ . '/../' )
);

$app->withFacades(); // Static interface to classes in the application's service containers
$app->withEloquent(); // ORM

// config files
$app->configure( 'app' );
$app->configure( 'database' );
$app->configure( 'auth' );
$app->configure( 'secrets' );
/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Cookie\QueueingFactory::class,
    'cookie'
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->middleware( [
    Illuminate\Cookie\Middleware\EncryptCookies::class,
    Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
] );

$app->routeMiddleware( [
    'auth'     => \App\Http\Middleware\Authenticate::class,
    'customer' => \App\Http\Middleware\CustomerRequestValidator::class,
    'product'  => \App\Http\Middleware\ProductRequestValidator::class,
    'order'    => \App\Http\Middleware\OrderRequestValidator::class,
] );

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register( App\Providers\AuthServiceProvider::class );
$app->register( App\Providers\AppServiceProvider::class );
$app->register( Illuminate\Cookie\CookieServiceProvider::class );
$app->register( Laravel\Passport\PassportServiceProvider::class );
$app->register( Dusterio\LumenPassport\PassportServiceProvider::class );

/*
$LaravelPassportClass = Laravel\Passport\PassportServiceProvider::class;
$LumenPassportClass   = Dusterio\LumenPassport\PassportServiceProvider::class;
if ( class_exists( $LaravelPassportClass ) && class_exists( $LumenPassportClass ) ) {

    $app->register( $LaravelPassportClass );
    $app->register( $LumenPassportClass );

// register routes

}*/


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

Dusterio\LumenPassport\LumenPassport::routes( $app );

$app->router->group( [
    'namespace' => 'App\Http\Controllers',
],
    function ( $router ) {
        require __DIR__ . '/../routes/web.php';
    } );

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
$app->router->group( [
    'namespace' => 'App\Http\Controllers',
],
    function ( $router ) {
        require __DIR__ . '/../routes/api.php';
    } );


return $app;
