<?php
/**
 * Created by PhpStorm.
 * User: safja
 * Date: 10/4/2019
 * Time: 2:39 PM
 */
namespace App\Models;
class Model
{
    public $db;
    public $table;

    public function __construct()
    {
        //class initiated
        $this->db = $GLOBALS['db'];
    }
}