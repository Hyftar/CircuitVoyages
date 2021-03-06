<?php

namespace Core;

use PDO;
use App\Config;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8';
            $db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}
