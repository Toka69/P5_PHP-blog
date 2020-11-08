<?php


namespace App;

use Lib\PDOSingleton;

/**
 * Class UsersManager
 * @package App
 */
class UsersManager
{
    /**
     * @return int
     */
    public function count(): int
    {
        return PDOSingleton::getInstance()->getPDO()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    /**
     * @param $begin
     * @param $end
     *
     * @return array
     */
    public function getList($begin, $end): array
    {
        return PDOSingleton::getInstance()->getPDO()->query(
            'SELECT u.id, u.admin, u.first_name, u.last_name, u.phone, u.email, u.password, u.street, u.address, u.postal_code, 
            u.logo, u.description, u.town, g.male, g.female, g.other 
            FROM users u INNER JOIN gender g ON g.id = u.gender_id ORDER BY id LIMIT '.$begin.', '.$end.''
        )->fetchAll();
    }
}
