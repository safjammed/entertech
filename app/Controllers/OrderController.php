<?php

namespace App\Controllers;

use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Template;
use Rakit\Validation\Validator;


class OrderController extends DefaultController
{
    public function orders_page()
    {
        $order = new Order();
        return Template::view("admin.orders", ['orders' => $order->allWithRelatedData()]);
    }
}