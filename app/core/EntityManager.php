<?php
    namespace App\Core;

    use App\Core\Interfaces\EntityInterface;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;

    abstract class EntityManager {

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
        public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder, string $table) {

            $this->db = $db;
            $this->q_builder = $q_builder;

            $this->q_builder->setTableName($table);
        }

        /**
         * Inserta un objeto en la base de datos.
         *
         * @param EntityInterface $modelObject
         */
        public function add(EntityInterface $modelObject) {

            $query = $this->q_builder->insert($modelObject->getClassParams())
                ->get();

            \print_r($query['query']);
            echo '----------------------------------------------';
            \print_r($query['values']);

            $this->db->persist($query);
            $this->db->disconnect();
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

            $query = $this->q_builder->update($modelObject->getClassParams())
                ->where('id', '=', $modelObject->getId())
                ->get();

            $this->db->persist($query);
            $this->db->disconnect();
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

            $this->db->persist($query);
            $this->db->disconnect();

            unset($modelObject);
        }

        /**
         * @param $data
         */
        protected abstract function make(array $data);
    }

?>







































