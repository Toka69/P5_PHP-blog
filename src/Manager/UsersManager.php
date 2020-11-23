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
            "SELECT u.id, u.admin, u.first_name as firstName, u.last_name as lastName, u.phone, u.email, u.password, u.street, u.address, u.postal_code as postalCode, 
            u.logo, u.description, u.town, g.name 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id {$order} ORDER BY id"
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getList[] = new User($data);
        }

        return $getList;
    }

    public function getUser($id): ?object
    {
        $getUser = [];
        $request = $this->db->query(
            'SELECT u.id, u.admin, u.first_name as firstName, u.last_name as lastName, u.phone, u.email, u.password, u.street, u.address, u.postal_code as postalCode, 
            u.logo, u.description, u.town, g.name 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id WHERE u.id= '.$id.' '
        );

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

    public function getGenders(){
        return $this->db->query('SELECT name FROM gender');
    }

    /**
     * @param $email
     * @return mixed
     */
    public function checkCredentials($email)
    {
        return $this->db->query('SELECT id, password FROM users WHERE email = \''.$email.'\' ')->fetch();
    }

    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $request = $this->db->prepare('INSERT INTO users(admin, first_name, last_name, email, password, gender_id) 
        VALUES(:admin, :first_name, :last_name, :email, :password, :gender_id)');

        $request->bindValue(':admin', '0');
        $request->bindValue(':first_name', $user->getFirstName()); //PDO::PARAM ?
        $request->bindValue(':last_name', $user->getLastName());
        $request->bindValue(':email', $user->getEmail());
        $request->bindValue(':password', $user->getPassword());
        $request->bindValue(':gender_id', $user->getGenderId());

        $request->execute();
    }

    /**
     * @param User $users
     */
    public function update(User $user)
    {

    }

    /**
     * @param User $users
     */
    public function delete(User $user)
    {

    }
}
