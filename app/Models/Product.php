<?php

namespace App\Models;

class Product extends Model
{
    public function allWithLocation(){
        $statement = $this->db->prepare("SELECT products.*, locations.name as 'location_name' FROM products LEFT  JOIN locations ON products.location_id = locations.id");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}