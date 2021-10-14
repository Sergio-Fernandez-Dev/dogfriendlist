<?php declare(strict_types=1);

namespace Tests\Users;

use PHPUnit\Framework\TestCase;
use App\Users\UserDataMapper;
use App\Users\User;
use App\Core\Interfaces\ConnectionInterface;


class UserDataMapperTest extends TestCase
{
    public $connection_i_mock;
    public $data;
    public $u_mapper;

    protected function setUp(): void
    {
        $this->connection_i_mock = $this->createMock(ConnectionInterface::class);

        $this->u_mapper = new UserDataMapper($this->connection_i_mock); 
       
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

    public function testCanCreateNewUser()
    {

        $user = $this->u_mapper->create();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserIsAnObject()
    {
        $user = $this->u_mapper->create($this->data);
        $this->assertIsObject($user);
    }

    public function testFillobjectFunctionIsFillingClassAttributes()
    {
        $user = $this->u_mapper->create($this->data);
        $this->assertEquals($this->data, $user->getClassParams());
    }

    

}

?>