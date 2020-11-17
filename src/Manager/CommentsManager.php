<?php


namespace App\Manager;

use App\Entity\Comment;
use App\Entity\User;
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
        $i = 0;

        $request =  $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, c.message, c.valid, c.user_id, c.created_date as createdDate, c.modified_date as modifiedDate
            FROM comments c INNER JOIN users u ON u.id = c.user_id'
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            ${"comment$i"}[] = new Comment($data);
            ${"user$i"}[] = new User($data);
            $getList[] = (object) array_merge((array)${"comment$i"}, (array)${"user$i"});
            $i++;
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
            'SELECT u.first_name as firstName, u.last_name as lastName, c.message, c.valid, c.user_id, c.created_date as createdDate, c.modified_date as modifiedDate
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
