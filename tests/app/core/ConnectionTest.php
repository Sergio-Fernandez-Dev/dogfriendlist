<?php declare (strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Core\Connection;

class ConnectionTest extends TestCase
{
    protected static $config;
    protected static $conn;
    protected static $dbh;

    public static function setUpBeforeClass(): void
    {
        self::$config =
        [
            'driver' => 'mysql',
            'host' => 'db',
            'user' => 'root',
            'pass' => '1234',
            'name' => 'testing-db',   
            'charset' => 'utf8'
        ];

        self::$dbh = new Connection(self::$config);
        self::$conn = self::$dbh->connect();
    }

    public static function tearDownAfterClass(): void
    {
        self::$conn = null; 
        unset(self::$dbh);
    }

    public function testConnectionIsNotEmpty(): void
    {
        $this->assertNotEmpty(self::$conn);
    }

    public function testConnectionIsAnObject(): void
    {
        $this->assertIsObject(self::$conn);
    }
    
}

?>