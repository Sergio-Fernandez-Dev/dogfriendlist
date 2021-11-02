<?php
    namespace App\Core\Interfaces;

    interface EntityInterface {
        public function getClassParams();

        /**
         * @param array $data
         * @param bool $override
         */
        public function setClassParams(array $data, bool $override);

        public function getId();

        /**
         * @param int $id
         */
        public function setId(int $id);
    }

?>










