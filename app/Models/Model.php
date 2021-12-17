<?php
/**
 * Created by PhpStorm.
 * User: safja
 * Date: 10/4/2019
 * Time: 2:39 PM
 */
namespace App\Models;
use PDO;

class Model
{
    public PDO $db;
    public string $table;

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }
    public function __construct()
    {
        if (!isset($this->table)){
            $exp = explode("\\",get_called_class());
            $this->setTable(strtolower($exp[array_key_last($exp)]).'s');
        }

        $this->db = $GLOBALS['db'];
    }
    public static function create(array $datas = [])
    {
        $params = [];
        $params_tokenized=[];
        $insertable = [];
        foreach ($datas as $param => $data){
            $params[] = $param;
            $params_tokenized[] = ':'.$param;
            $insertable[":".$param] = $data;
        }
        $model = get_called_class();
        $model = new $model();
        $sql = "INSERT INTO ".$model->getTable()." (".implode(",", $params).") VALUES (".implode(',', $params_tokenized).")";
        $statement = $model->db->prepare($sql);
        //add the data into the database
        $statement->execute($insertable);
        return $model->db->lastInsertId();
    }
    public static function find(int $id){
        $model = get_called_class();
        $model = new $model();
        $statement = $model->db->prepare("SELECT * FROM `".$model->table."` WHERE `id` = :id");
        $statement->execute([
            ':id' => $id
        ]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public static function all(){
        $model = get_called_class();
        $model = new $model();
        $sql = "SELECT * FROM ".$model->getTable();
        $statement = $model->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}