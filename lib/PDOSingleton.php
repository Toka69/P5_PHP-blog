<?php

namespace Lib;

use PDO;

/**
 * Class PDOSingleton
 * @package App
 */
class PDOSingleton
{
    /**
     * @var PDO
     * @var
     */
    private PDO $pdo;
    private static $instance;

    public function __construct(){
        $this->pdo = new PDO('mysql:host='.$_ENV['DATABASE_HOST'].';dbname='.$_ENV['DATABASE_NAME'].'', $_ENV['DATABASE_USER'],$_ENV['DATABASE_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDOSingleton
     */
    public static function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new PDOSingleton();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getPDO(){
        return $this->pdo;
    }
}
