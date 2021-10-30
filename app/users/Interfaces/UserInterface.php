<?php
namespace App\Users\Interfaces;

use App\Core\Interfaces\EntityInterface;

interface UserInterface extends EntityInterface {

    public function getNickname();

    public function getEmail();

    public function getVisibility();

    public function getCity();

    public function getCountry();

    public function getName();

    public function getSurname();

    public function getImg();

    public function getAboutMe();

    public function getPassHash();

    public function getRole();

    public function getActivationKey();

    public function getCreatedAt();

    /**
     * @param $nickname
     */
    public function setNickname($nickname);

    /**
     * @param $email
     */
    public function setEmail($email);

    /**
     * @param $visibility
     */
    public function setVisibility($visibility);

    /**
     * @param $city
     */
    public function setCity($city);

    /**
     * @param $country
     */
    public function setCountry($country);

    /**
     * @param $name
     */
    public function setName($name);

    /**
     * @param $surname
     */
    public function setSurname($surname);

    /**
     * @param $img
     */
    public function setImg($img);

    /**
     * @param $about_me
     */
    public function setAboutMe($about_me);

    /**
     * @param $pass_hash
     */
    public function setPassHash($pass_hash);

    /**
     * @param $role
     */
    public function setRole($role);

    /**
     * @param $activation_key
     */
    public function setActivationKey($activation_key);

    /**
     * @param $created_at
     */
    public function setCreatedAt($created_at);
}
}

?>

