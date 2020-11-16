<?php


namespace App\Manager;

use App\Entity\User;
use PDO;

/**
 * Class UsersManager
 * @package App
 */
class UsersManager
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
        return $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $getList = [];
        $request = $this->db->query(
            'SELECT u.id, u.admin, u.first_name, u.last_name, u.phone, u.email, u.password, u.street, u.address, u.postal_code, 
            u.logo, u.description, u.town, g.name 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id ORDER BY id'
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getList[] = new User($data);
        }

        return $getList;
    }

    public function getUser($id): array
    {
        $getUser = [];
        $request = $this->db->query(
            'SELECT u.id, u.admin, u.first_name, u.last_name, u.phone, u.email, u.password, u.street, u.address, u.postal_code, 
            u.logo, u.description, u.town, g.name 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id WHERE u.id='.$id.''
        );

        while ($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $getUser[] = new User($data);
        }

        return $getUser;
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
     * @param User $users
     */
    public function add(User $users)
    {

    }

    /**
     * @param User $users
     */
    public function update(User $users)
    {

    }

    /**
     * @param User $users
     */
    public function delete(User $users)
    {

    }
}
