<?php
    namespace App\Core\Interfaces;

    interface GatewayInterface {
        public function connect();

        public function disconnect();

        /**
         * @param array $data
         */
        public function persist(array $data);

        /**
         * @param int $id
         */
        public function retrieve(int $id);
    }

?>














