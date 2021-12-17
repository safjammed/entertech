<?php

namespace App\Controllers;

use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Template;
use Rakit\Validation\Validator;


class ProductsController extends DefaultController
{
    public function add_page(){
        return Template::view("admin.addProduct", ['locations' => Location::all()]);
    }
    public function add()
    {
        $validation = $this->validator->validate($this->input()->all(), [
            'name' => "required",
            'price' => "integer|required",
            'location_id' => "required|integer"
        ]);
        if($validation->fails()){
            $this->err('/admin/products/add', $validation->errors()->all());
        }
        Product::create($this->input()->all(['name', 'price', 'location_id', 'details']));
        $this->success("/admin/products", "Product added");
    }
    public function order_page($id){
        return Template::view("customer.checkout", ['product' => Product::find($id)]);
    }
    public function confirm_order($id){
        $product = Product::find($id);
        $location = Location::find($product['location_id']);
        $price = $product['price'];
        $eligible = $_SESSION['user']['location_id'] == $product['location_id'];
        $data = [
            'product_id' => $product['id'],
            'user_id' => $_SESSION['user']['id'],
            'charged' => $eligible ? $price - ($price * (intval($location['match_discount']) / 100)) : $price
        ];
        $order_id = Order::create($data);
        $this->success('/', "You have ordered ". $product['name']. ".Your order ID is :".$order_id);

    }
}