<?php 

namespace App\Users;

use App\Users\User;
use App\Core\BaseDataMapper;
use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\EntityInterface;

class UserDataMapper extends BaseDataMapper
{
    public function __construct(ConnectionInterface $dbh)
    {
        $this->dbh = $dbh;
    }

    protected function createObject()
    {
        return new User();
    }

    protected function fillObject(EntityInterface $object, array $data)
    {
        $object->setClassParams($data, false);
    }

    protected function insertObject(EntityInterface $object)
    {
        //TODO
    }

    protected function updateObject(EntityInterface $object)
    {
        //TODO
    }

    protected function deleteObject(EntityInterface $object)
    {
        //TODO
    }
}

?>