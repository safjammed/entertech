<?php

namespace App\Models;

class User extends Model
{
    public function getByEmail($email)
    {
        $statement = $this->db->prepare("SELECT * FROM `users` where email = :email");
        $statement->execute([':email' => $email]);
        return $statement->fetch(\PDO::FETCH_ASSOC);

    }

}