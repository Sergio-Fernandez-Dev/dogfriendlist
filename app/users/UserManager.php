<?php
namespace App\Users;

use App\Users\User;
use App\Core\EntityManager;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Users\Interfaces\UserManagerInterface;

class UserManager extends EntityManager implements UserManagerInterface {

    /**
     * @var array
     */
    private $immutables = ['id', 'username', 'created_at'];

    /**
     * @param GatewayInterface $db
     * @param QueryBuilderInterface $q_builder
     */
    public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder) {

        parent::__construct($db, $q_builder, 'Users', $this->immutables);
    }

    /**
     * @return QueryBuilderInterface
     */
    public function getQueryBuilder(): QueryBuilderInterface {

        return $this->q_builder;
    }

    /**
     * Añade un usuario a nuestra base de datos, crea una clave de activación y una carpeta
     * con la id de usuario en nuestro directorio de almacenamiento.
     *
     * @param User $user
     * @return string
     */
    public function add($user) {

        if (null === $user->getActivationKey()) {
            $user->setActivationKey();
        }

        $this->_createUserFolder($user->getUsername());

        parent::add($user);

        return $user->getActivationKey();
    }

    /**
     * Borra a un usuario de la base de datos junto a todos sus archivos relacionados.
     *
     * @param $user
     */
    public function remove($user) {

        $this->_destroyUserFolder($user->getId());

        parent::remove($user);
    }

    /**
     * Utiliza el nombre de usuario para buscar un registro en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param string $username
     */
    public function findByUsername(string $username) {

        $query = $this->q_builder->select()
            ->where('username', '=', $username)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $user = $this->make($result);

        return $user;

    }

    /**
     * Utiliza el email del usuario para buscar en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param string $email
     */
    public function findByEmail(string $email) {

        $query = $this->q_builder->select()
            ->where('email', '=', $email)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $user = $this->make($result);

        return $user;
    }

    /**
     * Utiliza la ciudad del usuario para buscar en la base de datos y crea
     * un objeto con el resultado de la consulta.
     * @param string $city
     */
    public function findByCity(string $city) {

        $query = $this->q_builder->select()
            ->where('city', '=', $city)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $user = $this->make($result);

        return $user;
    }

    /**
     * Utiliza el país del usuario para buscar en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param string $country
     */
    public function findByCountry(string $country) {

        $query = $this->q_builder->select()
            ->where('country', '=', $country)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $user = $this->make($result);

        return $user;
    }

    /**
     * Utiliza el rol del usuario para buscar en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param int $role
     */
    public function findByRole(int $role) {

        $query = $this->q_builder->select()
            ->where('role', '=', $role)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $user = $this->make($result);

        return $user;
    }

    /**
     * Crea un objeto Usuario con los parámetros
     * pasados como argumento.
     *
     * @param array $data
     */
    public function make(array $data) {

        $user = new User();
        $user->setProperties($data);

        return $user;
    }

    /**
     * Crea una carpeta para almacenar los archivos relacionados con el usuario
     *
     * @param string $username
     */
    private function _createUserFolder(string $username) {

        $user = $this->findByUsername($username);

        if (!is_dir('../storage/users/' . $user->getId())) {
            mkdir('../storage/users/' . $user->getId(), 0777);
        }
    }

    /**
     * Accede de forma recursiva a todas las subcarpetas de nuestra carpeta de usuario
     * y borra cualquier archivo que encuentre. Una vez vaciada, borra la carpeta principal.
     *
     * @param int $user
     */
    private function _destroyUserFolder(int $id) {

        $folder = "../storage/users/$id";

        foreach (glob($folder . '/*') as $subfolder) {

            if (is_dir($subfolder)) {
                $this->_destroyUserFolder($subfolder);
            } else {
                unlink($subfolder);
            }
        }

        rmdir($folder);
    }
}

?>