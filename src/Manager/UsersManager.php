<?php


namespace App\Manager;

use App\Entity\User;
use Lib\AbstractManager;
use PDO;

/**
 * Class UsersManager
 * @package App
 */
class UsersManager extends AbstractManager
{
    /**
     * @return int
     */
    public function count(): int
    {
        return $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    /**
     * @param string|null $order
     *
     * @return array
     */
    public function getList(?string $order=""): array
    {
        $getList = [];
        if ($order === "admin")
        {
            $order = 'WHERE u.admin = 1';
        }
        $request = $this->db->query(
            "SELECT u.id, u.admin, u.first_name as firstName, u.last_name as lastName, u.email, u.password, u.pseudo, u.valid, g.name 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id {$order} ORDER BY id"
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getList[] = new User($data);
        }

        return $getList;
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getUser($id): ?object
    {
        $getUser = [];
        $request = $this->db->prepare(
            'SELECT u.id, u.admin, u.first_name as firstName, u.last_name as lastName, u.email, u.password, u.pseudo, u.gender_id as genderId, u.valid, u.valid_by_mail as validByMail 
            FROM users u WHERE u.id= ? '
        );
        $request->execute(array($id));

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getUser = new User($data);
        }

        if(!empty($getUser))
        {
            return $getUser;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getGenders()
    {
        return $this->db->query('SELECT id, name FROM gender')->fetchAll();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function checkCredentials($email)
    {
        $request = $this->db->prepare('SELECT id, password FROM users WHERE email = ?');
        $request->execute(array($email));
        return $request->fetch();
    }

    /**
     * @param $pseudo
     * @return mixed
     */
    public function checkPseudo($pseudo)
    {
        $request = $this->db->prepare('SELECT pseudo FROM users WHERE pseudo = ? ');
        $request->execute(array($pseudo));
        return $request->fetch();
    }

    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $request = $this->db->prepare('INSERT INTO users(first_name, last_name, email, password, pseudo, gender_id) 
        VALUES(:first_name, :last_name, :email, :password, :pseudo, :gender_id)');

        $request->bindValue(':first_name', $user->getFirstName()); //PDO::PARAM ?
        $request->bindValue(':last_name', $user->getLastName());
        $request->bindValue(':email', $user->getEmail());
        $request->bindValue(':password', $user->getPassword());
        $request->bindValue(':pseudo', $user->getPseudo());
        $request->bindValue(':gender_id', $user->getGenderId());

        $request->execute();
    }

    /**
     * @param User $user
     */
    public function update(User $user)
    {
        $request = $this->db->prepare('UPDATE users SET admin = :admin, first_name = :first_name, last_name = :last_name, email = :email,
                 password = :password, pseudo = :pseudo, gender_id = :gender_id, valid = :valid, valid_by_mail = :validByMail WHERE id = :id');

        $request->bindValue(':admin', $user->getAdmin());
        $request->bindValue(':first_name', $user->getFirstName());
        $request->bindValue(':last_name', $user->getLastName());
        $request->bindValue(':email', $user->getEmail());
        $request->bindValue(':password', $user->getPassword());
        $request->bindValue(':pseudo', $user->getPseudo());
        $request->bindValue(':gender_id', $user->getGenderId());
        $request->bindValue(':valid', $user->getValid());
        $request->bindValue(':validByMail', $user->getValidByMail());
        $request->bindValue(':id', $user->getId());

        $request->execute();
    }
}
