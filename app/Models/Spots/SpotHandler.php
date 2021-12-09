<?php
namespace App\Models\Spots;

use App\Models\EntityHandler;
use App\Core\Interfaces\GatewayInterface;
use App\Core\Interfaces\QueryBuilderInterface;
use App\Models\Spots\Interfaces\SpotHandlerInterface;

class SpotHandler extends EntityHandler implements SpotHandlerInterface {

    /**
     * @var array
     */
    private $immutables = ['id', 'user_id', 'created_at'];

    /**
     * @param GatewayInterface $db
     * @param QueryBuilderInterface $q_builder
     */
    public function __construct(GatewayInterface $db, QueryBuilderInterface $q_builder) {

        parent::__construct($db, $q_builder, 'Spots', $this->immutables);
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
     * Utiliza la categoría del spot para buscar un registro en la base de datos y crea
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
     * un array de objetos con el resultado de la consulta.
     *
     * @param float $long
     * @param float $lat
     * @param float $distance
     *
     * @return array
     */
    public function findByCloseness(float $lat, float $lng, float $distance = 1) {

        $box = $this->_getBoundaries($lat, $lng, $distance);

        $query = $this->q_builder->raw(
            'SELECT *, ( 6371 * ACOS(
                COS( RADIANS(' . $lat . '))
                * COS(RADIANS( lat ))
                * COS(RADIANS( lng )
                - RADIANS(' . $lng . '))
                + SIN( RADIANS(' . $lat . '))
                * SIN(RADIANS( lat ))
               )
            ) AS distance
             FROM Spots
             WHERE (lat BETWEEN ' . $box['min_lat'] . ' AND ' . $box['max_lat'] . ')
             AND (lng BETWEEN ' . $box['min_lng'] . ' AND ' . $box['max_lng'] . ')
             HAVING distance < ' . $distance . '
             ORDER BY distance ASC')
            ->get();

        $result = $this->db->retrieve($query);
        $this->db->disconnect();

        $spot_list[] = $this->make($result);

        return $spot_list;
    }

    /**
     * Crea un objeto Spot con los parámetros
     * pasados como argumento.
     *
     * @param $data
     *
     * @return Spot
     */
    public function make($data) {

        $spot = new Spot();
        $spot->setProperties($data);

        return $spot;
    }

    /**
     * @param $lat
     * @param $lng
     * @param $distance
     *
     * @return array
     */
    private function _getBoundaries($lat, $lng, $distance = 1) {
        $earthRadius = 6371;

        $return = [];

        // Los angulos para cada dirección
        $cardinalCoords = [
            'north' => '0',
            'south' => '180',
            'east'  => '90',
            'west'  => '270',
        ];

        $rLat = deg2rad($lat);
        $rLng = deg2rad($lng);
        $rAngDist = $distance / $earthRadius;

        foreach ($cardinalCoords as $name => $angle) {
            $rAngle = deg2rad($angle);
            $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
            $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));

            $return[$name] = ['lat' => (float) rad2deg($rLatB),
                'lng'                   => (float) rad2deg($rLonB)];
        }

        return [
            'min_lat' => $return['south']['lat'],
            'max_lat' => $return['north']['lat'],
            'min_lng' => $return['west']['lng'],
            'max_lng' => $return['east']['lng'],
        ];
    }

}
?>