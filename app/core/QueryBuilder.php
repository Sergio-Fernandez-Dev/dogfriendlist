<?php 

namespace App\Core;

use App\Core\Interfaces\QueryBuilderInterface;
use stdClass;

use function PHPUnit\Framework\isNull;

class QueryBuilder implements QueryBuilderInterface
{
    private $query;

    public function __construct()
    {
        $this->_createEmptyQueryObject();
    }

    private function _createEmptyQueryObject()
    {
        $this->query = new stdClass();
    }

    private function _build($sql_string)
    {
        if(\is_array($sql_string))
        {
            $last = array_pop($sql_string);
            $this->query->result .=  $last;
            \array_push($sql_string, $last);
        }
        $this->query->result .= $sql_string;
    }

    public function sql(string $query): QueryBuilder
    {
        $this->query->base = $query;
        $this->_build($this->query->base);

        return $this;
    }

    public function insert(string $table, ?array $fields = null, array $values): QueryBuilder
    {

        if(\is_null($fields))
        {
            $this->query->base = "INSERT INTO $table VALUES (".implode(", ", $values).")";
        }
        else 
        {
            $this->query->base = "INSERT INTO $table (".implode(", ", $fields).") VALUES (".implode(", ", $values).")";
        }

        $this->query->type = 'insert';  
        $this->query->_build($this->query->base);

        return $this;
    }

    public function select(array $fields = null): QueryBuilder
    {

        if(\is_null($fields)) 
        {
            $this->query->base = "SELECT *";
        }
        else
        {
            $this->query->base = "SELECT ".implode(", ", $fields);
        }

        $this->query->type = 'select';   
        $this->query->_build($this->query->base);

        return $this;
    }

    public function selectDistinct(array $fields): QueryBuilder
    {
        $this->query->base = "SELECT DISTINCT ".implode(", ", $fields);
        $this->query->type = 'select';
        $this->query->_build($this->query->base);

        return $this;
    }

    public function update(string $table): QueryBuilder
    {
        $this->_createEmptyQueryObject();
        $this->query->base = "UPDATE $table";
        $this->query->type = 'update';
        $this->query->_build($this->query->base);

        return $this;
    }

    public function delete(string $table): QueryBuilder
    {
        $this->_createEmptyQueryObject();
        $this->query->base = "DELETE FROM $table";
        $this->query->type = 'delete';
        $this->query->_build($this->query->base);

        return $this;
    }

    public function set (string $field, string $operator = '=', string $value): QueryBuilder
    {
        if (!in_array($this->query->type, ['update'])) 
        {
            throw new \Exception("SET can only be added to UPDATE");
        }
        if (empty($this->query->set))
        {
            $this->query->set[] = " SET $field $operator '$value'";
        }
        else
        {
            $this->query->set[] = ", $field $operator '$value'";
        }

        $this->query->_build($this->query->set);

        return $this; 
    }

    public function as(string $alias): QueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("AS can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->as = " AS $alias";
        $this->query->_build($this->query->as);

        return $this;
    }

    public function from(string $table): QueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("FROM can only be added to SELECT");
        }
        $this->query->from = " FROM $table";
        $this->query->_build($this->query->from);

        return $this;
    }

    public function where(string $field, ?string $operator = '=', string $value): QueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where[] = "WHERE $field $operator '$value'";
        $this->query->_build($this->query->where);

        return $this;
    }
    public function whereAnd(string $field, string $operator = '=', string $value): QueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("AND can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->whereAnd[] = "AND $field $operator '$value'";
        $this->query->_build($this->query->whereAnd);
        
        return $this;
    }
    public function whereOr(string $field, string $operator = '=', string $value): QueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("OR can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->whereOr[] = " OR $field $operator '$value'";
        $this->query->_build($this->query->whereOr);

        return $this;
    }
    public function whereNot(string $field, string $operator = '=', string $value): QueryBuilder
    {
        if(!in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("NOT can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->whereNot[] = "$field $operator '$value'";
        $this->query->_build($this->query->whereNot);

        return $this;
    }

    public function whereIsNull(bool $value = true): QueryBuilder
    {
        if(!in_array($this->query->type, ['select', 'update', 'delete']) && $value) 
        {
            throw new \Exception("IS NULL can only be added to SELECT, UPDATE OR DELETE");
        }
        if(!in_array($this->query->type, ['select', 'update', 'delete']) && !$value) 
        {
            throw new \Exception("IS NOT NULL can only be added to SELECT, UPDATE OR DELETE");
        }

        if($value) {$this->query->whereIsNull = " IS NULL";}
        else {$this->query->whereIsNull = " IS NOT NULL";}

        $this->query->_build($this->query->whereIsNull);

        return $this;
    }

    public function limit(int $start, int $offset): QueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT $start, $offset";
        $this->query->_build($this->query->limit);

        return $this;
    }

    public function orderBy(string $field, string $order = 'ASC'): QueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("ORDER BY can only be added to SELECT");
        }
        $this->query->orderBy = " ORDER BY $field $order";
        $this->query->_build($this->query->orderBy);
        
        return $this;
    }

    public function join(string $type = 'INNER', string $table): QueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("JOIN can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->join = " $type JOIN $table";
        $this->query->_build($this->query->join);
        
        return $this;
    }

    public function on(string $field, string $operator = '=', string $value): QueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("ON can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->on = " ON $field $operator '$value'";
        $this->query->_build($this->query->on);

        return $this;
    }

    public function getQuery(): string
    {
        {
            $query = $this->query->result;
            $query .= ";";

            $this->_createEmptyQueryObject();

            return $query;
        }
    }
}



?>