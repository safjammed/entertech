<?php
namespace App\Controllers;

use App\Template;

class DefaultController
{
	public function home()
	{
		// implement
        try {
            return Template::view("customer.main", []);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
	}
}