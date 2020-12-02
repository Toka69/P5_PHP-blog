<?php


namespace Lib;


use PDO;

/**
 * Class AbstractManager
 * @package Lib
 */
class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = PDOSingleton::getInstance()->getPDO();
    }

}