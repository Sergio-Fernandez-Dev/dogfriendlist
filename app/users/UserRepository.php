<?php
namespace App\Users;

use App\Users\User;
use App\Users\UserFactory;
use App\Users\Interfaces\UserInterface;
use Exceptions\Db\UserNotFoundException;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Users\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

    /**
     * @var mixed
     */
    private $db;
    /**
     * @var mixed
     */
    private $qb;

    /**
     * @param GatewayInterface $db
     * @param QueryBuilderInterface $qb
     */
    public function __construct(GatewayInterface $db, QueryBuilderInterface $qb) {
        $this->db = $db;
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

        $this->db->connect();
        $user = $this->db->retrieve($query);
        $this->db->disconnect();

        return UserFactory::make($user);
    }

    /**
     * Registra o actualiza al usuario en la base de datos
     *
     * @param UserInterface $user
     * @return bool
     *
     * @throws UserNotFoundException
     */
    public function save($user) {

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

        $this->db->connect();
        $this->db->persist($query);
        $this->db->disconnect();

//Comprobamos que el usuario se ha creado
        if ($this->_checkIfItExists($user->getId())) {
            throw new UserNotFoundException();
        }

        return true;
    }

    /**
     * Elimina al Usuario de la base de datos
     *
     * @param UserInterface $user
     * @return bool
     *
     * @throws UserNotFoundException
     */
    public function remove(UserInterface $user) {

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
     * Comprueba si un usuario existe en la base de datos
     *
     * @param int $id
     */
    private function _checkIfItExists(int $id) {
        $this->find($id) instanceof User ? true : false;
    }

    public function findAll() {
        //TO-DO
    }

    /**
     * @param string $email
     */
    public function findByEmail(string $email) {
        //TO-DO
    }

    /**
     * @param string $nickname
     */
    public function findByNickname(string $nickname) {
        //TO-DO
    }

    /**
     * @param string $country
     */
    public function findByCountry(string $country) {
        //TO-DO
    }

    /**
     * @param string $city
     */
    public function findByCity(string $city) {
        //TO-DO
    }

    /**
     * @param int $role
     */
    public function findByRole(int $role) {
        //TO-DO
    }

    /**
     * @param int $id
     */
    public function delete(int $id) {
        //TO-DO
    }

}

?>