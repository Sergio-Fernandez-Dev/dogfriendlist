<?php 

namespace App\Core;

use App\Core\Interfaces\QueryBuilderInterface;
use stdClass;

use function PHPUnit\Framework\isNull;

class QueryBuilder implements QueryBuilderInterface
{
    private $query;

    private function _createEmptyQueryObject()
    {
        $this->query = new stdClass();
    }

    public function insert(string $table, ?array $fields = null)
    {
        $this->_createEmptyQueryObject();

        if(\is_null($fields)
        {
            $this->query->base = "INSERT INTO $table VALUES (".implode(", ", $values).")";
        }
        else 
        {
            $this->query->base = "INSERT INTO $table (".implode(", ", $fields).") VALUES (".implode(", ", $values).")";
        }
    }

    public function select(array $fields)
    {
        $this->_createEmptyQueryObject();
        $this->query->base = "SELECT".implode(", ", $fields);
        $this->query->type = 'select';

        return $this;
    }

    public function as(string $alias)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', ])) 
        {
            throw new \Exception("AS can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->as = "AS $alias";

        return $this;
    }

    public function from(string $table)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', ])) 
        {
            throw new \Exception("FROM can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->from = "FROM $table";

        return $this;
    }

    public function where(string $field, ?string $operator = '=', string $value)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', ])) 
        {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where = "WHERE $field $operator '$value'";

        return $this;
    }
    public function andWhere(string $field, string $operator = '=', string $value)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', ])) 
        {
            throw new \Exception("AND can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where = "AND $field $operator '$value'";

        return $this;
    }
    public function orWhere(string $field, string $operator = '=', string $value)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', ])) 
        {
            throw new \Exception("OR can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->andWhere = "OR $field $operator '$value'";

        return $this;
    }
    public function notWhere(string $field, string $operator = '=', string $value)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', ])) 
        {
            throw new \Exception("NOT can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where = "NOT $field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset)
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function order_by(string $field, string $order = 'ASC')
    {
        //TODO
    }

    public function join(string $join, string $table)
    {
        //TODO
    }

    public function on(string $field, string $operator = '=', string $value)
    {
        //TODO
    }

    public function getQuery()
    {
        //TODO
    }
}



?>