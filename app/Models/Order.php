<?php

namespace App\Models;

class Order extends Model
{
    public function allWithRelatedData()
    {
        $statement = $this->db->prepare("SELECT orders.*, products.name as 'product_name', users.name as 'user_name' FROM orders LEFT JOIN products ON orders.product_id = products.id LEFT JOIN users ON orders.user_id = users.id");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}