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
     */
    private PDO $pdo;
    private static $instance;
    protected SuperGlobalObject $superGlobalObject;

    public function __construct(){
        $this->superGlobalObject = new SuperGlobalObject();
        $this->pdo = new PDO('mysql:host='.$this->superGlobalObject->env['DATABASE_HOST'].';dbname='.$this->superGlobalObject->env['DATABASE_NAME'].'', $this->superGlobalObject->env['DATABASE_USER'],$this->superGlobalObject->env['DATABASE_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDOSingleton
     */
    public static function getInstance(): PDOSingleton
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
    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
