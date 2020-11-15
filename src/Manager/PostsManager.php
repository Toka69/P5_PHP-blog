<?php

namespace App\Manager;

use App\Entity\Posts;
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
            'SELECT u.first_name, u.last_name, p.id, p.title, p.lead_paragraph, p.content, p.created_date, p.modified_date, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id ORDER BY id DESC'
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getList[] = new Posts($data);
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
        $request = $this->db->query(
            'SELECT u.first_name, u.last_name, p.id, p.title, p.lead_paragraph, p.content, p.created_date, p.modified_date, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id WHERE p.id =' .$id.''
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $singlePost[] = new Posts($data);
        }

        return $singlePost;
    }

    /**
     * @param Posts $posts
     */
    public function add(Posts $posts)
    {

    }

    /**
     * @param Posts $posts
     */
    public function update(Posts $posts)
    {

    }

    /**
     * @param Posts $posts
     */
    public function delete(Posts $posts)
    {

    }
}
