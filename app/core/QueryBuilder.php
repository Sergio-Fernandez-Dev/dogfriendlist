<?php
namespace App\Core;

use stdClass;
use App\Core\Interfaces\QueryBuilderInterface;

/**
 * La clase QueryBuilder se encarga de construir
 * sentencias SQL mediante la combinación de sus métodos.
 */
class QueryBuilder implements QueryBuilderInterface {
    /**
     * @var mixed
     */
    private $query;
    /**
     * @var mixed
     */
    private $values_to_bind;
    /**
     * @var mixed
     */
    private $secure_values;
    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var string
     */
    private $table;

    /**
     * Establece el nombre de la tabla sobre la que
     * se realizarán las consultas. Este método debe
     * ser llamado antes de ejecutar cualquier consulta,
     * preferiblemente en el constructor de la clase que lo implemente.
     *
     * @param string $table
     */
    public function setTableName(string $table) {
        $this->table = $table;
        $this->_createEmptyQueryObject($table);
    }

    /**
     * Construye una sentencia SQL
     * con la cadena pasada como argumento.
     *
     * @param string $query
     *
     * @return QueryBuilder
     */
    public function raw(string $query) {
        $this->query->base = $query;
        $this->_build($this->query->base);

        return $this;
    }

    /**
     * Construye una sentencia del tipo INSERT
     *
     * @param array $data
     *
     * @return QueryBuilder
     */
    public function insert(array $data) {

        $columns = [];
        $values = [];

        foreach ($data as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }

        $values = $this->_secureValues($values);

        $this->query->base = "INSERT INTO $this->table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
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
    public function select() {

        $this->query->base = "SELECT * FROM $this->table";
        $this->query->type = 'select';

        $this->_build($this->query->base);

        return $this;
    }

    /**
     * Construye una sentencia del tipo SELECT DINSTINCT
     *
     * @param array|null $columns
     * @return QueryBuilder
     */
    public function selectDistinct(...$columns) {

        if (empty($columns)) {
            throw new \Exception("SELECT DISTINCT necesita recibir algún campo para realizar la consulta");
        }

        if (in_array($this->query->type, ['select'])) {
            throw new \Exception("SELECT DISTINCT no puede utilizarse junto a una sentencia SELECT");
        }

        $this->query->base = "SELECT DISTINCT " . implode(", ", $columns) . " FROM $this->table";
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
    public function update(array $data) {

        $this->_createEmptyQueryObject($this->table);

        $string = "";

        foreach ($data as $key => $value) {
            $value = $this->_secureValues($value);
            $string .= " $key = $value,";
        }

        $string = \trim($string, ','); //Borramos la última coma
        $string = \trim($string, ' '); //Borramos el primer espacio

        $this->query->base = "UPDATE $this->table SET $string";
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
    public function delete() {

        $this->_createEmptyQueryObject($this->table);

        $this->query->base = "DELETE FROM $this->table";
        $this->query->type = 'delete';

        $this->_build($this->query->base);

        return $this;
    }

    /**
     * Construye una sentencia del tipo WHERE.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return QueryBuilder
     */
    public function where(string $column, string $operator, $value) {

        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }

        if (isset($this->query->where)) {
            throw new \Exception("WHERE can't be used again. Try with AND Command");
        }

        if (\strcasecmp($value, 'IS NULL') == 0 || \strcasecmp($value, 'NOT NULL') == 0) {
            $value = \strtoupper($value);
            $this->query->where[] = " WHERE $column $value";
        } else {
            $value = $this->_secureValues($value);
            $this->query->where[] = " WHERE $column $operator $value";
        }

        $this->_build(end($this->query->where));

        return $this;
    }

    /**
     * Construye una sentencia del tipo AND.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return QueryBuilder
     */
    public function andWhere(string $column, string $operator, $value) {

        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("AND can only be added to SELECT, UPDATE OR DELETE");
        }

        if (!isset($this->query->where) && !isset($this->query->whereNot)) {
            throw new \Exception("AND can only be added to WHERE commmand");
        }

        $value = $this->_secureValues($value);
        $this->query->andWhere[] = " AND $column $operator $value";
        $this->_build(end($this->query->andWhere));

        return $this;
    }

    /**
     * Construye una sentencia del tipo OR.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return QueryBuilder
     */
    public function orWhere(string $column, string $operator, $value) {

        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("OR can only be added to SELECT, UPDATE OR DELETE");
        }

        if (!isset($this->query->where) && !isset($this->query->whereNot)) {
            throw new \Exception("OR can only be added to WHERE");
        }

        $value = $this->_secureValues($value);
        $this->query->orWhere[] = " OR $column $operator $value";
        $this->_build(end($this->query->orWhere));

        return $this;
    }

    /**
     * Construye una sentencia del tipo NOT.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return QueryBuilder
     */
    public function whereNot(string $column, string $operator, $value) {

        if (!isset($this->query->type) || !in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("NOT can only be added to SELECT, UPDATE OR DELETE");
        }

        if (isset($this->query->where) && !isset($this->query->join)) {
            throw new \Exception("WHERE NOT can't be used after WHERE command");
        }

        $value = $this->_secureValues($value);
        $this->query->whereNot[] = " WHERE NOT $column $operator $value";
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
    public function limit(int $start, int $offset = null) {

        if (!isset($this->query->type) || !in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }

        if (isset($offset)) {
            $this->query->limit = " LIMIT $start, $offset";
        } else {
            $this->query->limit = " LIMIT $start";
        }

        $this->_build($this->query->limit);

        return $this;
    }

    /**
     * Construye una sentencia del tipo ORDER BY.
     *
     * @param string $column
     * @param string $order
     *
     * @return QueryBuilder
     */
    public function orderBy(string $column, string $order = 'ASC') {

        if (!isset($this->query->type) || !in_array($this->query->type, ['select'])) {
            throw new \Exception("ORDER BY can only be added to SELECT");
        }

        $order = \strtoupper($order);
        $this->query->orderBy = " ORDER BY $column $order";
        $this->_build($this->query->orderBy);

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

            $values_to_bind = $this->values_to_bind;

            $this->position = 0;
            $this->_createEmptyQueryObject($this->table);

            print_r($this->values_to_bind);

            return ['query' => $query, 'values' => $values_to_bind];
        }

    }

    /**
     * Crea un objeto vacío
     *
     * @return void
     */
    private function _createEmptyQueryObject($table) {
        $this->query = new stdClass();
        $this->query->type = null;
        $this->values_to_bind = [];
        $this->table = $table;
    }

    /**
     * Construye la consulta
     *
     * @param int $sql_string
     *
     * @return void
     */
    private function _build($sql_string) {

        if (empty($this->query->result)) {$this->query->result = "";}

        $this->query->result .= $sql_string;

    }

    /**
     * Formatea los argumentos recibidos
     * para evitar inyección SQL
     *
     * @param string|array $values
     * @return string|array
     */
    private function _secureValues($values) {
        $result = [];

        if (\is_array($values)) {

            foreach ($values as $value) {
                $this->values_to_bind[":$this->position"] = $value;
                $this->secure_values[] = ":$this->position";

                $result[] = ":$this->position";

                $this->position++;
            }

        } else {
            $this->values_to_bind[":$this->position"] = $values;
            $this->secure_values[] = ":$this->position";

            $result_string = ":$this->position";

            $this->position++;

            return $result_string;
        }

        return $result;
    }

}

?>