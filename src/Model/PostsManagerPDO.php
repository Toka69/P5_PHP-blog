<?php

namespace App\Model;

use PDO;

/**
 * Class PostsManagerPDO
 * @package App\Model
 */
class PostsManagerPDO extends PostsManager
{
    /**
     * @var PDO
     */
    protected PDO $db;

    /**
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return Int
     */
    public function count(): int
    {
        return $this->db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }
}
