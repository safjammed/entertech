<?php

namespace App\Controllers;

use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use App\Template;
use Rakit\Validation\Validator;


class AdminPageController extends DefaultController
{
    public function products_page(){
        $product = new Product();
        return Template::view("admin.products", ['products' => $product->allWithLocation()]);
    }
}