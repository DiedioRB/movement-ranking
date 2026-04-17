<?php

namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Movement extends BaseModel
{
    protected static string $table = "movement";

    public function __construct(array $data){
        $this->id = $data['id'];
        $this->name = $data['name'];
    }

    //Finds a movement by its name
    public static function findByName(string $name) : ?static
    {
        $table = static::$table;
        $sql = "SELECT * FROM $table WHERE name LIKE :name";
        $query = self::connection()->prepare($sql);
        $query->execute([
            ":name" => $name
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            return null;
        }

        return new static($result) ?: null;
    }

    // Returns the ranking of a movement with users ordered by its value
    public static function ranking(int $id) : array
    {
        $db = self::connection();

        $sql = "SELECT `user`.name, highest_value, DENSE_RANK() OVER (ORDER BY highest_value DESC) position, `date`
                FROM `movement`
                JOIN 
                ( --  subquery to find hightest value and its date for every user on every movement
                    SELECT * FROM
                    (
                        SELECT *, max(value) over (partition by user_id, movement_id) highest_value
                        FROM personal_record
                    ) personal_records where value = highest_value
                ) personal_record
                ON movement.id=personal_record.movement_id
                JOIN `user` ON personal_record.user_id=`user`.id
                WHERE movement.id=:id
                ORDER BY highest_value DESC;
        ";
        $query = self::connection()->prepare($sql);
        $query->execute([
            ":id" => $id,
        ]);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}