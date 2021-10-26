<?php
namespace App\Users;

use App\Core\Interfaces\EntityInterface;

class User implements EntityInterface {
    /**
     * @var string
     */
    private $about_me = null;

    /**
     * @var string
     */
    private $activation_key;

    /**
     * @var string
     */
    private $city = null;

    /**
     * @var string
     */
    private $country = null;

    /**
     * @var date
     */
    private $created_at;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $img = 'users/common/default-profile-picture.jpg';

    /**
     * @var string
     */
    private $name = null;

    /**
     * @var string
     */
    private $nickname;

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
    private $surname = null;

    /**
     * @var int
     */
    private $visibility = 1;

    public function __construct() {
        $this->created_at = date('Y-m-d H:i:s');
    }

    /**
     * Devuelve un array con todas las propiedades de la clase.
     *
     * @return array
     */
    public function getClassParams(): array
    {
        $properties['id'] = (int) $this->getId();
        $properties['nickname'] = $this->getNickname();
        $properties['email'] = $this->getEmail();
        $properties['visibility'] = (int) $this->getVisibility();
        $properties['city'] = $this->getCity();
        $properties['country'] = $this->getCountry();
        $properties['name'] = $this->getName();
        $properties['surname'] = $this->getSurname();
        $properties['img'] = $this->getImg();
        $properties['about_me'] = $this->getAboutMe();
        $properties['pass_hash'] = $this->getPassHash();
        $properties['role'] = (int) $this->getRole();
        $properties['activation_key'] = $this->getActivationKey();
        $properties['created_at'] = $this->getCreatedAt();

        return $properties;
    }

    /**
     * @param array $data
     * @param bool $override
     */
    public function setClassParams(array $data, ?bool $override = false): void {

        foreach ($data as $key => $value) {

            if (empty($value) && !$override) {
                continue;
            }

            \is_int($this->$key) ? $this->$key = (int) $value : $this->$key = $value;
        }

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
    public function getActivationKey() {
        return $this->activation_key;
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
     * @return date
     */
    public function getCreatedAt() {
        return $this->created_at;
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
    public function getId(): int {
        return $this->id;
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
    public function getName() {
        return $this->name;
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
    public function getSurname() {
        return $this->surname;
    }

    /**
     * @return int
     */
    public function getVisibility() {
        return $this->visibility;
    }

    /**
     * @param $about_me
     */
    public function setAboutMe($about_me) {
        $this->about_me = $about_me;
    }

    /**
     * @param $activation_key
     */
    public function setActivationKey($activation_key) {
        $this->activation_key = $activation_key;
    }

    /**
     * @param $city
     */
    public function setCity($city) {
        $this->city = $city;
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

    /**
     * @param $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * @param $created_at
     */
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    /**
     * @param $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @param $img
     */
    public function setImg($img) {
        $this->img = $img;
    }

    /**
     * @param $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param $nickname
     */
    public function setNickname($nickname) {
        $this->nickname = $nickname;
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
     * @param $surname
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * @param $visibility
     */
    public function setVisibility($visibility) {
        $this->visibility = $visibility;
    }

}
