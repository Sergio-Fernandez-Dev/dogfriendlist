<?php
namespace App\Models\Users;

use App\Models\Users\User;
use App\Models\EntityHandler;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Models\Users\Interfaces\UserHandlerInterface;

class UserHandler extends EntityHandler implements UserHandlerInterface {

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

        parent::add($user);

        $this->_createUserFolder($user->getUsername());

        return $user->getActivationKey();
    }

    /**
     * Borra a un usuario de la base de datos junto a todos sus archivos relacionados.
     *
     * @param $user
     */
    public function remove($user) {

        $this->_destroyUserFolder('../storage/users/' . $user->getId());

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

        if (empty($result)) {
            $user_list[] = $this->make($result);
        } else {
            foreach ($result as $user) {
                $user_list[] = $this->make($user);
            }
        }

        return $user_list[0];

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

        if (empty($result)) {
            $user_list[] = $this->make($result);
        } else {
            foreach ($result as $user) {
                $user_list[] = $this->make($user);
            }
        }

        return $user_list[0];
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

        $user_list = [];

        foreach ($result as $user) {
            $user_list[] = $this->make($user);
        }

        return $user_list;
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

        $user_list = [];

        foreach ($result as $user) {
            $user_list[] = $this->make($user);
        }

        return $user_list;
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

        $user_list = [];

        foreach ($result as $user) {
            $user_list[] = $this->make($user);
        }

        return $user_list;
    }

    /**
     * Crea un objeto Usuario con los parámetros
     * pasados como argumento.
     *
     * @param array $data
     */
    public function make(array $data) {

        $user = new User();

        // Si el array está vacío, lo llenamos con los valores por defecto
        if (empty($data)) {
            return $user;
        }

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
     * @param string $folder
     */
    private function _destroyUserFolder($folder) {

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