<?php

namespace App\Model;

/**
 * Class PostsManager
 * @package App\Model
 */
abstract class PostsManager
{
    /**
     * @return int
     */
    abstract public function count();
}
