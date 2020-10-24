<?php

namespace App\Model;

/**
 * PostsManager
 */
abstract class PostsManager
{    
    /**
     * add
     *
     * @param  mixed $posts
     * @return void
     */
    abstract protected function add(posts $posts);
    
    /**
     * count
     *
     * @return void
     */
    abstract public function count();
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    abstract public function delete($id);
    
    /**
     * getList
     *
     * @param  mixed $debut
     * @param  mixed $limit
     * @return void
     */
    abstract public function getList($begin = -1, $limit = -1);
    
    /**
     * getUnique
     *
     * @param  mixed $id
     * @return void
     */
    abstract public function getUnique($id);
    
    /**
     * save
     *
     * @param  mixed $post
     * @return void
     */
    public function save(posts $post)
    {
        if($posts->isValid())
        {
            $posts->isNew() ? $this->add($posts) : $this->update($posts);
        }
        else
        {
            throw new RuntimeException('The post must be valid to be saved');
        }
    }
    
    /**
     * update
     *
     * @param  mixed $posts
     * @return void
     */
    abstract protected function update(posts $posts);
}
