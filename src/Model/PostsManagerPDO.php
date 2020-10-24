<?php

namespace App\Model;

/**
 * PostsManagerPDO
 */
class PostsManagerPDO extends PostsManager
{    
    /**
     * db
     *
     * @var mixed
     */
    protected $db;
    
    /**
     * __construct
     *
     * @param  mixed $db
     * @return void
     */
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    /**
     * add
     *
     * @param  mixed $posts
     * @return void
     */
    protected function add(posts $posts)
    {
        $request = $this->db->prepare('INSERT INTO posts(author, title, lead_paragraph, content, creating_date, modified_date) VALUES (:author, :title, :lead_paragraph, :content, NOW(), NOW())');
        
        $request->bindValue(':title', $posts->titre());
        $request->bindValue(':author', $posts->author());
        $request->bindValue(':lead_paragraph', $posts->lead_paragraph());
        $request->bindValue(':content', $posts->content());

        $request->execute();
    }
    
    /**
     * count
     *
     * @return void
     */
    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $this->db->exec('DELETE FROM posts WHERE id = '.(int) $id);
    }
    
    /**
     * getList
     *
     * @param  mixed $begin
     * @param  mixed $limit
     * @return void
     */
    public function getList($begin = -1, $limit = -1)
    {
        if($begin != -1 || $limit != -1)
        {
            $sql .= 'LIMIT '.(int) $limit.' OFFSET '.(int) $begin;
        }

        $request = $this->db->query($sql);
        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'posts');
        
        $postsList = $request->fetchAll();

        foreach($postsList as $posts)
        {
            $posts->setCreatingDate(new DateTime($posts->creatingDate()));
            $posts->setModifiedDate(new DateTime($posts->modifiedDate()));
        }

        $request->closeCursor();

        return $postsList;
    }
    
    /**
     * getUnique
     *
     * @param  mixed $id
     * @return void
     */
    public function getUnique($id)
    {
        $request = $this->db->prepare('SELECT id, title, lead_paragraph, content, author, creating_date, modified_date, user_id, FROM posts WHERE id = :id');
        
        $request->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $request->execute();

        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'posts');

        $posts = $request->fetch();

        $posts->setCreatingDate(new DateTime($posts->creatingDate()));
        $posts->setModifiedDate(new DateTime($posts->modifiedDate()));

        return $posts;
    }
    
    /**
     * update
     *
     * @param  mixed $posts
     * @return void
     */
    protected function update(posts $posts)
    {
        $request = $this->db->prepare('UPDATE posts SET title = :title, lead_paragraph = :lead_paragraph, content = :content, author = :author, modified_date = NOW() WHERE id = :id');
        
        $request->bindValue(':title', $posts->title());
        $request->bindValue(':lead_paragraph', $posts->lead_paragraph());
        $request->bindValue(':content', $posts->content());
        $request->bindValue(':author', $posts->author());
        $request->bindValue(':id', $posts->id(), PDO::PARAM_INT);

        $request->execute();
    }
}
