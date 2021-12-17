<?php

namespace App\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Template;
use Rakit\Validation\Validator;


class AuthController extends DefaultController
{
    public function login_page(){
        if ($_SESSION['logged_in']) $this->redirect("/");
        return Template::view("auth.login");
    }
    public function register_page(){
        if ($_SESSION['logged_in']) $this->redirect("/");

        $locations = Location::all();
        return Template::view("auth.register", [
            'locations' => $locations
        ]);
    }
    public function register()
    {
        $validation = $this->validator->validate($this->input()->all(), [
            'name' => "max:120|required",
            'email' => "email|required",
            "password" => "required",
            "password_confirmation" => "required|same:password",
            'location_id' => "required|integer"
        ]);

        if($validation->fails()){
            $this->err('/register', $validation->errors()->all());
        }

        //validation passed
        try {
            $user = User::create(array_merge($this->input()->all(['name', 'email', 'location_id']), [
                'password' => password_hash($this->input()->get('password'), PASSWORD_DEFAULT)
            ]));
        }catch (\Exception $exception){
            $this->err("/register", $exception->getMessage());
        }
        $this->success("/register", "User has been created!");
    }
    public function login()
    {

        $this->validateRequest('/login', [
            'email' => "email|required",
            'password' => 'required'
        ]);

        $model = new User();
        $user = $model->getByEmail($_POST['email']);
//        die(var_dump($user));
        if (!$user)
            $this->err("/login","User not found");

        if (password_verify($this->input()->get("password"), $user['password'])){
            $_SESSION['id'] = $user['id'];
            $_SESSION['user'] = array_filter($user, ( fn($value, $key) => $key !== 'password' ), ARRAY_FILTER_USE_BOTH); //hide password
            $_SESSION['logged_in'] = true;
            $this->redirect("/");
        }
        $this->err("/login","Wrong credentials");

    }
    public function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['user']);
        unset($_SESSION['logged_in']);
        $this->redirect("/login");
    }
}