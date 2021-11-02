<?php
namespace App\Users;

use App\Core\EntityManager;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Users\Interfaces\UserManagerInterface;

class UserManager extends EntityManager implements UserManagerInterface {

    /**
     * @param GatewayInterface $db
     * @param QueryBuilderInterface $q_builder
     */
    public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder) {

        parent::__construct($db, $q_builder, 'Users');
    }

    /**
     * @param string $nickname
     */
    public function findByNickname(string $nickname) {
        //TO-DO
    }

    /**
     * @param string $email
     */
    public function findByEmail(string $email) {
        //TO-DO
    }

    /**
     * @param string $city
     */
    public function findByCity(string $city) {
        //TO-DO
    }

    /**
     * @param string $country
     */
    public function findByCountry(string $country) {
        //TO-DO
    }

    /**
     * @param int $role
     */
    public function findByRole(int $role) {
        //TO-DO
    }

    /**
     * Crea un objeto Usuario con los parámetros
     * pasados como argumento.
     *
     * @param array $data
     */
    public function make(array $data) {

        $user = new User();
        $user->setClassParams($data, true);

        return $user;
    }
}

?>