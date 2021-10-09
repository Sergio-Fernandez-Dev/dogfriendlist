<?php 

namespace App\Core;

use App\Core\Connection;
use App\Core\BaseModel;
use App\Interfaces\ConnectionInterface;
use App\Interfaces\EntityInterface;

abstract class BaseDataMapper
{

    public function create(array $data = null)
    {
        $object = $this->createObject();
        if($data)
        {
            $object = $this->fillObject($object, $data);
        }

        return $object;
    }

    public function save(EntityInterface $object)
    {
        if(\is_null($object->getId()))
        {
            $this->insertObject($object);
        }
        else
        {
            $this->updateObject($object);
        }
    }

    public function delete(EntityInterface $object)
    {
        $this->deleteObject($object);
    }
    
    abstract protected function createObject();
    abstract protected function fillObject(EntityInterface $object, array $data);
    abstract protected function insertObject(EntityInterface $object);
    abstract protected function updateObject(EntityInterface $object);
    abstract protected function deleteObject(EntityInterface $object);
}     

?>