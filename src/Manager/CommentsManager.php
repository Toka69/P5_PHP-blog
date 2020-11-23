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
        $request =  $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, c.message, c.valid, c.user_id, c.created_date as createdDate, c.modified_date as modifiedDate
            FROM comments c INNER JOIN users u ON u.id = c.user_id'
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $array = [
                'message' => $data['message'],
                'valid' => $data['valid'],
                'createdDate' => $data['createdDate'],
                'modifiedDate' => $data['modifiedDate'],
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'user' => new User($data)
            ];
            $getList[] = new Comment($array);
        }

        return $getList;
    }

    /**
     * @param $id
     * @param $valid
     *
     * @return array
     */
    public function getComments($id, $valid): array
    {
        $getComments = [];
        $request = $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, c.message, c.valid, c.user_id as userId, c.created_date as createdDate, c.modified_date as modifiedDate
            FROM comments c INNER JOIN users u ON u.id = c.user_id WHERE posts_id = '.$id.' AND valid = '.$valid.''
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $array = [
                'message' => $data['message'],
                'valid' => $data['valid'],
                'createdDate' => $data['createdDate'],
                'modifiedDate' => $data['modifiedDate'],
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'user' => new User($data)
            ];
            $getComments[] = new Comment($array);
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
