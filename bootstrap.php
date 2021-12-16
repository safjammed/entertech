<?php
/**
 * This file bootstraps the application
 */

// include the configuration from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
//INIT THE DATABASE
include_once __DIR__."/resource/database.php";
$database = new db();
$db = $database->connect();

// Error reporting if state is development
if (getenv('APP_STATE') == 'development' && getenv('APP_STATE') != 'production'){
    error_reporting(3);
}else{
    error_reporting(0);
}


// Start the routing
\App\Router::start();
//set header to always show JSON
//header("Content-Type:application/json");

