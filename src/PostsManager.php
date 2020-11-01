<?php

namespace App;

/**
 * Class PostsManager
 * @package App
 */
class PostsManager
{
    /**
     * @return int
     */
    public function count(): int
    {
        return PDOSingleton::getInstance()->getPDO()->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }
}
