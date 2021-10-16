<?php 

namespace App\Core\Interfaces;

use App\Core\QueryBuilder;

interface QueryBuilderInterface
{
    public function sql(string $query): QueryBuilder;

    public function insert(string $table, array $values, ?array $fields): QueryBuilder;
    public function select(array $fields): QueryBuilder;
    public function selectDistinct(array $fields): QueryBuilder;
    public function update(string $table): QueryBuilder;
    public function delete(string $table): QueryBuilder;

    public function set (string $field, string $operator, string $value): QueryBuilder;
    public function as(string $alias): QueryBuilder;
    public function from(string $table): QueryBuilder;

    public function where(string $field, string $operator, string $value): QueryBuilder;
    public function andWhere(string $field, string $operator, string $value): QueryBuilder;
    public function orWhere(string $field, string $operator, string $value): QueryBuilder;
    public function whereNot(string $field, string $operator, string $value): QueryBuilder;

    public function limit(int $start, int $offset): QueryBuilder;
    public function orderBy(string $field, string $order): QueryBuilder;
    public function join(string $table, string $type): QueryBuilder;
    public function on(string $field, string $operator, string $value): QueryBuilder;
    
    public function get(): string; 
}

?>           