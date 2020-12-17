<?php


namespace Lib;


use PDO;

/**
 * Class AbstractManager
 * @package Lib
 */
class AbstractManager
{
    /**
     * @var PDO
     */
    protected PDO $db;

    public function __construct()
    {
        $this->db = PDOSingleton::getInstance()->getPDO();
    }

}