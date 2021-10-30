<?php
    namespace App\Users\Interfaces;

    use App\Core\Interfaces\RepositoryInterface;

    Interface UserRepositoryInterface extends RepositoryInterface {
        /**
         * @param int $id
         */
        public function findByEmail(string $email);

        /**
         * @param string $nickname
         */
        public function findByNickname(string $nickname);

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







