<?php declare(strict_types = 1);

namespace Tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Router;

class RouterTest extends TestCase
{
    public function testCanAddNewRoutesToRegister()
    {
        $function = function(){echo 'Adios';};
        $expected = 
        [
            'params' => '/user', 
            'action' => $function, 
            'method'=>'GET'
        ];

        Router::add('/User', function(){
            echo 'Hello';
        },'GET'); 

        $result = Router::getAll();

        $this->assertEquals($expected, $result[0]);
    }
}

?>