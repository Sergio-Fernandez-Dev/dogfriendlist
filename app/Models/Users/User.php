<?php
namespace App\Models\Users;

use App\Models\Interfaces\EntityInterface;;

class User implements EntityInterface {

    /**
     * @var int
     */
    private int $id = 0;

    /**
     * @var string
     */
    private $username = null;

    /**
     * @var string
     */
    private $email = null;

    /**
     * @var int
     */
    private int $visibility = 1;

    /**
     * @var string
     */
    private $city = null;

    /**
     * @var string
     */
    private $country = null;

    /**
     * @var string
     */
    private $name = null;

    /**
     * @var string
     */
    private $surname = null;

    /**
     * @var string
     */
    private $img = 'users/common/default-profile-picture.jpg';

    /**
     * @var string
     */
    private $about_me = null;

    /**
     * @var string
     */
    private $password = null;

    /**
     * @var int
     */
    private int $role = 0;

    /**
     * @var string
     */
    private $activation_key = null;

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

        foreach ($properties as $key => $value) {
//Si el valor es nulo o está vacío, lo eliminamos del array.
            if ($only_valuated) {
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
    public function setProperties(array $data, bool $override = true) {

        foreach ($data as $key => $value) {

            //Si el parámetro está vacío y la sobreescritura está desactivada, saltamos al siguiente.
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
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getVisibility() {
        return $this->visibility;
    }

    /**
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getImg() {
        return $this->img;
    }

    /**
     * @return string
     */
    public function getAboutMe() {
        return $this->about_me;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getActivationKey() {
        return $this->activation_key;
    }

    /**
     * @return string
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * @param $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @param $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @param $visibility
     */
    public function setVisibility($visibility) {
        $this->visibility = $visibility;
    }

    /**
     * @param $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * @param $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * @param $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param $surname
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * @param $img
     */
    public function setImg($img) {
        $this->img = $img;
    }

    /**
     * @param $about_me
     */
    public function setAboutMe($about_me) {
        $this->about_me = $about_me;
    }

    /**
     * @param $pass_hash
     */
    public function setPassword($password) {
        $this->password = \md5($password);
    }

    /**
     * @param $role
     */
    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * Creamos una clave de activación aleatoria utilizando el correo
     * del usuario y la fecha del momento de creación o utilizamos el valor
     * pasado como argumento.
     * 
     * @param $key
     */
    public function setActivationKey($custom_key = false) {
        
        $custom_key === false ? $this->activation_key = \md5($this->email . \date('d-m-Y H:i:s')) : $this->activation_key = $custom_key;
    }

}
?>