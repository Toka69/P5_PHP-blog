<?php


namespace App\Manager;

use App\Entity\Comments;
use PDO;

/**
 * Class CommentsManager
 * @package App
 */
class CommentsManager
{
    protected PDO $db;

    /**
     * @param $db
     */
    public function __construct($db)
    {
        $this->setDb($db);
    }

    /**
     * @param $db
     */
    private function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->db->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->db->query(
            'SELECT u.first_name, u.last_name, c.message, c.valid, c.user_id, c.created_date, c.modified_date 
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
        return $this->db->query(
            'SELECT u.first_name, u.last_name, c.message, c.valid, c.user_id, c.created_date, c.modified_date 
            FROM comments c INNER JOIN users u ON u.id = c.user_id WHERE posts_id = '.$id.' AND valid = '.$valid.''
        )->fetchAll();
    }

    public function add(Comments $comments)
    {

    }

    public function update(Comments $comments)
    {

    }

    public function delete(Comments $comments)
    {

    }
}
