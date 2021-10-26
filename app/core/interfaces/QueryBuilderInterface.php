<?php
    namespace App\Core\Interfaces;

    use App\Core\QueryBuilder;

    interface QueryBuilderInterface {
        /**
         * @param string $field
         * @param string $operator
         * @param mixed $value
         */
        public function andWhere(string $field, string $operator, $value): QueryBuilder;

        /**
         * @param string $alias
         */
        public function as (string $alias): QueryBuilder;

        /**
         * @param string $table
         */
        public function delete(string $table): QueryBuilder;

        /**
         * @param string $table
         */
        public function from(string $table): QueryBuilder;

        public function get(): array;

        /**
         * @param string $table
         * @param mixed $value
         * @param mixed $fields
         */
        public function insert(string $table, array $values, ?array $fields): QueryBuilder;

        /**
         * @param string $table
         * @param string $type
         */
        public function join(string $table, string $type): QueryBuilder;

        /**
         * @param int $start
         * @param int $offset
         */
        public function limit(int $start, int $offset): QueryBuilder;

        /**
         * @param string $field
         * @param string $operator
         * @param mixed $value
         */
        public function on(string $field, string $operator, $value): QueryBuilder;

        /**
         * @param string $field
         * @param string $operator
         * @param mixed $value
         */
        public function orWhere(string $field, string $operator, $value): QueryBuilder;

        /**
         * @param string $field
         * @param string $order
         */
        public function orderBy(string $field, string $order): QueryBuilder;

        /**
         * @param array $fields
         */
        public function select(array $fields): QueryBuilder;

        /**
         * @param array $fields
         */
        public function selectDistinct(array $fields): QueryBuilder;

        /**
         * @param string $field
         * @param string $operator
         * @param mixed $value
         */
        public function set(string $field, string $operator, $value): QueryBuilder;

        /**
         * @param string $query
         */
        public function sql(string $query): QueryBuilder;

        /**
         * @param string $table
         */
        public function update(string $table): QueryBuilder;

        /**
         * @param string $field
         * @param string $operator
         * @param mixed $value
         */
        public function where(string $field, string $operator, $value): QueryBuilder;

        /**
         * @param string $field
         * @param string $operator
         * @param mixed $value
         */
        public function whereNot(string $field, string $operator, $value): QueryBuilder;
    }

?>
























