<?php
namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;

class AdminSecurity implements IMiddleware
{
    public function handle(Request $request) : void
    {
        $request->authenticated =  $_SESSION['logged_in'];
        //check admin
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['user']['role'] != 'admin'){
            //redirect to home
            Router::response()->redirect("/");
        }
    }

}