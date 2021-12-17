<?php

namespace App\Models;

class Order extends Model
{
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_IN_TRANSIT = 'in_transit';
    public const STATUS_DELIVERED = 'delivered';
    public static array $statuses = [
        self::STATUS_SUBMITTED,
        self::STATUS_IN_TRANSIT,
        self::STATUS_DELIVERED,
    ];
    public function allWithRelatedData()
    {
        $statement = $this->db->prepare("SELECT orders.*, products.name as 'product_name', users.name as 'user_name' FROM orders LEFT JOIN products ON orders.product_id = products.id LEFT JOIN users ON orders.user_id = users.id");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function set_status($id, $status)
    {
        if (!in_array($status, self::$statuses))
            throw new \Exception("Invalid Status");

        $statement = $this->db->prepare("UPDATE orders SET status=:status WHERE id=:id");
        return $statement->execute([
            ':status' => $status,
            ':id' => $id
        ]);

    }
}