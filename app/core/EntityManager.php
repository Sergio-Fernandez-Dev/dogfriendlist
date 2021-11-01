<?php
namespace App\Core;

use App\Core\Interfaces\EntityInterface;

abstract class EntityManager {

    /**
     * @var mixed
     */
    private $table_name;

    /**
     * @param $table_name
     */
    public function __construct($table_name) {
        $this->table_name = (string) $table_name;
    }

    /**
     * @param EntityInterface $modelObject
     */
    public function add(EntityInterface $modelObject) {
        //TO-DO
    }

    /**
     * @param int $id
     */
    public function find(int $id) {
        //TO-DO
    }

    public function findAll() {
        //TO-DO
    }

    /**
     * @param EntityInterface $modelObject
     */
    public function save(EntityInterface $modelObject) {
        //TO-DO
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
