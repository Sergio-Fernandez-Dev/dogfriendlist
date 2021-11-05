<?php
    namespace App\Core\Interfaces;

    interface QueryBuilderInterface {

        /**
         * @param string $table
         */
        public function setTableName(string $table);

        /**
         * @param string $query
         */
        public function raw(string $query, ...$values_to_bind);

        /**
         * @param array $data
         */
        public function insert(array $data);

        public function select();

        /**
         * @param mixed $fields
         */
        public function selectDistinct(...$columns);

        /**
         * @param array $data
         */
        public function update(array $data);

        public function delete();

        /**
         * @param string $column
         * @param string $operator
         * @param mixed $value
         */
        public function where(string $column, string $operator, $value);

        /**
         * @param string $column
         * @param string $operator
         * @param mixed $value
         */
        public function andWhere(string $column, string $operator, $value);

        /**
         * @param string $column
         * @param string $operator
         * @param mixed $value
         */
        public function orWhere(string $column, string $operator, $value);

        /**
         * @param string $column
         * @param string $operator
         * @param mixed $value
         */
        public function whereNot(string $column, string $operator, $value);

        /**
         * @param int $start
         * @param int $offset
         */
        public function limit(int $start, int $offset);

        /**
         * @param string $column
         * @param string $order
         */
        public function orderBy(string $column, string $order);

        public function get(): array;

    }

?>


