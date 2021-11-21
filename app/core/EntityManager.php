<?php
namespace App\Core;

use LogicException;
use App\Core\Interfaces\EntityInterface;
use Exceptions\Db\UserNotFoundException;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Core\Interfaces\EntityManagerInterface;

abstract class EntityManager implements EntityManagerInterface {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var QueryBuilderInterface
     */
    protected $q_builder;

    /**
     * @var GatewayInterface
     */
    protected $db;

    /**
     * @param string $table
     * @param QueryBuilderInterface $q_builder
     */
    public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder, string $table, array $immutables) {

        $this->db = $db;
        $this->q_builder = $q_builder;

        $this->q_builder->setTableName($table);
        $this->q_builder->setImmutableValues($immutables);
    }

    /**
     * Inserta un objeto en la base de datos.
     *
     * @param EntityInterface $modelObject
     */
    public function add(EntityInterface $modelObject) {

        $query = $this->q_builder->insert($modelObject->getClassParams())
            ->get();

        $stmt = $this->db->persist($query);
        $this->db->disconnect();

        return $stmt;
    }

    /**
     * Busca un registro en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param int $id
     */
    public function find(int $id) {

        $query = $this->q_builder->select()
            ->where('id', '=', $id)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        if (empty($result)) {
            throw new UserNotFoundException();
        }

        $modelObject = $this->make($result);

        return $modelObject;
    }

    /**
     * Busca todos los registros de una tabla
     * y crea una lista de objetos con cada uno de ellos.
     *
     * @return mixed
     */
    public function findAll() {

        $query = $this->q_builder->select()
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $object_list = [];

        foreach ($result as $row) {
            $object_list[] = $this->make($row);
        }

        return $object_list;
    }

    /**
     * Actualiza en nuestra base de datos
     * los cambios hechos en el objeto pasado como parámetro.
     *
     * @param EntityInterface $modelObject
     */
    public function save(EntityInterface $modelObject) {

        $values = $modelObject->getClassParams();

        $query = $this->q_builder->update($values)
            ->where('id', '=', $modelObject->getId())
            ->get();

        $stmt = $this->db->persist($query);
        $this->db->disconnect();

        return $stmt;
    }

    /**
     * Borra el objeto pasado como parámetro
     * y su correspondiente registro en la base de datos.
     *
     * @param int $id
     */
    public function remove(EntityInterface $modelObject) {

        $query = $this->q_builder->delete()
            ->where('id', '=', $modelObject->getId())
            ->get();

        $stmt = $this->db->persist($query);
        $this->db->disconnect();

        unset($modelObject);

        return $stmt;
    }

    /**
     * Permite ejecutar consultas personalizadas en la base de datos
     *
     * @param array $query
     * @param string $kind Establece si la consulta debe persistir los datos u obtenerlos.
     * @return mixed
     */
    public function raw(array $query, string $kind) {

        if ('persist' == $kind) {

            $stmt = $this->db->persist($query);
            $this->db->disconnect();

            return $stmt;

        } elseif ('retrieve' == $kind) {

            $result = $this->db->retrieve($query);
            $this->db->disconnect();

            $modelObject = $this->make($result);

            return $modelObject;

        } else {
            throw new LogicException('El método de consulta debe ser tipo "retrieve" o "persist"');
        }

    }

    /**
     * @param $data
     */
    protected abstract function make(array $data);
}

?>

























