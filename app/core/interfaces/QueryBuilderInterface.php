<?php declare(strict_types = 1);

namespace App\Core\Interfaces;

use App\Core\QueryBuilder;

interface QueryBuilderInterface
{
    public function sql(string $query): QueryBuilder;

    public function insert(string $table, array $values, ?array $fields = NULL): QueryBuilder;
    public function select(array $fields = null): QueryBuilder;
    public function selectDistinct(array $fields): QueryBuilder;
    public function update(string $table): QueryBuilder;
    public function delete(string $table): QueryBuilder;

    public function set (string $field, string $operator = '=', string $value): QueryBuilder;
    public function as(string $alias): QueryBuilder;
    public function from(string $table): QueryBuilder;

    public function where(string $field, string $operator = '=', string $value): QueryBuilder;
    public function whereAnd(string $field, string $operator = '=', string $value): QueryBuilder;
    public function whereOr(string $field, string $operator = '=', string $value): QueryBuilder;
    public function whereNot(string $field, string $operator = '=', string $value): QueryBuilder;
    public function whereIsNull(bool $value = true): QueryBuilder;

    public function limit(int $start, int $offset): QueryBuilder;
    public function orderBy(string $field, string $order = 'ASC'): QueryBuilder;
    public function join(string $type = 'INNER', string $table): QueryBuilder;
    public function on(string $field, string $operator = '=', string $value): QueryBuilder;

    public function get(): string;
}

?>