<?php


namespace App\Manager;

use App\Entity\Comment;
use App\Entity\User;
use Lib\AbstractManager;
use PDO;

/**
 * Class CommentsManager
 * @package App
 */
class CommentsManager extends AbstractManager
{
    /**
     * @param int|null $id
     * @param int|null $admin
     *
     * @return int
     */
    public function count(?int $id = null, ?int $admin = null): int
    {
        if(is_int($admin) && $admin == 0)
        {
            return $this->db->query('SELECT COUNT(*) FROM comments WHERE user_id = '.$id.' ')->fetchColumn();
        }
        return $this->db->query('SELECT COUNT(*) FROM comments')->fetchColumn();
    }

    /**
     * @param int|null $id
     * @param int|null $admin
     *
     * @return array
     */
    public function getList(?int $id = null, ?int $admin = null): array
    {
        if(is_int($admin) && $admin == 0)
        {
            $order = "WHERE user_id = ".$id."";
        }
        else
        {
            $order = "";
        }
        $getList = [];
        $request =  $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, c.id, c.message, c.valid, c.user_id, c.created_date as createdDate, c.modified_date as modifiedDate
            FROM comments c INNER JOIN users u ON u.id = c.user_id '.$order.' '
        );

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $array = [
                'id' => $data['id'],
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

    public function getComment($id): ?object
    {
        $getComment = [];
        $request =  $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, c.id, c.message, c.valid, c.posts_id as postsId, c.user_id as userId, c.created_date as createdDate, c.modified_date as modifiedDate
            FROM comments c INNER JOIN users u ON u.id = c.user_id WHERE c.id = '.$id.''
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $array = [
                'id' => $data['id'],
                'message' => $data['message'],
                'valid' => $data['valid'],
                'postsId' => $data['postsId'],
                'userId' => $data['userId'],
                'createdDate' => $data['createdDate'],
                'modifiedDate' => $data['modifiedDate'],
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'user' => new User($data)
            ];
            $getComment = new Comment($array);
        }

        if(!empty($getComment))
        {
            return $getComment;
        }

        return null;
    }

    /**
     * @param $id
     * @param $valid
     *
     * @return array
     */
    public function getCommentsPost($id, $valid): array
    {
        $getComments = [];
        $request = $this->db->query(
            'SELECT u.first_name as firstName, u.last_name as lastName, c.id, c.message, c.valid, c.user_id as userId, c.created_date as createdDate, c.modified_date as modifiedDate
            FROM comments c INNER JOIN users u ON u.id = c.user_id WHERE posts_id = '.$id.' AND c.valid = '.$valid.''
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $array = [
                'id' => $data['id'],
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

    public function add(Comment $comment)
    {

    }

    public function update(Comment $comment)
    {
        $request = $this->db->prepare('UPDATE comments SET message = :message, valid = :valid, posts_id = :posts_id, 
            modified_date = :modified_date, user_id = :user_id WHERE id = :id');

        $request->bindValue(':message', $comment->getMessage());
        $request->bindValue(':valid', $comment->getValid());
        $request->bindValue(':posts_id', $comment->getPostsId());
        $request->bindValue(':modified_date', $comment->getModifiedDate());
        $request->bindValue(':user_id', $comment->getUserId());
        $request->bindValue(':id', $comment->getId());

        $request->execute();
    }

    public function delete(Comment $comments)
    {

    }
}
