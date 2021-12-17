<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Template;
use Pecee\Http\Request;
use Pecee\Http\Response;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Rakit\Validation\Validator;

class DefaultController
{
    protected Validator $validator;
    public function __construct()
    {
        $validator = new Validator();
        $this->validator = $validator;
    }

    public function home()
	{
		// implement
        try {
            return Template::view("customer.main", [
                'products' => Product::all()
            ]);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
	}
    function url(?string $name = null, $parameters = null, ?array $getParams = null): \Pecee\Http\Url
    {
        return Router::getUrl($name, $parameters, $getParams);
    }
    function err($url, $errors = [])
    {
        $_SESSION['errors'] = $errors;
        $this->redirect($url);
    }
    function success($url, $message = 'Done')
    {
        $_SESSION['success'] = $message;
        $this->redirect($url);
    }

    /**
     * @return \Pecee\Http\Response
     */
    function response(): Response
    {
        return Router::response();
    }

    /**
     * @return \Pecee\Http\Request
     */
    function request(): Request
    {
        return Router::request();
    }

    /**
     * Get input class
     * @param string|null $index Parameter index name
     * @param string|mixed|null $defaultValue Default return value
     * @param array ...$methods Default methods
     * @return \Pecee\Http\Input\InputHandler|array|string|null
     */
    function input($index = null, $defaultValue = null, ...$methods)
    {
        if ($index !== null) {
            return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
        }

        return request()->getInputHandler();
    }

    /**
     * @param string $url
     * @param int|null $code
     */
    function redirect(string $url, ?int $code = null): void
    {
        if ($code !== null) {
            response()->httpCode($code);
        }

        response()->redirect($url);
    }
    function validateRequest($url, array $rules)
    {

        $validation = $this->validator->validate($this->input()->all() + $_FILES, $rules);

        if($validation->fails()){
//            die("FAILED");
            $this->err($url, $validation->errors()->all());
        }
//        die("PASSED");
    }
}