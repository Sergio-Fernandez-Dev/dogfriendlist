<?php 

namespace App\Core\Interfaces;

class QueryBuilder
{
    public function select(string $table, array $fields);
    public function as(string $alias);
    public function from(string $table);
    public function where(string $field, string $operator = '=', string $value);
    public function limit(int $start, int $offset);
    public function order_by(string $field, string $order = 'ASC');
    public function join(string $join, string $table);
    public function on(string $field, string $operator = '=', string $value);
}

?>