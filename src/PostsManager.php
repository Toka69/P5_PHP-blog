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
     *
     * @return array
     */
    public function getList($begin, $end): array
    {
        return PDOSingleton::getInstance()->getPDO()->query(
            'SELECT u.first_name, u.last_name, p.id, p.title, p.lead_paragraph, p.content, p.creating_date, p.modified_date, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id ORDER BY id DESC LIMIT '.$begin.', '.$end.''
        )->fetchAll();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function getSinglePost($id): array
    {
        return PDOSingleton::getInstance()->getPDO()->query(
            'SELECT u.first_name, u.last_name, p.id, p.title, p.lead_paragraph, p.content, p.creating_date, p.modified_date, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id WHERE p.id ='.$id.''
        )->fetchAll();
    }
}
