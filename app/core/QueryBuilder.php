<?php 

namespace App\Core;

use App\Core\Interfaces\QueryBuilderInterface;
use stdClass;

/**
 * La clase QueryBuilder se encarga de construir
 * sentencias SQL mediante la combinación de sus métodos. 
 */
class QueryBuilder implements QueryBuilderInterface
{
    private $query;
    private $values_to_bind;
    private $secure_values;
    private $position = 0;

    public function __construct()
    {
        $this->_createEmptyQueryObject();
    }

    /**
     * Crea un objeto vacío
     *
     * @return void
     */
    private function _createEmptyQueryObject()
    {
        $this->query = new stdClass();
        $this->query->type = null;
    }

    /**
     * Construye la consulta
     *
     * @param int $sql_string
     * 
     * @return void
     */
    private function _build($sql_string)
    {
       
        if(empty($this->query->result)){$this->query->result = "";}

        $this->query->result .= $sql_string;
        
    }

    /**
     * Devuelve un string con los valores 
     * correctamente formateados.
     *
     /* @param string $separator
     //* @param array|null $array
     * 
     /* @return string
     */
    /* private function _implodeWithFormat(string $separator="", ?array $array)
    {
        $string = "";

        foreach($array as $value)
        {
            if(!next($array)) {$separator = "";}
            if(\is_string($value)) {$string .= "'".$value."'".$separator;}
            else {$string .= $value.$separator;}       
        }

        return $string;
    } */

    /**
     * Formatea los argumentos recibidos
     * para evitar inyección SQL
     * 
     * @param string|array $values
     * @return string|array
     */
    private function _secureValues($values)
    {
        $result = [];
        if(\is_array($values))
        {
            foreach($values as $value)
            {
                $this->values_to_bind[(string)$this->position] = $value;
                $this->secure_values[] = ":$this->position";

                $result[] = ":$this->position"; 

                $this->position++;
            }
        }
        else
        {
            $this->values_to_bind[(string)$this->position] = $values;
            $this->secure_values[] = ":$this->position";

            $result_string= ":$this->position"; 

            $this->position++;

            return $result_string;
        }

        return $result;
    }

    /**
     * Construye una sentencia SQL 
     * con la cadena pasada como argumento.
     * 
     * @param string $query
     * 
     * @return QueryBuilder
     */
    public function sql(string $query): QueryBuilder
    {
        $this->query->base = $query;
        $this->_build($this->query->base);

        return $this;
    }

    /**
     * Construye una sentencia del tipo INSERT
     *
     * @param string $table
     * @param array $values
     * @param array|null $fields
     * 
     * @return QueryBuilder
     */
    public function insert(string $table, array $values, ?array $fields = null): QueryBuilder
    {   
        $values = $this->_secureValues($values);

        if(!isset($fields))
        {
            $this->query->base = "INSERT INTO $table VALUES (".implode(", ", $values).")";
        }
        else 
        {
            $this->query->base = "INSERT INTO $table (".implode(", ", $fields).") VALUES (".implode(", ", $values).")";
        }

        $this->query->type = 'insert';  
        $this->_build($this->query->base);

        return $this;
    }

    /**
     * Construye una sentencia del tipo SELECT
     *
     * @param array|null $fields
     * 
     * @return QueryBuilder
     */
    public function select(array $fields = null): QueryBuilder
    {
        if($this->query->type == 'select')
        {
            $this->query->base = ", ".implode(", ", $fields);
            
        }
        elseif(\is_null($fields) || implode($fields) == '*') 
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

    /**
     * Construye una sentencia del tipo SELECT DINSTINCT
     *
     * @param array|null $fields
     * @return QueryBuilder
     */
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

    /**
     * Construye una sentencia del tipo UPDATE
     *
     * @param string $table
     *
     *  @return QueryBuilder
     */
    public function update(string $table): QueryBuilder
    {
        $this->_createEmptyQueryObject();
        $this->query->base = "UPDATE $table";
        $this->query->type = 'update';
        $this->_build($this->query->base);

        return $this;
    }


    /**
     * Construye una sentencia del tipo DELETE
     *
     * @param string $table
     * 
     * @return QueryBuilder
     */
    public function delete(string $table): QueryBuilder
    {
        $this->_createEmptyQueryObject();
        $this->query->base = "DELETE FROM $table";
        $this->query->type = 'delete';
        $this->_build($this->query->base);

        return $this;
    }

    /**
     * Construye una sentencia del tipo SET.
     *
     * @param string $field
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilder
     */
    public function set (string $field, string $operator, $value): QueryBuilder
    {
        
        if (!isset($this->query->type) || !in_array($this->query->type, ['update'])) 
        {
            throw new \Exception("SET can only be added to UPDATE");
        }
     
        $value = $this->_secureValues($value);
     
        if (empty($this->query->set))
        {
            $this->query->set[] = " SET $field $operator $value";
        }
        else
        {
            $this->query->set[] = ", $field $operator $value";
        }

        $this->_build(end($this->query->set));

        return $this; 
    }


    /**
     * Construye una sentencia del tipo AS.
     *
     * @param string $alias
     * 
     * @return QueryBuilder
     */
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

    /**
     * Construye una sentencia del tipo FROM
     *
     * @param string $table
     * 
     * @return QueryBuilder
     */
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

    /**
     * Construye una sentencia del tipo WHERE.
     *
     * @param string $field
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilder
     */
    public function where(string $field, string $operator, $value): QueryBuilder
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
            $value = $this->_secureValues($value);
            $this->query->where[] = " WHERE $field $operator $value";
        }
        $this->_build(end($this->query->where));

