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
        return Manager::getInstance()->getPDO()->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }
}
