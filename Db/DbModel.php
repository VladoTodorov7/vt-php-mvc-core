<?php
namespace Vlgeto\PhpMvc\Db;

use Vlgeto\PhpMvc\Application;
use Vlgeto\PhpMvc\Model;

/**
 * DbModel
 * @package Vlgeto\PhpMvc
 */
abstract class DbModel extends Model
{
    abstract public static function tableName(): string; 
    public static function primaryKey()
    {
        return 'id';
    }
    
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);        

        $statement  = self::prepare("
            INSERT INTO $tableName (" . implode(",", $attributes) . ")
            VALUES(" . implode(',', $params) . ")
        ");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}
?>