<?php
    namespace App\Users\Interfaces;

    use App\Users\User;

    Interface UserRepositoryInterface {
        /**
         * @param int $id
         */
        public function find(int $id);

        /**
         * @param User $user
         */
        public function remove(User $user);

        /**
         * @param User $user
         */
        public function save(User $user);
    }

?>



