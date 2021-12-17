<?php
namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;

class MustAuth implements IMiddleware
{
    public function handle(Request $request) : void
    {
        $request->authenticated =  $_SESSION['logged_in'];
        //check admin
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ){
            //redirect to home
            Router::response()->redirect("/");
        }
    }

}