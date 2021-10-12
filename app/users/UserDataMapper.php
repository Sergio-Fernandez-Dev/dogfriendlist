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
        $query = "INSERT INTO `USERS` (`Id`,`Nickname`,`Email`,`Visibility`,`City`,`Country`,`Name`,`Surname`,`Img`,`AboutMe`,`PassHash`,`CreatedAt`) 
        VALUES (1, 'Loop 501 Talla S', '100.00', '125.00', 1), "
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