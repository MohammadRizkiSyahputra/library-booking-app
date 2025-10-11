<?php

namespace App\Core;

abstract class DbModel extends Model
{
    public ?int $id = null;

    abstract public static function tableName(): string;
    abstract public function attributes(): array;
    abstract public static function primaryKey(): string;

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = self::prepare(
            "INSERT INTO $tableName (" . implode(',', $attributes) . ") 
            VALUES (" . implode(',', $params) . ")"
        );

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        $this->{static::primaryKey()} = (int)App::$app->db->pdo->lastInsertId();
        return true;
    }

    public static function findOne(array $where): ?static
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql LIMIT 1");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        
        if (!$data) {
            return null;
        }

        $instance = new static();
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
            }
        }
        
        return $instance;
    }

    public static function prepare($sql)
    {
        return App::$app->db->pdo->prepare($sql);
    }
}
