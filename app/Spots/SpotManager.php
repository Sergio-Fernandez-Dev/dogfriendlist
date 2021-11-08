<?php
namespace App\Spots;

use App\Core\EntityManager;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Spots\Interfaces\SpotManagerInterface;

class SpotManager extends EntityManager implements SpotManagerInterface {

    /**
     * @param GatewayInterface $db
     * @param QueryBuilderInterface $q_builder
     */
    public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder) {

        parent::__construct($db, $q_builder, 'Spots');
    }

    /**
     * Utiliza el nombre de usuario que creó el spot para buscar un registro en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param int $user_id
     */
    public function findByUser(int $user_id) {

        $query = $this->q_builder->select()
            ->where('user_id', '=', $user_id)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $spot = $this->make($result);

        return $spot;
    }

    /**
     * Utiliza la dirección del spot para buscar un registro en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param string $address
     */
    public function findByAddress(string $address) {

        $query = $this->q_builder->select()
            ->where('address', '=', $address)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $spot = $this->make($result);

        return $spot;
    }

    /**
     * Utiliza la ciudad del spot para buscar un registro en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param string $city
     */
    public function findByCity(string $city) {

        $query = $this->q_builder->select()
            ->where('city', '=', $city)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $spot = $this->make($result);

        return $spot;
    }

    /**
     * Utiliza el país del spot para buscar un registro en la base de datos y crea
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

        $spot = $this->make($result);

        return $spot;
    }

    /**
     * Utiliza la categgoría del spot para buscar un registro en la base de datos y crea
     * un objeto con el resultado de la consulta.
     *
     * @param int $category_id
     */
    public function findByCategory(int $category_id) {

        $query = $this->q_builder->select()
            ->where('category_id', '=', $category_id)
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $spot = $this->make($result);

        return $spot;
    }

    /**
     * Busca en la base de datos los spots más cercanos a la ubicación del usuario y crea
     * un objeto con el resultado de la consulta.
     *
     * @param float $long
     * @param float $lat
     */
    public function findByCloseness(float $long, float $lat) {

        //TO-DO
    }

    /**
     * Crea un objeto Spot con los parámetros
     * pasados como argumento.
     *
     * @param $data
     */
    public function make($data) {

        $spot = new Spot();
        $spot->setProperties($data);

        return $spot;
    }

}
?>