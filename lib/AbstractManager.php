<?php


namespace Lib;


use PDO;

class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = PDOSingleton::getInstance()->getPDO();
    }


}