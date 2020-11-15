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
     * @param $begin
     * @param $end
     *
     * @return array
     */
    public function getList($begin, $end): array
    {
        return $this->db->query(
            'SELECT u.first_name, u.last_name, p.id, p.title, p.lead_paragraph, p.content, p.created_date, p.modified_date, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id ORDER BY id DESC LIMIT ' .$begin.', '.$end.''
        )->fetchAll();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function getSinglePost($id): array
    {
        return $this->db->query(
            'SELECT u.first_name, u.last_name, p.id, p.title, p.lead_paragraph, p.content, p.created_date, p.modified_date, p.user_id 
            FROM posts p INNER JOIN users u ON u.id = p.user_id WHERE p.id =' .$id.''
        )->fetchAll();
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
