<?php 

namespace App\Users;

use App\Users\Interfaces\UserRepositoryInterface;
use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\QueryBuilderInterface;

class UserRepository implements UserRepositoryInterface {
    private $dbh;
    private $qb;

    public function __construct(ConnectionInterface $dbh, QueryBuilderInterface $qb) {
        $this->dbh = $dbh;
        $this->qb = $qb;
    }
    
    

    public function find(int $id) {
        $query = $this->qb->select(['*'])
                        ->from('Users')
                        ->where('Id','=',$id)
                        ->get();
        
        $result = $this->_execute($query);

        return $this->_setUser($result);
    }

    public function save(User $user) {
        if($this->_checkIfItExists($user->id)) {
            $db_user = $this->find($user->id);

            foreach($db_user as $key => $value) {
                if (!empty($user[$key]) && $db_user[$key] != $user[$key]) {
                    $array[$key] = $value;
                }
        }

        $data = $user->getClassParams();
        $fields = [];
        $values = [];

        foreach($data as $key => $value) {
            $fields[] = $key;
            $values[] = $value;
        }

        $query = $this->qb->insert('Users', $fields, $values)
                        ->get();

        $result = $this->_checkIfItExists($user->getId());
        
        return $result;        
    }

    public function remove(User $user) {
        //TO-DO
    }

    private function _execute($query) {
        $this->dbh->connect();
        $row = $this->dbh->execute($query);
        $this->dbh->close();
        return $row;
    }

    private function _setUser($rows) {
        $user = new User();
        $user->setClassParams($rows, true);
        return $user;
    }

    private function _checkIfItExists(int $id) {
        $this->find($id) instanceof User ? true : false;
    }
}

?>