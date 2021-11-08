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
            'method' => 'GET',
            'action' => $function,
        ];

        Router::add('/User', 'GET',
            function () {
                echo 'Hello';
            });

        $result = Router::getAll();

        $this->assertEquals($expected, $result[0]);
    }
}

?>