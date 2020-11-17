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
        $i = 0;

        $request = $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, p.id, p.title, p.lead_paragraph as leadParagraph, p.content, p.created_date as createdDate, p.modified_date as modifiedDate, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id ORDER BY id DESC'
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            ${"post$i"}[] = new Post($data);
            ${"user$i"}[] = new User($data);
            $getList[] = (object) array_merge((array)${"post$i"}, (array)${"user$i"});
            $i++;
        }

        return $getList;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function getSinglePost($id): array
    {
        $singlePost = [];
        $i = 0;
        $request = $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, p.id, p.title, p.lead_paragraph as leadParagraph, p.content, p.created_date as createdDate, p.modified_date as modifiedDate, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id WHERE p.id =' .$id.''
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            ${"singlePost$i"}[] = new Post($data);
            ${"user$i"}[] = new User($data);
            $singlePost[] = (object) array_merge((array)${"singlePost$i"}, (array)${"user$i"});
            $i++;
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
