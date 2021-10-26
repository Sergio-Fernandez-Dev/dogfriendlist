<?php declare (strict_types = 1);

namespace Tests\Core;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {
    public function testCanAddNewRoutesToRegister() {
        $function = function () {echo 'Adios';};
        $expected =
            [
            'params' => '/user',
            'action' => $function,
            'method' => 'GET',
        ];

        Router::add('/User', function () {
            echo 'Hello';
        }, 'GET');

        $result = Router::getAll();

        $this->assertEquals($expected, $result[0]);
    }
}

?>