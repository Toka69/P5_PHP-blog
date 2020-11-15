<?php


namespace App;

use App\Entity\Users;
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
     * @param $begin
     * @param $end
     *
     * @return array
     */
    public function getList($begin, $end): array
    {
        return $this->db->query(
            'SELECT u.id, u.admin, u.first_name, u.last_name, u.phone, u.email, u.password, u.street, u.address, u.postal_code, 
            u.logo, u.description, u.town, g.name 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id ORDER BY id LIMIT '.$begin.', '.$end.''
        )->fetchAll();
    }

    public function getUser($id): array
    {
        return $this->db->query(
            'SELECT u.id, u.admin, u.first_name, u.last_name, u.phone, u.email, u.password, u.street, u.address, u.postal_code, 
            u.logo, u.description, u.town, g.name 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id WHERE u.id='.$id.''
        )->fetchAll();
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
     * @param Users $users
     */
    public function add(Users $users)
    {

    }

    /**
     * @param Users $users
     */
    public function update(Users $users)
    {

    }

    /**
     * @param Users $users
     */
    public function delete(Users $users)
    {

    }
}
