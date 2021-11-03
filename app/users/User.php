<?php
namespace App\Users;

use App\Users\Interfaces\UserInterface;

class User implements UserInterface {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $visibility = 1;

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
    private $pass_hash;

    /**
     * @var int
     */
    private $role = 0;

    /**
     * @var string
     */
    private $activation_key = null;

    /**
     * @var date
     */
    private $created_at;

    /**
     * Devuelve un array con todas las propiedades de la clase.
     *
     * @return array
     */
    public function getClassParams() {

        $properties = \get_object_vars($this);

//Si el valor es nulo o está vacío, lo eliminamos del array;
        foreach ($properties as $key => $value) {

            if (!isset($properties[$key])) {
                unset($properties[$key]);
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
    public function setClassParams(array $data, ?bool $override = true) {

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
     * @return string
     */
    public function getNickname() {
        return $this->nickname;
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
    public function getPassHash() {
        return $this->pass_hash;
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
     * @param $nickname
     */
    public function setNickname($nickname) {
        $this->nickname = $nickname;
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
    public function setPassHash($pass_hash) {
        $this->pass_hash = $pass_hash;
    }

    /**
     * @param $role
     */
    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * @param $activation_key
     */
    public function setActivationKey($activation_key) {
        $this->activation_key = $activation_key;
    }

}
