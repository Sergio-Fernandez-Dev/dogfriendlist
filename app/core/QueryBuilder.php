<?php 

namespace App\Core;

use App\Core\Interfaces\QueryBuilderInterface;
use stdClass;

class QueryBuilder implements QueryBuilderInterface
{
    private $query;

    private function _createEmptyQueryObject()
    {
        $this->query = new stdClass();
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
        if (!in_array($this->query->type, ['create', 'select', 'update', 'delete', ])) {
            throw new \Exception("AS can only be added to CREATE, SELECT, UPDATE OR DELETE");
        }
        $this->query->as = "AS '$alias'";

        return $this;
    }

    public function from(string $table)
    {
        //TODO
    }

    public function where(string $field, string $operator = '=', string $value)
    {
        //TODO
    }

    public function limit(int $start, int $offset)
    {
        //TODO
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