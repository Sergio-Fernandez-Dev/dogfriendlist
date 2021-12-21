<?php
namespace App\Models\Spots;

use App\Models\Interfaces\EntityInterface;

class Spot implements EntityInterface {

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @var int
     */
    private $category_id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $lat;
    /**
     * @var float
     */
    private $lng;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $created_at;

    /**
     * Devuelve un array con todas las propiedades de la clase.
     *
     * @param bool $only_valuated
     * @return array
     */
    public function getProperties(bool $only_valuated = true) {

        $properties = \get_object_vars($this);

        if ($only_valuated) {

//Si el valor es nulo o está vacío, lo eliminamos del array;
            foreach ($properties as $key => $value) {
                if (!isset($properties[$key])) {
                    unset($properties[$key]);
                }
            }
        }

        return $properties;
    }

    /**
     * Establece las propiedades de clase dinámicamente
     * en base a un array pasado por parámetro.
     *
     * @param array $data Lista de valores con los que rellenaremos nuestras propiedades de clase.
     * @param bool $override Permite sobreescribir los valores por defecto cuando recibimos un valor vacío.
     *
     * @return void
     */
    public function setProperties(array $data, ?bool $override = true) {

        foreach ($data as $key => $value) {
            if (empty($value) && !$override) {
                continue;
            }
            $this->$key = $value;
        }

    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUser_id() {
        return $this->user_id;
    }

    /**
     *@param int $user_id
     */
    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getCategory_id() {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategory_id($category_id) {
        $this->category_id = $category_id;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getLat() {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat) {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLng() {
        return $this->lng;
    }

    /**
     * @param float $lng
     */
    public function setLng($lng) {
        $this->lng = $lng;
    }

    /**
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

}

?>