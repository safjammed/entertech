<?php
/**
 * This file contains all the routes for the project
 */

use App\Middlewares\AdminSecurity;
use App\Middlewares\ApiVerification;
use App\Middlewares\MessageClearer;
use App\Middlewares\MustAuth;
use App\Router;

//Router::csrfVerifier(new \Demo\Middlewares\CsrfVerifier());

Router::group(['namespace' => '\App\Controllers', 'middleware' => MessageClearer::class], function () {

	Router::get('/', 'DefaultController@home')->setName('home');
	Router::basic('/companies/{id?}', 'DefaultController@companies')->setName('companies');
    Router::get("/login", 'AuthController@login_page')->setName("login_page");
    Router::get("/register", 'AuthController@register_page')->setName("register_page");
    Router::post("/auth/register", 'AuthController@register')->setName("register");
    Router::post("/auth/login", 'AuthController@login')->setName("login");
    Router::get("/auth/logout", 'AuthController@logout')->setName("logout");

    Router::group(['prefix' => '/admin', 'middleware' => AdminSecurity::class], function () {
        Router::get("/", "AdminPageController@products_page");
        Router::group(['prefix' => '/orders'], function(){
            Router::get("/", "OrderController@orders_page");
            Router::get("/{id?}/{status?}", "OrderController@change_status");
        });
        Router::group(['prefix' => '/products'], function(){
            Router::get("/", "AdminPageController@products_page");
            Router::get("/add", "ProductsController@add_page");
            Router::post("/add", "ProductsController@add");
        });
    });
    Router::group(['middleware' => MustAuth::class], function () {
        Router::get('/buy/{id?}', "ProductsController@order_page");
        Router::post('/buy/{id?}', "ProductsController@confirm_order");
    });


    // API
	Router::group(['prefix' => '/api', 'middleware' => ApiVerification::class], function () {
		Router::resource('/demo', 'ApiController');
	});

    // CALLBACK EXAMPLES
    Router::get('/foo', function() {
        return 'foo';
    });

    Router::get('/foo-bar', function() {
        return 'foo-bar';
    });

});