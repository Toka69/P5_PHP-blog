<?php


namespace App\Manager;

use App\Entity\Comment;
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
        $getList = [];
        $request =  $this->db->query(
            'SELECT u.first_name, u.last_name, c.message, c.valid, c.user_id, c.created_date, c.modified_date 
            FROM comments c INNER JOIN users u ON u.id = c.user_id'
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getList[] = new Comment($data);
        }

        return $getList;
    }

    /**
     * @param $id
     * @param $valid
     * @return array
     */
    public function getComments($id, $valid): array
    {
        $getComments = [];
        $request = $this->db->query(
            'SELECT u.first_name, u.last_name, c.message, c.valid, c.user_id, c.created_date, c.modified_date 
            FROM comments c INNER JOIN users u ON u.id = c.user_id WHERE posts_id = '.$id.' AND valid = '.$valid.''
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getComments[] = new Comment($data);
        }

        return $getComments;
    }

    public function add(Comment $comments)
    {

    }

    public function update(Comment $comments)
    {

    }

    public function delete(Comment $comments)
    {

    }
}
