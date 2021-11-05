<?php
    namespace App\Core\Interfaces;

    interface EntityInterface {
        /**
         * @param bool $only_valuated
         */
        public function getClassParams(bool $only_valuated = true);

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












