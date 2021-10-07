<?php 

namespace App\Users;

use phpDocumentor\Reflection\Types\Boolean;
use PHPUnit\Framework\Constraint\IsEmpty;

class User
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
    private $created_at = '2021-10-7 11:35:33'; 

    public function getAllProperties()
    {
        $properties = (array)\get_class_vars(__CLASS__);
        $property = '';
        
        foreach($properties as $key => $value)
        {
            $words = explode('_', $value );
            if(\count($words)>1)
            {    
                foreach($words as $word)
                {
                    $property .= \ucwords($word);
                }
            }
            else
            {
                $property = \ucwords($value);
            }

            $porperties[$key] = $this->get[$property]();
        }

        return $properties;
    }

    /**
     * Establece las propiedades de clase
     * en base a un array pasado por parámetro.
     * 
     * @param array $data Lista de valores con los que rellenaremos nuestras propiedades de clase.
     * @param bool $override Permite sobreescribir los valores por defecto cuando recibimos un valor vacío.
     * 
     * @return void
     */   
    public function setAllProperties(array $data, bool $override = true)
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
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