<?php
namespace App\Core\Interfaces;

interface EntityHandlerInterface {

    /**
     * @param EntityInterface $modelObject
     */
    public function add(EntityInterface $modelObject);

    /**
     * @param int $id
     */
    public function find(int $id);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param EntityInterface $modelObject
     */
    public function save(EntityInterface $modelObject);

    /**
     * @param int $id
     */
    public function remove(EntityInterface $modelObject);
}

?>

