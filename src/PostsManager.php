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

    /**
     * @return mixed
     */
    public function getList($begin, $end): array
    {
        return PDOSingleton::getInstance()->getPDO()->query('SELECT id, title, lead_paragraph, content, creating_date, modified_date, user_id FROM posts ORDER BY id DESC LIMIT '.$begin.', '.$end.'')->fetchAll();
    }
}
