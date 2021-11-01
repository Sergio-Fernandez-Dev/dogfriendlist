<?php
    namespace App\Core;

    use App\Core\Interfaces\EntityInterface;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;

    abstract class EntityManager {

        /**
         * @var string
         */
        protected $table_name;

        /**
         * @var Queryq_BuilderInterface
         */
        protected $q_builder;

        /**
         * @var GatewayInterface
         */
        protected $db;

        /**
         * @param string $table_name
         * @param Queryq_BuilderInterface $q_builder
         */
        public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder, string $table_name) {

            $this->db = $db;
            $this->q_builder = $q_builder;

            $this->q_builder->setTableName($table_name);
        }

        /**
         * Inserta un objeto en la base de datos.
         *
         * @param EntityInterface $modelObject
         */
        public function add(EntityInterface $modelObject) {

            $query = $this->q_builder->insert($modelObject->getClassParams());
            $this->db->persist($query);
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

            $object_list = [];

            foreach ($result as $row) {
                $object_list[] = $this->make($row);
            }

            return $object_list;
        }

        /**
         * Actualiza en nuestra base de datos
         * los cambios hechos en nuestro objeto.
         *
         * @param EntityInterface $modelObject
         */
        public function save(EntityInterface $modelObject) {

            $query = $this->q_builder->update($modelObject->getClassParams())
                ->where('id', '=', $modelObject->getId())
                ->get();
        }

        /**
         * @param int $id
         */
        public function remove(int $id) {
            //TO-DO
        }

        /**
         * @param $data
         */
        protected abstract function make($data);
    }

?>





















