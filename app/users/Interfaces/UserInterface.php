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
         * @param string $nickname
         */
        public function setNickname(string $nickname);

        /**
         * @param string $email
         */
        public function setEmail(string $email);

        /**
         * @param int $visibility
         */
        public function setVisibility(int $visibility);

        /**
         * @param string $city
         */
        public function setCity(string $city);

        /**
         * @param string $country
         */
        public function setCountry(string $country);

        /**
         * @param string $name
         */
        public function setName(string $name);

        /**
         * @param string $surname
         */
        public function setSurname(string $surname);

        /**
         * @param string $img
         */
        public function setImg(string $img);

        /**
         * @param string $about_me
         */
        public function setAboutMe(string $about_me);

        /**
         * @param string $pass_hash
         */
        public function setPassHash(string $pass_hash);

        /**
         * @param int $role
         */
        public function setRole(int $role);

        /**
         * @param string $activation_key
         */
        public function setActivationKey(string $activation_key);
    }
?>




