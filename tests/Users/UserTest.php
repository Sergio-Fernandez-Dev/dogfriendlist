<?php declare (strict_types = 1);

namespace Tests\Users;

use App\Models\Users\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    /**
     * @var mixed
     */
    public $data;

    /**
     * @var mixed
     */
    public $user;

    protected function setUp(): void {

        $this->user = new User();

        $this->data = [
            'id'         => 1,
            'username'   => 'Testing',
            'email'      => 'correo@prueba.com',
            'visibility' => 1,
            'city'       => 'Madrid',
            'country'    => 'España',
            'name'       => 'Sergio',
            'surname'    => 'Fernández Fernández',
            'img'        => 'users/common/default-profile-picture.jpg',
            'about_me'   => 'Me encantan los perros',
            'role'       => 0,
            'created_at' => '2021-10-7 11:35:33',
        ];
    }

    protected function tearDown(): void {
        unset($this->user);
    }

    public function testgetPropertiesReturnsAnArray(): void {
        $this->user->setProperties($this->data, true);
        $result = $this->user->getProperties();

        $this->assertIsArray($result);
    }

    public function testgetPropertiesReturnsRightValues(): void {
        $this->user->setProperties($this->data, true);

        $result = $this->user->getProperties();

        $this->assertEquals($this->data, $result);
    }

    public function testSetpropertiesIsNotOverridingDefaultClassPropertiesIfEmptyValueIsGiven(): void {
        $this->data['city'] = "";

        $this->user->setProperties($this->data, false);

        $this->assertNull($this->user->getCity());
    }

    public function testSetpropertiesIsSettingClassPropertiesFromGivenArray(): void {
        $this->user->setProperties($this->data, true);

        $properties['id'] = $this->user->getId();
        $properties['username'] = $this->user->getUsername();
        $properties['email'] = $this->user->getEmail();
        $properties['visibility'] = $this->user->getVisibility();
        $properties['city'] = $this->user->getCity();
        $properties['country'] = $this->user->getCountry();
        $properties['name'] = $this->user->getName();
        $properties['surname'] = $this->user->getSurname();
        $properties['img'] = $this->user->getImg();
        $properties['about_me'] = $this->user->getAboutMe();
        $properties['role'] = $this->user->getRole();
        $properties['created_at'] = $this->user->getCreatedAt();

        $this->assertEquals($this->data, $properties);
    }

    public function testFunctionSetpropertiesOverridesDefaultClassPropertiesIfEmptyValueIsGiven(): void {
        $this->data['city'] = "";

        $this->user->setProperties($this->data, true);

        $this->assertEmpty($this->user->getCity());
    }

    public function testSetpropertiesSetsIdLikeAnInteger(): void {
        $this->user->setProperties($this->data, true);

        $result = $this->user->getId();

        $this->assertIsInt($result);

    }

    public function testSetpropertiesEncryptsTheGivenPassword(): void {
        $pass = ['password' => 'HolaMundo'];

        $this->user->setProperties($pass, true);

        $expected = \md5('HolaMundo');

        $this->assertEquals($this->user->getPassword(), $expected);
    }

    public function testSetidReturnsAnInteger(): void {
        $this->user->setId(5);

        $result = $this->user->getId();

        $this->assertIsInt($result);
    }

    public function testSetactivationkeyChangesTheKeyValueWhenAKeyIsGiven(): void {

        $this->user->setActivationKey('hola');

        $actual = $this->user->getActivationKey();

        $this->assertEquals('hola', $actual);
    }

    public function testSetactivationkeyChangesTheKeyValueToNull(): void {

        $this->user->setActivationKey(null);

        $actual = $this->user->getActivationKey();

        $this->assertNull($actual);
    }
}
