<?php declare(strict_types=1);

namespace Tests\Users;

use PHPUnit\Framework\TestCase;
use App\Users\User;

class UserTest extends TestCase
{
    public $data;
    public $user;

    protected function setUp(): void
    {
        $this->user = new User();

        $this->data =
        [
            'id' => 1,
            'nickname' => 'Testing',
            'email' => 'correo@prueba.com',
            'visibility' => 1,
            'city' => 'Madrid',
            'country' => 'España',
            'name' => 'Sergio',
            'surname' => 'Fernández Fernández',
            'img' => 'users/common/default-profile-picture.jpg',
            'about_me' => 'Me encantan los perros',
            'pass_hash' => 'E806A291CFC3E61F83B98D344EE57E3E8933CCCECE4FB45E1481F1F560E70EB1',
            'created_at' => '2021-10-7 11:35:33'  
        ];
    }

    protected function tearDown(): void
    {
        unset($this->user);
    }

    public function testFunctionSetAllPropertiesIsSettingClassPropertiesFromGivenArray(): void
    {
        $this->user->setAllProperties($this->data);

        $properties['id'] = $this->user->getId();
        $properties['nickname'] = $this->user->getNickname();
        $properties['email'] = $this->user->getEmail();
        $properties['visibility'] = $this->user->getVisibility();
        $properties['city'] = $this->user->getCity();
        $properties['country'] = $this->user->getCountry();
        $properties['name'] = $this->user->getName();
        $properties['surname'] = $this->user->getSurname();
        $properties['img'] = $this->user->getImg();
        $properties['about_me'] = $this->user->getAboutMe();
        $properties['pass_hash'] = $this->user->getPassHash();
        $properties['created_at'] = $this->user->getCreatedAt();

        $this->assertEquals($this->data, $properties);
    }

    public function testFunctionSetAllPropertiesIsNotOverridingDefaultClassPropertiesIfEmptyValueIsGiven(): void
    {
        $this->data['city'] = "";

        $this->user->setAllProperties($this->data, false);

        $this->assertNull($this->user->getCity());
    }

    public function testFunctionSetAllPropertiesOverridesDefaultClassPropertiesIfEmptyValueIsGiven(): void
    {
        $this->data['city'] = "";

        $this->user->setAllProperties($this->data);

        $this->assertEmpty($this->user->getCity());
    }

    public function testFunctionGetAllPropertiesReturnsAnArray(): void
    {
        $result = $this->user->getAllProperties();

        $this->assertIsArray($result);
    }

    public function testFunctionGetAllPropertiesReturnsRightValues(): void
    {
        $this->user->setAllProperties($this->data);

        $result = $this->user->getAllProperties();

        $this->assertEquals($this->data, $result);
    }

}

?>