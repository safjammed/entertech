<?php
namespace App\Controllers;

use App\Models\User;
use App\Template;

class DefaultController
{
	public function home()
	{
		// implement
        try {
            $user = new User();
//            var_dump($user->getTable());
            return Template::view("customer.main", []);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
	}
}