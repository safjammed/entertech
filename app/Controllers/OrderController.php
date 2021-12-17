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
        return Template::view("admin.orders", [
            'orders' => $order->allWithRelatedData(),
            "statuses" => Order::$statuses
        ]);
    }
    public function change_status($id, $status){
        $order = new Order();
        try {
            if ($order->set_status($id, $status))
                $this->success("/admin/orders", "Status of order #{$id} is now {$status}");
        } catch (\Exception $exception) {
            $this->err("/admin/orders", $exception->getMessage());
        }


        $this->err('/admin/orders', "Something went wrong");
    }
}