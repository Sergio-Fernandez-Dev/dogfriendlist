<?php 

namespace App\Users;

use App\Core\Interfaces\EntityInterface;

class User implements EntityInterface
{
    private $id;
    private $nickname;
    private $email;
    private $visibility = 1;
    private $city = null;
    private $country = null;
    private $name = null;
    private $surname = null;
    private $img = 'users/common/default-profile-picture.jpg';
    private $about_me = null;
    private $pass_hash;
    private $created_at; 

    public function __construct()
    {
        $this->created_at = date('Y-m-d H:i:s');
    }

    /**
     * Devuelve un array con todas las propiedades de la clase.
     *
     * @return array
     */
    public function getClassParams(): array
    {
        $properties['id'] = $this->getId();
        $properties['nickname'] = $this->getNickname();
        $properties['email'] = $this->getEmail();
        $properties['visibility'] = $this->getVisibility();
        $properties['city'] = $this->getCity();
        $properties['country'] = $this->getCountry();
        $properties['name'] = $this->getName();
        $properties['surname'] = $this->getSurname();
        $properties['img'] = $this->getImg();
        $properties['about_me'] = $this->getAboutMe();
        $properties['pass_hash'] = $this->getPassHash();
        $properties['created_at'] = $this->getCreatedAt();
      
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
    public function setClassParams(array $data, ?bool $override = false): void
    {
        foreach($data as $key => $value)
        {
            if(empty($value) && !$override)
            {
                continue;
            }
            $this->$key = $value;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
 
    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getAboutMe()
    {
        return $this->about_me;
    }

    public function setAboutMe($about_me)
    {
        $this->about_me = $about_me;
    }

    public function getPassHash()
    {
        return $this->pass_hash;
    }
 
    public function setPassHash($pass_hash)
    {
        $this->pass_hash = $pass_hash;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}

?>