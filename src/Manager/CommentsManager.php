<?php


namespace App\Manager;


use Lib\PDOSingleton;

/**
 * Class CommentsManager
 * @package App
 */
class CommentsManager
{
    /**
     * @return int
     */
    public function count(): int
    {
        return PDOSingleton::getInstance()->getPDO()->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return PDOSingleton::getInstance()->getPDO()->query(
            'SELECT u.first_name, u.last_name, c.message, c.valid, c.user_id, c.creating_date, c.modified_date 
            FROM comments c INNER JOIN users u ON u.id = c.user_id'
        )->fetchAll();
    }

    /**
     * @param $id
     * @param $valid
     *
     * @return array
     */
    public function getCommentsPost($id, $valid): array
    {
        return PDOSingleton::getInstance()->getPDO()->query(
            'SELECT u.first_name, u.last_name, c.message, c.valid, c.user_id, c.creating_date, c.modified_date 
            FROM comments c INNER JOIN users u ON u.id = c.user_id WHERE posts_id = '.$id.' AND valid = '.$valid.''
        )->fetchAll();
    }
}
