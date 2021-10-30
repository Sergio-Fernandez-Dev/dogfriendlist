<?php
namespace App\Users;

use Exceptions\Db\UserNotFoundException;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Users\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    /**
     * @var mixed
     */
    private $dbh;
    /**
     * @var mixed
     */
    private $qb;

    /**
     * @param GatewayInterface $dbh
     * @param QueryBuilderInterface $qb
     */
    public function __construct(GatewayInterface $dbh, QueryBuilderInterface $qb) {
        $this->dbh = $dbh;
        $this->qb = $qb;
    }

    /**
     * Busca al usuario en la base de datos;
     *
     * @param $id
     * @return mixed
     */
    public function find($id) {

        $query = $this->qb->select(['*'])
            ->from('Users')
            ->where('Id', '=', $id)
            ->get();

        $result = $this->_execute($query);

        return $this->_setUser($result);
    }

    /**
     * Registra o actualiza al usuario en la base de datos
     *
     * @param User $user
     * @return bool
     *
     * @throws UserNotFoundException
     */
    public function save(User $user) {

//Si el usuario existe
        if ($this->_checkIfItExists($user->getId())) {
            $db_user = $this->find($user->getId());
            $fields = [];
            $values = [];

            foreach ($db_user as $key => $value) {

//Comprobamos qué valores han sido modificados y los almacenamos
                if (!empty($user[$key]) && $db_user[$key] != $user[$key]) {
                    $fields[] = $key;
                    $values[] = $value;
                }

            }

            //Creamos una consulta de actualización
            $query = $this->qb->update('Users')
                ->setFromArray($fields, '=', $values)
                ->where('id', '=', $user->getId())
                ->get();

            //Si el usuario no existe
        } else {

            //Obtenemos todos sus parámetros
            $data = $user->getClassParams();
            $fields = [];
            $values = [];

//Y los almacenamos
            foreach ($data as $key => $value) {
                $fields[] = $key;
                $values[] = $value;
            }

            //Creamos una consulta de inserción
            $query = $this->qb->insert('Users', $fields, $values)
                ->get();

        }

        $this->_execute($query);

//Comprobamos que el usuario se ha creado
        if ($this->_checkIfItExists($user->getId())) {
            throw new UserNotFoundException();
        }

        return true;
    }

    /**
     * Elimina al Usuario de la base de datos
     *
     * @param User $user
     * @return bool
     *
     * @throws UserNotFoundException
     */
    public function remove(User $user) {

//Comprobamos que el Usuario existe
        if ($this->_checkIfItExists($user->getId())) {
            throw new UserNotFoundException();
        }

        $query = $this->qb->delete('Users')
            ->where('id', '=', $user->getId())
            ->get();
    }

    /**
     * Ejecuta una consulta en nuestra base de datos
     *
     * @param array $query
     * @return mixed
     */
    private function _execute($query) {

        $this->dbh->connect();
        $row = $this->dbh->execute($query);
        $this->dbh->disconnect();

        return $row;
    }

    /**
     * Crea un nuevo usuario con los parámetros obtenidos de la base de datos
     *
     * @param array $rows
     * @return mixed
     */
    private function _setUser($rows) {
        $user = new User();
        $user->setClassParams($rows, true);

        return $user;
    }

    /**
     * Comprueba si un usuario existe en la base de datos
     *
     * @param int $id
     */
    private function _checkIfItExists(int $id) {
        $this->find($id) instanceof User ? true : false;
    }

}

?>