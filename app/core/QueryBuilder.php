<?php 

namespace App\Core;

use App\Core\Interfaces\QueryBuilderInterface;
use stdClass;

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
        /* if(\is_array($sql_string))
        {
            $last = array_pop($sql_string);
            $this->query->result .=  $last;
            \array_push($sql_string, $last);
        } */
        if(empty($this->query->result)){$this->query->result = "";}

        $this->query->result .= $sql_string;
        
    }

    private function _implodeWithFormat(string $separator="", ?array $array)
    {
        $string = "";

        foreach($array as $value)
        {
            if(!next($array)) {$separator = "";}
            if(\is_string($value)) {$string .= "'".$value."'".$separator;}
            else {$string .= $value.$separator;}       
        }

        return $string;
    }

    public function sql(string $query): QueryBuilder
    {
        $this->query->base = $query;
        $this->_build($this->query->base);

        return $this;
    }

    public function insert(string $table, array $values, ?array $fields = null): QueryBuilder
    {
        if(!isset($fields))
        {
            $this->query->base = "INSERT INTO $table VALUES (".$this->_implodeWithFormat(", ", $values).")";
        }
        else 
        {
            $this->query->base = "INSERT INTO $table (".implode(", ", $fields).") VALUES (".$this->_implodeWithFormat(", ", $values).")";
        }

        $this->query->type = 'insert';  
        $this->_build($this->query->base);

        return $this;
    }

    public function select(array $fields = null): QueryBuilder
    {

        if(\is_null($fields) || implode($fields) == '*') 
        {
            $this->query->base = "SELECT *";
        }
        else
        {
            $this->query->base = "SELECT ".implode(", ", $fields);
        }

        $this->query->type = 'select';   
        $this->_build($this->query->base);

        return $this;
    }

    public function selectDistinct(?array $fields = null): QueryBuilder
    {
        if(\is_null($fields) || implode($fields) == '*') 
        {
            $this->query->base = "SELECT DISTINCT *";
        }
        else
        {
            $this->query->base = "SELECT DISTINCT ".implode(", ", $fields);
        }
        $this->query->type = 'select';
        $this->_build($this->query->base);

        return $this;
    }

    public function update(string $table): QueryBuilder
    {
        $this->_createEmptyQueryObject();
        $this->query->base = "UPDATE $table";
        $this->query->type = 'update';
        $this->_build($this->query->base);

        return $this;
    }

    public function delete(string $table): QueryBuilder
    {
        $this->_createEmptyQueryObject();
        $this->query->base = "DELETE FROM $table";
        $this->query->type = 'delete';
        $this->_build($this->query->base);

        return $this;
    }

    public function set (string $field, string $operator, string $value): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['update'])) 
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

        $this->_build(end($this->query->set));

        return $this; 
    }

    public function as(string $alias): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("AS can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->as = " AS $alias";
        $this->_build($this->query->as);

        return $this;
    }

    public function from(string $table): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("FROM can only be added to SELECT");
        }
        $this->query->from = " FROM $table";
        $this->_build($this->query->from);

        return $this;
    }

    public function where(string $field, string $operator, string $value): QueryBuilder
    {
        
        if(!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        if(isset($this->query->where) && !isset($this->query->join))
        {
            throw new \Exception("WHERE can't be used again. Try with AND Command");
        }
        if(\strcasecmp($value, 'IS NULL') == 0 || \strcasecmp($value, 'NOT NULL') == 0)
        {
            $value = \strtoupper($value);
            $this->query->where[] = " WHERE $field $value"; 
        }
        else
        {
            $this->query->where[] = " WHERE $field $operator '$value'";
        }
        $this->_build(end($this->query->where));

        return $this;
    }
    public function andWhere(string $field, string $operator, string $value): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("AND can only be added to SELECT, UPDATE OR DELETE");
        }
        if (!isset($this->query->where) && !isset($this->query->whereNot))
        {
            throw new \Exception("AND can only be added to WHERE commmand");
        }
    
        $this->query->andWhere[] = " AND $field $operator '$value'";
        $this->_build(end($this->query->andWhere));
        
        return $this;
    }
    public function orWhere(string $field, string $operator, string $value): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("OR can only be added to SELECT, UPDATE OR DELETE");
        }
        if (!isset($this->query->where) && !isset($this->query->whereNot))
        {
            throw new \Exception("OR can only be added to WHERE");
        }

        $this->query->orWhere[] = " OR $field $operator '$value'";
        $this->_build(end($this->query->orWhere));

        return $this;
    }
    public function whereNot(string $field, string $operator, string $value): QueryBuilder
    {
        if(!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("NOT can only be added to SELECT, UPDATE OR DELETE");
        }
        if(isset($this->query->where) && !isset($this->query->join))
        {
            throw new \Exception("WHERE NOT can't be used after WHERE command");
        }
        $this->query->whereNot[] = " WHERE NOT $field $operator '$value'";
        $this->_build(end($this->query->whereNot));

        return $this;
    }


    public function limit(int $start, int $offset): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT $start, $offset";
        $this->_build($this->query->limit);

        return $this;
    }

    public function orderBy(string $field, string $order = 'ASC'): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("ORDER BY can only be added to SELECT");
        }
        $this->query->orderBy = " ORDER BY $field $order";
        $this->_build($this->query->orderBy);
        
        return $this;
    }

    public function join(string $table, string $type = 'INNER'): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("JOIN can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->join = " $type JOIN $table";
        $this->_build($this->query->join);
        
        return $this;
    }

    public function on(string $field, string $operator = '=', string $value): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("ON can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->on = " ON $field $operator '$value'";
        $this->_build($this->query->on);

        return $this;
    }

    public function get(): string
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