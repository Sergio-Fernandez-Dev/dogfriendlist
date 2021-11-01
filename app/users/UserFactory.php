<?php
namespace App\Users;

use App\Core\Interfaces\FactoryInterface;

class UserFactory implements FactoryInterface {

    /**
     * Crea un objeto Usuario con los parámetros
     * pasados como argumento.
     *
     * @param array $data
     */
    public static function make(array $data) {

        $user = new User();
        $user->setClassParams($data, true);

        return $user;
    }
}

?>