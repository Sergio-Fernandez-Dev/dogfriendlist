<?php
namespace App\Spots;

use App\Core\EntityManager;
use App\Spots\Interfaces\SpotManagerInterface;

class SpotManager extends EntityManager implements SpotManagerInterface {

    /**
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
     * @param float $long
     * @param float $lat
     */
    public function findByCloseness(float $long, float $lat) {

        //TO-DO
    }

    /**
     * @param $data
     */
    public function make($data) {

        $spot = new Spot();
        $spot->setClassParams($data);

        return $spot;
    }

}
?>