<?php

namespace App;

use Lib\PDOSingleton;

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
     * @param $begin
     * @param $end
     * @return array
     */
    public function getList($begin, $end): array
    {
        return PDOSingleton::getInstance()->getPDO()->query('SELECT id, title, lead_paragraph, content, creating_date, modified_date, user_id FROM posts ORDER BY id DESC LIMIT '.$begin.', '.$end.'')->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getSinglePost($id): array
    {
        return PDOSingleton::getInstance()->getPDO()->query('SELECT u.first_name, u.last_name, p.id, p.title, p.lead_paragraph, p.content, p.creating_date, p.modified_date, p.user_id FROM posts p INNER JOIN user u ON u.id = p.user_id WHERE p.id ='.$id.'')->fetchAll();
    }

    public function getCommentsPost($id, $valid): array
    {
        return PDOSingleton::getInstance()->getPDO()->query('SELECT u.first_name, u.last_name, c.message, c.valid, c.user_id, c.creating_date, c.modified_date FROM comments c INNER JOIN user u ON u.id = c.user_id WHERE posts_id = '.$id.' AND valid = '.$valid.'')->fetchAll();
    }

}
