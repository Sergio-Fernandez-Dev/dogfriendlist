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
    private $immutables = ['id', 'nickname', 'created_at'];

    /**
     * @param GatewayInterface $db
     * @param QueryBuilderInterface $q_builder
     */
    public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder) {

        parent::__construct($db, $q_builder, 'Users', $this->immutables);
    }

    /**
     * @param $user
     */
    public function add($user) {

        $user->setActivationKey();

        parent::add($user);

        return $user->getActivationKey();

    }

    /**
     * Utiliza el nombre de usuario para buscar un registro en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param string $nickname
     */
    public function findByNickname(string $nickname) {

        $query = $this->q_builder->select()
            ->where('nickname', '=', $nickname)
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
}

?>