        return $this;
    }

    /**
     * Construye una sentencia del tipo AND.
     *
     * @param string $field
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilder
     */
    public function andWhere(string $field, string $operator, $value): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("AND can only be added to SELECT, UPDATE OR DELETE");
        }
        if (!isset($this->query->where) && !isset($this->query->whereNot))
        {
            throw new \Exception("AND can only be added to WHERE commmand");
        }
        
        $value = $this->_secureValues($value);
        $this->query->andWhere[] = " AND $field $operator $value";
        $this->_build(end($this->query->andWhere));
        
        return $this;
    }

    /**
     * Construye una sentencia del tipo OR.
     *
     * @param string $field
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilder
     */
    public function orWhere(string $field, string $operator, $value): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("OR can only be added to SELECT, UPDATE OR DELETE");
        }
        if (!isset($this->query->where) && !isset($this->query->whereNot))
        {
            throw new \Exception("OR can only be added to WHERE");
        }

        $value = $this->_secureValues($value);
        $this->query->orWhere[] = " OR $field $operator $value";
        $this->_build(end($this->query->orWhere));

        return $this;
    }

    /**
     * Construye una sentencia del tipo NOT.
     *
     * @param string $field
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilder
     */
    public function whereNot(string $field, string $operator, $value): QueryBuilder
    {
        if(!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("NOT can only be added to SELECT, UPDATE OR DELETE");
        }
        if(isset($this->query->where) && !isset($this->query->join))
        {
            throw new \Exception("WHERE NOT can't be used after WHERE command");
        }

        $value = $this->_secureValues($value);
        $this->query->whereNot[] = " WHERE NOT $field $operator $value";
        $this->_build(end($this->query->whereNot));

        return $this;
    }


    /**
     * Construye una sentencia del tipo LIMIT.
     *
     * @param integer $start
     * @param integer|null $offset
     * 
     * @return QueryBuilder
     */
    public function limit(int $start, int $offset = null): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        if (isset($offset))
        {    
            $this->query->limit = " LIMIT $start, $offset";
        }
        else
        {
            $this->query->limit = " LIMIT $start";
        }
            $this->_build($this->query->limit);

        return $this;
    }

    /**
     * Construye una sentencia del tipo ORDER BY.
     *
     * @param string $field
     * @param string $order
     * 
     * @return QueryBuilder
     */
    public function orderBy(string $field, string $order = 'ASC'): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select'])) 
        {
            throw new \Exception("ORDER BY can only be added to SELECT");
        }
        $order = \strtoupper($order);
        $this->query->orderBy = " ORDER BY $field $order";
        $this->_build($this->query->orderBy);
        
        return $this;
    }

    /**
     * Construye una sentencia del tipo JOIN.
     *
     * @param string $table
     * @param string $type
     * 
     * @return QueryBuilder
     */
    public function join(string $table, string $type = 'INNER'): QueryBuilder
    {
        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) 
        {
            throw new \Exception("JOIN can only be added to SELECT, UPDATE OR DELETE");
        }
        $type = \strtoupper($type);
        $this->query->join[] = " $type JOIN $table";
        $this->_build(end($this->query->join));
        
        return $this;
    }

    /**
     * Construye una sentencia del tipo ON.
     *
     * @param string $field
     * @param string $operator
     * @param string $value
     * 
     * @return QueryBuilder
     */
    public function on(string $field, string $operator, $value): QueryBuilder
    {
        if (!isset($this->query->join)) 
        {
            throw new \Exception("ON can only be added to JOIN");
        }

        $value = $this->_secureValues($value);
        $this->query->on[] = " ON $field $operator $value";
        $this->_build(end($this->query->on));

        return $this;
    }

    /**
     * Devuelve la query completa y resetea el objeto.
     * 
     * @return array
     */
    public function get(): array
    {
        {
            $query = $this->query->result;
            $query .= ";";

            $this->position = 0;
            $this->_createEmptyQueryObject();

            return [$query, $this->values_to_bind];
        }
    }
}
?>