<?php

namespace App\Manager;

use App\Entity\Post;
use App\Entity\User;
use Lib\AbstractManager;
use PDO;

/**
 * Class PostsManager
 * @package App
 */
class PostsManager extends AbstractManager
{
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
            FROM posts p INNER JOIN users u ON u.id = p.user_id ORDER BY p.created_date DESC'
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
     * @return object|null
     */
    public function getPost($id): ?object
    {
        $singlePost = [];
        $request = $this->db->prepare(
            'SELECT u.first_name as firstName, u.last_name as lastName, p.id, p.title, p.lead_paragraph as leadParagraph, p.content, p.created_date as createdDate, p.modified_date as modifiedDate, p.user_id as userId
            FROM posts p INNER JOIN users u ON u.id = p.user_id WHERE p.id = ? '
        );
        $request->execute(array($id));

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
            $singlePost = new Post($array);
        }
        if(!empty($singlePost))
        {
            return $singlePost;
        }

        return null;
    }

    /**
     * @param Post $post
     */
    public function add(Post $post)
    {
        $request = $this->db->prepare('INSERT INTO posts (title, lead_paragraph, content, user_id) 
                    VALUES (:title, :lead_paragraph, :content, :user_id)');

        $request->bindValue(':title', $post->getTitle());
        $request->bindValue(':lead_paragraph', $post->getLeadParagraph());
        $request->bindValue(':content', $post->getContent());
        $request->bindValue(':user_id', $post->getUserId());

        $request->execute();
    }

    /**
     * @param Post $post
     */
    public function update(Post $post)
    {
        $request = $this->db->prepare('UPDATE posts SET title = :title, lead_paragraph = :lead_paragraph, content = :content, 
            user_id = :user_id WHERE id = :id');

        $request->bindValue(':title', $post->getTitle());
        $request->bindValue(':lead_paragraph', $post->getLeadParagraph());
        $request->bindValue(':content', $post->getContent());
        $request->bindValue(':user_id', $post->getUserId());
        $request->bindValue(':id', $post->getId());

        $request->execute();
    }

    /**
     * @param Post $post
     */
    public function delete(Post $post)
    {
        $request = $this->db->prepare('DELETE FROM posts WHERE id = :id');
        $request->bindValue(':id', $post->getId());
        $request->execute();
    }

    /**
     * @param $first
     * @param $perPage
     *
     * @return array
     */
    public function getListPagination($first, $perPage): array
    {
        $getList = [];
        $request = $this->db->prepare(
            'SELECT u.first_name as firstName, u.last_name as lastName, p.id, p.title, p.lead_paragraph as leadParagraph, p.content, p.created_date as createdDate, p.modified_date as modifiedDate, p.user_id as userId
            FROM posts p INNER JOIN users u ON u.id = p.user_id ORDER BY id DESC LIMIT :first, :perPage'
        );

        $request->bindValue(':first', $first, PDO::PARAM_INT);
        $request->bindValue(':perPage', $perPage, PDO::PARAM_INT);

        $request->execute();

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
}
