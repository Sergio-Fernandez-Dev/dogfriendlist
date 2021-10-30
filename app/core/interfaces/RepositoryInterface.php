<?php
    namespace App\Core\Interfaces;

    use App\Core\Interfaces\EntityInterface;

    interface RepositoryInterface {

        /**
         * @param EntityInterface $modelObject
         */
        public function save(object $modelObject);

        /**
         * @param int $id
         */
        public function delete(int $id);

        /**
         * @param int $id
         */
        public function find(int $id);

        public function findAll();

    }

?>






