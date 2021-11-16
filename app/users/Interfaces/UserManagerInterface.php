<?php
namespace App\Users\Interfaces;

use App\Core\Interfaces\EntityManagerInterface;

Interface UserManagerInterface extends EntityManagerInterface {
    /**
     * @param int $id
     */
    public function findByEmail(string $email);

    /**
     * @param string $username
     */
    public function findByUsername(string $username);

    /**
     * @param string $country
     */
    public function findByCountry(string $country);

    /**
     * @param string $city
     */
    public function findByCity(string $city);

    /**
     * @param int $role
     */
    public function findByRole(int $role);
}

?>












