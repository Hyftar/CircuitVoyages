<?php

namespace App\Models;

use Core\Model;
use PDO;

class Media extends Model
{
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM media');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function create($name, $media_type, $description, $path)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'INSERT INTO media(name, media_type, description, path, header)
             VALUES (:name, :media_type, :description, :path, 0)'
        );

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':media_type', $media_type, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':path', $path, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
