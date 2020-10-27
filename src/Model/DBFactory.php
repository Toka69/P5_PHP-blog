<?php

namespace App\Model;

use PDO;

/**
 * DBFactory
 */
class DBFactory
{
    /**
     * @return PDO
     */
    public static function getMySQLConnexionWithPDO(): PDO
    {
        $db = new PDO('mysql:host='.$_ENV['DATABASE_HOST'].';dbname='.$_ENV['DATABASE_NAME'].'', $_ENV['DATABASE_USER'],$_ENV['DATABASE_PASSWORD']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
