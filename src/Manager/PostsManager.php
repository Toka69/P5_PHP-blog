<?php

namespace App\Manager;

use App\Entity\Post;
use App\Entity\User;
use PDO;

/**
 * Class PostsManager
 * @package App
 */
class PostsManager
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
        return $this->db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $getList = [];
        $request = $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, p.id, p.title, p.lead_paragraph as leadParagraph, p.content, p.created_date as createdDate, p.modified_date as modifiedDate, p.user_id as userId
            FROM posts p INNER JOIN users u ON u.id = p.user_id ORDER BY id DESC'
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $array = [
                'id' => $data['id'],
                'title' => $data['title'],
                'leadParagraph' => $data['leadParagraph'],
                'content' => $data['content'],
                'createdDate' => $data['createdDate'],
                'modifiedDate' => $data['modifiedDate'],
                'userId' => $data['userId'],
                'user' => new User ($data)
            ];
            $getList[] = new Post($array);
        }

        return $getList;
    }

    /**
     * @param $id
     *
     * @return object
     */
    public function getSinglePost($id): array
    {
        $singlePost = [];
        $request = $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, p.id, p.title, p.lead_paragraph as leadParagraph, p.content, p.created_date as createdDate, p.modified_date as modifiedDate, p.user_id as userId
            FROM posts p INNER JOIN users u ON u.id = p.user_id WHERE p.id =' .$id.''
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $array = [
                'id' => $data['id'],
                'title' => $data['title'],
                'leadParagraph' => $data['leadParagraph'],
                'content' => $data['content'],
                'createdDate' => $data['createdDate'],
                'modifiedDate' => $data['modifiedDate'],
                'userId' => $data['userId'],
                'user' => new User ($data)
            ];
            $singlePost[] = new Post($array);
        }

        return $singlePost;
    }

    /**
     * @param Post $posts
     */
    public function add(Post $posts)
    {

    }

    /**
     * @param Post $posts
     */
    public function update(Post $posts)
    {

    }

    /**
     * @param Post $posts
     */
    public function delete(Post $posts)
    {

    }
}
